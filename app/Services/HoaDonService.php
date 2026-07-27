<?php

namespace App\Services;

use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\ThanhToan;

class HoaDonService
{
    public function taoHoaDon(ThanhToan $payment)
    {
        $pdf = Pdf::loadView('Admin.pdf.hoa_don', [
            'payment' => $payment
        ]);

        $fileName = 'hoa_don_' . $payment->id . '.pdf';

        $path = storage_path('app/public/hoa_don/' . $fileName);

        if (!file_exists(storage_path('app/public/hoa_don'))) {
            mkdir(storage_path('app/public/hoa_don'), 0777, true);
        }

        $pdf->save($path);

        $payment->update([
            'hoa_don_pdf' => 'hoa_don/' . $fileName
        ]);

        return $path;
    }
}
