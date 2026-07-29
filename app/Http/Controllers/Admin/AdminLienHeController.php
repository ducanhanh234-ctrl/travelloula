<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LienHe;
use Illuminate\Http\Request;

class AdminLienHeController extends Controller
{
    /**
     * Danh sách liên hệ
     */
    public function index(Request $request)
    {
        $query = LienHe::query();

        if ($request->filled('keyword')) {
            $query->where(function ($q) use ($request) {
                $q->where('ho_ten', 'like', '%' . $request->keyword . '%')
                    ->orWhere('email', 'like', '%' . $request->keyword . '%')
                    ->orWhere('so_dien_thoai', 'like', '%' . $request->keyword . '%')
                    ->orWhere('tieu_de', 'like', '%' . $request->keyword . '%');
            });
        }

        if ($request->filled('trang_thai')) {
            $query->where('trang_thai', $request->trang_thai);
        }

        $lienHes = $query
            ->latest()
            ->paginate(15)
            ->withQueryString();

        // Thống kê
        $tong = LienHe::count();
        $chuaXuLy = LienHe::where('trang_thai', 'Chưa xử lý')->count();
        $daXuLy = LienHe::where('trang_thai', 'Đã xử lý')->count();

        return view('Admin.lien_hes.index', compact(
            'lienHes',
            'tong',
            'chuaXuLy',
            'daXuLy'
        ));
    }

    /**
     * Chi tiết liên hệ
     */
    public function show($id)
    {
        $lienHe = LienHe::findOrFail($id);

        

        return view('Admin.lien_hes.show', compact('lienHe'));
    }
    public function markRead($id)
    {
        $lienHe = LienHe::findOrFail($id);

        $lienHe->update([
            'trang_thai' => 'Đã xử lý'
        ]);

        return back()->with('success', 'Đã đánh dấu là Đã xử lý.');
    }

    public function markUnread($id)
    {
        $lienHe = LienHe::findOrFail($id);

        $lienHe->update([
            'trang_thai' => 'Chưa xử lý'
        ]);

        return back()->with('success', 'Đã chuyển về Chưa xử lý.');
    }

    /**
     * Cập nhật trạng thái
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'trang_thai' => 'required|in:Chưa xử lý,Đã xử lý',
            'ghi_chu_admin' => 'nullable|string|max:5000',
        ]);

        $lienHe = LienHe::findOrFail($id);

        $lienHe->update([
            'trang_thai' => $request->trang_thai,
            'ghi_chu_admin' => $request->ghi_chu_admin,
        ]);

        return redirect()
            ->route('Admin.lien_hes.show', $lienHe->id)
            ->with('success', 'Đã cập nhật liên hệ thành công.');
    }

    /**
     * Đánh dấu đã xử lý nhanh
     */
    public function markAsResolved($id)
    {
        $lienHe = LienHe::findOrFail($id);

        $lienHe->update([
            'trang_thai' => 'Đã xử lý',
        ]);

        return back()->with('success', 'Đã đánh dấu liên hệ là đã xử lý.');
    }

    /**
     * Xóa liên hệ
     */
    public function destroy($id)
    {
        $lienHe = LienHe::findOrFail($id);

        $lienHe->delete();

        return redirect()
            ->route('Admin.lien_hes.index')
            ->with('success', 'Đã xóa liên hệ.');
    }
}