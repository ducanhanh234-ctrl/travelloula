<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\LichKhoiHanhTour;
use App\Models\DanhSachTour;
use App\Models\HuongDanVien;
use App\Models\BangGiaTour;
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

        LichKhoiHanhTour::all()->each(function ($lich) {
            $lich->capNhatTrangThai();
        });

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

        $item->capNhatTrangThai();

        $item->load([
            'tour',
            'tour.danhMuc',
            'huongDanVien'
        ]);

        return view(
            'Admin.lich_khoi_hanh.show',
            compact('item')
        );
    }

    public function edit($id)
    {
        $item = LichKhoiHanhTour::findOrFail($id);

        // $item = LichKhoiHanhTour::findOrFail($id);

        $item->capNhatTrangThai();

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

        $validated = $request->validate([
            'tour_id' => 'required|exists:danh_sach_tours,id',
            'ngay_khoi_hanh' => 'required|date',
            'trang_thai' => 'required',
            'huong_dan_vien_id' => 'nullable|exists:huong_dan_viens,id',
        ], [
            'tour_id.required' => 'Vui lòng chọn tour.',
            'tour_id.exists' => 'Tour được chọn không tồn tại.',
            'ngay_khoi_hanh.required' => 'Vui lòng chọn ngày khởi hành.',
            'ngay_khoi_hanh.date' => 'Ngày khởi hành không hợp lệ.',
            'trang_thai.required' => 'Vui lòng chọn trạng thái.',
            'huong_dan_vien_id.exists' => 'Hướng dẫn viên không tồn tại.',
        ]);

        $tour = DanhSachTour::findOrFail($validated['tour_id']);

        /*
    |--------------------------------------------------------------------------
    | Tính ngày kết thúc theo thời lượng tour
    |--------------------------------------------------------------------------
    | Ví dụ:
    | "3 ngày 2 đêm" => 3 ngày
    | "1 ngày"       => 1 ngày
    */
        preg_match('/(\d+)/', $tour->thoi_luong ?? '', $match);

        $soNgay = max(1, (int) ($match[1] ?? 1));

        $ngayKetThuc = Carbon::parse($validated['ngay_khoi_hanh'])
            ->addDays($soNgay - 1)
            ->format('Y-m-d');

        $dataUpdate = [
            'tour_id' => $validated['tour_id'],
            'ngay_khoi_hanh' => $validated['ngay_khoi_hanh'],
            'ngay_ket_thuc' => $ngayKetThuc,
            'trang_thai' => $validated['trang_thai'],
        ];

        /*
    |--------------------------------------------------------------------------
    | Chỉ cập nhật hướng dẫn viên khi form có gửi trường này
    |--------------------------------------------------------------------------
    | Form hiện tại của bạn đang comment trường hướng dẫn viên.
    | Làm như vậy để tránh tự động xóa hướng dẫn viên đang được phân công.
    */
        if ($request->exists('huong_dan_vien_id')) {
            $dataUpdate['huong_dan_vien_id'] =
                $validated['huong_dan_vien_id'] ?? null;
        }

        /*
    |--------------------------------------------------------------------------
    | Không cập nhật số chỗ và giá
    |--------------------------------------------------------------------------
    | Các trường sau được lấy từ bảng khác nên không nhận từ form:
    |
    | so_cho
    | gia_nguoi_lon
    | gia_tre_em
    */
        $item->update($dataUpdate);

        return redirect()
            ->route('Admin.lich-khoi-hanh.index')
            ->with('success', 'Cập nhật lịch khởi hành thành công.');
    }

    public function destroy($id)
    {
        LichKhoiHanhTour::findOrFail($id)->delete();

        return redirect()->route('Admin.lich-khoi-hanh.index')
            ->with('success', 'Xóa thành công');
    }

    public function chot($id)
    {
        $lich = LichKhoiHanhTour::findOrFail($id);

        // Kiểm tra đã chốt chưa
        if ($lich->daDuocChot()) {
            return back()->with(
                'warning',
                'Lịch này đã được chốt.'
            );
        }

        // Kiểm tra có đủ điều kiện chốt không
        if (!$lich->coTheChot()) {
            return back()->with(
                'error',
                'Lịch này chưa đủ điều kiện để chốt.'
            );
        }

        $lich->update([
            'trang_thai' => 'finalized',
        ]);

        return back()->with(
            'success',
            'Đã chốt lịch thành công.'
        );
    }

    public function layBangGia(Request $request)
    {
        $bangGia = BangGiaTour::where('tour_id', $request->tour_id)
            ->where('loai_mua', $request->loai_mua)
            ->first();

        if (!$bangGia) {
            return response()->json([
                'success' => false,
                'message' => 'Không tìm thấy bảng giá.'
            ]);
        }

        return response()->json([
            'success' => true,
            'data' => [
                'gia_nguoi_lon' => $bangGia->gia_nguoi_lon,
                'gia_tre_em' => $bangGia->gia_tre_em,
                'gia_em_be' => $bangGia->gia_em_be,
            ]
        ]);
    }
}
