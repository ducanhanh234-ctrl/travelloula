@extends('layouts.admin')

@section('content')

<style>
.vehicle-wrap{
    max-width:1400px;
    margin:auto;
    padding:30px;
}

.vehicle-header{
    display:flex;
    justify-content:space-between;
    align-items:flex-start;
    margin-bottom:25px;
}

.back-link{
    color:#64748b;
    text-decoration:none;
    font-weight:600;
    display:inline-block;
    margin-bottom:10px;
}

.back-link:hover{
    color:#2563eb;
}

.vehicle-page-title{
    font-size:42px;
    font-weight:800;
    color:#0f172a;
    margin-bottom:5px;
}

.vehicle-subtitle{
    color:#64748b;
    font-size:16px;
}

.vehicle-card{
    background:#fff;
    border:1px solid #e5e7eb;
    border-radius:14px;
    overflow:hidden;
    box-shadow:0 2px 10px rgba(0,0,0,.04);
    margin-bottom:25px;
}

.vehicle-card-header{
    padding:18px 24px;
    border-bottom:1px solid #e5e7eb;
    font-size:18px;
    font-weight:700;
}

.vehicle-card-body{
    padding:24px;
}

.info-row{
    display:grid;
    grid-template-columns:180px 1fr;
    gap:20px;
    align-items:center;
    padding:16px 0;
    border-bottom:1px solid #f1f5f9;
}

.info-row:last-child{
    border-bottom:none;
}

.info-label{
    font-weight:700;
    color:#0f172a;
}

.info-value{
    color:#334155;
    font-size:15px;
}

.plate-box{
    background:#f8fafc;
    border:1px solid #e2e8f0;
    border-radius:12px;
    padding:25px;
    text-align:center;
    margin-bottom:25px;
}

.plate-label{
    font-size:13px;
    color:#64748b;
    font-weight:700;
    margin-bottom:10px;
}

.plate-value{
    font-size:38px;
    font-weight:800;
    color:#0f172a;
}

.side-label{
    font-weight:700;
    color:#0f172a;
    margin-bottom:8px;
}

.side-value{
    color:#334155;
    margin-bottom:20px;
}

.badge{
    padding:8px 16px;
    border-radius:50px;
    font-size:12px;
    font-weight:700;
}

.note-box{
    min-height:80px;
    color:#475569;
    line-height:1.8;
}

.edit-btn{
    border-radius:10px;
    padding:10px 20px;
    font-weight:700;
}

@media(max-width:991px){

    .vehicle-header{
        flex-direction:column;
        gap:15px;
    }

    .info-row{
        grid-template-columns:1fr;
        gap:5px;
    }

    .vehicle-page-title{
        font-size:30px;
    }
}
</style>
<div class="vehicle-wrap">

    <div class="vehicle-header">

        <div>
            <a href="{{ route('Admin.phuong-tiens.index') }}" class="back-link">
                <i class="fa fa-arrow-left"></i>
                Quay lại danh sách
            </a>

            <h1 class="vehicle-page-title">
                Biển số: {{ $phuongTien->bien_so_xe }}
            </h1>

            <div class="vehicle-subtitle">
                ID: #{{ $phuongTien->id }} • Chi tiết phương tiện và tài xế
            </div>
        </div>

        <a href="{{ route('Admin.phuong-tiens.edit',$phuongTien->id) }}"
           class="btn btn-primary edit-btn">
            <i class="fa fa-edit"></i>
            Chỉnh sửa
        </a>

    </div>

    <div class="row g-4 align-items-start">

        <div class="col-lg-8">

            <div class="vehicle-card">

                <div class="vehicle-card-header">
                    Thông tin xe
                </div>

                <div class="vehicle-card-body">

                    <div class="info-row">
                        <div class="info-label">Biển số</div>
                        <div class="info-value">{{ $phuongTien->bien_so_xe }}</div>
                    </div>

                    <div class="info-row">
                        <div class="info-label">Loại xe</div>
                        <div class="info-value">{{ $phuongTien->loai_phuong_tien }}</div>
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

                </div>
            </div>

            <div class="vehicle-card">

                <div class="vehicle-card-header">
                    Ghi chú
                </div>

                <div class="vehicle-card-body">

                    <div class="note-box">
                        {{ $phuongTien->ghi_chu ?: 'Không có ghi chú.' }}
                    </div>

                </div>

            </div>

        </div>

        <div class="col-lg-4">

            <div class="vehicle-card">

                <div class="vehicle-card-header">
                    Trạng thái & Tài xế
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

                    <div class="side-label">
                        Trạng thái
                    </div>

                    @switch($phuongTien->trang_thai)

                        @case(1)
                            <span class="badge bg-success">
                                ĐANG HOẠT ĐỘNG
                            </span>
                        @break

                        @case(2)
                            <span class="badge bg-primary">
                                ĐANG CHẠY TOUR
                            </span>
                        @break

                        @case(3)
                            <span class="badge bg-warning text-dark">
                                BẢO TRÌ
                            </span>
                        @break

                        @case(4)
                            <span class="badge bg-danger">
                                ĐANG SỬA CHỮA
                            </span>
                        @break

                        @default
                            <span class="badge bg-secondary">
                                NGỪNG HOẠT ĐỘNG
                            </span>

                    @endswitch

                    <hr>

                    <div class="side-label mt-4">
                        Tên tài xế
                    </div>

                    <div class="side-value">
                        {{ $phuongTien->ten_tai_xe }}
                    </div>

                    <div class="side-label">
                        Số điện thoại tài xế
                    </div>

                    <div class="side-value mb-0">
                        {{ $phuongTien->so_dien_thoai_tai_xe }}
                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection