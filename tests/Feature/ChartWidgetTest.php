<?php

namespace Tests\Feature;

use App\Dashboard\Widgets\ChartWidget;
use App\Models\User;
use Database\Seeders\RolePermissionSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ChartWidgetTest extends TestCase
{
    use RefreshDatabase;

    public function test_chart_widget_returns_data(): void
    {
        $this->seed(RolePermissionSeeder::class);

        $user = User::factory()->create();
        $user->assignRole('Super Admin');

        $data = (new ChartWidget($user))->getData();

        $this->assertArrayHasKey('trends', $data);
        $this->assertArrayHasKey('letterDistribution', $data);
        $this->assertNotEmpty($data['trends']);
        foreach ($data['trends'] as $row) {
            $this->assertArrayHasKey('label', $row);
            $this->assertArrayHasKey('total', $row);
        }
    }
}