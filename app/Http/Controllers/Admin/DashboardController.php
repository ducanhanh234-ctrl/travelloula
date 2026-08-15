<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class DashboardController extends Controller
{
    public function index()
    {
        Carbon::setLocale('vi');

        $now = now();
        $today = $now->copy()->startOfDay();

        $datTourQuery = DB::table('dat_tours');

        if (Schema::hasColumn('dat_tours', 'deleted_at')) {
            $datTourQuery->whereNull('deleted_at');
        }

        $tongDonDat = (clone $datTourQuery)->count();
        $donChoXacNhan = (clone $datTourQuery)
            ->where('trang_thai', 'cho_xac_nhan')
            ->count();

        $donDaThanhToan = (clone $datTourQuery)
            ->where('trang_thai', 'da_thanh_toan')
            ->count();

        $tongDoanhThu = (float) ((clone $datTourQuery)
            ->sum('so_tien_da_thanh_toan') ?? 0);

        $tongGiaTriDon = (float) ((clone $datTourQuery)
            ->sum('tong_tien') ?? 0);

        $congNoConLai = max(0, $tongGiaTriDon - $tongDoanhThu);

        $tongKhachDat = (clone $datTourQuery)
            ->whereNotNull('nguoi_dung_id')
            ->distinct()
            ->count('nguoi_dung_id');

        $startThisMonth = $now->copy()->startOfMonth();
        $endThisMonth = $now->copy()->endOfMonth();
        $startLastMonth = $now->copy()->subMonthNoOverflow()->startOfMonth();
        $endLastMonth = $now->copy()->subMonthNoOverflow()->endOfMonth();

        $doanhThuThangNay = (float) ((clone $datTourQuery)
            ->whereBetween('ngay_dat', [$startThisMonth, $endThisMonth])
            ->sum('so_tien_da_thanh_toan') ?? 0);

        $doanhThuThangTruoc = (float) ((clone $datTourQuery)
            ->whereBetween('ngay_dat', [$startLastMonth, $endLastMonth])
            ->sum('so_tien_da_thanh_toan') ?? 0);

        $donThangNay = (clone $datTourQuery)
            ->whereBetween('ngay_dat', [$startThisMonth, $endThisMonth])
            ->count();

        $donThangTruoc = (clone $datTourQuery)
            ->whereBetween('ngay_dat', [$startLastMonth, $endLastMonth])
            ->count();

        $tangTruongDoanhThu = $this->growthRate(
            $doanhThuThangNay,
            $doanhThuThangTruoc
        );

        $tangTruongDon = $this->growthRate(
            $donThangNay,
            $donThangTruoc
        );

        $tongTourDangHoatDong = Schema::hasTable('danh_sach_tours')
            ? DB::table('danh_sach_tours')
                ->where('trang_thai', 'active')
                ->count()
            : 0;

        $lichSapKhoiHanh = Schema::hasTable('lich_khoi_hanh_tours')
            ? DB::table('lich_khoi_hanh_tours')
                ->whereDate('ngay_khoi_hanh', '>=', $today->toDateString())
                ->whereIn('trang_thai', ['available', 'running'])
                ->count()
            : 0;

        $tyLeLapDay = 0;

        if (Schema::hasTable('lich_khoi_hanh_tours')) {
            $seatStats = DB::table('lich_khoi_hanh_tours')
                ->whereDate('ngay_khoi_hanh', '>=', $today->toDateString())
                ->whereIn('trang_thai', ['available', 'running', 'full'])
                ->selectRaw(
                    'COALESCE(SUM(so_cho),0) AS tong_cho,
                     COALESCE(SUM(so_cho_da_dat),0) AS da_dat'
                )
                ->first();

            $tongCho = (int) ($seatStats->tong_cho ?? 0);
            $daDat = (int) ($seatStats->da_dat ?? 0);

            $tyLeLapDay = $tongCho > 0
                ? min(100, round(($daDat / $tongCho) * 100))
                : 0;
        }

        $suCoChuaXuLy = 0;
        $suCoGanDay = collect();

        if (Schema::hasTable('bao_cao_su_cos')) {
            $suCoQuery = DB::table('bao_cao_su_cos');

            if (Schema::hasColumn('bao_cao_su_cos', 'deleted_at')) {
                $suCoQuery->whereNull('deleted_at');
            }

            $suCoChuaXuLy = (clone $suCoQuery)
                ->whereIn('trang_thai', ['cho_xu_ly', 'dang_xu_ly'])
                ->count();

            $suCoGanDay = (clone $suCoQuery)
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

        $chartLabels = [];
        $chartRevenue = [];
        $chartBookings = [];

        for ($i = 5; $i >= 0; $i--) {
            $month = $now->copy()->subMonthsNoOverflow($i);
            $monthStart = $month->copy()->startOfMonth();
            $monthEnd = $month->copy()->endOfMonth();

            $chartLabels[] = 'T' . $month->month . '/' . $month->year;

            $chartRevenue[] = (float) ((clone $datTourQuery)
                ->whereBetween('ngay_dat', [$monthStart, $monthEnd])
                ->sum('so_tien_da_thanh_toan') ?? 0);

            $chartBookings[] = (clone $datTourQuery)
                ->whereBetween('ngay_dat', [$monthStart, $monthEnd])
                ->count();
        }

        $bookingStatus = [
            'cho_xac_nhan' => (clone $datTourQuery)
                ->where('trang_thai', 'cho_xac_nhan')
                ->count(),
            'da_xac_nhan' => (clone $datTourQuery)
                ->where('trang_thai', 'da_xac_nhan')
                ->count(),
            'da_thanh_toan' => (clone $datTourQuery)
                ->where('trang_thai', 'da_thanh_toan')
                ->count(),
            'hoan_thanh' => (clone $datTourQuery)
                ->where('trang_thai', 'hoan_thanh')
                ->count(),
            'da_huy' => (clone $datTourQuery)
                ->where('trang_thai', 'da_huy')
                ->count(),
        ];

        $donGanDay = DB::table('dat_tours as dt')
            ->leftJoin('danh_sach_tours as tour', 'tour.id', '=', 'dt.tour_id')
            ->leftJoin('users as u', 'u.id', '=', 'dt.nguoi_dung_id')
            ->leftJoin(
                'lich_khoi_hanh_tours as lkh',
                'lkh.id',
                '=',
                'dt.lich_khoi_hanh_id'
            )
            ->when(
                Schema::hasColumn('dat_tours', 'deleted_at'),
                fn ($query) => $query->whereNull('dt.deleted_at')
            )
            ->select([
                'dt.id',
                'dt.ma_dat_tour',
                'dt.trang_thai',
                'dt.tong_tien',
                'dt.so_tien_da_thanh_toan',
                'dt.ngay_dat',
                'tour.ten_tour',
                'u.name as ten_khach_hang',
                'lkh.ngay_khoi_hanh',
            ])
            ->orderByDesc('dt.ngay_dat')
            ->orderByDesc('dt.id')
            ->limit(7)
            ->get();

        $topTours = DB::table('dat_tours as dt')
            ->join('danh_sach_tours as tour', 'tour.id', '=', 'dt.tour_id')
            ->when(
                Schema::hasColumn('dat_tours', 'deleted_at'),
                fn ($query) => $query->whereNull('dt.deleted_at')
            )
            ->where('dt.trang_thai', '<>', 'da_huy')
            ->selectRaw(
                'tour.id,
                 tour.ten_tour,
                 COUNT(dt.id) AS tong_don,
                 COALESCE(SUM(dt.so_tien_da_thanh_toan),0) AS doanh_thu'
            )
            ->groupBy('tour.id', 'tour.ten_tour')
            ->orderByDesc('doanh_thu')
            ->orderByDesc('tong_don')
            ->limit(5)
            ->get();

        $lichGanNhat = collect();

        if (
            Schema::hasTable('lich_khoi_hanh_tours')
            && Schema::hasTable('danh_sach_tours')
        ) {
            $lichGanNhat = DB::table('lich_khoi_hanh_tours as lkh')
                ->join('danh_sach_tours as tour', 'tour.id', '=', 'lkh.tour_id')
                ->whereDate('lkh.ngay_khoi_hanh', '>=', $today->toDateString())
                ->whereIn('lkh.trang_thai', ['available', 'running', 'full'])
                ->select([
                    'lkh.id',
                    'lkh.ngay_khoi_hanh',
                    'lkh.ngay_ket_thuc',
                    'lkh.so_cho',
                    'lkh.so_cho_da_dat',
                    'lkh.so_cho_con_lai',
                    'lkh.trang_thai',
                    'tour.ten_tour',
                ])
                ->orderBy('lkh.ngay_khoi_hanh')
                ->limit(5)
                ->get();
        }

        return view('Admin.dashboards.index', compact(
            'tongDoanhThu',
            'tongGiaTriDon',
            'congNoConLai',
            'tongDonDat',
            'donChoXacNhan',
            'donDaThanhToan',
            'tongKhachDat',
            'tongTourDangHoatDong',
            'lichSapKhoiHanh',
            'tyLeLapDay',
            'suCoChuaXuLy',
            'suCoGanDay',
            'doanhThuThangNay',
            'doanhThuThangTruoc',
            'donThangNay',
            'donThangTruoc',
            'tangTruongDoanhThu',
            'tangTruongDon',
            'chartLabels',
            'chartRevenue',
            'chartBookings',
            'bookingStatus',
            'donGanDay',
            'topTours',
            'lichGanNhat'
        ));
    }

    private function growthRate(float|int $current, float|int $previous): float
    {
        if ((float) $previous === 0.0) {
            return (float) $current > 0 ? 100.0 : 0.0;
        }

        return round(
            (($current - $previous) / abs($previous)) * 100,
            1
        );
    }
}
