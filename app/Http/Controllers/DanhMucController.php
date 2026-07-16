<?php

namespace App\Http\Controllers;

use App\Models\DanhMuc;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DanhMucController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:danh_mucs.view')
            ->only(['index', 'show']);

        $this->middleware('permission:danh_mucs.create')
            ->only(['create', 'store']);

        $this->middleware('permission:danh_mucs.edit')
            ->only(['edit', 'update']);

        $this->middleware('permission:danh_mucs.delete')
            ->only(['destroy']);
    }

    public function index(Request $request)
    {
        $keyword = $request->keyword;

        $danhMucs = DanhMuc::query()
            ->when($keyword, function ($query) use ($keyword) {
                $query->where(
                    'ten_danh_muc',
                    'like',
                    '%' . $keyword . '%'
                );
            })
            ->orderByDesc('id')
            ->paginate(5)
            ->withQueryString();

        return view(
            'Admin.danh_mucs.index',
            compact('danhMucs', 'keyword')
        );
    }

    public function create()
    {
        return view('Admin.danh_mucs.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'ten_danh_muc' => 'required|string|max:100',
            'mo_ta'        => 'nullable|string',
            'hinh_anh'     => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
            'trang_thai'   => 'required|in:active,inactive',
        ]);

        if ($request->hasFile('hinh_anh')) {
            $data['hinh_anh'] = $request
                ->file('hinh_anh')
                ->store('danh-mucs', 'public');
        }

        DanhMuc::create($data);

        return redirect()
            ->route('Admin.danh_mucs.index')
            ->with('success', 'Thêm danh mục thành công');
    }

    public function show(DanhMuc $danh_muc)
    {
        return view('Admin.danh_mucs.show', [
            'danhMuc' => $danh_muc,
        ]);
    }

    public function edit(DanhMuc $danh_muc)
    {
        return view('Admin.danh_mucs.edit', [
            'danhMuc' => $danh_muc,
        ]);
    }

    public function update(
        Request $request,
        DanhMuc $danh_muc
    ) {
        $data = $request->validate([
            'ten_danh_muc' => 'required|string|max:100',
            'mo_ta'        => 'nullable|string',
            'hinh_anh'     => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
            'trang_thai'   => 'required|in:active,inactive',
        ]);

        if ($request->hasFile('hinh_anh')) {
            $this->deleteStoredImage($danh_muc->hinh_anh);

            $data['hinh_anh'] = $request
                ->file('hinh_anh')
                ->store('danh-mucs', 'public');
        }

        $danh_muc->update($data);

        return redirect()
            ->route('Admin.danh_mucs.index')
            ->with('success', 'Cập nhật danh mục thành công');
    }

    public function destroy(DanhMuc $danh_muc)
    {
        try {
            $oldImage = $danh_muc->hinh_anh;

            $danh_muc->delete();

            $this->deleteStoredImage($oldImage);

            return back()->with(
                'success',
                'Xóa danh mục thành công'
            );
        } catch (\Exception $e) {
            return back()->with(
                'error',
                'Không thể xóa vì danh mục đang được sử dụng'
            );
        }
    }

    private function deleteStoredImage(?string $imagePath): void
    {
        if (!$imagePath) {
            return;
        }

        if (
            str_starts_with($imagePath, 'http://') ||
            str_starts_with($imagePath, 'https://')
        ) {
            return;
        }

        $imagePath = ltrim($imagePath, '/');

        if (str_starts_with($imagePath, 'storage/')) {
            $imagePath = substr($imagePath, strlen('storage/'));
        }

        if (str_starts_with($imagePath, 'public/')) {
            $imagePath = substr($imagePath, strlen('public/'));
        }

        if (Storage::disk('public')->exists($imagePath)) {
            Storage::disk('public')->delete($imagePath);
        }
    }
}
