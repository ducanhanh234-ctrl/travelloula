@extends('layouts.admin')

@section('content')
    @php
        $currentUser = auth()->user();
    @endphp

    <style>
        :root {
            --primary: #315be8;
            --primary-dark: #244bd2;
            --primary-light: #edf4ff;
            --primary-border: #c9dcff;

            --purple: #5b4dea;
            --cyan: #16c7e8;

            --text-dark: #172b4d;
            --text-main: #344563;
            --text-muted: #6b7895;
            --text-light: #98a2b3;

            --border: #dce6f5;
            --border-light: #e8eef8;

            --white: #ffffff;

            --success: #149963;
            --success-light: #eaf9f1;

            --danger: #dc4c64;
            --danger-light: #fff0f3;
        }

        .permission-detail-page {
            padding: 24px 0;
            color: var(--text-dark);
        }

        /* Tiêu đề phía trên */
        .detail-page-top {
            width: 100%;
            max-width: 920px;
            margin: 0 auto 18px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
        }

        .page-heading h3 {
            margin: 0;
            color: #173576;
            font-size: 23px;
            font-weight: 750;
            letter-spacing: -0.2px;
        }

        .page-heading p {
            margin: 6px 0 0;
            color: var(--text-muted);
            font-size: 14px;
        }

        .btn-back-top {
            min-height: 39px;
            padding: 8px 14px;
            color: #2c57d1;
            background: var(--primary-light);
            border: 1px solid #cbdcff;
            border-radius: 8px;
            font-size: 13px;
            font-weight: 650;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 7px;
            transition: all 0.18s ease;
        }

        .btn-back-top:hover {
            color: #1f46bd;
            background: #dfeaff;
            border-color: #a9c5ff;
            text-decoration: none;
            transform: translateY(-1px);
            box-shadow: 0 5px 14px rgba(49, 91, 232, 0.12);
        }

        /* Card */
        .detail-card {
            position: relative;
            width: 100%;
            max-width: 920px;
            margin: 0 auto;
            overflow: hidden;
            background: var(--white);
            border: 1px solid #d8e4f6;
            border-radius: 15px;
            box-shadow: 0 10px 32px rgba(28, 65, 139, 0.11);
        }

        .detail-card::before {
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

        /* Header */
        .detail-header {
            position: relative;
            min-height: 145px;
            padding: 30px;
            overflow: hidden;
            color: var(--white);
            background: linear-gradient(
                120deg,
                #2856df 0%,
                #316cec 55%,
                #5b49e8 100%
            );
            display: flex;
            align-items: center;
        }

        .detail-header::before {
            position: absolute;
            right: -55px;
            bottom: -105px;
            width: 250px;
            height: 250px;
            content: "";
            border: 22px solid rgba(255, 255, 255, 0.07);
            border-radius: 50%;
        }

        .detail-header::after {
            position: absolute;
            top: -90px;
            right: 110px;
            width: 180px;
            height: 180px;
            content: "";
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.045);
        }

        .detail-header-content {
            position: relative;
            z-index: 2;
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .detail-header-icon {
            width: 54px;
            height: 54px;
            flex-shrink: 0;
            color: var(--white);
            background: rgba(255, 255, 255, 0.16);
            border: 1px solid rgba(255, 255, 255, 0.3);
            border-radius: 14px;
            box-shadow: 0 7px 18px rgba(20, 43, 128, 0.2);
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .detail-header-icon i {
            font-size: 21px;
        }

        .detail-header h3 {
            margin: 0;
            color: var(--white);
            font-size: 23px;
            font-weight: 750;
        }

        .detail-header p {
            margin: 7px 0 0;
            color: rgba(255, 255, 255, 0.84);
            font-size: 13px;
            line-height: 1.5;
        }

        /* Nội dung */
        .detail-body {
            padding: 30px;
            background: var(--white);
        }

        .detail-section-title {
            margin-bottom: 20px;
            color: #24417d;
            font-size: 14px;
            font-weight: 750;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .detail-section-title::before {
            width: 4px;
            height: 18px;
            content: "";
            border-radius: 999px;
            background: linear-gradient(
                180deg,
                #315be8,
                #5b4dea
            );
        }

        /* Danh sách thông tin */
        .detail-list {
            margin: 0;
            overflow: hidden;
            border: 1px solid #dce6f5;
            border-radius: 11px;
            background: #ffffff;
        }

        .detail-row {
            min-height: 67px;
            border-bottom: 1px solid var(--border-light);
            display: grid;
            grid-template-columns: 210px 1fr;
        }

        .detail-row:last-child {
            border-bottom: none;
        }

        .detail-label {
            margin: 0;
            padding: 18px 20px;
            color: #29457d;
            background: #f3f7ff;
            border-right: 1px solid #dce6f5;
            font-size: 13px;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 9px;
        }

        .detail-label i {
            width: 18px;
            color: #426ce0;
            font-size: 13px;
            text-align: center;
        }

        .detail-value {
            margin: 0;
            min-width: 0;
            padding: 18px 20px;
            color: #4d5d7d;
            font-size: 14px;
            line-height: 1.6;
            display: flex;
            align-items: center;
        }

        /* Tên kỹ thuật */
        .permission-code {
            display: inline-block;
            max-width: 100%;
            padding: 5px 10px;
            overflow-wrap: anywhere;
            color: #2d59cf;
            background: #edf4ff;
            border: 1px solid #cee0ff;
            border-radius: 7px;
            font-family: Consolas, Monaco, monospace;
            font-size: 12px;
            font-weight: 650;
        }

        .display-name {
            color: #223d73;
            font-size: 15px;
            font-weight: 700;
        }

        /* Module */
        .module-badge {
            display: inline-flex;
            padding: 5px 11px;
            color: #2555cc;
            background: #eaf2ff;
            border: 1px solid #bed5ff;
            border-radius: 999px;
            font-size: 12px;
            font-weight: 700;
            align-items: center;
            gap: 6px;
        }

        .module-badge i {
            font-size: 10px;
        }

        .description-text {
            color: #65738e;
            white-space: pre-line;
        }

        .empty-value {
            color: var(--text-light);
            font-style: italic;
        }

        /* Trạng thái */
        .status-badge {
            display: inline-flex;
            padding: 6px 11px;
            border: 1px solid transparent;
            border-radius: 999px;
            font-size: 12px;
            font-weight: 700;
            align-items: center;
            gap: 6px;
        }

        .status-badge i {
            font-size: 9px;
        }

        .status-active {
            color: #08754a;
            background: var(--success-light);
            border-color: #c5ead8;
        }

        .status-inactive {
            color: #b33b50;
            background: var(--danger-light);
            border-color: #f1cbd3;
        }

        /* Nút */
        .detail-actions {
            margin-top: 28px;
            padding-top: 23px;
            border-top: 1px solid var(--border-light);
            display: flex;
            align-items: center;
            justify-content: flex-end;
            gap: 10px;
        }

        .btn-detail {
            min-width: 125px;
            min-height: 42px;
            padding: 9px 18px;
            border: 1px solid transparent;
            border-radius: 9px;
            font-size: 13px;
            font-weight: 700;
            cursor: pointer;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 7px;
            transition: all 0.18s ease;
        }

        .btn-detail:hover {
            text-decoration: none;
            transform: translateY(-1px);
        }

        .btn-edit-permission {
            color: var(--white);
            background: linear-gradient(
                135deg,
                #315be8 0%,
                #3b6dee 55%,
                #594bea 100%
            );
            border-color: #315be8;
            box-shadow: 0 6px 16px rgba(49, 91, 232, 0.24);
        }

        .btn-edit-permission:hover {
            color: var(--white);
            background: linear-gradient(
                135deg,
                #264ed4 0%,
                #315edc 55%,
                #4d40d8 100%
            );
            border-color: #264ed4;
            box-shadow: 0 8px 19px rgba(49, 91, 232, 0.3);
        }

        .btn-back {
            color: #53698f;
            background: #f2f6fc;
            border-color: #d4dfef;
        }

        .btn-back:hover {
            color: #304d83;
            background: #e7eef9;
            border-color: #bdcce3;
            box-shadow: 0 5px 13px rgba(41, 73, 132, 0.1);
        }

        /* Responsive */
        @media (max-width: 768px) {
            .permission-detail-page {
                padding: 15px 0;
            }

            .detail-page-top {
                align-items: stretch;
                flex-direction: column;
            }

            .btn-back-top {
                width: 100%;
            }

            .detail-card {
                border-radius: 11px;
            }

            .detail-header {
                min-height: 125px;
                padding: 23px 20px;
            }

            .detail-header h3 {
                font-size: 21px;
            }

            .detail-body {
                padding: 22px 18px;
            }

            .detail-row {
                grid-template-columns: 1fr;
            }

            .detail-label {
                min-height: auto;
                padding: 12px 15px;
                border-right: none;
                border-bottom: 1px solid #dce6f5;
            }

            .detail-value {
                min-height: 52px;
                padding: 14px 15px;
            }

            .detail-actions {
                align-items: stretch;
                flex-direction: column-reverse;
            }

            .btn-detail {
                width: 100%;
            }
        }

        @media (max-width: 480px) {
            .page-heading h3 {
                font-size: 20px;
            }

            .detail-header-content {
                align-items: flex-start;
            }

            .detail-header-icon {
                width: 46px;
                height: 46px;
            }

            .detail-header p {
                font-size: 12px;
            }
        }
    </style>

    <div class="container-fluid permission-detail-page">
        <div class="detail-page-top">
            <div class="page-heading">
                <h3>Chi tiết quyền hạn</h3>

                <p>
                    Xem thông tin và trạng thái hoạt động của quyền hạn.
                </p>
            </div>

            <a
                href="{{ route('Admin.quyen-hans.index') }}"
                class="btn-back-top"
            >
                <i class="fas fa-arrow-left"></i>
                Quay lại danh sách
            </a>
        </div>

        <div class="card detail-card">
            <div class="detail-header">
                <div class="detail-header-content">
                    <span class="detail-header-icon">
                        <i class="fas fa-key"></i>
                    </span>

                    <div>
                        <h3>{{ $quyenHan->ten_hien_thi }}</h3>

                        <p>
                            Thông tin chi tiết quyền hạn
                            <strong>{{ $quyenHan->ten }}</strong>.
                        </p>
                    </div>
                </div>
            </div>

            <div class="detail-body">
                <div class="detail-section-title">
                    Thông tin quyền hạn
                </div>

                <dl class="detail-list">
                    <div class="detail-row">
                        <dt class="detail-label">
                            <i class="fas fa-code"></i>
                            Tên kỹ thuật
                        </dt>

                        <dd class="detail-value">
                            <code class="permission-code">
                                {{ $quyenHan->ten }}
                            </code>
                        </dd>
                    </div>

                    <div class="detail-row">
                        <dt class="detail-label">
                            <i class="fas fa-font"></i>
                            Tên hiển thị
                        </dt>

                        <dd class="detail-value">
                            <span class="display-name">
                                {{ $quyenHan->ten_hien_thi }}
                            </span>
                        </dd>
                    </div>

                    <div class="detail-row">
                        <dt class="detail-label">
                            <i class="fas fa-layer-group"></i>
                            Mô đun
                        </dt>

                        <dd class="detail-value">
                            @if ($quyenHan->mo_dun)
                                <span class="module-badge">
                                    <i class="fas fa-folder"></i>
                                    {{ $quyenHan->mo_dun }}
                                </span>
                            @else
                                <span class="empty-value">
                                    Chưa xác định mô đun
                                </span>
                            @endif
                        </dd>
                    </div>

                    <div class="detail-row">
                        <dt class="detail-label">
                            <i class="fas fa-align-left"></i>
                            Mô tả
                        </dt>

                        <dd class="detail-value">
                            @if ($quyenHan->mo_ta)
                                <span class="description-text">
                                    {{ $quyenHan->mo_ta }}
                                </span>
                            @else
                                <span class="empty-value">
                                    Chưa có mô tả
                                </span>
                            @endif
                        </dd>
                    </div>

                    <div class="detail-row">
                        <dt class="detail-label">
                            <i class="fas fa-toggle-on"></i>
                            Trạng thái
                        </dt>

                        <dd class="detail-value">
                            @if ($quyenHan->trang_thai)
                                <span class="status-badge status-active">
                                    <i class="fas fa-circle"></i>
                                    Đang kích hoạt
                                </span>
                            @else
                                <span class="status-badge status-inactive">
                                    <i class="fas fa-circle"></i>
                                    Không kích hoạt
                                </span>
                            @endif
                        </dd>
                    </div>
                </dl>

                <div class="detail-actions">
                    <a
                        href="{{ route('Admin.quyen-hans.index') }}"
                        class="btn-detail btn-back"
                    >
                        <i class="fas fa-arrow-left"></i>
                        Quay lại
                    </a>

                    @if ($currentUser && $currentUser->hasPermission('permissions.edit'))
                        <a
                            href="{{ route('Admin.quyen-hans.edit', $quyenHan->id) }}"
                            class="btn-detail btn-edit-permission"
                        >
                            <i class="fas fa-pen-to-square"></i>
                            Chỉnh sửa
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
