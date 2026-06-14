<?php
namespace App\Http\Controllers;
use App\Models\KhachHangDatTour; use Illuminate\Http\Request;
class KhachHangDatTourController extends Controller
{
 public function index(){ $khachHangs=KhachHangDatTour::latest()->paginate(10); return view('khach_hang_dat_tours.index',compact('khachHangs')); }
 public function create(){ return view('khach_hang_dat_tours.create'); }
 public function store(Request $r){ $d=$r->validate(['dat_tour_id'=>'required|exists:dat_tours,id','ho_ten'=>'required|max:255','gioi_tinh'=>'nullable','nam_sinh'=>'nullable|integer','so_dien_thoai'=>'nullable|max:20','email'=>'nullable|email','so_giay_to'=>'nullable|max:50','loai_giay_to'=>'nullable','loai_hanh_khach'=>'nullable','ghi_chu'=>'nullable']); KhachHangDatTour::create($d); return redirect()->route('khach-hang.index'); }
 public function edit(KhachHangDatTour $khachHang){ return view('khach_hang_dat_tours.edit',compact('khachHang')); }
 public function update(Request $r,KhachHangDatTour $khachHang){ $d=$r->validate(['dat_tour_id'=>'required|exists:dat_tours,id','ho_ten'=>'required|max:255','gioi_tinh'=>'nullable','nam_sinh'=>'nullable|integer','so_dien_thoai'=>'nullable|max:20','email'=>'nullable|email','so_giay_to'=>'nullable|max:50','loai_giay_to'=>'nullable','loai_hanh_khach'=>'nullable','ghi_chu'=>'nullable']); $khachHang->update($d); return redirect()->route('khach-hang.index'); }
 public function destroy(KhachHangDatTour $khachHang){ $khachHang->delete(); return back(); }
}
