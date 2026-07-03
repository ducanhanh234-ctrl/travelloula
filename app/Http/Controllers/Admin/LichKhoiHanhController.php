<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\LichKhoiHanhTour;
use App\Models\DanhSachTour;
use App\Models\HuongDanVien;
use Carbon\Carbon;


class LichKhoiHanhController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:lich_khoi_hanh.view')->only(['index', 'show']);
        $this->middleware('permission:lich_khoi_hanh.create')->only(['create', 'store']);
        $this->middleware('permission:lich_khoi_hanh.edit')->only(['edit', 'update']);
        $this->middleware('permission:lich_khoi_hanh.delete')->only(['destroy']);
    }

    public function index()
    {
        $allData = LichKhoiHanhTour::with([
            'tour',
            'huongDanVien',
            'lichGopDen'
        ])->get();

        $query = LichKhoiHanhTour::with([
            'tour',
            'huongDanVien',
            'lichGopDen'
        ]);

        if (request('keyword')) {

            $query->whereHas('tour', function ($q) {

                $q->where(
                    'ten_tour',
                    'like',
                    '%' . request('keyword') . '%'
                );
            });
        }

        // Lọc từ ngày
        if (request('from_date')) {

            $query->whereDate(
                'ngay_khoi_hanh',
                '>=',
                request('from_date')
            );
        }

        // Lọc đến ngày
        if (request('to_date')) {

            $query->whereDate(
                'ngay_khoi_hanh',
                '<=',
                request('to_date')
            );
        }

        $data = $query
            ->orderBy('ngay_khoi_hanh')
            ->paginate(10)
            ->withQueryString();

        if (request('status')) {

            $data->setCollection(
                $data->getCollection()->filter(function ($item) {
                    return $item->trang_thai_hien_thi == request('status');
                })->values()
            );
        }

        $moBan = 0;
        $dangDienRa = 0;
        $hetCho = 0;
        $daKetThuc = 0;
        $daDong = 0;

        foreach ($allData as $item) {

            switch ($item->trang_thai_hien_thi) {

                case 'Mở bán':
                    $moBan++;
                    break;

                case 'Đang diễn ra':
                    $dangDienRa++;
                    break;

                case 'Hết chỗ':
                    $hetCho++;
                    break;

                case 'Đã kết thúc':
                    $daKetThuc++;
                    break;

                case 'Đã đóng':
                    $daDong++;
                    break;
            }
        }

        return view(
            'Admin.lich_khoi_hanh.index',
            compact(
                'data',
                'moBan',
                'dangDienRa',
                'hetCho',
                'daKetThuc',
                'daDong'
            )
        );
    }

    public function create()
    {
        $tours = DanhSachTour::all();

        return view(
            'Admin.lich_khoi_hanh.create',
            compact('tours')
        );
    }

    public function store(Request $request)
    {
        $request->validate([
            'tour_id' => 'required',

            'ngay_khoi_hanh' => 'required|date',

            'so_cho' => 'required|integer',

            'gia_nguoi_lon' => 'required|integer',
            'gia_tre_em' => 'required|integer',

            'ngay_ket_thuc' => 'required|date|after:ngay_khoi_hanh',
        ]);

        $tour = DanhSachTour::findOrFail($request->tour_id);

        // Lấy số ngày từ chuỗi như "3 ngày 2 đêm"
        preg_match('/(\d+)/', $tour->thoi_luong, $match);

        $soNgay = (int) ($match[1] ?? 1);

        // Tính ngày kết thúc
        $ngayKetThuc = Carbon::parse($request->ngay_khoi_hanh)
            ->addDays($soNgay - 1)
            ->format('Y-m-d');

        LichKhoiHanhTour::create([
            'tour_id' => $request->tour_id,

            'ngay_khoi_hanh' => $request->ngay_khoi_hanh,
            'ngay_ket_thuc' => $ngayKetThuc,

            'so_cho' => $request->so_cho,
            'so_cho_con_lai' => $request->so_cho,
            'so_cho_da_dat' => 0,

            'gia_nguoi_lon' => $request->gia_nguoi_lon,
            'gia_tre_em' => $request->gia_tre_em,

            'trang_thai' => 'available',
        ]);

        return redirect()
            ->route('Admin.lich-khoi-hanh.index')
            ->with('success', 'Thêm lịch khởi hành thành công');
    }

    public function show($id)
    {
        $item = LichKhoiHanhTour::with([
            'tour',
            'tour.danhMuc',
            'huongDanVien'
        ])->findOrFail($id);

        return view(
            'Admin.lich_khoi_hanh.show',
            compact('item')
        );
    }

    public function edit($id)
    {
        $item = LichKhoiHanhTour::findOrFail($id);

        $tours = DanhSachTour::orderBy('ten_tour')->get();

        $guides = HuongDanVien::where(
            'trang_thai',
            'hoat_dong'
        )
            ->orderBy('ho_ten')
            ->get();

        return view(
            'Admin.lich_khoi_hanh.edit',
            compact(
                'item',
                'tours',
                'guides'
            )
        );
    }

    public function update(Request $request, $id)
    {
        $item = LichKhoiHanhTour::findOrFail($id);

        $request->validate([
            'tour_id' => 'required',
            'ngay_khoi_hanh' => 'required|date',
            'so_cho' => 'required|integer|min:1',
            'gia_nguoi_lon' => 'required|integer|min:0',
            'gia_tre_em' => 'required|integer|min:0',
            'trang_thai' => 'required',
            'huong_dan_vien_id' => 'nullable|exists:huong_dan_viens,id',
        ]);

        $tour = DanhSachTour::findOrFail($request->tour_id);

        preg_match('/(\d+)/', $tour->thoi_luong, $match);

        $soNgay = (int) ($match[1] ?? 1);

        $ngayKetThuc = Carbon::parse($request->ngay_khoi_hanh)
            ->addDays($soNgay - 1)
            ->format('Y-m-d');

        $item->update([
            'tour_id' => $request->tour_id,

            'ngay_khoi_hanh' => $request->ngay_khoi_hanh,
            'ngay_ket_thuc'  => $ngayKetThuc,

            'so_cho' => $request->so_cho,

            'gia_nguoi_lon' => $request->gia_nguoi_lon,
            'gia_tre_em' => $request->gia_tre_em,

            'trang_thai' => $request->trang_thai,

            'huong_dan_vien_id' => $request->huong_dan_vien_id,
        ]);

        return redirect()
            ->route('Admin.lich-khoi-hanh.index')
            ->with('success', 'Cập nhật thành công');
    }

    public function destroy($id)
    {
        LichKhoiHanhTour::findOrFail($id)->delete();

        return redirect()->route('Admin.lich-khoi-hanh.index')
            ->with('success', 'Xóa thành công');
    }
}
