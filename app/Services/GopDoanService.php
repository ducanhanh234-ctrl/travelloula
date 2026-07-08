<?php

namespace App\Services;

use App\Models\LichKhoiHanhTour;
use Carbon\Carbon;
use App\Services\YeuCauGopDoanService;
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
                'id' => $item['yeuCau']->id ?? null,

                'yeuCau' => $item['yeuCau'] ?? null,

                'nhom' => $nhom,

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
        $tourGroups = LichKhoiHanhTour::with('tour')
            ->where('da_gop', false)
            ->where('so_cho_da_dat', '>', 0)
            ->get()
            ->filter(fn($x) => $x->trang_thai_hien_thi === 'Đã đóng')
            ->groupBy('tour_id');

        $ketQua = [];

        foreach ($tourGroups as $tour) {

            $tour = $tour->sortBy('ngay_khoi_hanh')->values();

            $daDung = [];

            while (true) {

                $conLai = $tour
                    ->reject(fn($x) => in_array($x->id, $daDung))
                    ->values();

                if ($conLai->count() < 2) {
                    break;
                }

                $toHops = $this->taoTatCaToHop($conLai->all());

                $totNhat = null;
                $diemTotNhat = -1;

                foreach ($toHops as $nhom) {

                    if (!$this->hopLe($nhom)) {
                        continue;
                    }

                    $diem = $this->tinhDiem($nhom);

                    if ($diem > $diemTotNhat) {
                        $diemTotNhat = $diem;
                        $totNhat = $nhom;
                    }
                }

                if (!$totNhat) {
                    break;
                }

                $nhomCollect = collect($totNhat)->values();


                $lichIds = $nhomCollect->pluck('id')->sort()->values()->toArray();

                $yeuCau = YeuCauGopDoan::with('chiTiets')
                    ->where('trang_thai', 'cho_xu_ly')
                    ->get()
                    ->first(function ($yc) use ($lichIds) {

                        $ids = $yc->chiTiets
                            ->pluck('lich_khoi_hanh_id')
                            ->unique()
                            ->sort()
                            ->values()
                            ->toArray();

                        return $ids == $lichIds;
                    });

                $ketQua[] = [
                    'nhom' => $nhomCollect,
                    'diem' => $diemTotNhat,
                    'ly_do' => $this->sinhLyDo($totNhat),

                    // thêm dòng này
                    'yeuCau' => $yeuCau,
                ];
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

            // foreach ($nhomTheoLich as $lichId => $chiTiets) {
            //     //Không có ai đồng ý → bỏ lịch Không phải “có từ chối là loại”
            //     if (!$chiTiets->contains('trang_thai_lien_he', 'dong_y')) {
            //         continue;
            //     }

            //     //Chỉ cần CÓ người đồng ý là được Không cần tất cả đồng ý
            //     if (!$chiTiets->contains('trang_thai_lien_he', 'dong_y')) {
            //         throw new \Exception("Lịch #{$lichId} không có khách đồng ý gộp.");
            //     } {

            //         throw new \Exception(
            //             "Lịch #{$lichId} vẫn còn booking chưa xác nhận."
            //         );
            //     }

            //     $lichHopLe->push($lichId);
            // }

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
                DatTour::where(
                    'lich_khoi_hanh_id',
                    $lichId
                )->update([
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
                'trang_thai' => 'hoan_tat'
            ]);
        });
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
