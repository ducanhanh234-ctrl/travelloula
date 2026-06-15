<?php

namespace App\Http\Controllers;

use App\Models\DanhGia;
use Illuminate\Http\Request;

class DanhGiaController extends Controller
{
    public function index(Request $request)
    {
        $query = DanhGia::query();
        $tongDanhGia = DanhGia::count();

        $danhGia5Sao = DanhGia::where('so_sao', 5)->count();



        $diemTrungBinh = round(
            DanhGia::avg('so_sao'),
            1
        );
        // Text search
        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->whereHas('khachHangDatTour', function ($sub) use ($search) {
                    $sub->where('ho_ten', 'like', "%{$search}%");
                })

                    ->orWhereHas('tour', function ($sub) use ($search) {
                        $sub->where('ten_tour', 'like', "%{$search}%");
                    });
            });
        }
        if ($request->filled('so_sao')) {
            $query->where('so_sao', $request->so_sao);
        }
        $danh_gias = $query->latest()->paginate(10)->withQueryString();

        return view('Admin.danh_gia.index', compact('danh_gias', 'tongDanhGia', 'danhGia5Sao',  'diemTrungBinh'));
    }
    public function show($id)
    {
        $danh_gia = DanhGia::query()->findOrFail($id);
        return view('Admin.danh_gia.show', compact('danh_gia'));
    }
    public function destroy($id)
    {
        $danh_gia = DanhGia::findOrFail($id);
        $danh_gia->delete();

        return redirect()->route('Admin.danh_gias.index')->with('success', 'Đánh giá đã được xóa thành công.');
    }
}
