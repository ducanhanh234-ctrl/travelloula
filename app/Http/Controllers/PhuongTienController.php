<?php

namespace App\Http\Controllers;

use App\Models\PhuongTien;
use Illuminate\Http\Request;

class PhuongTienController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:phuong_tiens.view')->only(['index', 'show']);
        $this->middleware('permission:phuong_tiens.create')->only(['create', 'store']);
        $this->middleware('permission:phuong_tiens.edit')->only(['edit', 'update']);
        $this->middleware('permission:phuong_tiens.delete')->only(['destroy']);
    }

    public function index(Request $request)
    {
        $query = PhuongTien::query();

        if ($request->filled('keyword')) {
            $keyword = $request->keyword;

            $query->where(function ($q) use ($keyword) {
                $q->where('bien_so_xe', 'like', "%{$keyword}%")
                    ->orWhere('loai_phuong_tien', 'like', "%{$keyword}%")
                    ->orWhere('hang_xe', 'like', "%{$keyword}%")
                    ->orWhere('ten_tai_xe', 'like', "%{$keyword}%")
                    ->orWhere('so_dien_thoai_tai_xe', 'like', "%{$keyword}%");
            });
        }

        if ($request->filled('trang_thai')) {
            $query->where('trang_thai', $request->trang_thai);
        }

        $phuongTiens = $query
            ->orderByDesc('id')
            ->paginate(10)
            ->appends($request->query());

        return view('Admin.phuong_tiens.index', compact('phuongTiens'));
    }

    public function create()
    {
        return view('Admin.phuong_tiens.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'bien_so_xe' => 'required|max:255|unique:phuong_tiens,bien_so_xe',

            'loai_phuong_tien' => 'required|in:xe_16_cho,xe_29_cho,xe_45_cho',

            'hang_xe' => 'required|max:255',
            'nam_san_xuat' => 'required|integer|min:1990|max:' . date('Y'),
            'mau_xe' => 'required|max:255',
            'trang_thai' => 'required|in:1,2,3,4,5',
            'ten_tai_xe' => 'required|max:255',
            'so_dien_thoai_tai_xe' => 'required|max:255',
            'ghi_chu' => 'nullable|string',
        ]);
        switch ($data['loai_phuong_tien']) {
            case 'xe_16_cho':
                $data['so_cho'] = 16;
                break;

            case 'xe_29_cho':
                $data['so_cho'] = 29;
                break;

            case 'xe_45_cho':
                $data['so_cho'] = 45;
                break;
        }

        PhuongTien::create($data);

        return redirect()
            ->route('Admin.phuong-tiens.index')
            ->with('success', 'Thêm xe thành công');
    }

    public function show($id)
    {
        $phuongTien = PhuongTien::findOrFail($id);

        return view('Admin.phuong_tiens.show', compact('phuongTien'));
    }

    public function edit($id)
    {
        $phuongTien = PhuongTien::findOrFail($id);

        return view('Admin.phuong_tiens.edit', compact('phuongTien'));
    }

    public function update(Request $request, $id)
    {
        $phuongTien = PhuongTien::findOrFail($id);

        $data = $request->validate([
            'bien_so_xe' => 'required|max:255|unique:phuong_tiens,bien_so_xe,' . $phuongTien->id,

            'loai_phuong_tien' => 'required|in:xe_16_cho,xe_29_cho,xe_45_cho',

            'hang_xe' => 'required|max:255',
            'nam_san_xuat' => 'required|integer|min:1990|max:' . date('Y'),
            'mau_xe' => 'required|max:255',
            'trang_thai' => 'required|in:1,2,3,4,5',
            'ten_tai_xe' => 'required|max:255',
            'so_dien_thoai_tai_xe' => 'required|max:255',
            'ghi_chu' => 'nullable|string',
        ]);
        switch ($data['loai_phuong_tien']) {
            case 'xe_16_cho':
                $data['so_cho'] = 16;
                break;

            case 'xe_29_cho':
                $data['so_cho'] = 29;
                break;

            case 'xe_45_cho':
                $data['so_cho'] = 45;
                break;
        }

        $phuongTien->update($data);

        return redirect()
            ->route('Admin.phuong-tiens.index')
            ->with('success', 'Cập nhật xe thành công');
    }

    public function destroy($id)
    {
        $phuongTien = PhuongTien::findOrFail($id);
        $phuongTien->delete();

        return redirect()
            ->route('Admin.phuong-tiens.index')
            ->with('success', 'Xóa xe thành công');
    }
}
