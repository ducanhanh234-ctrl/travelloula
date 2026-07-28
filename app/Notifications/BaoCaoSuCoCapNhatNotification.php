<?php

namespace App\Notifications;

use App\Models\BaoCaoSuCo;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class BaoCaoSuCoCapNhatNotification extends Notification
{
    use Queueable;

    public function __construct(public BaoCaoSuCo $baoCao)
    {
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        $message = match ($this->baoCao->trang_thai) {
            'da_tiep_nhan' =>
                'Admin đã tiếp nhận báo cáo sự cố của bạn.',

            'dang_xu_ly' =>
                'Admin đang xử lý báo cáo sự cố của bạn.',

            'da_xu_ly' =>
                'Báo cáo sự cố của bạn đã được xử lý.',

            'tu_choi' =>
                'Báo cáo sự cố của bạn đã bị từ chối.',

            default =>
                'Báo cáo sự cố của bạn đã được Admin cập nhật.',
        };

        return [
            'type' => 'bao_cao_su_co_cap_nhat',
            'bao_cao_id' => $this->baoCao->id,
            'tieu_de' => $this->baoCao->tieu_de,
            'trang_thai' => $this->baoCao->trang_thai,
            'ghi_chu_xu_ly' => $this->baoCao->ghi_chu_xu_ly,
            'message' => $message,
            'url' => route('Guide.baocaosuco.show', [
                'id' => $this->baoCao->id,
            ]),
        ];
    }
}
