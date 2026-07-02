<?php

namespace App\Services;

use App\Models\YeuCauGopDoan;
use App\Models\ChiTietYeuCauGopDoan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;
use App\Models\LichKhoiHanhTour;

class YeuCauGopDoanService
{
    public function taoYeuCauTuDeXuat(Collection $nhom, int $diem, array $lyDo)
    {
        return DB::transaction(function () use ($nhom, $diem, $lyDo) {

            $yeuCau = YeuCauGopDoan::create([
                'ma_yeu_cau' => 'YG' . now()->format('YmdHis') . rand(100, 999),
                'ly_do_de_xuat' => $lyDo,
                'loai_de_xuat' => 'tu_dong',
                'trang_thai' => 'cho_xu_ly',
                'xe_de_xuat' => $this->getXeDeXuat($nhom),
            ]);

            foreach ($nhom as $index => $lich) {

                // CHẶN TRÙNG (QUAN TRỌNG)
                if ((int)$lich->dang_gop_doan !== 0) {
                    throw new \Exception("Lịch {$lich->id} đã có yêu cầu gộp đoàn");
                }

                // tạo chi tiết
                ChiTietYeuCauGopDoan::create([
                    'yeu_cau_gop_doan_id' => $yeuCau->id,
                    'lich_khoi_hanh_id'   => $lich->id,
                    'la_lich_chinh'       => $index === 0,
                ]);

                // lock lịch
                $lich->update([
                    'dang_gop_doan' => 1
                ]);
            }

            return $yeuCau;
        });
    }

    public function taoYeuCauThuCong(array $lichIds, array|string $lyDo = [])
    {
        return DB::transaction(function () use ($lichIds, $lyDo) {

            $nhom = LichKhoiHanhTour::whereIn('id', $lichIds)
                ->orderBy('ngay_khoi_hanh')
                ->get();

            if ($nhom->count() < 2) {
                throw new \Exception('Phải chọn ít nhất 2 lịch để gộp.');
            }

            if (is_string($lyDo)) {
                $lyDo = explode(' | ', $lyDo);
            }

            $yeuCau = YeuCauGopDoan::create([
                'ma_yeu_cau'       => 'YG' . now()->format('YmdHis') . rand(100, 999),
                'dia_diem_de_xuat' => null,
                'ly_do_de_xuat'    => $lyDo,
                'loai_de_xuat'     => 'thu_cong',
                'trang_thai'       => 'cho_xu_ly',
                'xe_de_xuat'       => $this->getXeDeXuat($nhom),
            ]);

            foreach ($nhom as $index => $lich) {
                // lấy booking của lịch này
                $bookings = \App\Models\DatTour::where(
                    'lich_khoi_hanh_id',
                    $lich->id
                )->get();

                foreach ($bookings as $booking) {

                    ChiTietYeuCauGopDoan::create([

                        'yeu_cau_gop_doan_id' => $yeuCau->id,

                        'lich_khoi_hanh_id' => $lich->id,

                        'dat_tour_id' => $booking->id,

                        'la_lich_chinh' => $index === 0,

                    ]);
                }

                // nếu lịch chưa có booking vẫn tạo 1 dòng
                if ($bookings->count() == 0) {

                    ChiTietYeuCauGopDoan::create([

                        'yeu_cau_gop_doan_id' => $yeuCau->id,

                        'lich_khoi_hanh_id' => $lich->id,

                        'la_lich_chinh' => $index === 0,

                    ]);
                }

                $lich->update([
                    'dang_gop_doan' => 1
                ]);
            }

            return $yeuCau;
        });
    }

    private function getXeDeXuat($nhom)
    {
        $tong = collect($nhom)->sum('so_cho_da_dat');

        if ($tong <= 14) return 14;
        if ($tong <= 27) return 27;

        return 43;
    }

    public function huyYeuCau($yeuCauId)
    {
        return DB::transaction(function () use ($yeuCauId) {

            $yeuCau = YeuCauGopDoan::with('chiTiets')->findOrFail($yeuCauId);

            // 1. lấy toàn bộ lịch id 1 lần
            $lichIds = $yeuCau->chiTiets->pluck('lich_khoi_hanh_id')->toArray();

            // 2. reset trạng thái tất cả lịch cùng lúc (QUAN TRỌNG)
            if (!empty($lichIds)) {
                LichKhoiHanhTour::whereIn('id', $lichIds)
                    ->update([
                        'dang_gop_doan' => 0
                    ]);
            }

            // 3. xóa chi tiết trước
            $yeuCau->chiTiets()->delete();

            // 4. xóa yêu cầu
            $yeuCau->delete();

            return true;
        });
    }
}
