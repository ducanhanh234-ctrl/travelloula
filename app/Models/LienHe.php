<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class LienHe extends Model
{
    protected $table = 'lien_hes';

    protected $fillable = [
        'ho_ten',
        'email',
        'so_dien_thoai',
        'tieu_de',
        'noi_dung',
        'trang_thai',
        'ghi_chu_admin',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /*
    |--------------------------------------------------------------------------
    | Scope
    |--------------------------------------------------------------------------
    */

    /**
     * Liên hệ chưa xử lý
     */
    public function scopeChuaXuLy(Builder $query): Builder
    {
        return $query->where('trang_thai', 'Chưa xử lý');
    }

    /**
     * Liên hệ đã xử lý
     */
    public function scopeDaXuLy(Builder $query): Builder
    {
        return $query->where('trang_thai', 'Đã xử lý');
    }

    /**
     * Tìm kiếm
     */
    public function scopeSearch(Builder $query, ?string $keyword): Builder
    {
        if (!$keyword) {
            return $query;
        }

        return $query->where(function ($q) use ($keyword) {
            $q->where('ho_ten', 'like', "%{$keyword}%")
              ->orWhere('email', 'like', "%{$keyword}%")
              ->orWhere('so_dien_thoai', 'like', "%{$keyword}%")
              ->orWhere('tieu_de', 'like', "%{$keyword}%");
        });
    }

    /*
    |--------------------------------------------------------------------------
    | Accessor
    |--------------------------------------------------------------------------
    */

    /**
     * Badge trạng thái
     */
    public function getBadgeTrangThaiAttribute(): string
    {
        return match ($this->trang_thai) {
            'Đã xử lý' => 'success',
            default => 'warning',
        };
    }

    /**
     * Màu chữ trạng thái
     */
    public function getMauTrangThaiAttribute(): string
    {
        return match ($this->trang_thai) {
            'Đã xử lý' => '#16a34a',
            default => '#f59e0b',
        };
    }
}