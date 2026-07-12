<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\GopDoanService;
use App\Models\YeuCauGopDoan;
use App\Models\ChiTietYeuCauGopDoan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\DanhSachTour;
use App\Services\YeuCauGopDoanService;
use App\Models\LichKhoiHanhTour;

class GopDoanController extends Controller
{
    protected $gopDoanService;
    protected $yeuCauGopDoanService;

    public function __construct(
        GopDoanService $gopDoanService,
        YeuCauGopDoanService $yeuCauGopDoanService
    ) {
        $this->gopDoanService = $gopDoanService;
        $this->yeuCauGopDoanService = $yeuCauGopDoanService;
    }

    public function index()
    {
        $deXuats = $this->gopDoanService->layDanhSachDeXuat();

        return view('Admin.gop_doan.index', compact('deXuats'));
    }

    public function thuCong()
    {
        $tours = DanhSachTour::with([
            'lichKhoiHanh' => function ($query) {

                $query
                    ->where('da_gop', 0)
                    ->where('dang_gop_doan', 0)
                    ->where('so_cho_da_dat', '>', 0)
                    ->orderBy('ngay_khoi_hanh');
            }
        ])
            ->get();

        /*
    |--------------------------------------------------------------------------
    | Chỉ giữ lịch đã đóng bán
    |--------------------------------------------------------------------------
    */

        $tours = $tours->map(function ($tour) {

            $tour->lichHopLe = $tour->lichKhoiHanh
                ->filter(function ($lich) {

                    return $lich->trang_thai_hien_thi == 'Đã đóng';
                })
                ->values();

            return $tour;
        })
            ->filter(function ($tour) {

                return $tour->lichHopLe->count() >= 2;
            })
            ->values();

        return view(
            'Admin.gop_doan.thu-cong',
            compact('tours')
        );
    }

    public function storeAI(Request $request)
    {
        $request->validate([
            'lich_ids' => 'required|array|min:2',
            'lich_ids.*' => 'exists:lich_khoi_hanh_tours,id',
            'ly_do_de_xuat' => 'required|string|max:500',
        ]);

        try {

            $lichs = LichKhoiHanhTour::whereIn(
                'id',
                $request->lich_ids
            )->get();

            if ($lichs->count() < 2) {
                throw new \Exception('Phải chọn tối thiểu 2 lịch để gộp.');
            }

            if (
                $lichs->pluck('tour_id')
                ->unique()
                ->count() > 1
            ) {
                throw new \Exception(
                    'Chỉ được gộp các lịch thuộc cùng một tour.'
                );
            }

            if (
                $lichs->contains(
                    fn($l) => $l->dang_gop_doan != 0
                )
            ) {
                throw new \Exception(
                    'Có lịch đã nằm trong yêu cầu gộp khác.'
                );
            }

            $this->yeuCauGopDoanService
                ->taoYeuCauTuDeXuat(
                    $lichs,
                    100,
                    explode(' | ', $request->ly_do_de_xuat)
                );

            return redirect()
                ->route('Admin.gop-doan.index')
                ->with(
                    'success',
                    'Tạo yêu cầu AI thành công.'
                );
        } catch (\Exception $e) {

            return back()
                ->with(
                    'error',
                    $e->getMessage()
                );
        }
    }

    public function storeThuCong(Request $request)
    {
        $request->validate([
            'lich_ids' => 'required|array|min:2',
            'lich_ids.*' => 'exists:lich_khoi_hanh_tours,id',

            'lich_chinh_id' => 'required|integer|exists:lich_khoi_hanh_tours,id',

            'ly_do_de_xuat' => 'required|string|max:500',
        ]);

        try {

            $lichs = LichKhoiHanhTour::whereIn(
                'id',
                $request->lich_ids
            )->get();

            /*
        |--------------------------------------------------------------------------
        | Lịch chính phải thuộc danh sách đã chọn
        |--------------------------------------------------------------------------
        */

            if (!in_array($request->lich_chinh_id, $request->lich_ids)) {

                throw new \Exception(
                    'Lịch chính phải nằm trong danh sách các lịch được chọn.'
                );
            }

            /*
        |--------------------------------------------------------------------------
        | Phải có ít nhất 2 lịch
        |--------------------------------------------------------------------------
        */
            if ($lichs->count() < 2) {
                throw new \Exception(
                    'Phải chọn tối thiểu 2 lịch để gộp.'
                );
            }

            /*
        |--------------------------------------------------------------------------
        | Chỉ được cùng Tour
        |--------------------------------------------------------------------------
        */
            if (
                $lichs->pluck('tour_id')
                ->unique()
                ->count() > 1
            ) {
                throw new \Exception(
                    'Chỉ được gộp các lịch thuộc cùng một tour.'
                );
            }

            /*
        |--------------------------------------------------------------------------
        | Không được nằm trong yêu cầu khác
        |--------------------------------------------------------------------------
        */
            if (
                $lichs->contains(
                    fn($l) => $l->dang_gop_doan != 0
                )
            ) {
                throw new \Exception(
                    'Có lịch đã nằm trong một yêu cầu gộp khác.'
                );
            }

            /*
        |--------------------------------------------------------------------------
        | Không gộp lịch đã khởi hành
        |--------------------------------------------------------------------------
        */
            if (
                $lichs->contains(function ($lich) {
                    return \Carbon\Carbon::parse($lich->ngay_khoi_hanh)->lt(today());
                })
            ) {
                throw new \Exception(
                    'Không thể gộp lịch đã khởi hành.'
                );
            }

            /*
        |--------------------------------------------------------------------------
        | Chỉ cho phép cách nhau tối đa 7 ngày
        |--------------------------------------------------------------------------
        */
            $min = $lichs->min('ngay_khoi_hanh');

            $max = $lichs->max('ngay_khoi_hanh');

            if (
                $min->diffInDays($max) > 7
            ) {
                throw new \Exception(
                    'Các lịch cách nhau quá 7 ngày.'
                );
            }

            /*
        |--------------------------------------------------------------------------
        | Tạo yêu cầu
        |--------------------------------------------------------------------------
        */
            $this->yeuCauGopDoanService
                ->taoYeuCauThuCong(
                    $request->lich_ids,
                    $request->ly_do_de_xuat,
                    $request->lich_chinh_id
                );

            return redirect()
                ->route('Admin.gop-doan.index')
                ->with(
                    'success',
                    'Tạo yêu cầu gộp đoàn thành công.'
                );
        } catch (\Exception $e) {

            return back()
                ->withInput()
                ->with(
                    'error',
                    $e->getMessage()
                );
        }
    }

    public function lichSu()
    {
        $data = $this->gopDoanService->layLichSu();

        return view(
            'Admin.gop_doan.lich-su',
            compact('data')
        );
    }
}
