<?php

namespace App\Http\Controllers\Guide;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class GuideDashboardController extends Controller
{
    public function index()
    {
        Carbon::setLocale('vi');

        $user = auth()->user();
        $today = now()->startOfDay();
        $todayString = $today->toDateString();

        $guide = DB::table('huong_dan_viens')
            ->where('user_id', $user->id)
            ->first();

        if (!$guide) {
            return view('Guide.dashboard.index', [
                'guide' => null,
                'tongTourDuocPhanCong' => 0,
                'tourHomNay' => 0,
                'tongKhachSapPhucVu' => 0,
                'checkInHomNay' => 0,
                'tongCheckInHomNay' => 0,
                'tyLeCheckInHomNay' => 0,
                'suCoChuaXuLy' => 0,
                'tourGanNhat' => null,
                'lichSapToi' => collect(),
                'hoatDongGanDay' => collect(),
                'suCoGanDay' => collect(),
            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | LỊCH ĐƯỢC PHÂN CÔNG
        |--------------------------------------------------------------------------
        */
        $assignmentBase = DB::table('phan_congs as pc')
            ->join(
                'lich_khoi_hanh_tours as lkh',
                'lkh.id',
                '=',
                'pc.lich_khoi_hanh_id'
            )
            ->join(
                'danh_sach_tours as tour',
                'tour.id',
                '=',
                'lkh.tour_id'
            )
            ->leftJoin(
                'phuong_tiens as pt',
                'pt.id',
                '=',
                'pc.phuong_tien_id'
            )
            ->where('pc.hdv_id', $guide->id);

        $tongTourDuocPhanCong = (clone $assignmentBase)
            ->whereDate('lkh.ngay_ket_thuc', '>=', $todayString)
            ->count();

        $tourHomNay = (clone $assignmentBase)
            ->whereDate('lkh.ngay_khoi_hanh', '<=', $todayString)
            ->whereDate(
                DB::raw('COALESCE(lkh.ngay_ket_thuc, lkh.ngay_khoi_hanh)'),
                '>=',
                $todayString
            )
            ->count();

        /*
        |--------------------------------------------------------------------------
        | TOUR GẦN NHẤT / ĐANG CHẠY
        |--------------------------------------------------------------------------
        */
        $tourGanNhat = (clone $assignmentBase)
            ->whereDate(
                DB::raw('COALESCE(lkh.ngay_ket_thuc, lkh.ngay_khoi_hanh)'),
                '>=',
                $todayString
            )
            ->select([
                'pc.id as phan_cong_id',
                'pc.ghi_chu as ghi_chu_phan_cong',
                'lkh.id as lich_khoi_hanh_id',
                'lkh.ngay_khoi_hanh',
                'lkh.ngay_ket_thuc',
                'lkh.so_cho',
                'lkh.so_cho_da_dat',
                'lkh.so_cho_con_lai',
                'lkh.trang_thai',
                'tour.id as tour_id',
                'tour.ten_tour',
                'tour.anh_dai_dien',
                'tour.dia_diem_khoi_hanh',
                'tour.diem_den',
                'tour.thoi_luong',
                'pt.loai_phuong_tien',
                'pt.bien_so_xe',
                'pt.ten_tai_xe',
                'pt.so_dien_thoai_tai_xe',
            ])
            ->orderByRaw(
                "CASE
                    WHEN lkh.ngay_khoi_hanh <= ? AND
                         COALESCE(lkh.ngay_ket_thuc, lkh.ngay_khoi_hanh) >= ?
                    THEN 0
                    ELSE 1
                 END",
                [$todayString, $todayString]
            )
            ->orderBy('lkh.ngay_khoi_hanh')
            ->first();

        /*
        |--------------------------------------------------------------------------
        | DANH SÁCH LỊCH SẮP TỚI
        |--------------------------------------------------------------------------
        */
        $lichSapToi = (clone $assignmentBase)
            ->whereDate(
                DB::raw('COALESCE(lkh.ngay_ket_thuc, lkh.ngay_khoi_hanh)'),
                '>=',
                $todayString
            )
            ->select([
                'pc.id as phan_cong_id',
                'lkh.id as lich_khoi_hanh_id',
                'lkh.ngay_khoi_hanh',
                'lkh.ngay_ket_thuc',
                'lkh.so_cho',
                'lkh.so_cho_da_dat',
                'lkh.so_cho_con_lai',
                'lkh.trang_thai',
                'tour.ten_tour',
                'tour.dia_diem_khoi_hanh',
                'tour.diem_den',
                'pt.loai_phuong_tien',
                'pt.bien_so_xe',
            ])
            ->orderBy('lkh.ngay_khoi_hanh')
            ->limit(6)
            ->get();

        /*
        |--------------------------------------------------------------------------
        | TỔNG KHÁCH CỦA CÁC TOUR SẮP / ĐANG CHẠY
        |--------------------------------------------------------------------------
        */
        $assignedScheduleIds = (clone $assignmentBase)
            ->whereDate(
                DB::raw('COALESCE(lkh.ngay_ket_thuc, lkh.ngay_khoi_hanh)'),
                '>=',
                $todayString
            )
            ->pluck('lkh.id');

        $tongKhachSapPhucVu = 0;

        if ($assignedScheduleIds->isNotEmpty()) {
            if (Schema::hasTable('khach_hang_dat_tours')) {
                $tongKhachSapPhucVu = DB::table('khach_hang_dat_tours as kh')
                    ->join('dat_tours as dt', 'dt.id', '=', 'kh.dat_tour_id')
                    ->whereIn('dt.lich_khoi_hanh_id', $assignedScheduleIds)
                    ->where('dt.trang_thai', '<>', 'da_huy')
                    ->when(
                        Schema::hasColumn('dat_tours', 'deleted_at'),
                        fn ($query) => $query->whereNull('dt.deleted_at')
                    )
                    ->count();
            } else {
                $tongKhachSapPhucVu = DB::table('dat_tours')
                    ->whereIn('lich_khoi_hanh_id', $assignedScheduleIds)
                    ->where('trang_thai', '<>', 'da_huy')
                    ->selectRaw(
                        'COALESCE(SUM(so_nguoi_lon + so_tre_em + so_em_be), 0) AS tong'
                    )
                    ->value('tong') ?? 0;
            }
        }

        /*
        |--------------------------------------------------------------------------
        | CHECK-IN HÔM NAY
        |--------------------------------------------------------------------------
        */
        $checkInHomNay = 0;
        $tongCheckInHomNay = 0;
        $tyLeCheckInHomNay = 0;

        if (Schema::hasTable('check_in_khach_hangs')) {
            $checkInQuery = DB::table('check_in_khach_hangs')
                ->where('huong_dan_vien_id', $guide->id);

            $tongCheckInHomNay = (clone $checkInQuery)
                ->whereDate('created_at', $todayString)
                ->count();

            $checkInHomNay = (clone $checkInQuery)
                ->whereDate('created_at', $todayString)
                ->whereIn('trang_thai', ['da_check_in', 'da_check_out'])
                ->count();

            $tyLeCheckInHomNay = $tongCheckInHomNay > 0
                ? min(100, round(($checkInHomNay / $tongCheckInHomNay) * 100))
                : 0;
        }

        /*
        |--------------------------------------------------------------------------
        | SỰ CỐ
        |--------------------------------------------------------------------------
        */
        $suCoChuaXuLy = 0;
        $suCoGanDay = collect();

        if (Schema::hasTable('bao_cao_su_cos')) {
            $incidentBase = DB::table('bao_cao_su_cos')
                ->where('huong_dan_vien_id', $guide->id);

            if (Schema::hasColumn('bao_cao_su_cos', 'deleted_at')) {
                $incidentBase->whereNull('deleted_at');
            }

            $suCoChuaXuLy = (clone $incidentBase)
                ->whereIn('trang_thai', ['cho_xu_ly', 'dang_xu_ly'])
                ->count();

            $suCoGanDay = (clone $incidentBase)
                ->select([
                    'id',
                    'tieu_de',
                    'loai_su_co',
                    'muc_do',
                    'trang_thai',
                    'created_at',
                ])
                ->orderByDesc('created_at')
                ->limit(5)
                ->get();
        }

        /*
        |--------------------------------------------------------------------------
        | HOẠT ĐỘNG GẦN ĐÂY
        |--------------------------------------------------------------------------
        */
        $hoatDongGanDay = collect();

        if (Schema::hasTable('nhat_ky_huong_dan_viens')) {
            $hoatDongGanDay = DB::table('nhat_ky_huong_dan_viens')
                ->where('huong_dan_vien_id', $guide->id)
                ->select([
                    'id',
                    'hanh_dong',
                    'noi_dung',
                    'created_at',
                ])
                ->orderByDesc('created_at')
                ->limit(7)
                ->get();
        }

        return view('Guide.dashboard.index', compact(
            'guide',
            'tongTourDuocPhanCong',
            'tourHomNay',
            'tongKhachSapPhucVu',
            'checkInHomNay',
            'tongCheckInHomNay',
            'tyLeCheckInHomNay',
            'suCoChuaXuLy',
            'tourGanNhat',
            'lichSapToi',
            'hoatDongGanDay',
            'suCoGanDay'
        ));
    }
}
