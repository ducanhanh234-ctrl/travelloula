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

        // Tìm kiếm
        if ($request->filled('keyword')) {
            $query->search($request->keyword);
        }

        // Lọc trạng thái
        if ($request->filled('trang_thai')) {
            $query->where('trang_thai', $request->trang_thai);
        }

        $lienHes = $query
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('Admin.lien_he.index', compact('lienHes'));
    }

    /**
     * Chi tiết liên hệ
     */
    public function show($id)
    {
        $lienHe = LienHe::findOrFail($id);

        return view('Admin.lien_he.show', compact('lienHe'));
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
            ->route('Admin.lien_he.show', $lienHe->id)
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
            ->route('Admin.lien_he.index')
            ->with('success', 'Đã xóa liên hệ.');
    }
}