<?php

namespace App\Services;

use App\Models\LichKhoiHanhTour;
use Carbon\Carbon;
// use App\Services\YeuCauGopDoanService;
use Illuminate\Support\Facades\DB;
use App\Models\YeuCauGopDoan;
use App\Models\DatTour;


class GopDoanService
{
    public function layDanhSachDeXuat()
    {
        $nhomDoans = $this->timNhomCoTheGop();

        $deXuats = [];

        foreach ($nhomDoans as $item) {

            $nhom = $item['nhom'];

            $deXuats[] = [

                'nhom' => $nhom,

                'lich_chinh' => $nhom->first(),

                'tong_khach' => $nhom->sum('so_cho_da_dat'),

                'diem' => $item['diem'],

                'ly_do' => $item['ly_do'],

            ];
        }

        usort($deXuats, function ($a, $b) {
            return $b['diem'] <=> $a['diem'];
        });


        return $deXuats;
    }

    private function timNhomCoTheGop()
    {
        // Chỉ lấy các lịch còn tự do
        $tourGroups = LichKhoiHanhTour::with('tour')
            ->where('da_gop', 0)
            ->where('dang_gop_doan', 0)
            ->where('so_cho_da_dat', '>', 0)
            ->get()
            ->filter(fn($lich) => $lich->trang_thai_hien_thi === 'Đã đóng')
            ->groupBy('tour_id');

        $ketQua = [];

        foreach ($tourGroups as $lichTheoTour) {

            $lichTheoTour = $lichTheoTour
                ->sortBy('ngay_khoi_hanh')
                ->values();

            // đánh dấu lịch đã dùng
            $daDung = [];

            while (true) {

                $conLai = $lichTheoTour
                    ->reject(fn($l) => in_array($l->id, $daDung))
                    ->values();

                if ($conLai->count() < 2) {
                    break;
                }

                $totNhat = null;
                $diemTotNhat = -1;

                $toHops = $this->taoTatCaToHop(
                    $conLai->all(),
                    2,
                    4
                );

                foreach ($toHops as $nhom) {

                    if (!$this->hopLe($nhom)) {
                        continue;
                    }

                    $diem = $this->tinhDiem($nhom);

                    if ($diem > $diemTotNhat) {

                        $diemTotNhat = $diem;
                        $totNhat = collect($nhom)->values();
                    }
                }

                if (!$totNhat) {
                    break;
                }


                $ketQua[] = [

                    'nhom' => $totNhat,

                    'diem' => $diemTotNhat,

                    'ly_do' => $this->sinhLyDo($totNhat),

                ];

                // Đánh dấu các lịch đã dùng
                foreach ($totNhat as $lich) {
                    $daDung[] = $lich->id;
                }
            }
        }

        return $ketQua;
    }

    private function taoTatCaToHop($items, $min = 2, $max = 4)
    {
        $ketQua = [];

        $this->backtrack(
            $items,
            0,
            [],
            $ketQua,
            $min,
            $max
        );

        return $ketQua;
    }

    private function backtrack($items, $index, $current, &$ketQua, $min, $max)
    {
        $items = array_values($items);

        if (count($current) >= $min) {
            $ketQua[] = array_values($current);
        }

        if (count($current) == $max) {
            return;
        }

        for ($i = $index; $i < count($items); $i++) {

            $new = $current;

            $new[] = $items[$i]; // OK sau khi array_values

            $this->backtrack($items, $i + 1, $new, $ketQua, $min, $max);
        }
    }

    private function hopLe($nhom)
    {
        $nhom = collect($nhom);
        $tong = $nhom->sum('so_cho_da_dat');

        if ($tong > 43) {
            return false;
        }

        $ngayDau = Carbon::parse(
            $nhom->min('ngay_khoi_hanh')
        );

        $ngayCuoi = Carbon::parse(
            $nhom->max('ngay_khoi_hanh')
        );

        return $ngayDau->diffInDays($ngayCuoi) <= 7;
    }

    private function mucTieuGanNhat($tongKhach)
    {
        return collect([14, 27, 43])
            ->map(fn($x) => abs($tongKhach - $x))
            ->min();
    }

    private function tinhDiem($nhom)
    {
        $nhom = collect($nhom)->values();

        $diem = 0;

        $tongKhach = $nhom->sum('so_cho_da_dat');

        $ngayDau = $nhom->min('ngay_khoi_hanh');
        $ngayCuoi = $nhom->max('ngay_khoi_hanh');

        $soNgay = Carbon::parse($ngayDau)
            ->diffInDays(Carbon::parse($ngayCuoi));

        if ($soNgay <= 2) {
            $diem += 30;
        } elseif ($soNgay <= 4) {
            $diem += 25;
        } else {
            $diem += 20;
        }

        $lech = collect([14, 27, 43])
            ->map(fn($x) => abs($tongKhach - $x))
            ->min();

        $diem += max(0, 50 - ($lech * 2));

        switch ($nhom->count()) {
            case 2:
                $diem += 20;
                break;
            case 3:
                $diem += 10;
                break;
            case 4:
                $diem += 5;
                break;
        }

        return min($diem, 100);
    }
    private function sinhLyDo($nhom)
    {
        $nhom = collect($nhom)->filter();

        $lyDo = [];

        $tongKhach = $nhom->sum('so_cho_da_dat');

        $ngayDau = $nhom->min('ngay_khoi_hanh');
        $ngayCuoi = $nhom->max('ngay_khoi_hanh');

        $soNgay = 0;

        if ($ngayDau && $ngayCuoi) {
            $soNgay = Carbon::parse($ngayDau)
                ->diffInDays(Carbon::parse($ngayCuoi));
        }

        $lyDo[] = "Ghép {$nhom->count()} lịch";
        $lyDo[] = "Khoảng cách {$soNgay} ngày";
        $lyDo[] = "Tổng {$tongKhach} khách";
        $lyDo[] = "Đề xuất xe {$this->xacDinhLoaiXe($tongKhach)} chỗ";

        return $lyDo;
    }

    private function xacDinhLoaiXe($soKhach)
    {
        if ($soKhach <= 14) {
            return 14;
        }

        if ($soKhach <= 27) {
            return 27;
        }

        return 43;
    }

    public function chotGop($yeuCauId)
    {
        DB::transaction(function () use ($yeuCauId) {

            $yeuCau = YeuCauGopDoan::with('chiTiets')->findOrFail($yeuCauId);

            /*
        |--------------------------------------------------------------------------
        | Gom chi tiết theo lịch khởi hành
        |--------------------------------------------------------------------------
        */

            $nhomTheoLich = $yeuCau->chiTiets->groupBy('lich_khoi_hanh_id');

            /*
        |--------------------------------------------------------------------------
        | Kiểm tra từng lịch
        |--------------------------------------------------------------------------
        */

            $lichHopLe = collect();

            foreach ($nhomTheoLich as $lichId => $chiTiets) {

                // bỏ lịch nếu không có ai đồng ý
                if (!$chiTiets->contains('trang_thai_lien_he', 'dong_y')) {
                    continue;
                }

                // bỏ lịch nếu còn người chưa liên hệ
                if ($chiTiets->contains('trang_thai_lien_he', 'chua_lien_he')) {
                    throw new \Exception("Lịch #{$lichId} còn khách chưa liên hệ.");
                }

                $lichHopLe->push($lichId);
            }

            if ($lichHopLe->count() < 1) {
                throw new \Exception('Không đủ lịch để gộp.');
            }

            /*
        |--------------------------------------------------------------------------
        | Tìm lịch chính
        |--------------------------------------------------------------------------
        */

            $lichChinhChiTiet = $yeuCau->chiTiets
                ->where('la_lich_chinh', 1)
                ->first();

            if (!$lichChinhChiTiet) {
                throw new \Exception('Không tìm thấy lịch chính.');
            }

            $lichChinhId = $lichChinhChiTiet->lich_khoi_hanh_id;

            /*
        |--------------------------------------------------------------------------
        | Nếu lịch chính bị loại thì không được gộp
        |--------------------------------------------------------------------------
        */

            if (!$lichHopLe->contains($lichChinhId)) {
                throw new \Exception('Lịch chính đã bị từ chối.');
            }

            /*
        |--------------------------------------------------------------------------
        | Gộp các lịch phụ
        |--------------------------------------------------------------------------
        */

            foreach ($lichHopLe as $lichId) {

                if ($lichId == $lichChinhId) {
                    continue;
                }

                // chuyển booking
                $bookingIds = $yeuCau->chiTiets
                    ->where('lich_khoi_hanh_id', $lichId)
                    ->where('trang_thai_lien_he', 'dong_y')
                    ->pluck('dat_tour_id');

                DatTour::whereIn('id', $bookingIds)
                    ->update([
                        'lich_khoi_hanh_id' => $lichChinhId
                    ]);

                $lichPhu = LichKhoiHanhTour::findOrFail($lichId);

                $soKhach = $this->tinhTongKhachTheoLich($lichId);

                $lichPhu->update([
                    'da_gop' => 1,
                    'dang_gop_doan' => 0,
                    'gop_vao_lich_id' => $lichChinhId,
                    'so_cho_da_dat' => $soKhach,
                    'so_cho_con_lai' => max(0, $lichPhu->so_cho - $soKhach),
                ]);
            }

            /*
        |--------------------------------------------------------------------------
        | Cập nhật lịch chính
        |--------------------------------------------------------------------------
        */

            $lichChinh = LichKhoiHanhTour::findOrFail($lichChinhId);

            $tongKhach = $this->tinhTongKhachTheoLich($lichChinhId);

            $lichChinh->update([
                'dang_gop_doan' => 0,
                'so_cho_da_dat' => $tongKhach,
                'so_cho_con_lai' => $lichChinh->so_cho - $tongKhach,
            ]);

            /*
        |--------------------------------------------------------------------------
        | Hoàn tất yêu cầu
        |--------------------------------------------------------------------------
        */

            $yeuCau->update([
                'trang_thai' => 'hoan_tat',
                'thoi_gian_hoan_tat' => now(),
            ]);
        });
    }

    public function layLichSu()
    {
        $data = YeuCauGopDoan::with([
            'chiTiets.lichKhoiHanh.tour',
            'chiTiets.datTour',
            'phuongTien',
            'huongDanVien'
        ])
            ->where('trang_thai', 'hoan_tat')
            ->orderByDesc('created_at')
            ->paginate(10);

        $data->getCollection()->transform(function ($yeuCau) {

            // ==========================
            // Loại đề xuất
            // ==========================

            $yeuCau->loaiText = $yeuCau->loai_de_xuat == 'tu_dong'
                ? 'AI'
                : 'Thủ công';

            // ==========================
            // Trạng thái
            // ==========================

            $yeuCau->trangThaiText = $yeuCau->trang_thai == 'cho_xu_ly'
                ? 'Chờ xử lý'
                : 'Hoàn tất';

            // ==========================
            // Lịch chính
            // ==========================

            $lichChinh = $yeuCau->chiTiets
                ->firstWhere('la_lich_chinh', 1);

            $yeuCau->lichChinh = $lichChinh;

            // ==========================
            // Danh sách lịch
            // ==========================

            $yeuCau->danhSachLich = $yeuCau->chiTiets
                ->groupBy('lich_khoi_hanh_id');

            // ==========================
            // Tour
            // ==========================

            $yeuCau->tenTour = optional(
                optional($lichChinh)->lichKhoiHanh->tour
            )->ten_tour ?? '-';

            // ==========================
            // Số lịch
            // ==========================

            $yeuCau->soLich = $yeuCau->danhSachLich->count();

            // ==========================
            // Tổng booking
            // ==========================

            $yeuCau->tongBooking = $yeuCau->chiTiets
                ->whereNotNull('datTour')
                ->count();

            // ==========================
            // Booking đồng ý
            // ==========================

            $yeuCau->bookingDongY = $yeuCau->chiTiets
                ->where('trang_thai_lien_he', 'dong_y')
                ->count();

            // ==========================
            // Booking từ chối
            // ==========================

            $yeuCau->bookingTuChoi = $yeuCau->chiTiets
                ->where('trang_thai_lien_he', 'tu_choi')
                ->count();

            // ==========================
            // Booking chưa liên hệ
            // ==========================

            $yeuCau->bookingChuaLienHe = $yeuCau->chiTiets
                ->where('trang_thai_lien_he', 'chua_lien_he')
                ->count();

            // ==========================
            // Tổng khách
            // ==========================

            $yeuCau->tongKhach = $yeuCau->chiTiets
                ->sum(function ($ct) {

                    if (!$ct->datTour) {
                        return 0;
                    }

                    return ($ct->datTour->so_nguoi_lon ?? 0)
                        + ($ct->datTour->so_tre_em ?? 0)
                        + ($ct->datTour->so_em_be ?? 0);
                });

            // ==========================
            // Khách đã chuyển
            // ==========================

            $yeuCau->khachDaChuyen = $yeuCau->chiTiets
                ->where('trang_thai_lien_he', 'dong_y')
                ->sum(function ($ct) {

                    if (!$ct->datTour) {
                        return 0;
                    }

                    return ($ct->datTour->so_nguoi_lon ?? 0)
                        + ($ct->datTour->so_tre_em ?? 0)
                        + ($ct->datTour->so_em_be ?? 0);
                });

            // ==========================
            // Khách ở lại
            // ==========================

            $yeuCau->khachBoLai = $yeuCau->chiTiets
                ->where('trang_thai_lien_he', 'tu_choi')
                ->sum(function ($ct) {

                    if (!$ct->datTour) {
                        return 0;
                    }

                    return ($ct->datTour->so_nguoi_lon ?? 0)
                        + ($ct->datTour->so_tre_em ?? 0)
                        + ($ct->datTour->so_em_be ?? 0);
                });

            // ==========================
            // Quyền thao tác
            // ==========================

            $yeuCau->coTheHuy =
                $yeuCau->trang_thai == 'cho_xu_ly';

            $yeuCau->coTheChot =
                $yeuCau->trang_thai == 'cho_xu_ly'
                && $yeuCau->bookingChuaLienHe == 0;

            return $yeuCau;
        });

        return $data;
    }

    private function tinhTongKhachTheoLich($lichId)
    {
        return DatTour::where('lich_khoi_hanh_id', $lichId)
            ->get()
            ->sum(function ($booking) {
                return ($booking->so_nguoi_lon ?? 0)
                    + ($booking->so_tre_em ?? 0)
                    + ($booking->so_em_be ?? 0);
            });
    }
}
