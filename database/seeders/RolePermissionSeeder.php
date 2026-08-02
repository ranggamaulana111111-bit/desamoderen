<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        app()->make(PermissionRegistrar::class)->forgetCachedPermissions();

        $permissions = [
            // Dashboard
            'dashboard.view',

            // User Management
            'user.view',
            'user.create',
            'user.edit',
            'user.delete',
            'user.assign_role',

            // Letter Management
            'letter.view',
            'letter.create',
            'letter.review',
            'letter.verify',
            'letter.final_approve',
            'letter.reject',
            'letter.print',
            'letter.download',
            'letter.sign',
            'letter.cancel',
            'letter.version.view',
            'letter.version.restore',

            // Settings
            'setting.view',
            'setting.manage',

            // Events
            'event.manage',

            // News
            'news.manage',

            // Analytics
            'analytics.view',

            // Queue
            'queue.view',
            'queue.manage',

            // Activity Log / Audit
            'audit.view',

            // Backup
            'backup.manage',

            // Office Administration
            'office.view',

            // Inventaris & Aset
            'inventaris.view',
            'inventaris.manage',

            // APBDesa
            'anggaran.view',
            'anggaran.manage',

            // RBAC
            'role.manage',
            'permission.manage',
        ];

        $guard = 'web';

        foreach ($permissions as $name) {
            Permission::firstOrCreate(['name' => $name, 'guard_name' => $guard]);
        }

        $roles = [
            'Super Admin' => Permission::all(),

            'Operator Pelayanan' => Permission::whereIn('name', [
                'dashboard.view',
                'user.view',
                'letter.view',
                'letter.create',
                'letter.review',
                'letter.cancel',
                'letter.print',
                'letter.download',
                'letter.version.view',
                'queue.view',
                'queue.manage',
                'setting.view',
                'setting.manage',
                'analytics.view',
                'news.manage',
                'event.manage',
                'office.view',
                'inventaris.view',
                'inventaris.manage',
                'anggaran.view',
                'anggaran.manage',
            ])->get(),

            'Sekretaris Desa' => Permission::whereIn('name', [
                'dashboard.view',
                'user.view',
                'letter.view',
                'letter.verify',
                'letter.reject',
                'letter.print',
                'letter.download',
                'letter.version.view',
                'letter.version.restore',
                'analytics.view',
                'queue.view',
                'setting.view',
                'setting.manage',
                'office.view',
                'inventaris.view',
                'inventaris.manage',
                'anggaran.view',
                'anggaran.manage',
            ])->get(),

            'Kepala Desa' => Permission::whereIn('name', [
                'dashboard.view',
                'user.view',
                'letter.view',
                'letter.final_approve',
                'letter.reject',
                'letter.sign',
                'letter.print',
                'letter.download',
                'letter.version.view',
                'letter.version.restore',
                'analytics.view',
                'queue.view',
                'setting.view',
                'setting.manage',
                'office.view',
                'audit.view',
                'inventaris.view',
                'inventaris.manage',
                'anggaran.view',
                'anggaran.manage',
            ])->get(),

            'RT' => Permission::whereIn('name', [
                'dashboard.view',
                'letter.view',
                'analytics.view',
            ])->get(),

            'RW' => Permission::whereIn('name', [
                'dashboard.view',
                'letter.view',
                'analytics.view',
            ])->get(),

            'Warga' => Permission::whereIn('name', [
                'letter.create',
            ])->get(),
        ];

        foreach ($roles as $roleName => $rolePermissions) {
            $role = Role::firstOrCreate(['name' => $roleName, 'guard_name' => $guard]);
            $role->syncPermissions($rolePermissions);
        }
    }
}
