<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Http\UploadedFile;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Tests\TestCase;

class ClientImportHanhKhachTest extends TestCase
{
    public function test_client_can_import_passenger_excel(): void
    {
        $user = new User([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
        ]);

        $tempFile = tempnam(sys_get_temp_dir(), 'import-passenger');
        $tempXlsx = $tempFile . '.xlsx';
        rename($tempFile, $tempXlsx);

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->fromArray([
            ['Họ tên', 'Giới tính', 'Ngày sinh', 'Quốc tịch', 'Loại giấy tờ', 'Số giấy tờ', 'SĐT', 'Yêu cầu đặc biệt'],
            ['Nguyễn Văn A', 'Nam', '1990-01-01', 'Việt Nam', 'CCCD', '123456789', '0900000000', 'Ăn chay'],
        ]);

        $writer = new Xlsx($spreadsheet);
        $writer->save($tempXlsx);

        $uploadedFile = new UploadedFile(
            $tempXlsx,
            'passengers.xlsx',
            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            null,
            true
        );

        $response = $this->actingAs($user)
            ->postJson(route('Client.import_hanh_khach'), [
                'file' => $uploadedFile,
            ]);

        $response->assertOk();
        $response->assertJsonFragment([
            'ho_ten' => 'Nguyễn Văn A',
            'gioi_tinh' => 'Nam',
            'so_giay_to' => '123456789',
        ]);

        unlink($tempXlsx);
    }
}
