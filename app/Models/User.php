<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

use App\Models\BaoCaoSuCo;
use App\Models\HuongDanVien;
use App\Models\QuyenHan;
use App\Models\VaiTro;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'password',
        'address',
        'avatar',
        'is_active',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'is_active' => 'integer',
    ];

    public function hasRole(string $roles): bool
    {
        $roleNames = array_filter(
            array_map('trim', preg_split('/[|,]/', $roles))
        );

        if (empty($roleNames)) {
            return false;
        }

        $lowerRoles = array_map('strtolower', $roleNames);

        $placeholders = implode(
            ', ',
            array_fill(0, count($lowerRoles), '?')
        );

        return $this->vaiTros()
            ->whereRaw(
                "lower(ten_vai_tro) IN ({$placeholders})",
                $lowerRoles
            )
            ->exists();
    }

    public function hasPermission(string $permissions): bool
    {
        $permissionNames = array_filter(
            array_map('trim', preg_split('/[|,]/', $permissions))
        );

        if (empty($permissionNames)) {
            return false;
        }

        $lowerPermissions = array_map(
            'strtolower',
            $permissionNames
        );

        $placeholders = implode(
            ', ',
            array_fill(0, count($lowerPermissions), '?')
        );

        return $this->vaiTros()
            ->whereHas('quyenHans', function ($query) use (
                $placeholders,
                $lowerPermissions
            ) {
                $query->whereRaw(
                    "lower(ten) IN ({$placeholders})",
                    $lowerPermissions
                );
            })
            ->exists();
    }

    public function permissions()
    {
        return QuyenHan::whereHas('vaiTros', function ($query) {
            $query->whereIn('vai_tros.id', function ($subQuery) {
                $subQuery
                    ->select('vai_tro_id')
                    ->from('nguoi_dung_vai_tros')
                    ->whereColumn(
                        'nguoi_dung_vai_tros.vai_tro_id',
                        'vai_tros.id'
                    )
                    ->where('nguoi_dung_id', $this->id);
            });
        });
    }

    public function roleType(): string
    {
        if ($this->hasPermission('vao_admin')) {
            return 'admin';
        }

        if ($this->hasPermission('vao_guide')) {
            return 'guide';
        }

        return 'client';
    }

    public function isAdmin(): bool
    {
        return $this->hasPermission('vao_admin');
    }

    public function isGuide(): bool
    {
        return $this->hasPermission('vao_guide');
    }

    public function isClient(): bool
    {
        return !$this->hasPermission('vao_admin|vao_guide');
    }

    public function vaiTros()
    {
        return $this->belongsToMany(
            VaiTro::class,
            'nguoi_dung_vai_tros',
            'nguoi_dung_id',
            'vai_tro_id'
        );
    }

    public function huongDanVien()
    {
        return $this->hasOne(
            HuongDanVien::class,
            'user_id'
        );
    }

    public function baoCaoSuCosXuLy()
    {
        return $this->hasMany(
            BaoCaoSuCo::class,
            'admin_xu_ly_id'
        );
    }
}
