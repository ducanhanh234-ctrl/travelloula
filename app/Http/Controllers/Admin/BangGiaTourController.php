<?php


namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BangGiaTour;
use App\Models\DanhSachTour;
use Illuminate\Http\Request;

class BangGiaTourController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $bangGias = BangGiaTour::with('tour')
            ->latest()
            ->paginate(10);

        return view('Admin.bang_gia_tours.index', compact('bangGias'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $tours = DanhSachTour::orderBy('ten_tour')->get();

        return view('Admin.bang_gia_tours.create', compact('tours'));
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([

            'tour_id' => 'required|exists:danh_sach_tours,id',

            'ten_bang_gia' => 'required|string|max:255',

            'ngay_bat_dau' => 'required|date',

            'ngay_ket_thuc' => 'required|date|after_or_equal:ngay_bat_dau',

            'phan_tram_tang' => 'required|numeric|min:0|max:100',

        ]);
        $exists = BangGiaTour::where('tour_id', $request->tour_id)
            ->where(function ($query) use ($request) {

                $query->whereBetween('ngay_bat_dau', [
                    $request->ngay_bat_dau,
                    $request->ngay_ket_thuc
                ])
                    ->orWhereBetween('ngay_ket_thuc', [
                        $request->ngay_bat_dau,
                        $request->ngay_ket_thuc
                    ])
                    ->orWhere(function ($q) use ($request) {

                        $q->where('ngay_bat_dau', '<=', $request->ngay_bat_dau)
                            ->where('ngay_ket_thuc', '>=', $request->ngay_ket_thuc);

                    });

            })
            ->exists();

        if ($exists) {

            return back()
                ->withInput()
                ->withErrors([
                    'ngay_bat_dau' => 'Khoảng thời gian này đã có bảng giá.'
                ]);

        }
        $tour = DanhSachTour::findOrFail($request->tour_id);

        $giaNguoiLon = $tour->gia_nguoi_lon +
            ($tour->gia_nguoi_lon * $request->phan_tram_tang / 100);

        $giaTreEm = $tour->gia_tre_em +
            ($tour->gia_tre_em * $request->phan_tram_tang / 100);

        BangGiaTour::create([

            'tour_id' => $tour->id,

            'ten_bang_gia' => $request->ten_bang_gia,

            'ngay_bat_dau' => $request->ngay_bat_dau,

            'ngay_ket_thuc' => $request->ngay_ket_thuc,

            'phan_tram_tang' => $request->phan_tram_tang,

            'gia_nguoi_lon' => $giaNguoiLon,

            'gia_tre_em' => $giaTreEm,

            'trang_thai' => 'active',

        ]);

        return redirect()
            ->route('Admin.bang-gia-tours.index')
            ->with('success', 'Thêm bảng giá thành công.');
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
    public function edit(BangGiaTour $bang_gia_tour)
    {
        $tours = DanhSachTour::orderBy('ten_tour')->get();

        return view(
            'Admin.bang_gia_tours.edit',
            compact('bang_gia_tour', 'tours')
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, BangGiaTour $bang_gia_tour)
    {
        $request->validate([

            'tour_id' => 'required|exists:danh_sach_tours,id',

            'ten_bang_gia' => 'required|string|max:255',

            'ngay_bat_dau' => 'required|date',

            'ngay_ket_thuc' => 'required|date|after_or_equal:ngay_bat_dau',

            'phan_tram_tang' => 'required|numeric|min:0|max:100',

            'trang_thai' => 'required|in:active,inactive',

        ]);
        $exists = BangGiaTour::where('tour_id', $request->tour_id)
            ->where('id', '!=', $bang_gia_tour->id)
            ->where(function ($query) use ($request) {

                $query->whereBetween('ngay_bat_dau', [
                    $request->ngay_bat_dau,
                    $request->ngay_ket_thuc
                ])
                    ->orWhereBetween('ngay_ket_thuc', [
                        $request->ngay_bat_dau,
                        $request->ngay_ket_thuc
                    ])
                    ->orWhere(function ($q) use ($request) {

                        $q->where('ngay_bat_dau', '<=', $request->ngay_bat_dau)
                            ->where('ngay_ket_thuc', '>=', $request->ngay_ket_thuc);

                    });

            })
            ->exists();

        if ($exists) {

            return back()
                ->withInput()
                ->withErrors([
                    'ngay_bat_dau' => 'Khoảng thời gian này đã có bảng giá.'
                ]);

        }
        $tour = DanhSachTour::findOrFail($request->tour_id);

        $giaNguoiLon = $tour->gia_nguoi_lon +
            ($tour->gia_nguoi_lon * $request->phan_tram_tang / 100);

        $giaTreEm = $tour->gia_tre_em +
            ($tour->gia_tre_em * $request->phan_tram_tang / 100);

        $bang_gia_tour->update([

            'tour_id' => $tour->id,

            'ten_bang_gia' => $request->ten_bang_gia,

            'ngay_bat_dau' => $request->ngay_bat_dau,

            'ngay_ket_thuc' => $request->ngay_ket_thuc,

            'phan_tram_tang' => $request->phan_tram_tang,

            'gia_nguoi_lon' => $giaNguoiLon,

            'gia_tre_em' => $giaTreEm,

            'trang_thai' => $request->trang_thai,

        ]);

        return redirect()
            ->route('Admin.bang-gia-tours.index')
            ->with('success', 'Cập nhật bảng giá thành công.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(BangGiaTour $bang_gia_tour)
    {
        $bang_gia_tour->delete();

        return redirect()
            ->route('Admin.bang-gia-tours.index')
            ->with('success', 'Xóa bảng giá thành công.');
    }
}
