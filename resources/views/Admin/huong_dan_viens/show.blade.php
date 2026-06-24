@extends('layouts.admin_pro')

@section('content')
<div class="guide-page">
    <div class="guide-top">
        <div>
            <h2>Chi tiết hướng dẫn viên</h2>
            <p>Thông tin hồ sơ và trạng thái hoạt động</p>
        </div>

        <div class="guide-actions">
            <a href="{{ route('Admin.huong-dan-viens.edit', $huongDanVien->id) }}" class="btn-edit">
                <i class="fas fa-edit"></i> Sửa
            </a>

            <a href="{{ route('Admin.huong-dan-viens.index') }}" class="btn-back">
                <i class="fas fa-arrow-left"></i> Quay lại
            </a>
        </div>
    </div>

    <div class="guide-detail-card">
        <div class="guide-profile">
            <div class="guide-avatar-wrap">
                <div class="guide-avatar-box">
                    @if($huongDanVien->anh_dai_dien)
                    <img src="{{ asset('storage/' . $huongDanVien->anh_dai_dien) }}" alt="{{ $huongDanVien->ho_ten }}">
                    @else
                    <i class="fas fa-user"></i>
                    @endif
                </div>

                <span class="avatar-status {{ $huongDanVien->trang_thai == 'hoat_dong' ? 'online' : 'offline' }}"></span>
            </div>

            <div class="guide-main-info">
                <h3>{{ $huongDanVien->ho_ten }}</h3>

                <div class="guide-position">
                    <i class="fas fa-map-signs"></i>
                    Hướng dẫn viên du lịch
                </div>

                <p>
                    <i class="fas fa-envelope"></i>
                    {{ $huongDanVien->email }}
                </p>

                <span class="guide-status {{ $huongDanVien->trang_thai == 'hoat_dong' ? 'active' : 'inactive' }}">
                    {{ $huongDanVien->trang_thai == 'hoat_dong' ? 'Đang hoạt động' : 'Ngừng hoạt động' }}
                </span>
            </div>
        </div>

        <div class="guide-info-grid">
            <div class="guide-info-item">
                <div class="info-icon phone">
                    <i class="fas fa-phone"></i>
                </div>
                <div>
                    <span>Số điện thoại</span>
                    <strong>{{ $huongDanVien->so_dien_thoai ?? '-' }}</strong>
                </div>
            </div>

            <div class="guide-info-item">
                <div class="info-icon birthday">
                    <i class="fas fa-calendar"></i>
                </div>
                <div>
                    <span>Ngày sinh</span>
                    <strong>{{ $huongDanVien->ngay_sinh?->format('d/m/Y') ?? '-' }}</strong>
                </div>
            </div>

            <div class="guide-info-item">
                <div class="info-icon gender">
                    <i class="fas fa-venus-mars"></i>
                </div>
                <div>
                    <span>Giới tính</span>
                    <strong>{{ ucfirst($huongDanVien->gioi_tinh ?? 'Chưa cập nhật') }}</strong>
                </div>
            </div>

            <div class="guide-info-item">
                <div class="info-icon address">
                    <i class="fas fa-location-dot"></i>
                </div>
                <div>
                    <span>Địa chỉ</span>
                    <strong>{{ $huongDanVien->dia_chi ?? '-' }}</strong>
                </div>
            </div>

            <div class="guide-info-item">
                <div class="info-icon exp">
                    <i class="fas fa-briefcase"></i>
                </div>
                <div>
                    <span>Kinh nghiệm</span>
                    <strong>{{ $huongDanVien->so_nam_kinh_nghiem ?? 0 }} năm</strong>
                </div>
            </div>
        </div>

        <div class="guide-desc">
            <h5>
                <i class="fas fa-align-left"></i>
                Mô tả
            </h5>
            <p>{{ $huongDanVien->mo_ta ?? 'Chưa có mô tả.' }}</p>
        </div>

        <div class="guide-footer">
            <span>
                <i class="fas fa-plus-circle"></i>
                Tạo: {{ $huongDanVien->created_at->format('d/m/Y H:i') }}
            </span>

            <span>
                <i class="fas fa-rotate"></i>
                Cập nhật: {{ $huongDanVien->updated_at->format('d/m/Y H:i') }}
            </span>
        </div>
    </div>
</div>

<style>
    .guide-page {
        max-width: 1100px;
        margin: 0 auto;
    }

    .guide-top {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 22px;
    }

    .guide-top h2 {
        margin: 0;
        font-size: 26px;
        font-weight: 800;
        color: #111827;
    }

    .guide-top p {
        margin: 5px 0 0;
        color: #6b7280;
    }

    .guide-actions {
        display: flex;
        gap: 10px;
    }

    .btn-edit,
    .btn-back {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 10px 16px;
        border-radius: 12px;
        font-weight: 700;
        text-decoration: none;
        transition: .25s;
    }

    .btn-edit {
        background: #2563eb;
        color: #fff;
    }

    .btn-edit:hover {
        background: #1d4ed8;
        color: #fff;
        transform: translateY(-2px);
    }

    .btn-back {
        background: #f3f4f6;
        color: #374151;
    }

    .btn-back:hover {
        background: #e5e7eb;
        color: #111827;
        transform: translateY(-2px);
    }

    .guide-detail-card {
        background: #fff;
        border-radius: 22px;
        padding: 32px;
        border: 1px solid #e5e7eb;
        box-shadow: 0 14px 40px rgba(15, 23, 42, 0.08);
    }

    .guide-profile {
        display: flex;
        align-items: center;
        gap: 30px;
        padding-bottom: 28px;
        border-bottom: 1px solid #eef2f7;
    }

    .guide-avatar-wrap {
        position: relative;
        width: 150px;
        height: 150px;
        flex-shrink: 0;
    }

    .guide-avatar-box {
        width: 150px;
        height: 150px;
        border-radius: 50%;
        padding: 5px;
        background: linear-gradient(135deg, #2563eb, #7c3aed, #ec4899);
        box-shadow: 0 18px 35px rgba(37, 99, 235, .28);
        transition: .3s ease;
    }

    .guide-avatar-box:hover {
        transform: translateY(-5px) scale(1.03);
    }

    .guide-avatar-box img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        border-radius: 50%;
        border: 5px solid #fff;
        background: #fff;
    }

    .guide-avatar-box i {
        width: 100%;
        height: 100%;
        border-radius: 50%;
        border: 5px solid #fff;
        background: #eff6ff;
        color: #2563eb;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 58px;
    }

    .avatar-status {
        position: absolute;
        right: 14px;
        bottom: 14px;
        width: 24px;
        height: 24px;
        border-radius: 50%;
        border: 4px solid #fff;
        box-shadow: 0 3px 8px rgba(0, 0, 0, .15);
    }

    .avatar-status.online {
        background: #22c55e;
    }

    .avatar-status.offline {
        background: #ef4444;
    }

    .guide-main-info h3 {
        margin: 0;
        font-size: 34px;
        font-weight: 800;
        color: #111827;
    }

    .guide-position {
        margin: 8px 0;
        color: #2563eb;
        font-weight: 700;
    }

    .guide-position i,
    .guide-main-info p i {
        margin-right: 8px;
    }

    .guide-main-info p {
        margin: 8px 0 14px;
        color: #6b7280;
    }

    .guide-status {
        display: inline-flex;
        padding: 7px 16px;
        border-radius: 999px;
        font-size: 13px;
        font-weight: 800;
    }

    .guide-status.active {
        background: #dcfce7;
        color: #15803d;
    }

    .guide-status.inactive {
        background: #fee2e2;
        color: #b91c1c;
    }

    .guide-info-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 16px;
        margin-top: 28px;
    }

    .guide-info-item {
        display: flex;
        align-items: center;
        gap: 15px;
        background: #f9fafb;
        border: 1px solid #edf0f4;
        border-radius: 16px;
        padding: 18px;
        transition: .25s;
    }

    .guide-info-item:hover {
        background: #fff;
        transform: translateY(-3px);
        box-shadow: 0 10px 24px rgba(15, 23, 42, 0.06);
    }

    .info-icon {
        width: 46px;
        height: 46px;
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
    }

    .info-icon.phone {
        background: #dcfce7;
        color: #15803d;
    }

    .info-icon.birthday {
        background: #dbeafe;
        color: #2563eb;
    }

    .info-icon.gender {
        background: #fce7f3;
        color: #db2777;
    }

    .info-icon.address {
        background: #ffedd5;
        color: #ea580c;
    }

    .info-icon.exp {
        background: #ede9fe;
        color: #7c3aed;
    }

    .guide-info-item span {
        display: block;
        font-size: 13px;
        color: #6b7280;
        margin-bottom: 4px;
    }

    .guide-info-item strong {
        color: #111827;
        font-size: 15px;
        font-weight: 800;
    }

    .guide-desc {
        margin-top: 28px;
        padding: 22px;
        border-radius: 18px;
        background: linear-gradient(180deg, #f9fafb, #ffffff);
        border: 1px solid #edf0f4;
    }

    .guide-desc h5 {
        margin: 0 0 12px;
        font-size: 17px;
        font-weight: 800;
        color: #111827;
    }

    .guide-desc h5 i {
        color: #2563eb;
        margin-right: 8px;
    }

    .guide-desc p {
        margin: 0;
        color: #374151;
        line-height: 1.8;
    }

    .guide-footer {
        margin-top: 22px;
        padding-top: 18px;
        border-top: 1px solid #eef2f7;
        display: flex;
        justify-content: flex-end;
        gap: 18px;
        color: #6b7280;
        font-size: 13px;
    }

    .guide-footer i {
        margin-right: 6px;
        color: #9ca3af;
    }

    @media (max-width: 768px) {
        .guide-top {
            flex-direction: column;
            align-items: flex-start;
            gap: 14px;
        }

        .guide-profile {
            flex-direction: column;
            align-items: flex-start;
        }

        .guide-main-info h3 {
            font-size: 26px;
        }

        .guide-info-grid {
            grid-template-columns: 1fr;
        }

        .guide-footer {
            flex-direction: column;
            align-items: flex-start;
            gap: 8px;
        }
    }

</style>
@endsection
