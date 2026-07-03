<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use App\Models\QuyenHan;
use App\Models\VaiTro;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'password',
        'phone',
        'address',
        'is_active',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'is_active' => 'integer',
    ];

    public function hasRole(string $roles): bool
    {
        $roleNames = array_filter(array_map('trim', preg_split('/[|,]/', $roles)));
        if (empty($roleNames)) {
            return false;
        }

        $lowerRoles = array_map('strtolower', $roleNames);
        $placeholders = implode(', ', array_fill(0, count($lowerRoles), '?'));

        $hasRole = $this->vaiTros()
            ->whereRaw("lower(ten_vai_tro) IN ({$placeholders})", $lowerRoles)
            ->exists();

        if ($hasRole) {
            return true;
        }

        return $this->legacyRoleFallback($roleNames);
    }

    protected function legacyRoleFallback(array $roleNames): bool
    {
        $activeValue = isset($this->attributes['is_active']) ? (int) $this->attributes['is_active'] : 0;

        if ($activeValue === 3 && in_array('admin', $roleNames, true)) {
            return true;
        }

        if ($activeValue === 2 && in_array('guide', $roleNames, true)) {
            return true;
        }

        return false;
    }

    public function hasPermission(string $permissions): bool
    {
        $permissionNames = array_filter(array_map('trim', preg_split('/[|,]/', $permissions)));
        if (empty($permissionNames)) {
            return false;
        }

        $lowerPermissions = array_map('strtolower', $permissionNames);
        $placeholders = implode(', ', array_fill(0, count($lowerPermissions), '?'));

        $hasPermission = $this->vaiTros()->whereHas('quyenHans', function ($query) use ($placeholders, $lowerPermissions) {
            $query->whereRaw("lower(ten) IN ({$placeholders})", $lowerPermissions);
        })->exists();

        if ($hasPermission) {
            return true;
        }

        return $this->legacyPermissionFallback($permissionNames);
    }

    public function permissions()
    {
        return QuyenHan::whereHas('vaiTros', function ($query) {
            $query->whereIn('vai_tros.id', function ($query) {
                $query->select('vai_tro_id')
                    ->from('nguoi_dung_vai_tros')
                    ->whereColumn('nguoi_dung_vai_tros.vai_tro_id', 'vai_tros.id')
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

    protected function legacyPermissionFallback(array $permissionNames): bool
    {
        $activeValue = isset($this->attributes['is_active']) ? (int) $this->attributes['is_active'] : 0;

        if ($activeValue === 3 && in_array('vao_admin', $permissionNames, true)) {
            return true;
        }

        if ($activeValue === 2 && in_array('vao_guide', $permissionNames, true)) {
            return true;
        }

        return false;
    }

    public function vaiTros()
    {
        return $this->belongsToMany(VaiTro::class, 'nguoi_dung_vai_tros', 'nguoi_dung_id', 'vai_tro_id');
    }
}
