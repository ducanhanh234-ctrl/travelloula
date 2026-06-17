<?php

namespace App\Http\Controllers;

use App\Models\DanhGia;
use App\Models\DatTour;
use App\Models\KhachHangDatTour;
use App\Models\ThanhToan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ThongKeController extends Controller
{
    public function index()
    {
        $tongDoanhThu = ThanhToan::where('trang_thai', 1)
            ->sum('so_tien');

        $tongDon = DatTour::count();

        $tongKhachHang = KhachHangDatTour::count();

        $tongDanhGia = DanhGia::count();
        $diemTrungBinh = DanhGia::avg('so_sao');
        $danhGia5Sao = DanhGia::where('so_sao', 5)->count();

        $danhGia4Sao = DanhGia::where('so_sao', 4)->count();

        $danhGia3Sao = DanhGia::where('so_sao', 3)->count();
        $danhGia1Sao = DanhGia::where('so_sao', 1)->count();
        $doanhThuTheoThang = ThanhToan::selectRaw("
    MONTH(thoi_gian_thanh_toan) as thang,
    SUM(so_tien) as tong_tien
")
            ->where('trang_thai', 1)
            ->groupBy('thang')
            ->orderBy('thang')
            ->get();
        $labels = [];
        $revenues = [];

        foreach ($doanhThuTheoThang as $item) {

            $labels[] = 'T' . $item->thang;

            $revenues[] = $item->tong_tien;
        }
        $tourNoiBat = DatTour::selectRaw(
            'tour_id,
    COUNT(*) as so_luot_dat'
        )
            ->with('tour')
            ->groupBy('tour_id')
            ->orderByDesc('so_luot_dat')
            ->limit(5)
            ->get();
        $choXuLy = DatTour::where('trang_thai', 'cho_xac_nhan')->count();

        $daXacNhan = DatTour::where('trang_thai', 'da_xac_nhan')->count();

        $daHuy = DatTour::where('trang_thai', 'da_huy')->count();
        return view(
            'admin.thongke_baocao.index',
            compact(
                'tongDoanhThu',
                'tongDon',
                'tongKhachHang',
                'tongDanhGia',
                'diemTrungBinh',
                'choXuLy',
                'daXacNhan',
                'daHuy',
                'tourNoiBat',
                'danhGia5Sao',
                'danhGia4Sao',
                'danhGia3Sao',
                'danhGia1Sao',
                'labels',
                'revenues'
            )
        );
    }

    public function export()
    {
        $tongDoanhThu = ThanhToan::where('trang_thai', 1)
            ->sum('so_tien');

        $tongDon = DatTour::count();

        $tongKhachHang = KhachHangDatTour::count();

        $tongDanhGia = DanhGia::count();
        $diemTrungBinh = DanhGia::avg('so_sao');

        $doanhThuTheoThang = ThanhToan::selectRaw(
            "MONTH(thoi_gian_thanh_toan) as thang, SUM(so_tien) as tong_tien"
        )
            ->where('trang_thai', 1)
            ->groupBy('thang')
            ->orderBy('thang')
            ->get();

        $tourNoiBat = DatTour::selectRaw('tour_id, COUNT(*) as so_luot_dat')
            ->with('tour')
            ->groupBy('tour_id')
            ->orderByDesc('so_luot_dat')
            ->limit(5)
            ->get();

        $callback = function () use ($tongDoanhThu, $tongDon, $tongKhachHang, $tongDanhGia, $diemTrungBinh, $doanhThuTheoThang, $tourNoiBat) {
            $out = fopen('php://output', 'w');

            fprintf($out, chr(0xEF) . chr(0xBB) . chr(0xBF));

            fputcsv($out, ['BÁO CÁO THỐNG KÊ']);
            fputcsv($out, []);

            fputcsv($out, ['Chỉ số', 'Giá trị']);
            fputcsv($out, ['Tổng doanh thu', $tongDoanhThu]);
            fputcsv($out, ['Tổng đơn đặt tour', $tongDon]);
            fputcsv($out, ['Tổng khách hàng', $tongKhachHang]);
            fputcsv($out, ['Tổng đánh giá', $tongDanhGia]);
            fputcsv($out, ['Điểm trung bình đánh giá', number_format($diemTrungBinh, 1)]);

            fputcsv($out, []);
            fputcsv($out, ['Doanh thu theo tháng']);
            fputcsv($out, ['Tháng', 'Tổng tiền']);
            foreach ($doanhThuTheoThang as $row) {
                fputcsv($out, ['T' . $row->thang, $row->tong_tien]);
            }

            fputcsv($out, []);
            fputcsv($out, ['Top 5 tour theo lượt đặt']);
            fputcsv($out, ['Tên tour', 'Số lượt đặt']);
            foreach ($tourNoiBat as $t) {
                $ten = $t->tour->ten_tour ?? 'N/A';
                fputcsv($out, [$ten, $t->so_luot_dat]);
            }

            fclose($out);
        };

        $fileName = 'bao-cao-thong-ke-' . date('Ymd') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
        ];

        return response()->streamDownload($callback, $fileName, $headers);
    }
}
