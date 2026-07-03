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
        $this->middleware('permission:gop_doan.view')->only(['index', 'show']);
        $this->middleware('permission:gop_doan.create')->only(['store']);
        $this->middleware('permission:gop_doan.edit')->only(['capNhatTrangThaiLienHe', 'chotGop']);
        $this->middleware('permission:gop_doan.delete')->only(['destroy']);

        $this->gopDoanService = $gopDoanService;
        $this->yeuCauGopDoanService = $yeuCauGopDoanService;
    }

    public function index()
    {
        $deXuats = $this->gopDoanService->layDanhSachDeXuat();

        return view('Admin.gop_doan.index', compact('deXuats'));
    }

    public function store(Request $request)
    {
        try {

            $this->yeuCauGopDoanService->taoYeuCauThuCong(
                $request->lich_ids,
                $request->ly_do_de_xuat
            );

            return redirect()
                ->route('Admin.gop-doan.index')
                ->with('success', 'Tạo yêu cầu gộp đoàn thành công');
        } catch (\Exception $e) {

            return back()->with('error', $e->getMessage());
        }
    }

    public function show($id)
    {

        $yeuCau = YeuCauGopDoan::with([
            'chiTiets.datTour',
            'chiTiets.lichKhoiHanh',
        ])->findOrFail($id);



        return view(
            'Admin.gop_doan.show',
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
            return redirect()->route('Admin.gop-doan.index')->with('success', 'Đã chốt gộp đoàn thành công.');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {

            $this->yeuCauGopDoanService->huyYeuCau($id);

            return redirect()
                ->route('Admin.gop-doan.index')
                ->with('success', 'Hủy yêu cầu thành công');
        } catch (\Exception $e) {

            return back()->with('error', $e->getMessage());
        }
    }
}
