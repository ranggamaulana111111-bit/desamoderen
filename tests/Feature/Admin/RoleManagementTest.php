<?php

namespace Tests\Feature\Admin;

use App\Models\User;
use Database\Seeders\RolePermissionSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class RoleManagementTest extends TestCase
{
    use \Illuminate\Foundation\Testing\WithoutMiddleware, RefreshDatabase;

    public function test_super_admin_can_create_new_role()
    {
        $this->seed(RolePermissionSeeder::class);
        $superAdmin = User::factory()->create();
        $superAdmin->assignRole('Super Admin');

        $this->actingAs($superAdmin);

        $response = $this->post(route('admin.roles.store'), [
            'name' => 'Staf Baru',
            'permissions' => ['dashboard.view'],
        ]);

        $response->assertRedirect(route('admin.roles.index'));
        $this->assertDatabaseHas('roles', ['name' => 'Staf Baru']);
        $this->assertTrue(Role::where('name', 'Staf Baru')->first()->hasPermissionTo('dashboard.view'));
    }
}
