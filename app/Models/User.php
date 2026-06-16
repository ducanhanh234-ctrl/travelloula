<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
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

    public function hasRole(string $role): bool
    {
        return $this->vaiTros()->whereRaw('lower(ten_vai_tro) = ?', [strtolower($role)])->exists();
    }

    public function roleType(): string
    {
        return match ($this->is_active) {
            2 => 'guide',
            3 => 'admin',
            default => 'client',
        };
    }

    public function isAdmin(): bool
    {
        return $this->is_active === 3;
    }

    public function isGuide(): bool
    {
        return $this->is_active === 2;
    }

    public function isClient(): bool
    {
        return $this->is_active === 1 || !in_array($this->is_active, [2, 3], true);
    }

    public function vaiTros(){ return $this->belongsToMany(VaiTro::class, 'nguoi_dung_vai_tros', 'nguoi_dung_id', 'vai_tro_id'); }
}
