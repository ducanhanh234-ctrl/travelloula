<?php

namespace App\Http\Controllers;

use App\Models\VaiTro;
use App\Models\QuyenHan;
use Illuminate\Http\Request;

class VaiTroController extends Controller
{
    // tick quyền
    public function __construct()
    {
        $this->middleware('permission:roles.view')->only(['index', 'show']);
        $this->middleware('permission:roles.create')->only(['create', 'store']);
        $this->middleware('permission:roles.edit')->only(['edit', 'update']);
        $this->middleware('permission:roles.delete')->only(['destroy']);
    }

    public function index()
    {
        $vaiTros = VaiTro::with('quyenHans')->paginate(10);
        return view('Admin.vai_tros.index', compact('vaiTros'));
    }
    public function create()
    {
        $quyenHans = QuyenHan::all();
        return view('Admin.vai_tros.create', compact('quyenHans'));
    }
    public function store(Request $r)
    {
        $d = $r->validate(['ten_vai_tro' => 'required|max:50|unique:vai_tros,ten_vai_tro', 'mo_ta' => 'nullable|max:255', 'quyen_han_ids' => 'array']);
        $v = VaiTro::create($d);
        $v->quyenHans()->sync($d['quyen_han_ids'] ?? []);
        return redirect()->route('Admin.vai-tros.index');
    }
    public function edit(VaiTro $vaiTro)
    {
        $quyenHans = QuyenHan::all();
        $vaiTro->load('quyenHans');
        return view('Admin.vai_tros.edit', compact('vaiTro', 'quyenHans'));
    }
    public function show(VaiTro $vaiTro)
    {
        $vaiTro->load('quyenHans');
        return view('Admin.vai_tros.show', compact('vaiTro'));
    }
    public function update(Request $r, VaiTro $vaiTro)
    {
        $d = $r->validate(['ten_vai_tro' => 'required|max:50|unique:vai_tros,ten_vai_tro,' . $vaiTro->id, 'mo_ta' => 'nullable|max:255', 'quyen_han_ids' => 'array']);
        $vaiTro->update($d);
        $vaiTro->quyenHans()->sync($d['quyen_han_ids'] ?? []);
        return redirect()->route('Admin.vai-tros.index');
    }
    public function destroy(VaiTro $vaiTro)
    {
        $vaiTro->delete();
        return back();
    }
}
