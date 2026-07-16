<?php

namespace App\Http\Controllers;

use App\Models\VaiTro;
use App\Models\QuyenHan;
use Illuminate\Http\Request;

class RolePermissionController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:roles.edit')->only(['matrix', 'updateMatrix']);
    }

    public function matrix()
    {
        $vaiTros = VaiTro::with('quyenHans')
            ->orderBy('ten_vai_tro')
            ->get();

        $quyenHans = QuyenHan::orderBy('mo_dun')
            ->orderBy('ten_hien_thi')
            ->paginate(100);
        $rolePermissions = [];

        foreach ($vaiTros as $role) {
            $rolePermissions[$role->id] = $role->quyenHans->pluck('id')->toArray();
        }

        return view('Admin.role_permissions.matrix', compact('vaiTros', 'quyenHans', 'rolePermissions'));
    }

    public function updateMatrix(Request $r)
    {
        $r->validate([
            'role_permissions' => 'array',
            'role_permissions.*' => 'array',
            'role_permissions.*.*' => 'integer|exists:quyen_hans,id'
        ]);

        $rolePermissions = $r->input('role_permissions', []);

        foreach ($rolePermissions as $roleId => $permissionIds) {
            $vaiTro = VaiTro::find($roleId);
            if ($vaiTro) {
                $vaiTro->quyenHans()->sync($permissionIds ?? []);
            }
        }

        return back()->with('success', 'Cập nhật phân quyền thành công');
    }
}
