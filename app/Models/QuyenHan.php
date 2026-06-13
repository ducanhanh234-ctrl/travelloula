<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class QuyenHan extends Model
{
    protected $table = 'quyen_hans';
    protected $fillable = ['ten','ten_hien_thi','mo_ta','mo_dun','trang_thai'];

    public function vaiTros(){ return $this->belongsToMany(VaiTro::class, 'vai_tro_quyen_hans', 'quyen_han_id', 'vai_tro_id'); }
}
