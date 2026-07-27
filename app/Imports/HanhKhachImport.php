<?php
namespace App\Imports;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class HanhKhachImport implements ToCollection
{
    public array $rows = [];

    public function collection(Collection $collection)
    {
        foreach ($collection as $index => $row) {
            // Bỏ dòng tiêu đề
            if ($index == 0) {
                continue;
            }
            $this->rows[] = [
                'ho_ten' => $row[0] ?? '',
                'gioi_tinh' => $row[1] ?? '',
                'ngay_sinh' => $row[2] ?? '',
                'quoc_tich' => $row[3] ?? 'Việt Nam',
                'loai_giay_to' => $row[4] ?? 'CCCD',
                'so_giay_to' => $row[5] ?? '',
                'so_dien_thoai' => $row[6] ?? '',
                'yeu_cau_dac_biet' => $row[7] ?? '',
            ];
        }
    }
}
