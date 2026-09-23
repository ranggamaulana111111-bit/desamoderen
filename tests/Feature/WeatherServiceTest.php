<?php

namespace Tests\Feature;

use App\Dashboard\Widgets\HeaderWidget;
use App\Models\User;
use App\Services\WeatherService;
use Database\Seeders\RolePermissionSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class WeatherServiceTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(RolePermissionSeeder::class);

        config([
            'village.latitude' => '-6.3421',
            'village.longitude' => '107.8321',
        ]);
    }

    public function test_returns_formatted_weather_from_api(): void
    {
        Http::fake([
            'api.open-meteo.com/*' => Http::response([
                'current' => ['temperature_2m' => 28.4, 'weather_code' => 0],
            ]),
        ]);

        $weather = app(WeatherService::class)->getWeather();

        $this->assertNotNull($weather);
        $this->assertSame(28, $weather['temperature']);
        $this->assertSame('Cerah', $weather['description']);
        $this->assertSame('28°C Cerah', $weather['label']);

        Http::assertSent(fn ($request) => str_contains($request->url(), 'latitude=-6.3421'));
        Http::assertSent(fn ($request) => str_contains($request->url(), 'longitude=107.8321'));
    }

    public function test_returns_null_without_coordinates_and_sends_no_http(): void
    {
        config([
            'village.latitude' => null,
            'village.longitude' => null,
        ]);
        Http::fake();

        $this->assertNull(app(WeatherService::class)->getWeather());

        Http::assertNothingSent();
    }

    public function test_returns_null_and_caches_failure_when_api_returns_error(): void
    {
        Http::fake([
            'api.open-meteo.com/*' => Http::response('', 500),
        ]);

        $this->assertNull(app(WeatherService::class)->getWeather());
        $this->assertNull(app(WeatherService::class)->getWeather());

        Http::assertSentCount(1);
    }

    public function test_returns_null_and_caches_failure_on_connection_exception(): void
    {
        Http::fake(fn () => throw new ConnectionException('Connection refused'));

        $this->assertNull(app(WeatherService::class)->getWeather());
        $this->assertNull(app(WeatherService::class)->getWeather());
    }

    public function test_success_result_is_cached(): void
    {
        Http::fake([
            'api.open-meteo.com/*' => Http::response([
                'current' => ['temperature_2m' => 30.6, 'weather_code' => 61],
            ]),
        ]);

        $first = app(WeatherService::class)->getWeather();
        $second = app(WeatherService::class)->getWeather();

        $this->assertSame('31°C Hujan Ringan', $first['label']);
        $this->assertSame($first, $second);
        Http::assertSentCount(1);
    }

    public function test_header_widget_includes_weather_key(): void
    {
        Http::fake([
            'api.open-meteo.com/*' => Http::response([
                'current' => ['temperature_2m' => 28.4, 'weather_code' => 0],
            ]),
        ]);

        $user = User::factory()->create();
        $user->assignRole('Super Admin');

        $data = (new HeaderWidget($user))->getData();

        $this->assertArrayHasKey('weather', $data);
        $this->assertNotNull($data['weather']);
        $this->assertSame('28°C Cerah', $data['weather']['label']);
    }
}
