<?php

namespace App\Http\Controllers\Guide;

use App\Http\Controllers\Controller;
use App\Models\HuongDanVien;
use App\Models\LichKhoiHanhTour;
use App\Models\PhanCong;
use App\Models\YeuCauHoTroHdv;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HoTroController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware('permission:ho_tro_hdv.view')->only(['index']);
    //     $this->middleware('permission:ho_tro_hdv.create')->only(['store']);
    // }

    public function index()
    {
        $guide = HuongDanVien::where('user_id', Auth::id())->firstOrFail();

        $lichIdsTuPhanCong = PhanCong::whereJsonContains(
            'hdv_ids',
            (string) $guide->id
        )->pluck('lich_khoi_hanh_id');

        $lichKhoiHanhs = LichKhoiHanhTour::with('tour')
            ->where(function ($query) use ($guide, $lichIdsTuPhanCong) {
                $query->whereIn('id', $lichIdsTuPhanCong)
                    ->orWhere('huong_dan_vien_id', $guide->id);
            })
            ->whereNotIn('trang_thai', ['running', 'completed'])
            ->whereDate('ngay_khoi_hanh', '>', now()->toDateString())
            ->orderBy('ngay_khoi_hanh')
            ->get();

        $yeuCaus = YeuCauHoTroHdv::with([
            'lichKhoiHanh.tour',
            'huongDanVienThayThe',
        ])
            ->where('huong_dan_vien_id', $guide->id)
            ->orderByDesc('id')
            ->get();

        $pendingBySchedule = $yeuCaus
            ->where('trang_thai', 'cho_xu_ly')
            ->keyBy('lich_khoi_hanh_id');

        return view('Guide.ho_tro.index', compact(
            'guide',
            'lichKhoiHanhs',
            'yeuCaus',
            'pendingBySchedule'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'lich_khoi_hanh_id' => [
                'required',
                'integer',
                'exists:lich_khoi_hanh_tours,id',
            ],
            'ly_do' => ['required', 'string', 'max:1000'],
        ], [
            'lich_khoi_hanh_id.required' => 'Vui lòng chọn lịch khởi hành.',
            'ly_do.required' => 'Vui lòng nhập lý do cần thay HDV.',
        ]);

        $guide = HuongDanVien::where('user_id', Auth::id())->firstOrFail();
        $lich = LichKhoiHanhTour::with('tour')
            ->findOrFail($request->lich_khoi_hanh_id);

        $assigned = (
            $lich->huong_dan_vien_id
            && (int) $lich->huong_dan_vien_id === (int) $guide->id
        ) || PhanCong::where('lich_khoi_hanh_id', $lich->id)
            ->whereJsonContains('hdv_ids', (string) $guide->id)
            ->exists();

        if (!$assigned) {
            return back()->with('error', 'Bạn không được phân công lịch khởi hành này.');
        }

        if (in_array($lich->trang_thai, ['running', 'completed'], true)) {
            return back()->with(
                'error',
                'Tour đã bắt đầu hoặc đã hoàn thành nên không thể gửi yêu cầu thay HDV trước khởi hành.'
            );
        }

        $departureDate = Carbon::parse($lich->ngay_khoi_hanh)->startOfDay();

        if (now()->startOfDay()->gte($departureDate)) {
            return back()->with(
                'error',
                'Đã đến ngày khởi hành nên không thể gửi yêu cầu thay HDV theo chức năng này.'
            );
        }

        $exists = YeuCauHoTroHdv::where('lich_khoi_hanh_id', $lich->id)
            ->where('huong_dan_vien_id', $guide->id)
            ->where('trang_thai', 'cho_xu_ly')
            ->exists();

        if ($exists) {
            return back()->with(
                'error',
                'Bạn đã có yêu cầu đang chờ Admin xử lý cho tour này.'
            );
        }

        YeuCauHoTroHdv::create([
            'lich_khoi_hanh_id' => $lich->id,
            'huong_dan_vien_id' => $guide->id,
            'loai_yeu_cau' => 'thay_hdv',
            'tieu_de' => 'Yêu cầu thay hướng dẫn viên',
            'ly_do' => trim($request->ly_do),
            'trang_thai' => 'cho_xu_ly',
        ]);

        return back()->with('success', 'Đã gửi yêu cầu hỗ trợ đến Admin.');
    }
}
