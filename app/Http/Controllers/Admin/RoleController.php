<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreRoleRequest;
use App\Http\Requests\UpdateRoleRequest;
use App\Models\ActivityLog;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    private const SYSTEM_ROLES = ['Super Admin', 'Operator Pelayanan', 'Sekretaris Desa', 'Kepala Desa', 'RT', 'RW', 'Warga', 'Lembaga'];

    public function index()
    {
        $roles = Role::withCount(['permissions', 'users'])
            ->orderBy('name')
            ->paginate(20);

        return view('admin.roles.index', compact('roles'));
    }

    public function create()
    {
        $permissions = Permission::orderBy('name')->get()->groupBy(function ($perm) {
            $parts = explode('.', $perm->name);

            return ucfirst(str_replace('_', ' ', $parts[0]));
        });

        return view('admin.roles.create', compact('permissions'));
    }

    public function store(StoreRoleRequest $request)
    {
        $role = Role::create([
            'name' => $request->name,
            'guard_name' => 'web',
        ]);

        $role->syncPermissions($request->permissions);

        ActivityLog::catat(
            'create_role',
            "Membuat role baru: {$role->name} dengan ".count($request->permissions).' permission.',
            'role',
            $role->id
        );

        return redirect()->route('admin.roles.index')
            ->with('success', "Role '{$role->name}' berhasil dibuat.");
    }

    public function edit(Role $role)
    {
        $role->load('permissions');
        $permissions = Permission::orderBy('name')->get()->groupBy(function ($perm) {
            $parts = explode('.', $perm->name);

            return ucfirst(str_replace('_', ' ', $parts[0]));
        });
        $rolePermissions = $role->permissions->pluck('name')->toArray();

        return view('admin.roles.edit', compact('role', 'permissions', 'rolePermissions'));
    }

    public function update(UpdateRoleRequest $request, Role $role)
    {
        if (in_array($role->name, self::SYSTEM_ROLES, true) && $request->name !== $role->name) {
            return redirect()->route('admin.roles.index')
                ->with('error', "Role sistem '{$role->name}' tidak dapat diubah namanya.");
        }

        $role->update([
            'name' => $request->name,
        ]);

        $role->syncPermissions($request->permissions);

        ActivityLog::catat(
            'update_role',
            "Memperbarui role: {$role->name}.",
            'role',
            $role->id
        );

        return redirect()->route('admin.roles.index')
            ->with('success', "Role '{$role->name}' berhasil diperbarui.");
    }

    public function destroy(Role $role)
    {
        if (in_array($role->name, self::SYSTEM_ROLES, true)) {
            return redirect()->route('admin.roles.index')
                ->with('error', "Role sistem '{$role->name}' tidak dapat dihapus.");
        }

        if ($role->users()->exists()) {
            return redirect()->route('admin.roles.index')
                ->with('error', "Role '{$role->name}' tidak dapat dihapus karena masih digunakan oleh pengguna.");
        }

        $roleName = $role->name;
        $role->delete();

        ActivityLog::catat(
            'delete_role',
            "Menghapus role: {$roleName}.",
            'role',
            null
        );

        return redirect()->route('admin.roles.index')
            ->with('success', "Role '{$roleName}' berhasil dihapus.");
    }
}
