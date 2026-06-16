<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class VaiTro extends Model
{
    protected $table = 'vai_tros';
    protected $fillable = ['ten_vai_tro','mo_ta'];

    public function nguoiDungs(){ return $this->belongsToMany(User::class, 'nguoi_dung_vai_tros', 'vai_tro_id', 'nguoi_dung_id'); }
    public function quyenHans(){ return $this->belongsToMany(QuyenHan::class, 'vai_tro_quyen_hans', 'vai_tro_id', 'quyen_han_id'); }
}
