<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HuongDanVien;
use App\Models\PhanCong;
use App\Models\YeuCauHoTroHdv;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HoTroHdvController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:ho_tro_hdv.view')->only(['index', 'show']);
        $this->middleware('permission:ho_tro_hdv.process')->only(['approve', 'reject']);
    }

    public function index(Request $request)
    {
        $query = YeuCauHoTroHdv::with([
            'lichKhoiHanh.tour',
            'huongDanVien',
            'huongDanVienThayThe',
        ])->orderByDesc('id');

        if ($request->filled('trang_thai')) {
            $query->where('trang_thai', $request->trang_thai);
        }

        if ($request->filled('q')) {
            $keyword = trim($request->q);

            $query->where(function ($q) use ($keyword) {
                $q->where('ly_do', 'like', '%' . $keyword . '%')
                    ->orWhereHas('lichKhoiHanh.tour', function ($tourQuery) use ($keyword) {
                        $tourQuery->where('ten_tour', 'like', '%' . $keyword . '%');
                    })
                    ->orWhereHas('huongDanVien', function ($guideQuery) use ($keyword) {
                        $guideQuery->where('ho_ten', 'like', '%' . $keyword . '%');
                    });
            });
        }

        $yeuCaus = $query->paginate(15)->withQueryString();

        return view('Admin.ho_tro_hdv.index', compact('yeuCaus'));
    }

    public function show($id)
    {
        $yeuCau = YeuCauHoTroHdv::with([
            'lichKhoiHanh.tour',
            'huongDanVien',
            'huongDanVienThayThe',
        ])->findOrFail($id);

        $guides = HuongDanVien::where('id', '!=', $yeuCau->huong_dan_vien_id)
            ->orderBy('ho_ten')
            ->get();

        return view('Admin.ho_tro_hdv.show', compact('yeuCau', 'guides'));
    }

    public function approve(Request $request, $id)
    {
        $request->validate([
            'huong_dan_vien_thay_the_id' => [
                'required',
                'integer',
                'exists:huong_dan_viens,id',
            ],
            'phan_hoi_admin' => ['nullable', 'string', 'max:1000'],
        ], [
            'huong_dan_vien_thay_the_id.required' => 'Vui lòng chọn HDV thay thế.',
        ]);

        $yeuCau = YeuCauHoTroHdv::with([
            'lichKhoiHanh',
            'huongDanVien',
        ])->findOrFail($id);

        if ($yeuCau->trang_thai !== 'cho_xu_ly') {
            return back()->with('error', 'Yêu cầu này đã được xử lý.');
        }

        $lich = $yeuCau->lichKhoiHanh;

        if (
            !$lich
            || in_array($lich->trang_thai, ['running', 'completed'], true)
            || now()->startOfDay()->gte(
                \Carbon\Carbon::parse($lich->ngay_khoi_hanh)->startOfDay()
            )
        ) {
            return back()->with(
                'error',
                'Tour đã đến thời điểm khởi hành nên không thể thay HDV bằng yêu cầu trước khởi hành.'
            );
        }

        if (
            (int) $request->huong_dan_vien_thay_the_id
            ===
            (int) $yeuCau->huong_dan_vien_id
        ) {
            return back()->with('error', 'HDV thay thế phải khác HDV hiện tại.');
        }

        $newGuide = HuongDanVien::findOrFail(
            $request->huong_dan_vien_thay_the_id
        );

        DB::transaction(function () use ($request, $yeuCau, $lich, $newGuide) {
            $phanCong = PhanCong::where(
                'lich_khoi_hanh_id',
                $lich->id
            )->first();

            if ($phanCong) {
                $ids = $phanCong->hdv_ids;

                if (is_string($ids)) {
                    $decoded = json_decode($ids, true);
                    $ids = is_array($decoded) ? $decoded : [];
                }

                $ids = collect((array) $ids)
                    ->map(function ($guideId) use ($yeuCau, $newGuide) {
                        return (int) $guideId === (int) $yeuCau->huong_dan_vien_id
                            ? (string) $newGuide->id
                            : (string) $guideId;
                    });

                if (!$ids->contains((string) $newGuide->id)) {
                    $ids->push((string) $newGuide->id);
                }

                $phanCong->hdv_ids = $ids
                    ->unique()
                    ->values()
                    ->toArray();

                $phanCong->save();
            }

            if (
                $lich->huong_dan_vien_id
                && (int) $lich->huong_dan_vien_id
                    === (int) $yeuCau->huong_dan_vien_id
            ) {
                $lich->huong_dan_vien_id = $newGuide->id;
                $lich->save();
            }

            $yeuCau->trang_thai = 'da_xu_ly';
            $yeuCau->huong_dan_vien_thay_the_id = $newGuide->id;
            $yeuCau->admin_xu_ly_id = Auth::id();
            $yeuCau->phan_hoi_admin = trim((string) $request->phan_hoi_admin);
            $yeuCau->thoi_gian_xu_ly = now();
            $yeuCau->save();
        });

        return redirect()
            ->route('Admin.ho-tro-hdv.show', $yeuCau->id)
            ->with('success', 'Đã thay hướng dẫn viên thành công.');
    }

    public function reject(Request $request, $id)
    {
        $request->validate([
            'phan_hoi_admin' => ['required', 'string', 'max:1000'],
        ], [
            'phan_hoi_admin.required' => 'Vui lòng nhập lý do từ chối.',
        ]);

        $yeuCau = YeuCauHoTroHdv::findOrFail($id);

        if ($yeuCau->trang_thai !== 'cho_xu_ly') {
            return back()->with('error', 'Yêu cầu này đã được xử lý.');
        }

        $yeuCau->update([
            'trang_thai' => 'tu_choi',
            'admin_xu_ly_id' => Auth::id(),
            'phan_hoi_admin' => trim($request->phan_hoi_admin),
            'thoi_gian_xu_ly' => now(),
        ]);

        return redirect()
            ->route('Admin.ho-tro-hdv.show', $yeuCau->id)
            ->with('success', 'Đã từ chối yêu cầu.');
    }
}
