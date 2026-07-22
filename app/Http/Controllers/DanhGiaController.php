<?php

namespace App\Http\Controllers;

use App\Models\DanhGia;
use App\Models\DanhSachTour;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class DanhGiaController extends Controller
{
    /**
     * Admin xem toàn bộ đánh giá.
     * Không còn quy trình chờ duyệt, duyệt hoặc ẩn.
     */
    public function index(Request $request): View
    {
        $query = DanhGia::query()
            ->with([
                'user',
                'khachHangDatTour',
                'tour',
            ]);

        if ($request->filled('search')) {
            $search = trim((string) $request->input('search'));

            $query->where(function ($q) use ($search) {
                $q->whereHas('user', function ($userQuery) use ($search) {
                    $userQuery
                        ->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                })
                    ->orWhereHas('khachHangDatTour', function ($customerQuery) use ($search) {
                        $customerQuery
                            ->where('ho_ten', 'like', "%{$search}%")
                            ->orWhere('email', 'like', "%{$search}%");
                    })
                    ->orWhereHas('tour', function ($tourQuery) use ($search) {
                        $tourQuery->where('ten_tour', 'like', "%{$search}%");
                    })
                    ->orWhere('tieu_de', 'like', "%{$search}%")
                    ->orWhere('noi_dung_danh_gia', 'like', "%{$search}%");
            });
        }

        if ($request->filled('so_sao')) {
            $query->where('so_sao', (int) $request->input('so_sao'));
        }

        $tongDanhGia = DanhGia::query()->count();

        $danhGia5Sao = DanhGia::query()
            ->where('so_sao', 5)
            ->count();

        $diemTrungBinh = round(
            (float) (DanhGia::query()->avg('so_sao') ?? 0),
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
            'danhGia5Sao',
            'diemTrungBinh'
        ));
    }

    /**
     * Người dùng chỉ cần đăng nhập là có thể đánh giá tour.
     *
     * Không giới hạn số lần đánh giá.
     * Mỗi lần gửi sẽ tạo một bản ghi đánh giá mới.
     */
    public function store(
        Request $request,
        DanhSachTour $tour
    ): RedirectResponse {
        if (!Auth::check()) {
            return redirect()
                ->route('login')
                ->with('error', 'Vui lòng đăng nhập để gửi đánh giá.');
        }

        $validated = $request->validate([
            'so_sao' => ['required', 'integer', 'between:1,5'],
            'tieu_de' => ['nullable', 'string', 'max:255'],
            'noi_dung_danh_gia' => [
                'required',
                'string',
                'min:5',
                'max:2000',
            ],
        ], [
            'so_sao.required' => 'Bạn chưa chọn số sao.',
            'so_sao.integer' => 'Số sao không hợp lệ.',
            'so_sao.between' => 'Số sao phải từ 1 đến 5.',
            'tieu_de.max' => 'Tiêu đề không được vượt quá 255 ký tự.',
            'noi_dung_danh_gia.required' => 'Bạn chưa nhập nội dung đánh giá.',
            'noi_dung_danh_gia.min' => 'Nội dung phải có ít nhất 5 ký tự.',
            'noi_dung_danh_gia.max' => 'Nội dung không được vượt quá 2000 ký tự.',
        ]);

        try {
            DanhGia::query()->create([
                'nguoi_dung_id' => Auth::id(),
                'khach_hang_dat_tour_id' => null,
                'tour_id' => $tour->id,
                'so_sao' => (int) $validated['so_sao'],
                'tieu_de' => $validated['tieu_de'] ?? null,
                'noi_dung_danh_gia' => trim(
                    $validated['noi_dung_danh_gia']
                ),
                'hien_thi' => 1,
                'thoi_gian_danh_gia' => now(),
            ]);
        } catch (\Throwable $exception) {
            report($exception);

            return $this->quayLaiDanhGia(
                $tour,
                'error',
                'Không lưu được đánh giá. Hãy kiểm tra migration và cấu trúc bảng danh_gia.'
            );
        }

        return $this->quayLaiDanhGia(
            $tour,
            'success',
            'Đánh giá mới đã được đăng và hiển thị ngay.'
        );
    }

    /**
     * Admin xem chi tiết đánh giá.
     */
    public function show(int $id): View
    {
        $danh_gia = DanhGia::query()
            ->with([
                'user',
                'khachHangDatTour',
                'tour',
            ])
            ->findOrFail($id);

        return view('Admin.danh_gia.show', compact('danh_gia'));
    }

    /**
     * Admin chỉ xóa đánh giá không phù hợp.
     */
    public function destroy(int $id): RedirectResponse
    {
        $danh_gia = DanhGia::query()->findOrFail($id);
        $danh_gia->delete();

        return redirect()
            ->route('Admin.danh_gias.index')
            ->with('success', 'Đánh giá đã được xóa thành công.');
    }

    private function quayLaiDanhGia(
        DanhSachTour $tour,
        string $loai,
        string $noiDung
    ): RedirectResponse {
        $url = route('Client.danh_sach_tour.show', $tour->id)
            . '#danh-gia';

        /*
         * Chỉ giữ lại dữ liệu form khi có lỗi.
         * Khi gửi thành công, không gọi withInput() để form tải lại trống.
         */
        if ($loai === 'error') {
            return redirect()
                ->to($url)
                ->withInput()
                ->with($loai, $noiDung);
        }

        return redirect()
            ->to($url)
            ->with($loai, $noiDung);
    }
}