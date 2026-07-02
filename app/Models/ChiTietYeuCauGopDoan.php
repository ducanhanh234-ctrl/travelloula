<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\DatTour;

class ChiTietYeuCauGopDoan extends Model
{
    protected $table = 'chi_tiet_yeu_cau_gop_doans';


    protected $fillable = [
        'yeu_cau_gop_doan_id',
        'lich_khoi_hanh_id',
        'dat_tour_id',
        'la_lich_chinh',
        'trang_thai_lien_he',
        'ghi_chu',
        'thoi_gian_lien_he',
    ];


    public function yeuCau()
    {
        return $this->belongsTo(
            YeuCauGopDoan::class,
            'yeu_cau_gop_doan_id'
        );
    }


    public function lichKhoiHanh()
    {
        return $this->belongsTo(
            LichKhoiHanhTour::class,
            'lich_khoi_hanh_id'
        );
    }


    public function datTour()
    {
        return $this->belongsTo(
            DatTour::class,
            'dat_tour_id'
        );
    }
}
