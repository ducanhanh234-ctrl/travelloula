<?php

namespace App\Imports;

use App\Models\ChiTietLichTrinh;
use App\Models\LichTrinhTour;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class ChiTietLichTrinhImport implements ToCollection
{
    protected $tourId;

    public function __construct($tourId)
    {
        $this->tourId = $tourId;
    }

    public function collection(Collection $rows)
    {
        foreach ($rows->skip(1) as $row) {

            if (empty($row[0])) {
                continue;
            }

            $ngayThu = $row[0];

            $lichTrinh = LichTrinhTour::where('tour_id', $this->tourId)
                ->where('ngay_thu', $ngayThu)
                ->first();

            if (!$lichTrinh) {
                continue;
            }

            ChiTietLichTrinh::create([
                'lich_trinh_tour_id' => $lichTrinh->id,
                'gio_bat_dau'        => $row[1],
                'gio_ket_thuc'       => $row[2],
                'tieu_de'            => $row[3],
                'noi_dung'           => $row[4],
                'thu_tu'             => $row[5],
            ]);
        }
    }
}