<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ChiTietLichTrinh;
use App\Models\LichTrinhTour;
use Illuminate\Http\Request;

class ChiTietLichTrinhController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($lichTrinh)
    {
        $lichTrinh = LichTrinhTour::with([
            'chiTiets'
        ])->findOrFail($lichTrinh);

        return view(
            'Admin.chi_tiet_lich_trinhs.index',
            compact(
                'lichTrinh'
            )
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($lichTrinh)
    {
        $lichTrinh = LichTrinhTour::findOrFail($lichTrinh);

        return view(
            'Admin.chi_tiet_lich_trinhs.create',
            compact('lichTrinh')
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(
        Request $request,
        $lichTrinh
    ) {
        $request->validate([

            'gio_bat_dau' => 'required',

            'tieu_de' => 'required'

        ]);

        ChiTietLichTrinh::create([

            'lich_trinh_tour_id' => $lichTrinh,

            'gio_bat_dau' => $request->gio_bat_dau,

            'gio_ket_thuc' => $request->gio_ket_thuc,

            'tieu_de' => $request->tieu_de,

            'noi_dung' => $request->noi_dung,

            'thu_tu' => $request->thu_tu

        ]);

        return redirect()->route(
            'Admin.chi_tiet_lich_trinhs.index',
            $lichTrinh
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($chiTiet)
    {
        $chiTiet = ChiTietLichTrinh::findOrFail($chiTiet);

        return view(
            'Admin.chi_tiet_lich_trinhs.edit',
            compact('chiTiet')
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $chiTiet)
    {
        $chiTiet = ChiTietLichTrinh::findOrFail($chiTiet);

        $chiTiet->update([

            'gio_bat_dau' => $request->gio_bat_dau,

            'gio_ket_thuc' => $request->gio_ket_thuc,

            'tieu_de' => $request->tieu_de,

            'noi_dung' => $request->noi_dung,

            'thu_tu' => $request->thu_tu

        ]);

        return redirect()->route(

            'Admin.chi_tiet_lich_trinhs.index',

            $chiTiet->lich_trinh_tour_id

        );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($chiTiet)
    {
        $chiTiet = ChiTietLichTrinh::findOrFail($chiTiet);

        $id = $chiTiet->lich_trinh_tour_id;

        $chiTiet->delete();

        return redirect()->route(

            'Admin.chi_tiet_lich_trinhs.index',

            $id

        );
    }
}
