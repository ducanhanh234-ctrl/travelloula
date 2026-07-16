@extends('layouts.admin')

@section('title', 'Chi tiết danh mục')

@section('content')
    <style>
        :root {
            --detail-primary: #315be8;
            --detail-purple: #5b4dea;
            --detail-dark: #173576;
            --detail-text: #344563;
            --detail-muted: #6b7895;
            --detail-border: #dce6f5;
            --detail-white: #ffffff;
            --detail-soft: #f5f8ff;
            --detail-success: #08754a;
            --detail-success-bg: #eaf9f1;
            --detail-danger: #c13d55;
            --detail-danger-bg: #fff0f3;
            --detail-warning: #ae6c0d;
            --detail-warning-bg: #fff7e8;
        }

        .category-detail-page {
            padding: 24px 0;
            color: var(--detail-text);
        }

        .category-detail-top {
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            flex-wrap: wrap;
        }

        .category-detail-heading {
            display: flex;
            align-items: center;
            gap: 13px;
        }

        .category-detail-page-icon {
            width: 47px;
            height: 47px;
            flex-shrink: 0;
            color: var(--detail-primary);
            background: #edf4ff;
            border: 1px solid #cfe0ff;
            border-radius: 12px;
            font-size: 18px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .category-detail-heading h3 {
            margin: 0;
            color: var(--detail-dark);
            font-size: 23px;
            font-weight: 750;
        }

        .category-detail-heading p {
            margin: 6px 0 0;
            color: var(--detail-muted);
            font-size: 14px;
        }

        .btn-back-category {
            min-height: 41px;
            padding: 9px 15px;
            color: #40537a;
            background: var(--detail-white);
            border: 1px solid #ccd9ed;
            border-radius: 9px;
            font-size: 13px;
            font-weight: 700;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 7px;
            transition: all 0.18s ease;
        }

        .btn-back-category:hover {
            color: var(--detail-primary);
            background: #edf4ff;
            border-color: #b9ccef;
            text-decoration: none;
            transform: translateY(-1px);
        }

        .category-detail-card {
            position: relative;
            overflow: hidden;
            background: var(--detail-white);
            border: 1px solid #d8e4f6;
            border-radius: 15px;
            box-shadow: 0 8px 30px rgba(28, 65, 139, 0.1);
        }

        .category-detail-card::before {
            position: absolute;
            top: 0;
            right: 0;
            left: 0;
            z-index: 3;
            height: 4px;
            content: "";
            background: linear-gradient(
                90deg,
                #2458e7,
                #3478ef,
                #18c7e7,
                #5947e9
            );
        }

        .category-detail-header {
            position: relative;
            min-height: 116px;
            padding: 24px;
            overflow: hidden;
            color: var(--detail-white);
            background: linear-gradient(
                120deg,
                #2856df 0%,
                #316cec 55%,
                #5b49e8 100%
            );
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
        }

        .category-detail-header::before {
            position: absolute;
            right: -50px;
            bottom: -105px;
            width: 235px;
            height: 235px;
            content: "";
            border: 21px solid rgba(255, 255, 255, 0.07);
            border-radius: 50%;
        }

        .category-detail-header::after {
            position: absolute;
            top: -85px;
            right: 115px;
            width: 175px;
            height: 175px;
            content: "";
            background: rgba(255, 255, 255, 0.045);
            border-radius: 50%;
        }

        .category-detail-header-content {
            position: relative;
            z-index: 2;
            min-width: 0;
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .category-detail-header-icon {
            width: 46px;
            height: 46px;
            flex-shrink: 0;
            color: var(--detail-white);
            background: rgba(255, 255, 255, 0.16);
            border: 1px solid rgba(255, 255, 255, 0.3);
            border-radius: 12px;
            font-size: 18px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .category-detail-header h4 {
            margin: 0;
            color: var(--detail-white);
            font-size: 20px;
            font-weight: 750;
        }

        .category-detail-header p {
            margin: 6px 0 0;
            color: rgba(255, 255, 255, 0.82);
            font-size: 12px;
        }

        .category-detail-code {
            position: relative;
            z-index: 2;
            padding: 9px 13px;
            color: var(--detail-white);
            background: rgba(255, 255, 255, 0.14);
            border: 1px solid rgba(255, 255, 255, 0.25);
            border-radius: 9px;
            font-size: 11px;
            font-weight: 700;
            white-space: nowrap;
        }

        .category-detail-body {
            padding: 24px;
        }

        .category-detail-grid {
            display: grid;
            grid-template-columns: minmax(280px, 370px) minmax(0, 1fr);
            gap: 24px;
            align-items: stretch;
        }

        .category-image-panel,
        .category-info-panel {
            overflow: hidden;
            background: var(--detail-white);
            border: 1px solid var(--detail-border);
            border-radius: 12px;
        }

        .category-panel-heading {
            padding: 14px 17px;
            color: #24417d;
            background: #f1f6ff;
            border-bottom: 1px solid var(--detail-border);
            font-size: 13px;
            font-weight: 750;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .category-panel-heading i {
            color: var(--detail-primary);
        }

        .category-image-content {
            padding: 18px;
        }

        .category-image-frame {
            position: relative;
            width: 100%;
            overflow: hidden;
            aspect-ratio: 4 / 3;
            background: #f4f7fc;
            border: 1px solid #dce6f5;
            border-radius: 11px;
        }

        .category-main-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }

        .category-image-placeholder {
            width: 100%;
            height: 100%;
            color: #8191ad;
            background:
                linear-gradient(
                    135deg,
                    #f6f9ff,
                    #edf3fd
                );
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            gap: 10px;
        }

        .category-image-placeholder i {
            font-size: 38px;
            color: #6681bd;
        }

        .category-image-placeholder span {
            font-size: 12px;
            font-weight: 650;
        }

        .category-image-path {
            margin-top: 12px;
            padding: 10px 12px;
            color: #697894;
            background: #f7f9fd;
            border: 1px solid #e1e8f2;
            border-radius: 8px;
            font-size: 10px;
            line-height: 1.6;
            overflow-wrap: anywhere;
        }

        .category-image-path i {
            margin-right: 5px;
            color: #5b79cb;
        }

        .category-info-content {
            padding: 18px;
        }

        .category-info-item {
            padding: 16px 0;
            border-bottom: 1px solid #e8eef8;
        }

        .category-info-item:first-child {
            padding-top: 0;
        }

        .category-info-item:last-child {
            padding-bottom: 0;
            border-bottom: none;
        }

        .category-info-label {
            margin-bottom: 7px;
            color: #71809a;
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.03em;
            display: flex;
            align-items: center;
            gap: 7px;
        }

        .category-info-label i {
            color: #5476d1;
        }

        .category-name-value {
            color: #233f7a;
            font-size: 20px;
            font-weight: 780;
            line-height: 1.4;
        }

        .category-description-value {
            margin: 0;
            color: #52627f;
            font-size: 13px;
            line-height: 1.8;
            white-space: pre-line;
        }

        .category-empty-value {
            color: #98a2b3;
            font-size: 12px;
            font-style: italic;
        }

        .category-status {
            padding: 6px 11px;
            border: 1px solid transparent;
            border-radius: 999px;
            font-size: 10px;
            font-weight: 750;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .category-status-dot {
            width: 7px;
            height: 7px;
            border-radius: 50%;
            background: currentColor;
        }

        .category-status-active {
            color: var(--detail-success);
            background: var(--detail-success-bg);
            border-color: #c5ead8;
        }

        .category-status-inactive {
            color: var(--detail-danger);
            background: var(--detail-danger-bg);
            border-color: #f0c9d1;
        }

        .category-date-value {
            color: #40537a;
            font-size: 12px;
            font-weight: 650;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .category-detail-actions {
            margin-top: 22px;
            padding-top: 18px;
            border-top: 1px solid #e5ecf6;
            display: flex;
            align-items: center;
            justify-content: flex-end;
            gap: 10px;
        }

        .btn-category-action {
            min-height: 41px;
            padding: 9px 16px;
            border: 1px solid transparent;
            border-radius: 9px;
            font-size: 13px;
            font-weight: 700;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 7px;
            transition: all 0.18s ease;
        }

        .btn-category-list {
            color: #53698f;
            background: var(--detail-white);
            border-color: #ccd9ed;
        }

        .btn-category-list:hover {
            color: #304d83;
            background: #edf3fb;
            border-color: #b9c9e0;
            text-decoration: none;
        }

        .btn-category-edit {
            color: #8d5f0c;
            background: var(--detail-warning-bg);
            border-color: #ecd59e;
        }

        .btn-category-edit:hover {
            color: var(--detail-white);
            background: #df9420;
            border-color: #df9420;
            text-decoration: none;
            transform: translateY(-1px);
        }

        @media (max-width: 900px) {
            .category-detail-grid {
                grid-template-columns: 1fr;
            }

            .category-image-panel {
                max-width: 520px;
                width: 100%;
                margin: 0 auto;
            }
        }

        @media (max-width: 768px) {
            .category-detail-page {
                padding: 14px 0;
            }

            .category-detail-top {
                align-items: stretch;
                flex-direction: column;
            }

            .btn-back-category {
                width: 100%;
            }

            .category-detail-header {
                align-items: flex-start;
                padding: 20px 18px;
                flex-direction: column;
            }

            .category-detail-body {
                padding: 16px;
            }

            .category-detail-actions {
                align-items: stretch;
                flex-direction: column-reverse;
            }

            .btn-category-action {
                width: 100%;
            }
        }
    </style>

    @php
        $imagePath = trim((string) ($danhMuc->hinh_anh ?? ''));
        $imageUrl = null;

        if ($imagePath !== '') {
            if (
                \Illuminate\Support\Str::startsWith(
                    $imagePath,
                    ['http://', 'https://', '//', 'data:']
                )
            ) {
                $imageUrl = $imagePath;
            } elseif (
                \Illuminate\Support\Str::startsWith(
                    $imagePath,
                    'public/'
                )
            ) {
                $imageUrl = asset(
                    'storage/' .
                    \Illuminate\Support\Str::after(
                        $imagePath,
                        'public/'
                    )
                );
            } elseif (
                \Illuminate\Support\Str::startsWith(
                    $imagePath,
                    ['storage/', 'images/', 'uploads/']
                )
            ) {
                $imageUrl = asset(ltrim($imagePath, '/'));
            } else {
                $imageUrl = asset(
                    'storage/' . ltrim($imagePath, '/')
                );
            }
        }
    @endphp

    <div class="container-fluid category-detail-page">
        <div class="category-detail-top">
            <div class="category-detail-heading">
                <span class="category-detail-page-icon">
                    <i class="fas fa-folder-open"></i>
                </span>

                <div>
                    <h3>Chi tiết danh mục</h3>

                    <p>
                        Xem thông tin, hình ảnh và trạng thái của danh mục.
                    </p>
                </div>
            </div>

            <a
                href="{{ route('Admin.danh_mucs.index') }}"
                class="btn-back-category"
            >
                <i class="fas fa-arrow-left"></i>
                Quay lại danh sách
            </a>
        </div>

        <div class="category-detail-card">
            <div class="category-detail-header">
                <div class="category-detail-header-content">
                    <span class="category-detail-header-icon">
                        <i class="fas fa-folder-open"></i>
                    </span>

                    <div>
                        <h4>{{ $danhMuc->ten_danh_muc }}</h4>

                        <p>
                            Thông tin chi tiết của danh mục đang được chọn.
                        </p>
                    </div>
                </div>

                <div class="category-detail-code">
                    Danh mục #{{ $danhMuc->id }}
                </div>
            </div>

            <div class="category-detail-body">
                <div class="category-detail-grid">
                    <div class="category-image-panel">
                        <div class="category-panel-heading">
                            <i class="fas fa-image"></i>
                            Hình ảnh danh mục
                        </div>

                        <div class="category-image-content">
                            <div class="category-image-frame">
                                @if ($imageUrl)
                                    <img
                                        src="{{ $imageUrl }}"
                                        alt="{{ $danhMuc->ten_danh_muc }}"
                                        class="category-main-image"
                                        id="category_main_image"
                                        onerror="
                                            this.style.display = 'none';
                                            document.getElementById('category_image_error').style.display = 'flex';
                                        "
                                    >

                                    <div
                                        class="category-image-placeholder"
                                        id="category_image_error"
                                        style="display: none;"
                                    >
                                        <i class="fas fa-image"></i>
                                        <span>Không tải được hình ảnh</span>
                                    </div>
                                @else
                                    <div class="category-image-placeholder">
                                        <i class="fas fa-image"></i>
                                        <span>Danh mục chưa có hình ảnh</span>
                                    </div>
                                @endif
                            </div>

                            @if ($imagePath !== '')
                                <div class="category-image-path">
                                    <i class="fas fa-link"></i>
                                    {{ $imagePath }}
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="category-info-panel">
                        <div class="category-panel-heading">
                            <i class="fas fa-info-circle"></i>
                            Thông tin danh mục
                        </div>

                        <div class="category-info-content">
                            <div class="category-info-item">
                                <div class="category-info-label">
                                    <i class="fas fa-folder"></i>
                                    Tên danh mục
                                </div>

                                <div class="category-name-value">
                                    {{ $danhMuc->ten_danh_muc }}
                                </div>
                            </div>

                            <div class="category-info-item">
                                <div class="category-info-label">
                                    <i class="fas fa-align-left"></i>
                                    Mô tả
                                </div>

                                @if ($danhMuc->mo_ta)
                                    <p class="category-description-value">
                                        {{ $danhMuc->mo_ta }}
                                    </p>
                                @else
                                    <span class="category-empty-value">
                                        Không có mô tả
                                    </span>
                                @endif
                            </div>

                            <div class="category-info-item">
                                <div class="category-info-label">
                                    <i class="fas fa-check-circle"></i>
                                    Trạng thái
                                </div>

                                @if ($danhMuc->trang_thai === 'active')
                                    <span class="category-status category-status-active">
                                        <span class="category-status-dot"></span>
                                        Đang hoạt động
                                    </span>
                                @else
                                    <span class="category-status category-status-inactive">
                                        <span class="category-status-dot"></span>
                                        Ngừng hoạt động
                                    </span>
                                @endif
                            </div>

                            @if ($danhMuc->created_at)
                                <div class="category-info-item">
                                    <div class="category-info-label">
                                        <i class="fas fa-calendar-plus"></i>
                                        Ngày tạo
                                    </div>

                                    <span class="category-date-value">
                                        <i class="fas fa-clock"></i>

                                        {{ $danhMuc->created_at->format('d/m/Y H:i') }}
                                    </span>
                                </div>
                            @endif

                            @if ($danhMuc->updated_at)
                                <div class="category-info-item">
                                    <div class="category-info-label">
                                        <i class="fas fa-calendar-alt"></i>
                                        Cập nhật gần nhất
                                    </div>

                                    <span class="category-date-value">
                                        <i class="fas fa-clock"></i>

                                        {{ $danhMuc->updated_at->format('d/m/Y H:i') }}
                                    </span>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="category-detail-actions">
                    <a
                        href="{{ route('Admin.danh_mucs.index') }}"
                        class="btn-category-action btn-category-list"
                    >
                        <i class="fas fa-arrow-left"></i>
                        Quay lại
                    </a>

                    <a
                        href="{{ route('Admin.danh_mucs.edit', $danhMuc) }}"
                        class="btn-category-action btn-category-edit"
                    >
                        <i class="fas fa-edit"></i>
                        Chỉnh sửa danh mục
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
