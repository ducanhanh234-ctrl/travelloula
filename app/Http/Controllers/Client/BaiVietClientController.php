<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\BaiViet;
use Illuminate\Contracts\View\View;

class BaiVietClientController extends Controller
{
    /**
     * Hiển thị danh sách bài viết đang được công khai.
     */
    public function index(): View
    {
        $baiViets = BaiViet::query()
            ->where('trang_thai', 1)
            ->orderByDesc('created_at')
            ->paginate(9);

        return view('Client.bai_viet.index', compact('baiViets'));
    }

    /**
     * Hiển thị chi tiết bài viết theo đường dẫn.
     *
     * Mỗi phiên trình duyệt chỉ cộng một lượt xem cho mỗi bài viết,
     * tránh việc tải lại liên tục làm tăng lượt xem ảo.
     */
    public function show(string $duongDan): View
    {
        $baiViet = BaiViet::query()
            ->where('duong_dan', $duongDan)
            ->where('trang_thai', 1)
            ->firstOrFail();

        $sessionKey = 'da_xem_bai_viet_' . $baiViet->id;

        if (!session()->has($sessionKey)) {
            $baiViet->increment('luot_xem');
            session()->put($sessionKey, true);

            /*
             * Lấy lại dữ liệu mới nhất để giao diện hiển thị
             * đúng số lượt xem vừa được cộng trong database.
             */
            $baiViet->refresh();
        }

        $baiVietLienQuan = BaiViet::query()
            ->where('trang_thai', 1)
            ->where('id', '!=', $baiViet->id)
            ->orderByDesc('created_at')
            ->limit(4)
            ->get();

        return view('Client.bai_viet.detail', compact(
            'baiViet',
            'baiVietLienQuan'
        ));
    }
}