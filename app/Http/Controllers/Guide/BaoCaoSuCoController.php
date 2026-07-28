<?php

namespace App\Http\Controllers\Guide;

use App\Http\Controllers\Controller;
use App\Models\BaoCaoSuCo;
use App\Models\LichKhoiHanhTour;
use App\Models\User;
use App\Notifications\BaoCaoSuCoMoiNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;

class BaoCaoSuCoController extends Controller
{
    public function index(Request $request)
    {
        $guide = Auth::user()?->huongDanVien;

        abort_unless(
            (bool) $guide,
            403,
            'Tài khoản chưa liên kết hướng dẫn viên.'
        );

        $query = BaoCaoSuCo::query()
            ->with([
                'lichKhoiHanh',
                'adminXuLy',
            ])
            ->where('huong_dan_vien_id', $guide->id);

        if ($request->filled('keyword')) {
            $keyword = trim((string) $request->keyword);

            $query->where(function ($q) use ($keyword) {
                $q->where('tieu_de', 'like', "%{$keyword}%")
                    ->orWhere('noi_dung', 'like', "%{$keyword}%");
            });
        }

        if ($request->filled('trang_thai')) {
            $query->where(
                'trang_thai',
                $request->trang_thai
            );
        }

        if ($request->filled('muc_do')) {
            $query->where(
                'muc_do',
                $request->muc_do
            );
        }

        $baoCaos = $query
            ->latest()
            ->paginate(12)
            ->withQueryString();

        $base = BaoCaoSuCo::query()
            ->where('huong_dan_vien_id', $guide->id);

        $thongKe = [
            'tong' => (clone $base)->count(),

            'moi' => (clone $base)
                ->where('trang_thai', 'moi')
                ->count(),

            'dang_xu_ly' => (clone $base)
                ->whereIn('trang_thai', [
                    'da_tiep_nhan',
                    'dang_xu_ly',
                ])
                ->count(),

            'da_xu_ly' => (clone $base)
                ->where('trang_thai', 'da_xu_ly')
                ->count(),
        ];

        return view(
            'Guide.baocaosuco.index',
            compact('baoCaos', 'thongKe')
        );
    }

    public function create()
    {
        $guide = Auth::user()?->huongDanVien;

        abort_unless(
            (bool) $guide,
            403,
            'Tài khoản chưa liên kết hướng dẫn viên.'
        );

        $activeLichKhoiHanh = $this->getActiveLichKhoiHanhForGuide($guide);

        return view(
            'Guide.baocaosuco.create',
            compact('activeLichKhoiHanh')
        );
    }

    public function store(Request $request)
    {
        $guide = Auth::user()?->huongDanVien;

        abort_unless(
            (bool) $guide,
            403,
            'Tài khoản chưa liên kết hướng dẫn viên.'
        );

        $data = $request->validate([
            'tieu_de' => [
                'required',
                'string',
                'max:255',
            ],

            'loai_su_co' => [
                'required',
                'in:phuong_tien,lich_trinh,khach_hang,dich_vu,an_ninh,suc_khoe,khac',
            ],

            'muc_do' => [
                'required',
                'in:thap,trung_binh,cao,khan_cap',
            ],

            'noi_dung' => [
                'required',
                'string',
                'max:10000',
            ],
        ]);

        $lichKhoiHanh = $this->getActiveLichKhoiHanhForGuide($guide);

        if (!$lichKhoiHanh) {
            return back()
                ->withInput()
                ->withErrors([
                    'lich_khoi_hanh_id' =>
                    'Bạn chỉ được báo cáo sự cố cho tour đang được phân công và đang diễn ra.',
                ]);
        }

        $baoCao = DB::transaction(function () use (
            $data,
            $guide,
            $lichKhoiHanh
        ) {
            return BaoCaoSuCo::create([
                'lich_khoi_hanh_id' => $lichKhoiHanh->id,
                'huong_dan_vien_id' => $guide->id,
                'tieu_de' => $data['tieu_de'],
                'loai_su_co' => $data['loai_su_co'],
                'muc_do' => $data['muc_do'],
                'noi_dung' => $data['noi_dung'],
                'trang_thai' => 'moi',
            ]);
        });

        $admins = User::query()
            ->get()
            ->filter(fn(User $user) => $user->hasPermission('vao_admin'))
            ->values();

        if ($admins->isNotEmpty()) {
            Notification::send(
                $admins,
                new BaoCaoSuCoMoiNotification(
                    $baoCao->load([
                        'huongDanVien',
                        'lichKhoiHanh',
                    ])
                )
            );
        }

        return redirect()
            ->route('Guide.baocaosuco.index')
            ->with(
                'success',
                'Đã gửi báo cáo sự cố đến Admin.'
            );
    }

    private function getActiveLichKhoiHanhForGuide($guide): ?LichKhoiHanhTour
    {
        $homNay = now()->startOfDay();

        return LichKhoiHanhTour::query()
            ->with('tour')
            ->whereHas('phanCong', function ($query) use ($guide) {
                $query->where('hdv_id', $guide->id);
            })
            ->whereDate('ngay_khoi_hanh', '<=', $homNay)
            ->whereDate('ngay_ket_thuc', '>=', $homNay)
            ->orderBy('ngay_khoi_hanh')
            ->first();
    }

    public function show($id)
{
    $guide = auth()->user()?->huongDanVien;

    abort_unless(
        $guide,
        403,
        'Tài khoản chưa liên kết hướng dẫn viên.'
    );

    $baoCaoSuCo = BaoCaoSuCo::query()
        ->with([
            'lichKhoiHanh.tour',
            'adminXuLy',
        ])
        ->where('huong_dan_vien_id', $guide->id)
        ->findOrFail($id);

    auth()->user()
        ->unreadNotifications()
        ->get()
        ->filter(function ($notification) use ($baoCaoSuCo) {
            return isset($notification->data['bao_cao_id'])
                && (int) $notification->data['bao_cao_id']
                    === (int) $baoCaoSuCo->id;
        })
        ->each(function ($notification) {
            $notification->markAsRead();
        });

    return view(
        'Guide.baocaosuco.show',
        compact('baoCaoSuCo')
    );
}
}
