<?php

namespace App\Http\Controllers;

use App\Models\QuyenHan;
use Illuminate\Http\Request;

class QuyenHanController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:permissions.view')->only(['index', 'show']);
        $this->middleware('permission:permissions.create')->only(['create', 'store']);
        $this->middleware('permission:permissions.edit')->only(['edit', 'update']);
        $this->middleware('permission:permissions.delete')->only(['destroy']);
    }

    public function index()
    {
        $quyenHans = QuyenHan::paginate(10);
        return view('Admin.quyen_hans.index', compact('quyenHans'));
    }
    public function create()
    {
        return view('Admin.quyen_hans.create');
    }
    public function store(Request $r)
    {
        $d = $r->validate(['ten' => 'required|max:255|unique:quyen_hans,ten', 'ten_hien_thi' => 'required|max:255', 'mo_ta' => 'nullable', 'mo_dun' => 'nullable|max:255', 'trang_thai' => 'nullable|boolean']);
        $d['trang_thai'] = $r->boolean('trang_thai');
        QuyenHan::create($d);
        return redirect()->route('Admin.quyen-hans.index');
    }
    public function edit(QuyenHan $quyenHan)
    {
        return view('Admin.quyen_hans.edit', compact('quyenHan'));
    }
    public function show(QuyenHan $quyenHan)
    {
        return view('Admin.quyen_hans.show', compact('quyenHan'));
    }
    public function update(Request $r, QuyenHan $quyenHan)
    {
        $d = $r->validate(['ten' => 'required|max:255|unique:quyen_hans,ten,' . $quyenHan->id, 'ten_hien_thi' => 'required|max:255', 'mo_ta' => 'nullable', 'mo_dun' => 'nullable|max:255', 'trang_thai' => 'nullable|boolean']);
        $d['trang_thai'] = $r->boolean('trang_thai');
        $quyenHan->update($d);
        return redirect()->route('Admin.quyen-hans.index');
    }
    public function destroy(QuyenHan $quyenHan)
    {
        $quyenHan->delete();
        return back();
    }
}
