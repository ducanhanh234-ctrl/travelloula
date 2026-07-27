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
        return [
            'type' => 'bao_cao_su_co_cap_nhat',
            'bao_cao_id' => $this->baoCao->id,
            'tieu_de' => $this->baoCao->tieu_de,
            'trang_thai' => $this->baoCao->trang_thai,
            'ghi_chu_xu_ly' => $this->baoCao->ghi_chu_xu_ly,
            'message' => 'Báo cáo sự cố của bạn đã được Admin cập nhật.',
            'url' => route('Guide.baocaosuco.show', $this->baoCao),
        ];
    }
}
