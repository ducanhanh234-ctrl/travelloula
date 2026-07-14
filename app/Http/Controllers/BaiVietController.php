<?php

namespace App\Http\Controllers;

use App\Models\BaiViet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BaiVietController extends Controller
{
    public function index(Request $request)
    {
        $keyword = $request->keyword;
        $trangThai = $request->trang_thai;

        $baiViets = BaiViet::query()
            ->when($keyword, function ($query) use ($keyword) {
                $query->where(function ($q) use ($keyword) {
                    $q->where('tieu_de', 'like', '%' . $keyword . '%')
                        ->orWhere('mo_ta_ngan', 'like', '%' . $keyword . '%')
                        ->orWhere('tac_gia', 'like', '%' . $keyword . '%');
                });
            })
            ->when($trangThai !== null && $trangThai !== '', function ($query) use ($trangThai) {
                $query->where('trang_thai', $trangThai);
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('Admin.bai_viets.index', compact('baiViets'));
    }

    public function create()
    {
        return view('Admin.bai_viets.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'tieu_de' => 'required|string|max:255',
            'duong_dan' => 'nullable|string|max:255|unique:bai_viets,duong_dan',
            'anh_dai_dien' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:4096',
            'mo_ta_ngan' => 'nullable|string',
            'noi_dung' => 'nullable|string',
            'tac_gia' => 'nullable|string|max:255',
            'trang_thai' => 'required|in:0,1',
        ], [
            'tieu_de.required' => 'Vui lòng nhập tiêu đề bài viết.',
            'duong_dan.unique' => 'Đường dẫn này đã tồn tại.',
            'anh_dai_dien.image' => 'File tải lên phải là hình ảnh.',
            'anh_dai_dien.mimes' => 'Ảnh phải có định dạng jpg, jpeg, png hoặc webp.',
            'anh_dai_dien.max' => 'Ảnh không được vượt quá 4MB.',
        ]);

        if (empty($data['duong_dan'])) {
            $data['duong_dan'] = Str::slug($data['tieu_de']);
        } else {
            $data['duong_dan'] = Str::slug($data['duong_dan']);
        }

        $duongDanGoc = $data['duong_dan'];
        $dem = 1;

        while (BaiViet::where('duong_dan', $data['duong_dan'])->exists()) {
            $data['duong_dan'] = $duongDanGoc . '-' . $dem;
            $dem++;
        }

        if ($request->hasFile('anh_dai_dien')) {
            $data['anh_dai_dien'] = $request->file('anh_dai_dien')->store('bai_viets', 'public');
        }

        BaiViet::create($data);

        return redirect()
            ->route('Admin.bai_viets.index')
            ->with('success', 'Thêm bài viết thành công.');
    }

    public function show(BaiViet $baiViet)
    {
        return view('Admin.bai_viets.show', compact('baiViet'));
    }

    public function edit(BaiViet $baiViet)
    {
        return view('Admin.bai_viets.edit', compact('baiViet'));
    }

    public function update(Request $request, BaiViet $baiViet)
    {
        $data = $request->validate([
            'tieu_de' => 'required|string|max:255',
            'duong_dan' => 'nullable|string|max:255|unique:bai_viets,duong_dan,' . $baiViet->id,
            'anh_dai_dien' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:4096',
            'mo_ta_ngan' => 'nullable|string',
            'noi_dung' => 'nullable|string',
            'tac_gia' => 'nullable|string|max:255',
            'trang_thai' => 'required|in:0,1',
        ], [
            'tieu_de.required' => 'Vui lòng nhập tiêu đề bài viết.',
            'duong_dan.unique' => 'Đường dẫn này đã tồn tại.',
            'anh_dai_dien.image' => 'File tải lên phải là hình ảnh.',
            'anh_dai_dien.mimes' => 'Ảnh phải có định dạng jpg, jpeg, png hoặc webp.',
            'anh_dai_dien.max' => 'Ảnh không được vượt quá 4MB.',
        ]);

        if (empty($data['duong_dan'])) {
            $data['duong_dan'] = Str::slug($data['tieu_de']);
        } else {
            $data['duong_dan'] = Str::slug($data['duong_dan']);
        }

        if ($request->hasFile('anh_dai_dien')) {
            if ($baiViet->anh_dai_dien && Storage::disk('public')->exists($baiViet->anh_dai_dien)) {
                Storage::disk('public')->delete($baiViet->anh_dai_dien);
            }

            $data['anh_dai_dien'] = $request->file('anh_dai_dien')->store('bai_viets', 'public');
        }

        $baiViet->update($data);

        return redirect()
            ->route('Admin.bai_viets.index')
            ->with('success', 'Cập nhật bài viết thành công.');
    }

    public function destroy(BaiViet $baiViet)
    {
        if ($baiViet->anh_dai_dien && Storage::disk('public')->exists($baiViet->anh_dai_dien)) {
            Storage::disk('public')->delete($baiViet->anh_dai_dien);
        }

        $baiViet->delete();

        return redirect()
            ->route('Admin.bai_viets.index')
            ->with('success', 'Xóa bài viết thành công.');
    }
}