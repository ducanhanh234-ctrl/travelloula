<?php

namespace App\Http\Controllers;

use App\Models\ThanhToan;
use Illuminate\Http\Request;

class ThanhToanController extends Controller
{
    public function index(Request $request)
    {
        $query = ThanhToan::query();
        $tongDoanhThu = ThanhToan::where('trang_thai', 1)
            ->sum('so_tien');

        $daThanhToan = ThanhToan::where('trang_thai', 1)
            ->count();

        $dangXuLy = ThanhToan::where('trang_thai', 2)
            ->count();
        $hoanTien = ThanhToan::where('trang_thai', 4)
            ->count();
        // Text search
        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('ma_giao_dich', 'like', "%{$search}%")
                    ->orWhere('phuong_thuc_thanh_toan', 'like', "%{$search}%")
                    ->orWhereHas('nguoiDung', function ($sub) use ($search) {
                        $sub->where('name', 'like', "%{$search}%");
                    })
                    ->orWhereHas('datTour.tour', function ($sub) use ($search) {
                        $sub->where('ten_tour', 'like', "%{$search}%");
                    });
            });
        }

        // Status filter
        if ($request->filled('status')) {
            $query->where('trang_thai', $request->status);
        }

        $thanh_toans = $query->latest()->paginate(10)->withQueryString();

        return view(
            'Admin.thanh_toan.index',
            compact('thanh_toans', 'tongDoanhThu', 'daThanhToan', 'dangXuLy', 'hoanTien')
        );
    }
    public function show($id)
    {
        $thanh_toan = ThanhToan::query()->findOrFail($id);
        return view('Admin.thanh_toan.show', compact('thanh_toan'));
    }
    public function editStatus($id)
    {
        $thanhToan = ThanhToan::findOrFail($id);

        return view(
            'Admin.thanh_toan.edit_status',
            compact('thanhToan')
        );
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|integer',
            'ghi_chu' => 'nullable|string'
        ]);

        $thanhToan = ThanhToan::findOrFail($id);

        $thanhToan->update([
            'trang_thai' => $request->status,
            'ghi_chu' => $request->ghi_chu,
        ]);

        return redirect()
            ->route('Admin.thanh_toans.show', $thanhToan->id)
            ->with('success', 'Cập nhật trạng thái thành công');
    }
    public function destroy($id)
    {
        $thanh_toan = ThanhToan::query()->findOrFail($id);
        $thanh_toan->delete();
        return redirect()->route('Admin.thanh_toans.index')->with('success', 'Xóa thành công');
    }
}
