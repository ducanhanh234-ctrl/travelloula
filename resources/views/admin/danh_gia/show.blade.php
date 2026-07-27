@extends('layouts.admin')

@section('title', 'Chi tiết đánh giá')

@section('breadcrumb')
    <li class="breadcrumb-item">
        <a href="{{ route('Admin.danh_gias.index') }}">
            Quản lý Đánh giá
        </a>
    </li>

    <li class="breadcrumb-item active">
        Chi tiết đánh giá
    </li>
@endsection

@section('content')
@php
    /*
     * Dữ liệu mới ưu tiên tài khoản trực tiếp gửi đánh giá.
     * Dữ liệu cũ vẫn hỗ trợ thông qua khachHangDatTour.
     */
    $reviewerName = $danh_gia->user?->name
        ?? $danh_gia->khachHangDatTour?->ho_ten
        ?? 'Không xác định';

    $reviewerEmail = $danh_gia->user?->email
        ?? $danh_gia->khachHangDatTour?->email
        ?? 'Không có';

    $reviewerPhone = $danh_gia->user?->so_dien_thoai
        ?? $danh_gia->user?->phone
        ?? $danh_gia->khachHangDatTour?->so_dien_thoai
        ?? 'Không có';

    $reviewSource = $danh_gia->nguoi_dung_id
        ? 'Tài khoản đăng nhập'
        : 'Dữ liệu đánh giá cũ';

    $reviewDate = $danh_gia->thoi_gian_danh_gia
        ? \Carbon\Carbon::parse($danh_gia->thoi_gian_danh_gia)
        : null;
@endphp

<style>
    :root {
        --review-primary: #315be8;
        --review-primary-dark: #2447c7;
        --review-purple: #5b4dea;
        --review-dark: #173576;
        --review-text: #344563;
        --review-muted: #6b7895;
        --review-border: #dce6f5;
        --review-soft: #f5f8ff;
        --review-white: #ffffff;
        --review-danger: #dc3545;
    }

    .review-detail-page {
        width: 100%;
        padding: 24px 0 42px;
        color: var(--review-text);
    }

    .review-detail-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 18px;
        margin-bottom: 22px;
    }

    .review-detail-heading {
        display: flex;
        align-items: center;
        gap: 13px;
        min-width: 0;
    }

    .review-detail-heading-icon {
        width: 48px;
        height: 48px;
        flex: 0 0 48px;
        display: grid;
        place-items: center;
        color: var(--review-primary);
        background: #edf4ff;
        border: 1px solid #cfe0ff;
        border-radius: 13px;
        font-size: 19px;
    }

    .review-detail-heading h3 {
        margin: 0;
        color: var(--review-dark);
        font-size: 25px;
        font-weight: 800;
    }

    .review-detail-heading p {
        margin: 5px 0 0;
        color: var(--review-muted);
        font-size: 14px;
    }

    .review-back-btn {
        min-height: 42px;
        padding: 9px 16px;
        border: 1px solid #cbd7e8;
        border-radius: 10px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        color: #53698f;
        background: #fff;
        font-size: 13px;
        font-weight: 750;
        text-decoration: none;
        transition: .18s ease;
        white-space: nowrap;
    }

    .review-back-btn:hover {
        color: var(--review-primary);
        border-color: #aac1ef;
        background: #edf4ff;
        text-decoration: none;
        transform: translateY(-1px);
    }

    .review-public-note {
        margin-bottom: 20px;
        padding: 13px 15px;
        display: flex;
        align-items: flex-start;
        gap: 9px;
        color: #3158ce;
        background: #edf4ff;
        border: 1px solid #cfe0ff;
        border-radius: 11px;
        font-size: 13px;
        font-weight: 650;
        line-height: 1.6;
    }

    .review-detail-grid {
        display: grid;
        grid-template-columns: minmax(0, 1.6fr) minmax(310px, .8fr);
        gap: 22px;
        align-items: start;
    }

    .review-detail-main,
    .review-detail-sidebar {
        min-width: 0;
    }

    .review-detail-card {
        margin-bottom: 20px;
        overflow: hidden;
        background: var(--review-white);
        border: 1px solid var(--review-border);
        border-radius: 15px;
        box-shadow: 0 8px 28px rgba(28, 65, 139, .08);
    }

    .review-detail-card:last-child {
        margin-bottom: 0;
    }

    .review-detail-card-header {
        min-height: 58px;
        padding: 15px 19px;
        display: flex;
        align-items: center;
        gap: 9px;
        color: #24417d;
        background: #f1f6ff;
        border-bottom: 1px solid var(--review-border);
        font-size: 14px;
        font-weight: 800;
    }

    .review-detail-card-header i {
        color: var(--review-primary);
    }

    .review-detail-card-body {
        padding: 21px;
    }

    .review-score-row {
        display: flex;
        align-items: center;
        flex-wrap: wrap;
        gap: 12px;
        margin-bottom: 18px;
    }

    .review-stars {
        display: inline-flex;
        gap: 4px;
    }

    .review-stars i {
        color: #d3d8e3;
        font-size: 25px;
    }

    .review-stars i.active {
        color: #f2a900;
    }

    .review-score-badge {
        padding: 6px 11px;
        color: #9b650a;
        background: #fff7e6;
        border: 1px solid #f1dcae;
        border-radius: 999px;
        font-size: 12px;
        font-weight: 800;
    }

    .review-title-box {
        margin-bottom: 15px;
        padding: 14px 16px;
        color: #233f7a;
        background: #f8fbff;
        border: 1px solid #dbe7f8;
        border-radius: 11px;
        font-size: 16px;
        font-weight: 800;
    }

    .review-content-box {
        min-height: 145px;
        padding: 18px;
        color: #425372;
        background: #fbfdff;
        border: 1px solid #dce6f5;
        border-radius: 12px;
        font-size: 14px;
        line-height: 1.8;
        white-space: pre-line;
        overflow-wrap: anywhere;
    }

    .review-info-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 14px;
    }

    .review-info-item {
        min-width: 0;
        padding: 14px;
        background: #fbfdff;
        border: 1px solid #e2eaf6;
        border-radius: 11px;
    }

    .review-info-item.full-width {
        grid-column: 1 / -1;
    }

    .review-info-item label {
        display: block;
        margin-bottom: 6px;
        color: var(--review-muted);
        font-size: 11px;
        font-weight: 750;
        text-transform: uppercase;
        letter-spacing: .03em;
    }

    .review-info-item strong {
        display: block;
        color: #233f7a;
        font-size: 13px;
        font-weight: 750;
        line-height: 1.55;
        overflow-wrap: anywhere;
    }

    .review-source-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 6px 10px;
        color: #08754a;
        background: #eaf9f1;
        border: 1px solid #c5ead8;
        border-radius: 999px;
        font-size: 11px;
        font-weight: 800;
    }

    .review-tour-name {
        color: #233f7a;
        font-size: 15px;
        font-weight: 800;
        line-height: 1.6;
    }

    .review-tour-link {
        margin-top: 13px;
        min-height: 38px;
        padding: 8px 12px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 7px;
        color: var(--review-primary);
        background: #edf4ff;
        border: 1px solid #cfe0ff;
        border-radius: 9px;
        font-size: 12px;
        font-weight: 750;
        text-decoration: none;
    }

    .review-tour-link:hover {
        color: #fff;
        background: var(--review-primary);
        border-color: var(--review-primary);
        text-decoration: none;
    }

    .review-meta-list {
        display: grid;
        gap: 13px;
    }

    .review-meta-row {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 14px;
        padding-bottom: 13px;
        border-bottom: 1px solid #e8eef8;
    }

    .review-meta-row:last-child {
        padding-bottom: 0;
        border-bottom: 0;
    }

    .review-meta-row span {
        color: var(--review-muted);
        font-size: 12px;
    }

    .review-meta-row strong {
        color: #233f7a;
        font-size: 12px;
        text-align: right;
        overflow-wrap: anywhere;
    }

    .review-delete-form {
        margin: 0;
    }

    .review-delete-btn {
        width: 100%;
        min-height: 45px;
        padding: 10px 16px;
        border: 1px solid #efb9c2;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        color: #b4233a;
        background: #fff0f3;
        font-size: 13px;
        font-weight: 800;
        cursor: pointer;
        transition: .18s ease;
    }

    .review-delete-btn:hover {
        color: #fff;
        background: var(--review-danger);
        border-color: var(--review-danger);
        transform: translateY(-1px);
        box-shadow: 0 8px 18px rgba(220, 53, 69, .2);
    }

    @media (max-width: 1050px) {
        .review-detail-grid {
            grid-template-columns: 1fr;
        }

        .review-detail-sidebar {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 20px;
        }

        .review-detail-sidebar .review-detail-card {
            margin-bottom: 0;
        }

        .review-detail-sidebar .review-detail-card:last-child {
            grid-column: 1 / -1;
        }
    }

    @media (max-width: 700px) {
        .review-detail-page {
            padding-top: 14px;
        }

        .review-detail-header {
            align-items: stretch;
            flex-direction: column;
        }

        .review-back-btn {
            width: 100%;
        }

        .review-detail-heading {
            align-items: flex-start;
        }

        .review-detail-heading h3 {
            font-size: 21px;
        }

        .review-info-grid,
        .review-detail-sidebar {
            grid-template-columns: 1fr;
        }

        .review-detail-sidebar .review-detail-card:last-child {
            grid-column: auto;
        }

        .review-detail-card-body {
            padding: 16px;
        }

        .review-meta-row {
            flex-direction: column;
            gap: 4px;
        }

        .review-meta-row strong {
            text-align: left;
        }
    }
</style>

<div class="container-fluid review-detail-page">
    <div class="review-detail-header">
        <div class="review-detail-heading">
            <span class="review-detail-heading-icon">
                <i class="fas fa-comment-dots"></i>
            </span>

            <div>
                <h3>Chi tiết đánh giá</h3>
                <p>Xem thông tin tài khoản, tour và nội dung đánh giá.</p>
            </div>
        </div>

        <a href="{{ route('Admin.danh_gias.index') }}" class="review-back-btn">
            <i class="fas fa-arrow-left"></i>
            Quay lại danh sách
        </a>
    </div>

    <div class="review-public-note">
        <i class="fas fa-info-circle"></i>
        <span>
            Đánh giá này được hiển thị ngay sau khi người dùng gửi.
            Quản trị viên chỉ xóa khi nội dung không phù hợp.
        </span>
    </div>

    <div class="review-detail-grid">
        <div class="review-detail-main">
            <section class="review-detail-card">
                <div class="review-detail-card-header">
                    <i class="fas fa-star"></i>
                    Nội dung đánh giá
                </div>

                <div class="review-detail-card-body">
                    <div class="review-score-row">
                        <div class="review-stars">
                            @for($star = 1; $star <= 5; $star++)
                                <i class="fas fa-star {{ $star <= $danh_gia->so_sao ? 'active' : '' }}"></i>
                            @endfor
                        </div>

                        <span class="review-score-badge">
                            {{ $danh_gia->so_sao }}/5
                        </span>
                    </div>

                    @if($danh_gia->tieu_de)
                        <div class="review-title-box">
                            {{ $danh_gia->tieu_de }}
                        </div>
                    @endif

                    <div class="review-content-box">
                        {{ $danh_gia->noi_dung_danh_gia ?: 'Không có nội dung đánh giá.' }}
                    </div>
                </div>
            </section>

            <section class="review-detail-card">
                <div class="review-detail-card-header">
                    <i class="fas fa-user"></i>
                    Thông tin người đánh giá
                </div>

                <div class="review-detail-card-body">
                    <div class="review-info-grid">
                        <div class="review-info-item">
                            <label>Họ tên</label>
                            <strong>{{ $reviewerName }}</strong>
                        </div>

                        <div class="review-info-item">
                            <label>Email</label>
                            <strong>{{ $reviewerEmail }}</strong>
                        </div>

                        <div class="review-info-item">
                            <label>Số điện thoại</label>
                            <strong>{{ $reviewerPhone }}</strong>
                        </div>

                        <div class="review-info-item">
                            <label>ID tài khoản</label>
                            <strong>
                                {{ $danh_gia->nguoi_dung_id ? '#' . $danh_gia->nguoi_dung_id : 'Không có' }}
                            </strong>
                        </div>

                        <div class="review-info-item full-width">
                            <label>Nguồn dữ liệu</label>
                            <span class="review-source-badge">
                                <i class="fas fa-user-check"></i>
                                {{ $reviewSource }}
                            </span>
                        </div>
                    </div>
                </div>
            </section>
        </div>

        <aside class="review-detail-sidebar">
            <section class="review-detail-card">
                <div class="review-detail-card-header">
                    <i class="fas fa-map-marked-alt"></i>
                    Thông tin tour
                </div>

                <div class="review-detail-card-body">
                    <div class="review-tour-name">
                        {{ $danh_gia->tour?->ten_tour ?? 'Tour không còn tồn tại' }}
                    </div>

                    <div class="review-meta-list mt-3">
                        <div class="review-meta-row">
                            <span>Mã tour</span>
                            <strong>
                                {{ $danh_gia->tour?->id ? 'TOUR-' . $danh_gia->tour->id : 'N/A' }}
                            </strong>
                        </div>

                        <div class="review-meta-row">
                            <span>Điểm đến</span>
                            <strong>{{ $danh_gia->tour?->diem_den ?? 'Đang cập nhật' }}</strong>
                        </div>
                    </div>

                    @if($danh_gia->tour)
                        <a
                            href="{{ route('Client.danh_sach_tour.show', $danh_gia->tour->id) }}#danh-gia"
                            class="review-tour-link"
                            target="_blank"
                        >
                            <i class="fas fa-external-link-alt"></i>
                            Xem tour phía khách hàng
                        </a>
                    @endif
                </div>
            </section>

            <section class="review-detail-card">
                <div class="review-detail-card-header">
                    <i class="fas fa-info-circle"></i>
                    Thông tin đánh giá
                </div>

                <div class="review-detail-card-body">
                    <div class="review-meta-list">
                        <div class="review-meta-row">
                            <span>Mã đánh giá</span>
                            <strong>#DG{{ $danh_gia->id }}</strong>
                        </div>

                        <div class="review-meta-row">
                            <span>Ngày đánh giá</span>
                            <strong>
                                {{ $reviewDate ? $reviewDate->format('d/m/Y H:i:s') : 'N/A' }}
                            </strong>
                        </div>

                        <div class="review-meta-row">
                            <span>Trạng thái</span>
                            <strong>Đang hiển thị công khai</strong>
                        </div>
                    </div>
                </div>
            </section>

            <section class="review-detail-card">
                <div class="review-detail-card-header">
                    <i class="fas fa-cogs"></i>
                    Thao tác quản trị
                </div>

                <div class="review-detail-card-body">
                    <form
                        action="{{ route('Admin.danh_gias.destroy', $danh_gia->id) }}"
                        method="POST"
                        class="review-delete-form"
                        onsubmit="return confirm('Bạn có chắc muốn xóa vĩnh viễn đánh giá này?');"
                    >
                        @csrf
                        @method('DELETE')

                        <button type="submit" class="review-delete-btn">
                            <i class="fas fa-trash"></i>
                            Xóa đánh giá không phù hợp
                        </button>
                    </form>
                </div>
            </section>
        </aside>
    </div>
</div>
@endsection