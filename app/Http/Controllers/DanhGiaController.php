<?php

namespace App\Http\Controllers;

use App\Models\DanhGia;
use App\Models\DanhSachTour;
use App\Models\DatTour;
use App\Models\KhachHangDatTour;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DanhGiaController extends Controller
{
    /**
     * Danh sách đánh giá phía quản trị.
     */
    public function index(Request $request)
    {
        $query = DanhGia::query()
            ->with([
                'khachHangDatTour',
                'tour',
            ]);

        if ($request->filled('search')) {
            $search = trim((string) $request->search);

            $query->where(function ($q) use ($search) {
                $q->whereHas('khachHangDatTour', function ($subQuery) use ($search) {
                    $subQuery->where('ho_ten', 'like', "%{$search}%");
                })
                    ->orWhereHas('tour', function ($subQuery) use ($search) {
                        $subQuery->where('ten_tour', 'like', "%{$search}%");
                    })
                    ->orWhere('tieu_de', 'like', "%{$search}%")
                    ->orWhere('noi_dung_danh_gia', 'like', "%{$search}%");
            });
        }

        if ($request->filled('so_sao')) {
            $query->where('so_sao', (int) $request->so_sao);
        }

        if ($request->filled('trang_thai')) {
            if ($request->trang_thai === 'cho_duyet') {
                $query->where('hien_thi', 0);
            } elseif ($request->trang_thai === 'da_duyet') {
                $query->where('hien_thi', 1);
            }
        }

        $tongDanhGia = DanhGia::count();
        $tongChoDuyet = DanhGia::where('hien_thi', 0)->count();
        $tongDaDuyet = DanhGia::where('hien_thi', 1)->count();

        $danhGia5Sao = DanhGia::query()
            ->where('hien_thi', 1)
            ->where('so_sao', 5)
            ->count();

        $diemTrungBinh = round(
            (float) (
                DanhGia::query()
                    ->where('hien_thi', 1)
                    ->avg('so_sao') ?? 0
            ),
            1
        );

        $danh_gias = $query
            ->orderByDesc('thoi_gian_danh_gia')
            ->orderByDesc('id')
            ->paginate(10)
            ->withQueryString();

        return view('Admin.danh_gia.index', compact(
            'danh_gias',
            'tongDanhGia',
            'tongChoDuyet',
            'tongDaDuyet',
            'danhGia5Sao',
            'diemTrungBinh'
        ));
    }

    /**
     * Khách hàng gửi đánh giá.
     *
     * Bảng danh_gia hiện tại KHÔNG có cột user_id.
     * Vì vậy đánh giá được liên kết qua khach_hang_dat_tour_id.
     */
    public function store(Request $request, DanhSachTour $tour)
    {
        if (!Auth::check()) {
            return redirect()
                ->route('login')
                ->with('error', 'Vui lòng đăng nhập để gửi đánh giá.');
        }

        $validated = $request->validate([
            'so_sao' => ['required', 'integer', 'between:1,5'],
            'tieu_de' => ['nullable', 'string', 'max:255'],
            'noi_dung_danh_gia' => ['required', 'string', 'min:5', 'max:2000'],
        ], [
            'so_sao.required' => 'Bạn chưa chọn số sao.',
            'so_sao.integer' => 'Số sao không hợp lệ.',
            'so_sao.between' => 'Số sao phải từ 1 đến 5.',
            'tieu_de.max' => 'Tiêu đề không được vượt quá 255 ký tự.',
            'noi_dung_danh_gia.required' => 'Bạn chưa nhập nội dung đánh giá.',
            'noi_dung_danh_gia.min' => 'Nội dung phải có ít nhất 5 ký tự.',
            'noi_dung_danh_gia.max' => 'Nội dung không được vượt quá 2000 ký tự.',
        ]);

        /*
        |--------------------------------------------------------------------------
        | Tìm tất cả đơn của tài khoản đang đăng nhập cho tour hiện tại
        |--------------------------------------------------------------------------
        */
        $datTourIds = DatTour::query()
            ->where('nguoi_dung_id', Auth::id())
            ->where('tour_id', $tour->id)
            ->where('trang_thai', '<>', 'da_huy')
            ->pluck('id');

        if ($datTourIds->isEmpty()) {
            return $this->quayLaiDanhGia(
                $tour,
                'error',
                'Tài khoản của bạn chưa có đơn đặt tour này.'
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Tìm hành khách thuộc các đơn đặt tour vừa tìm được
        |--------------------------------------------------------------------------
        */
        $khachHangIds = KhachHangDatTour::query()
            ->whereIn('dat_tour_id', $datTourIds)
            ->pluck('id');

        if ($khachHangIds->isEmpty()) {
            return $this->quayLaiDanhGia(
                $tour,
                'error',
                'Đơn đặt tour chưa có thông tin hành khách nên chưa thể đánh giá.'
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Kiểm tra tài khoản đã đánh giá tour này chưa
        |--------------------------------------------------------------------------
        */
        $daDanhGia = DanhGia::query()
            ->where('tour_id', $tour->id)
            ->whereIn('khach_hang_dat_tour_id', $khachHangIds)
            ->exists();

        if ($daDanhGia) {
            return $this->quayLaiDanhGia(
                $tour,
                'error',
                'Bạn đã gửi đánh giá cho tour này rồi.'
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Dùng hành khách đầu tiên của đơn để liên kết đánh giá
        |--------------------------------------------------------------------------
        */
        $khachHangId = $khachHangIds->first();

        try {
            DanhGia::create([
                'khach_hang_dat_tour_id' => $khachHangId,
                'tour_id' => $tour->id,
                'so_sao' => (int) $validated['so_sao'],
                'tieu_de' => $validated['tieu_de'] ?? null,
                'noi_dung_danh_gia' => $validated['noi_dung_danh_gia'],
                'hien_thi' => 0,
                'thoi_gian_danh_gia' => now(),
            ]);
        } catch (\Throwable $exception) {
            report($exception);

            return $this->quayLaiDanhGia(
                $tour,
                'error',
                'Không lưu được đánh giá: ' . $exception->getMessage()
            );
        }

        return redirect()
            ->to(route('Client.danh_sach_tour.show', $tour->id) . '#danh-gia')
            ->with(
                'success',
                'Đánh giá đã được gửi và đang chờ quản trị viên duyệt.'
            );
    }

    public function show($id)
    {
        $danh_gia = DanhGia::query()
            ->with([
                'khachHangDatTour',
                'tour',
            ])
            ->findOrFail($id);

        return view('Admin.danh_gia.show', compact('danh_gia'));
    }

    public function approve($id)
    {
        $danh_gia = DanhGia::findOrFail($id);

        $danh_gia->update([
            'hien_thi' => 1,
        ]);

        return back()->with('success', 'Đã duyệt đánh giá.');
    }

    public function hide($id)
    {
        $danh_gia = DanhGia::findOrFail($id);

        $danh_gia->update([
            'hien_thi' => 0,
        ]);

        return back()->with(
            'success',
            'Đã ẩn đánh giá khỏi trang khách hàng.'
        );
    }

    public function destroy($id)
    {
        $danh_gia = DanhGia::findOrFail($id);
        $danh_gia->delete();

        return redirect()
            ->route('Admin.danh_gias.index')
            ->with('success', 'Đánh giá đã được xóa thành công.');
    }

    private function quayLaiDanhGia(
        DanhSachTour $tour,
        string $loai,
        string $noiDung
    ) {
        return redirect()
            ->to(route('Client.danh_sach_tour.show', $tour->id) . '#danh-gia')
            ->withInput()
            ->with($loai, $noiDung);
    }
}