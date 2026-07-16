@extends('layouts.admin')

@section('title', 'Quản lý Danh Mục')

@section('content')
    <style>
        :root {
            --category-primary: #315be8;
            --category-primary-light: #edf4ff;
            --category-purple: #5b4dea;

            --category-text-dark: #172b4d;
            --category-text-main: #344563;
            --category-text-muted: #6b7895;
            --category-text-light: #98a2b3;

            --category-border: #dce6f5;
            --category-border-light: #e8eef8;

            --category-white: #ffffff;
            --category-soft: #f5f8ff;
            --category-hover: #f3f7ff;

            --category-success: #08754a;
            --category-success-bg: #eaf9f1;

            --category-warning: #ae6c0d;
            --category-warning-bg: #fff7e8;

            --category-danger: #c13d55;
            --category-danger-bg: #fff0f3;
        }

        .category-page {
            padding: 24px 0;
            color: var(--category-text-dark);
        }

        /* Header trang */
        .category-page-top {
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            flex-wrap: wrap;
        }

        .category-page-heading {
            min-width: 0;
            display: flex;
            align-items: center;
            gap: 13px;
        }

        .category-page-icon {
            width: 47px;
            height: 47px;
            flex-shrink: 0;
            color: var(--category-primary);
            background: var(--category-primary-light);
            border: 1px solid #cfe0ff;
            border-radius: 12px;
            font-size: 18px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .category-page-heading h3 {
            margin: 0;
            color: #173576;
            font-size: 23px;
            font-weight: 750;
        }

        .category-page-heading p {
            margin: 6px 0 0;
            color: var(--category-text-muted);
            font-size: 14px;
        }

        .btn-add-category {
            min-height: 41px;
            padding: 9px 16px;
            color: var(--category-white);
            background: linear-gradient(
                135deg,
                #315be8 0%,
                #3c6df0 55%,
                #594bea 100%
            );
            border: 1px solid #315be8;
            border-radius: 9px;
            box-shadow: 0 6px 16px rgba(49, 91, 232, 0.23);
            font-size: 13px;
            font-weight: 700;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 7px;
            transition: all 0.18s ease;
        }

        .btn-add-category:hover {
            color: var(--category-white);
            background: linear-gradient(
                135deg,
                #264ed4,
                #4d40d8
            );
            border-color: #264ed4;
            text-decoration: none;
            transform: translateY(-1px);
        }

        /* Thông báo */
        .category-alert {
            margin-bottom: 18px;
            padding: 14px 16px;
            border: 1px solid transparent;
            border-radius: 10px;
            font-size: 13px;
            font-weight: 650;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .category-alert-success {
            color: var(--category-success);
            background: var(--category-success-bg);
            border-color: #bfead3;
        }

        .category-alert-danger {
            color: var(--category-danger);
            background: var(--category-danger-bg);
            border-color: #f0c9d1;
        }

        /* Card */
        .category-card {
            position: relative;
            overflow: hidden;
            background: var(--category-white);
            border: 1px solid #d8e4f6;
            border-radius: 15px;
            box-shadow: 0 8px 30px rgba(28, 65, 139, 0.1);
        }

        .category-card::before {
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

        .category-card-header {
            position: relative;
            min-height: 115px;
            padding: 24px;
            overflow: hidden;
            color: var(--category-white);
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

        .category-card-header::before {
            position: absolute;
            right: -50px;
            bottom: -105px;
            width: 235px;
            height: 235px;
            content: "";
            border: 21px solid rgba(255, 255, 255, 0.07);
            border-radius: 50%;
        }

        .category-card-header::after {
            position: absolute;
            top: -85px;
            right: 115px;
            width: 175px;
            height: 175px;
            content: "";
            background: rgba(255, 255, 255, 0.045);
            border-radius: 50%;
        }

        .category-card-heading {
            position: relative;
            z-index: 2;
            min-width: 0;
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .category-card-icon {
            width: 46px;
            height: 46px;
            flex-shrink: 0;
            color: var(--category-white);
            background: rgba(255, 255, 255, 0.16);
            border: 1px solid rgba(255, 255, 255, 0.3);
            border-radius: 12px;
            font-size: 18px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .category-card-heading h4 {
            margin: 0;
            color: var(--category-white);
            font-size: 20px;
            font-weight: 750;
        }

        .category-card-heading p {
            margin: 6px 0 0;
            color: rgba(255, 255, 255, 0.82);
            font-size: 12px;
        }

        .category-total {
            position: relative;
            z-index: 2;
            min-width: 105px;
            padding: 12px 15px;
            color: var(--category-white);
            background: rgba(255, 255, 255, 0.14);
            border: 1px solid rgba(255, 255, 255, 0.25);
            border-radius: 11px;
            text-align: center;
        }

        .category-total strong {
            display: block;
            font-size: 22px;
            line-height: 1;
        }

        .category-total span {
            display: block;
            margin-top: 5px;
            font-size: 10px;
            opacity: 0.85;
        }

        .category-card-body {
            padding: 22px;
        }

        /* Bộ lọc */
        .category-filter-box {
            margin-bottom: 20px;
            padding: 16px;
            background: var(--category-soft);
            border: 1px solid #d8e4f6;
            border-radius: 11px;
        }

        .category-filter-title {
            margin-bottom: 13px;
            color: #29457d;
            font-size: 13px;
            font-weight: 750;
            display: flex;
            align-items: center;
            gap: 7px;
        }

        .category-filter-form {
            display: grid;
            grid-template-columns: minmax(280px, 1fr) auto auto;
            gap: 10px;
            align-items: end;
        }

        .category-filter-field label {
            margin-bottom: 6px;
            color: #40537a;
            font-size: 12px;
            font-weight: 700;
            display: block;
        }

        .category-filter-control {
            position: relative;
        }

        .category-filter-icon {
            position: absolute;
            top: 50%;
            left: 12px;
            z-index: 2;
            color: #7686a5;
            font-size: 12px;
            pointer-events: none;
            transform: translateY(-50%);
        }

        .category-filter-form .form-control {
            width: 100%;
            min-height: 40px;
            padding-left: 34px;
            color: var(--category-text-main);
            background: var(--category-white);
            border: 1px solid #ccd9ed;
            border-radius: 8px;
            font-size: 13px;
            box-shadow: none;
        }

        .category-filter-form .form-control:focus {
            border-color: #4f78eb;
            outline: none;
            box-shadow: 0 0 0 3px rgba(49, 91, 232, 0.1);
        }

        .btn-filter-action {
            min-height: 40px;
            padding: 8px 14px;
            border: 1px solid transparent;
            border-radius: 8px;
            font-size: 12px;
            font-weight: 700;
            cursor: pointer;
            text-decoration: none;
            white-space: nowrap;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            transition: all 0.18s ease;
        }

        .btn-filter-action:hover {
            text-decoration: none;
            transform: translateY(-1px);
        }

        .btn-search-category {
            color: var(--category-white);
            background: linear-gradient(
                135deg,
                #315be8,
                #584be8
            );
            border-color: #315be8;
        }

        .btn-search-category:hover {
            color: var(--category-white);
            background: linear-gradient(
                135deg,
                #264ed4,
                #4c40d7
            );
        }

        .btn-reset-category {
            color: #53698f;
            background: var(--category-white);
            border-color: #ccd9ed;
        }

        .btn-reset-category:hover {
            color: #304d83;
            background: #eaf1fb;
            border-color: #b9c9e0;
        }

        /* Bảng */
        .category-table-wrapper {
            width: 100%;
            overflow-x: auto;
            border: 1px solid var(--category-border);
            border-radius: 11px;
        }

        .category-table {
            width: 100%;
            min-width: 1080px;
            margin-bottom: 0;
            vertical-align: middle;
        }

        .category-table thead th {
            padding: 14px;
            color: #24417d;
            background: #f1f6ff;
            border-top: none;
            border-bottom: 1px solid #d8e5f8;
            font-size: 10px;
            font-weight: 750;
            letter-spacing: 0.025em;
            text-transform: uppercase;
            white-space: nowrap;
        }

        .category-table tbody td {
            padding: 14px;
            color: #4d5d7d;
            border-bottom: 1px solid var(--category-border-light);
            font-size: 12px;
            line-height: 1.6;
            vertical-align: middle;
        }

        .category-table tbody tr:last-child td {
            border-bottom: none;
        }

        .category-table tbody tr:hover {
            background: var(--category-hover);
            box-shadow: inset 3px 0 0 #3a67ea;
        }

        .category-table th:nth-child(1),
        .category-table td:nth-child(1) {
            width: 70px;
            text-align: center;
        }

        .category-table th:nth-child(2),
        .category-table td:nth-child(2) {
            width: 225px;
        }

        .category-table th:nth-child(3),
        .category-table td:nth-child(3) {
            width: 125px;
            text-align: center;
        }

        .category-table th:nth-child(4),
        .category-table td:nth-child(4) {
            min-width: 280px;
        }

        .category-table th:nth-child(5),
        .category-table td:nth-child(5) {
            width: 145px;
            text-align: center;
        }

        .category-table th:nth-child(6),
        .category-table td:nth-child(6) {
            width: 125px;
            text-align: center;
        }

        .category-id {
            min-width: 34px;
            height: 30px;
            padding: 0 8px;
            color: #3158ce;
            background: #edf3ff;
            border: 1px solid #d4e2ff;
            border-radius: 8px;
            font-size: 10px;
            font-weight: 750;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        /* Tên danh mục */
        .category-name-wrap {
            display: flex;
            align-items: center;
            gap: 9px;
        }

        .category-folder-icon {
            width: 35px;
            height: 35px;
            flex-shrink: 0;
            color: var(--category-primary);
            background: var(--category-primary-light);
            border: 1px solid #cfe0ff;
            border-radius: 9px;
            font-size: 12px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .category-name {
            max-width: 175px;
            overflow: hidden;
            color: #233f7a;
            font-size: 12px;
            font-weight: 750;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .category-code {
            margin-top: 3px;
            color: #8b97aa;
            font-size: 9px;
        }

        /* Ảnh danh mục */
        .category-image-box {
            width: 82px;
            height: 58px;
            margin: 0 auto;
            overflow: hidden;
            background: #f4f7fc;
            border: 1px solid #dce6f5;
            border-radius: 9px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .category-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }

        .category-image-empty {
            width: 100%;
            height: 100%;
            color: #8797b3;
            background: #f4f7fc;
            font-size: 17px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* Mô tả */
        .category-description {
            max-width: 430px;
            color: #596984;
            line-height: 1.7;
            overflow-wrap: anywhere;
        }

        .empty-value {
            color: var(--category-text-light);
            font-size: 10px;
            font-style: italic;
        }

        /* Trạng thái */
        .category-status {
            padding: 5px 10px;
            border: 1px solid transparent;
            border-radius: 999px;
            font-size: 9px;
            font-weight: 750;
            white-space: nowrap;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 5px;
        }

        .status-dot {
            width: 6px;
            height: 6px;
            flex-shrink: 0;
            border-radius: 50%;
            background: currentColor;
        }

        .status-active {
            color: var(--category-success);
            background: var(--category-success-bg);
            border-color: #c5ead8;
        }

        .status-hidden {
            color: var(--category-danger);
            background: var(--category-danger-bg);
            border-color: #f0c9d1;
        }

        /* Thao tác */
        .category-actions {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 5px;
        }

        .category-actions form {
            margin: 0;
            display: inline-flex;
        }

        .btn-table-action {
            width: 30px;
            height: 30px;
            padding: 0;
            border: 1px solid transparent;
            border-radius: 7px;
            font-size: 11px;
            cursor: pointer;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            transition: all 0.16s ease;
        }

        .btn-table-action:hover {
            text-decoration: none;
            transform: translateY(-2px);
        }

        .btn-view-category {
            color: #2d5fd7;
            background: #eaf2ff;
            border-color: #c7dafe;
        }

        .btn-view-category:hover {
            color: var(--category-white);
            background: #3867e5;
            border-color: #3867e5;
        }

        .btn-edit-category {
            color: var(--category-warning);
            background: var(--category-warning-bg);
            border-color: #f1dba9;
        }

        .btn-edit-category:hover {
            color: var(--category-white);
            background: #e39a25;
            border-color: #e39a25;
        }

        .btn-delete-category {
            color: var(--category-danger);
            background: var(--category-danger-bg);
            border-color: #f0c9d1;
        }

        .btn-delete-category:hover {
            color: var(--category-white);
            background: #df5067;
            border-color: #df5067;
        }

        /* Empty */
        .category-empty-row {
            padding: 52px 20px !important;
            color: #8793aa !important;
            text-align: center !important;
        }

        .empty-state-icon {
            width: 52px;
            height: 52px;
            margin: 0 auto 12px;
            color: #3664dd;
            background: #edf3ff;
            border: 1px solid #d3e1ff;
            border-radius: 13px;
            font-size: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .empty-state-title {
            color: #506181;
            font-size: 14px;
            font-weight: 700;
        }

        .empty-state-text {
            margin-top: 4px;
            font-size: 12px;
        }

        /* Footer */
        .category-card-footer {
            padding: 16px 22px;
            background: #fafcff;
            border-top: 1px solid var(--category-border);
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
        }

        .category-result-info {
            color: var(--category-text-muted);
            font-size: 11px;
        }

        .category-card-footer .pagination {
            margin: 0;
        }

        @media (max-width: 768px) {
            .category-page {
                padding: 14px 0;
            }

            .category-page-top {
                align-items: stretch;
                flex-direction: column;
            }

            .btn-add-category {
                width: 100%;
            }

            .category-card-header {
                padding: 20px 18px;
            }

            .category-card-body {
                padding: 16px;
            }

            .category-filter-form {
                grid-template-columns: 1fr;
            }

            .btn-filter-action {
                width: 100%;
            }

            .category-card-footer {
                align-items: stretch;
                flex-direction: column;
            }

            .category-result-info {
                text-align: center;
            }
        }

        @media (max-width: 520px) {
            .category-card-header {
                align-items: flex-start;
                flex-direction: column;
            }
        }
    </style>

    <div class="container-fluid category-page">
        <div class="category-page-top">
            <div class="category-page-heading">
                <span class="category-page-icon">
                    <i class="fas fa-folder-open"></i>
                </span>

                <div>
                    <h3>Quản lý danh mục</h3>

                    <p>
                        Quản lý các nhóm Tour và trạng thái hiển thị trong hệ thống.
                    </p>
                </div>
            </div>

            <a
                href="{{ route('Admin.danh_mucs.create') }}"
                class="btn-add-category"
            >
                <i class="fas fa-plus"></i>
                Thêm danh mục
            </a>
        </div>

        @if (session('success'))
            <div class="category-alert category-alert-success">
                <i class="fas fa-check-circle"></i>
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="category-alert category-alert-danger">
                <i class="fas fa-exclamation-circle"></i>
                {{ session('error') }}
            </div>
        @endif

        <div class="category-card">
            <div class="category-card-header">
                <div class="category-card-heading">
                    <span class="category-card-icon">
                        <i class="fas fa-folder-open"></i>
                    </span>

                    <div>
                        <h4>Danh sách danh mục</h4>

                        <p>
                            Theo dõi hình ảnh, tên, mô tả và trạng thái danh mục.
                        </p>
                    </div>
                </div>

                <div class="category-total">
                    <strong>{{ $danhMucs->total() }}</strong>
                    <span>Danh mục</span>
                </div>
            </div>

            <div class="category-card-body">
                <div class="category-filter-box">
                    <div class="category-filter-title">
                        <i class="fas fa-filter"></i>
                        Bộ lọc tìm kiếm
                    </div>

                    <form
                        method="GET"
                        action="{{ route('Admin.danh_mucs.index') }}"
                        class="category-filter-form"
                    >
                        <div class="category-filter-field">
                            <label for="keyword">
                                Tìm kiếm danh mục
                            </label>

                            <div class="category-filter-control">
                                <i class="fas fa-search category-filter-icon"></i>

                                <input
                                    type="text"
                                    name="keyword"
                                    id="keyword"
                                    value="{{ request('keyword', $keyword ?? '') }}"
                                    class="form-control"
                                    placeholder="Nhập tên hoặc mô tả danh mục..."
                                    autocomplete="off"
                                >
                            </div>
                        </div>

                        <button
                            type="submit"
                            class="btn-filter-action btn-search-category"
                        >
                            <i class="fas fa-search"></i>
                            Tìm kiếm
                        </button>

                        <a
                            href="{{ route('Admin.danh_mucs.index') }}"
                            class="btn-filter-action btn-reset-category"
                        >
                            <i class="fas fa-redo-alt"></i>
                            Đặt lại
                        </a>
                    </form>
                </div>

                <div class="category-table-wrapper">
                    <table class="table category-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Tên danh mục</th>
                                <th>Hình ảnh</th>
                                <th>Mô tả</th>
                                <th>Trạng thái</th>
                                <th>Thao tác</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse ($danhMucs as $item)
                                @php
                                    $imagePath = trim((string) $item->hinh_anh);
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
                                            $imageUrl = asset(
                                                ltrim($imagePath, '/')
                                            );
                                        } else {
                                            $imageUrl = asset(
                                                'storage/' .
                                                ltrim($imagePath, '/')
                                            );
                                        }
                                    }
                                @endphp

                                <tr>
                                    <td>
                                        <span class="category-id">
                                            #{{ $item->id }}
                                        </span>
                                    </td>

                                    <td>
                                        <div class="category-name-wrap">
                                            <span class="category-folder-icon">
                                                <i class="fas fa-folder"></i>
                                            </span>

                                            <div>
                                                <div
                                                    class="category-name"
                                                    title="{{ $item->ten_danh_muc }}"
                                                >
                                                    {{ $item->ten_danh_muc }}
                                                </div>

                                                <div class="category-code">
                                                    Danh mục #{{ $item->id }}
                                                </div>
                                            </div>
                                        </div>
                                    </td>

                                    <td>
                                        <div class="category-image-box">
                                            @if ($imageUrl)
                                                <img
                                                    src="{{ $imageUrl }}"
                                                    alt="{{ $item->ten_danh_muc }}"
                                                    class="category-image"
                                                    loading="lazy"
                                                    onerror="
                                                        this.style.display='none';
                                                        this.nextElementSibling.style.display='flex';
                                                    "
                                                >

                                                <span
                                                    class="category-image-empty"
                                                    style="display: none;"
                                                    title="Không tải được hình ảnh"
                                                >
                                                    <i class="fas fa-image"></i>
                                                </span>
                                            @else
                                                <span
                                                    class="category-image-empty"
                                                    title="Chưa có hình ảnh"
                                                >
                                                    <i class="fas fa-image"></i>
                                                </span>
                                            @endif
                                        </div>
                                    </td>

                                    <td>
                                        @if ($item->mo_ta)
                                            <div class="category-description">
                                                {{ $item->mo_ta }}
                                            </div>
                                        @else
                                            <span class="empty-value">
                                                Không có mô tả
                                            </span>
                                        @endif
                                    </td>

                                    <td>
                                        @if ($item->trang_thai === 'active')
                                            <span class="category-status status-active">
                                                <span class="status-dot"></span>
                                                Hoạt động
                                            </span>
                                        @else
                                            <span class="category-status status-hidden">
                                                <span class="status-dot"></span>
                                                Đang ẩn
                                            </span>
                                        @endif
                                    </td>

                                    <td>
                                        <div class="category-actions">
                                            <a
                                                href="{{ route('Admin.danh_mucs.show', $item) }}"
                                                class="btn-table-action btn-view-category"
                                                title="Xem chi tiết"
                                            >
                                                <i class="fas fa-eye"></i>
                                            </a>

                                            <a
                                                href="{{ route('Admin.danh_mucs.edit', $item) }}"
                                                class="btn-table-action btn-edit-category"
                                                title="Chỉnh sửa danh mục"
                                            >
                                                <i class="fas fa-edit"></i>
                                            </a>

                                            <form
                                                method="POST"
                                                action="{{ route('Admin.danh_mucs.destroy', $item) }}"
                                                onsubmit="return confirm('Bạn có chắc muốn xóa danh mục này?');"
                                            >
                                                @csrf
                                                @method('DELETE')

                                                <button
                                                    type="submit"
                                                    class="btn-table-action btn-delete-category"
                                                    title="Xóa danh mục"
                                                >
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td
                                        colspan="6"
                                        class="category-empty-row"
                                    >
                                        <div class="empty-state-icon">
                                            <i class="fas fa-folder-open"></i>
                                        </div>

                                        <div class="empty-state-title">
                                            Chưa có danh mục
                                        </div>

                                        <div class="empty-state-text">
                                            Không tìm thấy danh mục phù hợp với điều kiện tìm kiếm.
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="category-card-footer">
                <div class="category-result-info">
                    @if ($danhMucs->total() > 0)
                        Hiển thị {{ $danhMucs->firstItem() }}
                        đến {{ $danhMucs->lastItem() }}
                        trong tổng số {{ $danhMucs->total() }} danh mục
                    @else
                        Không có danh mục nào
                    @endif
                </div>

                {{ $danhMucs->withQueryString()->links() }}
            </div>
        </div>
    </div>
@endsection
