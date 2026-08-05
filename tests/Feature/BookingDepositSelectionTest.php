<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Support\Collection;
use Tests\TestCase;

class BookingDepositSelectionTest extends TestCase
{
    public function test_booking_view_includes_hidden_deposit_input_for_form_submission(): void
    {
        $user = new User([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
        ]);

        $this->actingAs($user);

        $tour = new \stdClass();
        $tour->id = 1;
        $tour->ten_tour = 'Tour test';
        $tour->anh_dai_dien = '';
        $tour->dia_diem_khoi_hanh = 'Hà Nội';
        $tour->thoi_luong = '3 ngày 2 đêm';
        $tour->gia_nguoi_lon = 1000000;
        $tour->gia_tre_em = 500000;

        $html = view('Client.dat_tour.index', [
            'tour' => $tour,
            'lichKhoiHanhs' => new Collection(),
            'lichDuocChon' => [],
            'tours' => new Collection(),
        ])->render();

        $this->assertStringContainsString('name="phan_tram_thanh_toan"', $html);
        $this->assertStringContainsString('id="input_phan_tram_thanh_toan"', $html);
    }
}
