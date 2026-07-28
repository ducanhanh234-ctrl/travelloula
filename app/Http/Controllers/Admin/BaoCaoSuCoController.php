<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BaoCaoSuCo;
use App\Notifications\BaoCaoSuCoCapNhatNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BaoCaoSuCoController extends Controller
{
    public function index(Request $request)
    {
        $query = BaoCaoSuCo::with([
            'huongDanVien',
            'lichKhoiHanh',
            'adminXuLy',
        ]);

        if ($request->filled('keyword')) {
            $keyword = trim((string) $request->keyword);

            $query->where(function ($q) use ($keyword) {
                $q->where('tieu_de', 'like', "%{$keyword}%")
                    ->orWhere('noi_dung', 'like', "%{$keyword}%")
                    ->orWhereHas('huongDanVien', function ($guideQuery) use ($keyword) {
                        $guideQuery->where('ho_ten', 'like', "%{$keyword}%");
                    });
            });
        }

        if ($request->filled('trang_thai')) {
            $query->where('trang_thai', $request->trang_thai);
        }

        if ($request->filled('muc_do')) {
            $query->where('muc_do', $request->muc_do);
        }

        $baoCaos = $query
            ->orderByRaw("
                CASE muc_do
                    WHEN 'khan_cap' THEN 1
                    WHEN 'cao' THEN 2
                    WHEN 'trung_binh' THEN 3
                    ELSE 4
                END
            ")
            ->latest()
            ->paginate(15)
            ->withQueryString();

        $thongKe = [
            'tong' => BaoCaoSuCo::count(),

            'moi' => BaoCaoSuCo::where(
                'trang_thai',
                'moi'
            )->count(),

            'dang_xu_ly' => BaoCaoSuCo::whereIn(
                'trang_thai',
                [
                    'da_tiep_nhan',
                    'dang_xu_ly',
                ]
            )->count(),

            'da_xu_ly' => BaoCaoSuCo::where(
                'trang_thai',
                'da_xu_ly'
            )->count(),

            'khan_cap' => BaoCaoSuCo::where(
                'muc_do',
                'khan_cap'
            )
                ->whereNotIn(
                    'trang_thai',
                    [
                        'da_xu_ly',
                        'tu_choi',
                    ]
                )
                ->count(),
        ];

        return view(
            'Admin.bao_cao_su_co.index',
            compact('baoCaos', 'thongKe')
        );
    }

    public function show($id)
    {
        $baoCaoSuCo = BaoCaoSuCo::with([
            'huongDanVien',
            'lichKhoiHanh',
            'adminXuLy',
        ])->findOrFail($id);

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
            'Admin.bao_cao_su_co.show',
            compact('baoCaoSuCo')
        );
    }

    public function tiepNhan($id)
    {
        $baoCaoSuCo = BaoCaoSuCo::findOrFail($id);

        if ($baoCaoSuCo->trang_thai !== 'moi') {
            return back()->with(
                'error',
                'Sự cố đã được tiếp nhận hoặc xử lý.'
            );
        }

        $baoCaoSuCo->update([
            'admin_xu_ly_id' => auth()->id(),
            'trang_thai' => 'da_tiep_nhan',
            'thoi_gian_tiep_nhan' => now(),
        ]);

        $this->notifyGuide($baoCaoSuCo);

        return redirect()
            ->route(
                'Admin.baocaosuco.show',
                ['id' => $baoCaoSuCo->id]
            )
            ->with(
                'success',
                'Đã tiếp nhận sự cố.'
            );
    }

    public function update(Request $request, $id)
    {
        $baoCaoSuCo = BaoCaoSuCo::findOrFail($id);

        $data = $request->validate([
            'trang_thai' => [
                'required',
                'in:da_tiep_nhan,dang_xu_ly,da_xu_ly,tu_choi',
            ],

            'ghi_chu_xu_ly' => [
                'nullable',
                'string',
                'max:10000',
            ],
        ]);

        DB::transaction(function () use ($data, $baoCaoSuCo) {
            $baoCaoSuCo->update([
                'admin_xu_ly_id' => auth()->id(),

                'trang_thai' => $data['trang_thai'],

                'ghi_chu_xu_ly' =>
                $data['ghi_chu_xu_ly'] ?? null,

                'thoi_gian_tiep_nhan' =>
                $baoCaoSuCo->thoi_gian_tiep_nhan ?? now(),

                'thoi_gian_xu_ly' =>
                $data['trang_thai'] === 'da_xu_ly'
                    ? now()
                    : null,
            ]);
        });

        $baoCaoSuCo->refresh();

        $this->notifyGuide($baoCaoSuCo);

        return redirect()
            ->route(
                'Admin.baocaosuco.show',
                ['id' => $baoCaoSuCo->id]
            )
            ->with(
                'success',
                'Đã cập nhật xử lý sự cố.'
            );
    }

    private function notifyGuide(BaoCaoSuCo $baoCaoSuCo): void
    {
        $baoCaoSuCo->loadMissing('huongDanVien.user');

        $user = $baoCaoSuCo->huongDanVien?->user;

        if ($user) {
            $user->notify(
                new BaoCaoSuCoCapNhatNotification(
                    $baoCaoSuCo->fresh()
                )
            );
        }
    }
}
