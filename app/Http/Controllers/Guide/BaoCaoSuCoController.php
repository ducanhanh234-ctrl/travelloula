<?php

namespace App\Http\Controllers\Guide;

use App\Http\Controllers\Controller;
use App\Models\BaoCaoSuCo;
use App\Models\HuongDanVien;
use App\Models\LichKhoiHanhTour;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BaoCaoSuCoController extends Controller
{
    public function index()
    {
        $guide = HuongDanVien::where(
            'user_id',
            Auth::id()
        )->firstOrFail();

        $baoCaos = BaoCaoSuCo::with('lichKhoiHanh.tour')
            ->where('huong_dan_vien_id', $guide->id)
            ->latest()
            ->get();

        // Thống kê
        $tongBaoCao = $baoCaos->count();

        $choXuLy = $baoCaos
            ->where('trang_thai', 'cho_xu_ly')
            ->count();

        $dangXuLy = $baoCaos
            ->where('trang_thai', 'dang_xu_ly')
            ->count();

        $daXuLy = $baoCaos
            ->where('trang_thai', 'da_xu_ly')
            ->count();

        return view(
            'Guide.baocaosuco.index',
            compact(
                'baoCaos',
                'tongBaoCao',
                'choXuLy',
                'dangXuLy',
                'daXuLy'
            )
        );
    }

    public function create()
    {
        $guide = HuongDanVien::where(
            'user_id',
            Auth::id()
        )->firstOrFail();

        $lichKhoiHanhs = LichKhoiHanhTour::with('tour')
            ->where('huong_dan_vien_id', $guide->id)
            ->get();

        return view(
            'Guide.baocaosuco.create',
            compact('lichKhoiHanhs')
        );
    }

    public function store(Request $request)
    {
        $request->validate([
            'lich_khoi_hanh_id' => 'required|exists:lich_khoi_hanh_tours,id',
            'tieu_de' => 'required|max:255',
            'loai_su_co' => 'required',
            'muc_do' => 'required',
            'noi_dung' => 'required',
        ]);

        $guide = HuongDanVien::where(
            'user_id',
            Auth::id()
        )->firstOrFail();

        BaoCaoSuCo::create([

            'lich_khoi_hanh_id' => $request->lich_khoi_hanh_id,

            'huong_dan_vien_id' => $guide->id,

            'tieu_de' => $request->tieu_de,

            'loai_su_co' => $request->loai_su_co,

            'muc_do' => $request->muc_do,

            'noi_dung' => $request->noi_dung,

            'trang_thai' => 'cho_xu_ly',

        ]);

        return redirect()
            ->route('Guide.baocaosuco.index')
            ->with(
                'success',
                'Báo cáo sự cố đã được gửi.'
            );
    }

    public function show($id)
    {
        $baoCao = BaoCaoSuCo::with([
            'lichKhoiHanh.tour',
            'huongDanVien'
        ])->findOrFail($id);

        return view(
            'Guide.baocaosuco.show',
            compact('baoCao')
        );
    }

    public function edit($id)
    {
        $guide = HuongDanVien::where(
            'user_id',
            Auth::id()
        )->firstOrFail();

        $baoCao = BaoCaoSuCo::findOrFail($id);

        // Chỉ được sửa báo cáo của chính mình
        if ($baoCao->huong_dan_vien_id != $guide->id) {
            abort(403);
        }

        // Chỉ sửa khi đang chờ xử lý
        if ($baoCao->trang_thai != 'cho_xu_ly') {
            return redirect()
                ->route('Guide.baocaosuco.index')
                ->with(
                    'error',
                    'Báo cáo này không thể chỉnh sửa.'
                );
        }

        $lichKhoiHanhs = LichKhoiHanhTour::with('tour')
            ->where('huong_dan_vien_id', $guide->id)
            ->get();

        return view(
            'Guide.baocaosuco.edit',
            compact('baoCao', 'lichKhoiHanhs')
        );
    }

    public function update(Request $request, $id)
    {
        $guide = HuongDanVien::where(
            'user_id',
            Auth::id()
        )->firstOrFail();

        $baoCao = BaoCaoSuCo::findOrFail($id);

        if ($baoCao->huong_dan_vien_id != $guide->id) {
            abort(403);
        }

        if ($baoCao->trang_thai != 'cho_xu_ly') {
            return redirect()
                ->route('Guide.baocaosuco.index')
                ->with(
                    'error',
                    'Báo cáo đã được xử lý nên không thể chỉnh sửa.'
                );
        }

        $request->validate([
            'tieu_de' => 'required|max:255',
            'loai_su_co' => 'required',
            'muc_do' => 'required',
            'noi_dung' => 'required',
        ]);

        $baoCao->update([
            'lich_khoi_hanh_id' => $request->lich_khoi_hanh_id,
            'tieu_de' => $request->tieu_de,
            'loai_su_co' => $request->loai_su_co,
            'muc_do' => $request->muc_do,
            'noi_dung' => $request->noi_dung,
        ]);

        return redirect()
            ->route('Guide.baocaosuco.index')
            ->with(
                'success',
                'Cập nhật báo cáo thành công.'
            );
    }

    public function destroy($id)
    {
        $guide = HuongDanVien::where(
            'user_id',
            Auth::id()
        )->firstOrFail();

        $baoCao = BaoCaoSuCo::findOrFail($id);

        if ($baoCao->huong_dan_vien_id != $guide->id) {
            abort(403);
        }

        if ($baoCao->trang_thai != 'cho_xu_ly') {
            return redirect()
                ->route('Guide.baocaosuco.index')
                ->with(
                    'error',
                    'Báo cáo đã được xử lý nên không thể xóa.'
                );
        }

        $baoCao->delete();

        return redirect()
            ->route('Guide.baocaosuco.index')
            ->with(
                'success',
                'Đã xóa báo cáo.'
            );
    }

    // thùng rác
    public function trash()
    {
        $guide = HuongDanVien::where(
            'user_id',
            Auth::id()
        )->firstOrFail();

        $baoCaos = BaoCaoSuCo::onlyTrashed()
            ->with('lichKhoiHanh.tour')
            ->where('huong_dan_vien_id', $guide->id)
            ->latest()
            ->get();

        return view(
            'Guide.baocaosuco.trash',
            compact('baoCaos')
        );
    }

    //khôi phục báo cáo đã xóa
    public function restore($id)
    {
        $guide = HuongDanVien::where(
            'user_id',
            Auth::id()
        )->firstOrFail();

        $baoCao = BaoCaoSuCo::onlyTrashed()
            ->findOrFail($id);

        if ($baoCao->huong_dan_vien_id != $guide->id) {
            abort(403);
        }

        $baoCao->restore();

        return redirect()
            ->route('Guide.baocaosuco.trash')
            ->with(
                'success',
                'Khôi phục báo cáo thành công.'
            );
    }

    // Xóa vĩnh viễn 
    public function forceDelete($id)
    {
        $guide = HuongDanVien::where(
            'user_id',
            Auth::id()
        )->firstOrFail();

        $baoCao = BaoCaoSuCo::onlyTrashed()
            ->findOrFail($id);

        if ($baoCao->huong_dan_vien_id != $guide->id) {
            abort(403);
        }

        $baoCao->forceDelete();

        return redirect()
            ->route('Guide.baocaosuco.trash')
            ->with(
                'success',
                'Đã xóa vĩnh viễn.'
            );
    }
}
