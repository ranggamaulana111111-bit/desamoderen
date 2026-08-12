<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Requests\UpdateUserRoleRequest;
use App\Models\ActivityLog;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class UserManagementController extends Controller
{
    public function index(Request $request)
    {
        $query = User::with('roles');

        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        if ($role = $request->input('role')) {
            $query->role($role);
        }

        $warga = $query->latest()->paginate(20)->withQueryString();
        $roles = Role::orderBy('name')->get();

        return view('admin.users.index', compact('warga', 'roles'));
    }

    public function create()
    {
        $roles = Role::orderBy('name')->get();

        return view('admin.users.create', compact('roles'));
    }

    public function store(StoreUserRequest $request)
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'nik' => $request->nik,
            'password' => bcrypt($request->password),
            'no_hp' => $request->no_hp,
            'alamat' => $request->alamat,
        ]);

        $user->assignRole($request->role);

        ActivityLog::catat(
            'create_user',
            "Mendaftarkan pengguna baru: {$user->name} dengan role '{$request->role}'.",
            'user',
            $user->id
        );

        return redirect()->route('admin.users.index')
            ->with('success', "Pengguna '{$user->name}' berhasil didaftarkan.");
    }

    public function edit(User $user)
    {
        $roles = Role::orderBy('name')->get();

        return view('admin.users.create', compact('user', 'roles'));
    }

    public function update(UpdateUserRequest $request, User $user)
    {
        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'nik' => $request->nik,
            'no_hp' => $request->no_hp,
            'alamat' => $request->alamat,
        ];

        if ($request->filled('password')) {
            $data['password'] = bcrypt($request->password);
        }

        $user->update($data);

        $oldRole = $user->roles()->first()?->name;
        if ($oldRole !== $request->role) {
            $user->syncRoles([$request->role]);
        }

        ActivityLog::catat(
            'update_user',
            "Memperbarui data pengguna '{$user->name}'".($oldRole !== $request->role ? " dan mengubah role menjadi '{$request->role}'" : '').'.',
            'user',
            $user->id
        );

        return redirect()->route('admin.users.show', $user)
            ->with('success', "Data pengguna '{$user->name}' berhasil diperbarui.");
    }

    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
        }

        if ($user->hasRole('Super Admin') && User::role('Super Admin')->where('id', '!=', $user->id)->doesntExist()) {
            return back()->with('error', 'Tidak dapat menghapus Super Admin terakhir.');
        }

        $name = $user->name;

        $user->delete();

        ActivityLog::catat(
            'delete_user',
            "Menghapus pengguna '{$name}'.",
            'user',
            $user->id
        );

        return redirect()->route('admin.users.index')
            ->with('success', "Pengguna '{$name}' berhasil dihapus.");
    }

    public function show(User $user)
    {
        $user->load('roles');
        $pengajuanStats = $user->pengajuanSurat()
            ->selectRaw('status, count(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status');
        $recentActivity = $user->approvalHistories()
            ->with('pengajuan')
            ->latest()
            ->take(10)
            ->get();
        $allRoles = Role::orderBy('name')->get();

        return view('admin.users.show', compact('user', 'pengajuanStats', 'recentActivity', 'allRoles'));
    }

    public function updateRole(UpdateUserRoleRequest $request, User $user)
    {
        $oldRole = $user->roles()->first()?->name;

        $user->syncRoles([$request->role]);

        $newRole = $request->role;

        ActivityLog::catat(
            'update_user_role',
            "Mengubah role pengguna '{$user->name}' dari '".($oldRole ?? 'Tidak ada')."' menjadi '{$newRole}'.",
            'user',
            $user->id
        );

        return redirect()->route('admin.users.show', $user)
            ->with('success', "Role pengguna '{$user->name}' berhasil diperbarui.");
    }
}
