@extends('layouts.admin')

@section('content')
<style>
.vehicle-detail-page{
    background:#f8fafc;
    min-height:100vh;
    padding:20px 12px 40px;
    color:#0f172a;
    width:100%;
}

.vehicle-header{
    display:flex;
    justify-content:space-between;
    align-items:flex-start;
    margin-bottom:24px;
}

.back-link{
    color:#64748b;
    text-decoration:none;
    font-weight:600;
    display:inline-flex;
    align-items:center;
    gap:8px;
    margin-bottom:12px;
}

.back-link:hover{
    color:#2563eb;
}

.vehicle-title{
    font-size:32px;
    font-weight:800;
    margin:0 0 6px;
    color:#0f172a;
}

.vehicle-subtitle{
    color:#64748b;
    font-size:15px;
}

.edit-btn{
    background:#3b82f6;
    color:#fff;
    border:none;
    border-radius:10px;
    padding:12px 22px;
    font-weight:800;
    text-decoration:none;
    box-shadow:0 6px 14px rgba(59,130,246,.22);
    transition:.2s;
}

.edit-btn:hover{
    background:#2563eb;
    color:#fff;
    transform:translateY(-1px);
}

.detail-grid{
    display:grid;
    grid-template-columns:1fr 390px;
    gap:24px;
    align-items:start;
}

.vehicle-card{
    background:#fff;
    border:1px solid #e2e8f0;
    border-radius:16px;
    overflow:hidden;
    box-shadow:0 1px 3px rgba(15,23,42,.06);
    margin-bottom:24px;
}

.vehicle-card-header{
    padding:18px 24px;
    border-bottom:1px solid #e2e8f0;
    font-size:18px;
    font-weight:800;
    color:#0f172a;
    display:flex;
    align-items:center;
    gap:10px;
}

.vehicle-card-body{
    padding:24px;
}

.info-grid{
    display:grid;
    grid-template-columns:1fr 1fr;
    gap:0 42px;
}

.info-row{
    padding:18px 0;
    border-bottom:1px solid #f1f5f9;
}

.info-label{
    font-size:14px;
    font-weight:800;
    color:#64748b;
    margin-bottom:8px;
}

.info-value{
    font-size:16px;
    font-weight:700;
    color:#0f172a;
}

.plate-box{
    background:#f8fafc;
    border:1px solid #e2e8f0;
    border-radius:14px;
    padding:28px 20px;
    text-align:center;
    margin-bottom:24px;
}

.plate-label{
    font-size:13px;
    color:#64748b;
    font-weight:800;
    margin-bottom:10px;
    letter-spacing:.04em;
}

.plate-value{
    font-size:36px;
    line-height:1.1;
    font-weight:900;
    color:#0f172a;
}

.side-section{
    margin-bottom:22px;
}

.side-label{
    font-size:14px;
    font-weight:800;
    color:#64748b;
    margin-bottom:8px;
}

.side-value{
    font-size:16px;
    font-weight:700;
    color:#0f172a;
}

.badge-status{
    display:inline-block;
    padding:7px 15px;
    border-radius:999px;
    font-size:12px;
    font-weight:900;
    color:#fff;
    white-space:nowrap;
}

.bg-green{background:#10b981;}
.bg-blue{background:#3b82f6;}
.bg-yellow{background:#f59e0b;color:#111827;}
.bg-red{background:#ef4444;}
.bg-gray{background:#64748b;}

.note-box{
    color:#334155;
    line-height:1.7;
    min-height:90px;
    font-size:15px;
}

@media(max-width:1100px){
    .vehicle-detail-page{
        padding:20px 10px 32px;
    }

    .vehicle-header{
        flex-direction:column;
        gap:18px;
    }

    .detail-grid{
        grid-template-columns:1fr;
    }

    .info-grid{
        grid-template-columns:1fr;
    }

    .vehicle-title{
        font-size:28px;
    }
}
</style>

<div class="vehicle-detail-page">

    <div class="vehicle-header">
        <div>
            <a href="{{ route('Admin.phuong-tiens.index') }}" class="back-link">
                <i class="fa fa-arrow-left"></i>
                Quay lại danh sách
            </a>

            <h1 class="vehicle-title">
                Biển số: {{ $phuongTien->bien_so_xe }}
            </h1>

            <div class="vehicle-subtitle">
                ID: #{{ $phuongTien->id }} • Chi tiết phương tiện và tài xế
            </div>
        </div>

        <a href="{{ route('Admin.phuong-tiens.edit', $phuongTien->id) }}" class="edit-btn">
            <i class="fa fa-edit"></i>
            Chỉnh sửa
        </a>
    </div>

    <div class="detail-grid">

        <div>
            <div class="vehicle-card">
                <div class="vehicle-card-header">
                    🚐 Thông tin xe
                </div>

                <div class="vehicle-card-body">
                    <div class="info-grid">

                        <div class="info-row">
                            <div class="info-label">Biển số</div>
                            <div class="info-value">{{ $phuongTien->bien_so_xe }}</div>
                        </div>

                        <div class="info-row">
                            <div class="info-label">Loại xe</div>
                            <div class="info-value">{{ $phuongTien->loai_phuong_tien_text }}</div>
                        </div>

                        <div class="info-row">
                            <div class="info-label">Hãng xe</div>
                            <div class="info-value">{{ $phuongTien->hang_xe }}</div>
                        </div>

                        <div class="info-row">
                            <div class="info-label">Năm sản xuất</div>
                            <div class="info-value">{{ $phuongTien->nam_san_xuat }}</div>
                        </div>

                        <div class="info-row">
                            <div class="info-label">Màu xe</div>
                            <div class="info-value">{{ $phuongTien->mau_xe }}</div>
                        </div>

                        <div class="info-row">
                            <div class="info-label">Mã phương tiện</div>
                            <div class="info-value">#{{ $phuongTien->id }}</div>
                        </div>

                    </div>
                </div>
            </div>

            <div class="vehicle-card">
                <div class="vehicle-card-header">
                    📝 Ghi chú
                </div>

                <div class="vehicle-card-body">
                    <div class="note-box">
                        {{ $phuongTien->ghi_chu ?: 'Không có ghi chú.' }}
                    </div>
                </div>
            </div>
        </div>

        <div>
            <div class="vehicle-card">
                <div class="vehicle-card-header">
                    👤 Trạng thái & Tài xế
                </div>

                <div class="vehicle-card-body">

                    <div class="plate-box">
                        <div class="plate-label">
                            BIỂN SỐ XE
                        </div>

                        <div class="plate-value">
                            {{ $phuongTien->bien_so_xe }}
                        </div>
                    </div>

                    <div class="side-section">
                        <div class="side-label">Trạng thái</div>

                        @switch($phuongTien->trang_thai)
                            @case(1)
                                <span class="badge-status bg-green">ĐANG HOẠT ĐỘNG</span>
                                @break

                            @case(2)
                                <span class="badge-status bg-blue">ĐANG CHẠY TOUR</span>
                                @break

                            @case(3)
                                <span class="badge-status bg-yellow">BẢO TRÌ</span>
                                @break

                            @case(4)
                                <span class="badge-status bg-red">ĐANG SỬA CHỮA</span>
                                @break

                            @default
                                <span class="badge-status bg-gray">NGỪNG HOẠT ĐỘNG</span>
                        @endswitch
                    </div>

                    <hr>

                    <div class="side-section">
                        <div class="side-label">Tên tài xế</div>
                        <div class="side-value">{{ $phuongTien->ten_tai_xe }}</div>
                    </div>

                    <div class="side-section" style="margin-bottom:0;">
                        <div class="side-label">Số điện thoại tài xế</div>
                        <div class="side-value">{{ $phuongTien->so_dien_thoai_tai_xe }}</div>
                    </div>

                </div>
            </div>
        </div>

    </div>
</div>
@endsection