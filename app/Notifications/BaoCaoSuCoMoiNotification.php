<?php

namespace App\Notifications;

use App\Models\BaoCaoSuCo;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class BaoCaoSuCoMoiNotification extends Notification
{
    use Queueable;

    public function __construct(
        public BaoCaoSuCo $baoCao
    ) {
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toDatabase(object $notifiable): array
    {
        return [
            'type' => 'bao_cao_su_co_moi',
            'bao_cao_id' => $this->baoCao->id,
            'tieu_de' => $this->baoCao->tieu_de,
            'muc_do' => $this->baoCao->muc_do,
            'message' => 'Có báo cáo sự cố mới từ hướng dẫn viên.',
            'url' => route(
                'Admin.baocaosuco.show',
                $this->baoCao->id
            ),
        ];
    }

    public function toArray(object $notifiable): array
    {
        return $this->toDatabase($notifiable);
    }
}
