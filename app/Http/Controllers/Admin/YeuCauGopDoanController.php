<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\GopDoanService;
use App\Services\YeuCauGopDoanService;
use App\Models\YeuCauGopDoan;
use App\Models\ChiTietYeuCauGopDoan;
use App\Models\LichKhoiHanhTour;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class YeuCauGopDoanController extends Controller
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
        $data = YeuCauGopDoan::with([
            'chiTiets.lichKhoiHanh.tour',
            'chiTiets.datTour.nguoiDung',
            'phuongTien',
            'huongDanVien'
        ])
            ->where('trang_thai', 'cho_xu_ly')
            ->orderByDesc('created_at')
            ->paginate(10);

        $data->getCollection()->transform(function ($yeuCau) {

            $yeuCau->loaiText = $yeuCau->loai_de_xuat == 'tu_dong'
                ? 'AI'
                : 'Thủ công';

            $yeuCau->trangThaiText = $yeuCau->trang_thai == 'cho_xu_ly'
                ? 'Chờ xử lý'
                : 'Hoàn tất';

            $lichChinh = $yeuCau->chiTiets
                ->firstWhere('la_lich_chinh', 1);

            $yeuCau->lichChinh = $lichChinh;

            $yeuCau->danhSachLich = $yeuCau->chiTiets
                ->groupBy('lich_khoi_hanh_id');

            $yeuCau->tenTour = optional(
                optional($lichChinh)->lichKhoiHanh->tour
            )->ten_tour ?? '-';

            $yeuCau->soLich = $yeuCau->danhSachLich->count();

            $yeuCau->tongBooking = $yeuCau->chiTiets
                ->whereNotNull('datTour')
                ->count();

            $yeuCau->bookingDongY = $yeuCau->chiTiets
                ->where('trang_thai_lien_he', 'dong_y')
                ->count();

            $yeuCau->bookingTuChoi = $yeuCau->chiTiets
                ->where('trang_thai_lien_he', 'tu_choi')
                ->count();

            $yeuCau->bookingChuaLienHe = $yeuCau->chiTiets
                ->where('trang_thai_lien_he', 'chua_lien_he')
                ->count();

            $yeuCau->coTheHuy = $yeuCau->trang_thai == 'cho_xu_ly';

            $yeuCau->coTheChot =
                $yeuCau->trang_thai == 'cho_xu_ly'
                && $yeuCau->bookingChuaLienHe == 0;

            return $yeuCau;
        });

        return view(
            'Admin.yeu_cau_gop_doan.index',
            compact('data')
        );
    }

    public function show($id)
    {
        $yeuCau = YeuCauGopDoan::with([
            'chiTiets.datTour.nguoiDung',
            'chiTiets.lichKhoiHanh.tour',
        ])->findOrFail($id);

        // nhóm theo lịch
        $yeuCau->danhSachLich = $yeuCau->chiTiets
            ->groupBy('lich_khoi_hanh_id');

        // lịch chính
        $yeuCau->lichChinh = $yeuCau->chiTiets
            ->firstWhere('la_lich_chinh', 1);

        // tổng booking
        $yeuCau->tongBooking = $yeuCau->chiTiets
            ->whereNotNull('datTour')
            ->count();

        // còn booking chưa liên hệ?
        $yeuCau->bookingChuaLienHe = $yeuCau->chiTiets
            ->where('trang_thai_lien_he', 'chua_lien_he')
            ->count();

        $yeuCau->coTheChot =
            $yeuCau->trang_thai == 'cho_xu_ly'
            && $yeuCau->bookingChuaLienHe == 0;

        $yeuCau->coTheHuy =
            $yeuCau->trang_thai == 'cho_xu_ly';

        return view(
            'Admin.yeu_cau_gop_doan.show',
            compact('yeuCau')
        );
    }

    public function capNhatTrangThaiLienHe(Request $request, $id)
    {

        DB::transaction(function () use ($request, $id) {


            $chiTiet = ChiTietYeuCauGopDoan::findOrFail($id);


            $chiTiet->update([

                'trang_thai_lien_he'
                => $request->trang_thai

            ]);



            // nếu khách từ chối
            if ($request->trang_thai == 'tu_choi') {


                LichKhoiHanhTour::where(
                    'id',
                    $chiTiet->lich_khoi_hanh_id
                )
                    ->update([
                        'dang_gop_doan' => 0
                    ]);
            }
        });


        return back()
            ->with(
                'success',
                'Cập nhật trạng thái khách thành công'
            );
    }

    public function chotGop($id)
    {

        try {
            $this->gopDoanService->chotGop($id);
            return redirect()
                ->route('Admin.gop-doan.lich-su')
                ->with('success', 'Đã chốt gộp đoàn thành công.');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {

            $this->yeuCauGopDoanService->huyYeuCau($id);

            return redirect()
                ->route('Admin.gop-doan.lich-su')
                ->with('success', 'Hủy yêu cầu thành công');
        } catch (\Exception $e) {

            return back()->with('error', $e->getMessage());
        }
    }
}
