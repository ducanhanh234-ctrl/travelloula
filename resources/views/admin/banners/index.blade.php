@extends('layouts.admin')

@section('title', 'Quản lý Banner')

@section('content')
    <style>
        :root {
            --banner-primary: #315be8;
            --banner-purple: #5b4dea;
            --banner-dark: #173576;
            --banner-text: #344563;
            --banner-muted: #6b7895;
            --banner-light: #98a2b3;
            --banner-border: #dce6f5;
            --banner-border-light: #e8eef8;
            --banner-white: #ffffff;
            --banner-soft: #f5f8ff;
            --banner-hover: #f3f7ff;
            --banner-success: #08754a;
            --banner-success-bg: #eaf9f1;
            --banner-danger: #c13d55;
            --banner-danger-bg: #fff0f3;
            --banner-warning: #ae6c0d;
            --banner-warning-bg: #fff7e8;
        }

        .banner-page {
            padding: 24px 0;
            color: var(--banner-text);
        }

        /* Header trang */
        .banner-page-top {
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            flex-wrap: wrap;
        }

        .banner-page-heading {
            min-width: 0;
            display: flex;
            align-items: center;
            gap: 13px;
        }

        .banner-page-icon {
            width: 47px;
            height: 47px;
            flex-shrink: 0;
            color: var(--banner-primary);
            background: #edf4ff;
            border: 1px solid #cfe0ff;
            border-radius: 12px;
            font-size: 18px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .banner-page-heading h3 {
            margin: 0;
            color: var(--banner-dark);
            font-size: 23px;
            font-weight: 750;
            letter-spacing: -0.2px;
        }

        .banner-page-heading p {
            margin: 6px 0 0;
            color: var(--banner-muted);
            font-size: 14px;
        }

        .btn-add-banner {
            min-height: 41px;
            padding: 9px 16px;
            color: var(--banner-white);
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

        .btn-add-banner:hover {
            color: var(--banner-white);
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
        .banner-alert {
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

        .banner-alert-success {
            color: var(--banner-success);
            background: var(--banner-success-bg);
            border-color: #bfead3;
        }

        .banner-alert-danger {
            color: var(--banner-danger);
            background: var(--banner-danger-bg);
            border-color: #f0c9d1;
        }

        /* Card */
        .banner-card {
            position: relative;
            overflow: hidden;
            background: var(--banner-white);
            border: 1px solid #d8e4f6;
            border-radius: 15px;
            box-shadow: 0 8px 30px rgba(28, 65, 139, 0.1);
        }

        .banner-card::before {
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

        .banner-card-header {
            position: relative;
            min-height: 115px;
            padding: 24px;
            overflow: hidden;
            color: var(--banner-white);
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

        .banner-card-header::before {
            position: absolute;
            right: -50px;
            bottom: -105px;
            width: 235px;
            height: 235px;
            content: "";
            border: 21px solid rgba(255, 255, 255, 0.07);
            border-radius: 50%;
        }

        .banner-card-header::after {
            position: absolute;
            top: -85px;
            right: 115px;
            width: 175px;
            height: 175px;
            content: "";
            background: rgba(255, 255, 255, 0.045);
            border-radius: 50%;
        }

        .banner-card-heading {
            position: relative;
            z-index: 2;
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .banner-card-icon {
            width: 46px;
            height: 46px;
            flex-shrink: 0;
            color: var(--banner-white);
            background: rgba(255, 255, 255, 0.16);
            border: 1px solid rgba(255, 255, 255, 0.3);
            border-radius: 12px;
            font-size: 18px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .banner-card-heading h4 {
            margin: 0;
            color: var(--banner-white);
            font-size: 20px;
            font-weight: 750;
        }

        .banner-card-heading p {
            margin: 6px 0 0;
            color: rgba(255, 255, 255, 0.82);
            font-size: 12px;
        }

        .banner-total {
            position: relative;
            z-index: 2;
            min-width: 105px;
            padding: 12px 15px;
            color: var(--banner-white);
            background: rgba(255, 255, 255, 0.14);
            border: 1px solid rgba(255, 255, 255, 0.25);
            border-radius: 11px;
            text-align: center;
        }

        .banner-total strong {
            display: block;
            font-size: 22px;
            line-height: 1;
        }

        .banner-total span {
            display: block;
            margin-top: 5px;
            font-size: 10px;
            opacity: 0.85;
        }

        .banner-card-body {
            padding: 22px;
        }

        /* Bộ lọc */
        .banner-filter-box {
            margin-bottom: 20px;
            padding: 16px;
            background: var(--banner-soft);
            border: 1px solid #d8e4f6;
            border-radius: 11px;
        }

        .banner-filter-title {
            margin-bottom: 13px;
            color: #29457d;
            font-size: 13px;
            font-weight: 750;
            display: flex;
            align-items: center;
            gap: 7px;
        }

        .banner-filter-title i {
            color: var(--banner-primary);
        }

        .banner-filter-form {
            display: grid;
            grid-template-columns: minmax(280px, 1fr) auto auto;
            gap: 10px;
            align-items: end;
        }

        .banner-filter-field label {
            margin-bottom: 6px;
            color: #40537a;
            font-size: 12px;
            font-weight: 700;
            display: block;
        }

        .banner-filter-control {
            position: relative;
        }

        .banner-filter-icon {
            position: absolute;
            top: 50%;
            left: 12px;
            z-index: 2;
            color: #7686a5;
            font-size: 12px;
            pointer-events: none;
            transform: translateY(-50%);
        }

        .banner-filter-form .form-control {
            width: 100%;
            min-height: 40px;
            padding-left: 34px;
            color: var(--banner-text);
            background: var(--banner-white);
            border: 1px solid #ccd9ed;
            border-radius: 8px;
            font-size: 13px;
            box-shadow: none;
        }

        .banner-filter-form .form-control::placeholder {
            color: #9ca8bd;
        }

        .banner-filter-form .form-control:focus {
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
            white-space: nowrap;
            cursor: pointer;
            text-decoration: none;
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

        .btn-search-banner {
            color: var(--banner-white);
            background: linear-gradient(
                135deg,
                #315be8,
                #584be8
            );
            border-color: #315be8;
        }

        .btn-search-banner:hover {
            color: var(--banner-white);
            background: linear-gradient(
                135deg,
                #264ed4,
                #4c40d7
            );
        }

        .btn-reset-banner {
            color: #53698f;
            background: var(--banner-white);
            border-color: #ccd9ed;
        }

        .btn-reset-banner:hover {
            color: #304d83;
            background: #eaf1fb;
            border-color: #b9c9e0;
        }

        /* Table */
        .banner-table-wrapper {
            width: 100%;
            overflow-x: auto;
            border: 1px solid var(--banner-border);
            border-radius: 11px;
        }

        .banner-table {
            width: 100%;
            min-width: 1050px;
            margin-bottom: 0;
            vertical-align: middle;
        }

        .banner-table thead th {
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

        .banner-table tbody td {
            padding: 14px;
            color: #4d5d7d;
            border-bottom: 1px solid var(--banner-border-light);
            font-size: 12px;
            line-height: 1.6;
            vertical-align: middle;
        }

        .banner-table tbody tr:last-child td {
            border-bottom: none;
        }

        .banner-table tbody tr:hover {
            background: var(--banner-hover);
            box-shadow: inset 3px 0 0 #3a67ea;
        }

        .banner-table th:nth-child(1),
        .banner-table td:nth-child(1) {
            width: 70px;
            text-align: center;
        }

        .banner-table th:nth-child(2),
        .banner-table td:nth-child(2) {
            width: 190px;
            text-align: center;
        }

        .banner-table th:nth-child(3),
        .banner-table td:nth-child(3) {
            min-width: 240px;
        }

        .banner-table th:nth-child(4),
        .banner-table td:nth-child(4) {
            width: 170px;
            text-align: center;
        }

        .banner-table th:nth-child(5),
        .banner-table td:nth-child(5) {
            width: 145px;
            text-align: center;
        }

        .banner-table th:nth-child(6),
        .banner-table td:nth-child(6) {
            width: 130px;
            text-align: center;
        }

        .banner-id {
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

        /* Ảnh banner */
        .banner-image-box {
            width: 150px;
            height: 76px;
            margin: 0 auto;
            overflow: hidden;
            background: #f4f7fc;
            border: 1px solid #dce6f5;
            border-radius: 9px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .banner-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }

        .banner-image-empty {
            width: 100%;
            height: 100%;
            color: #8797b3;
            background: #f4f7fc;
            font-size: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* Tiêu đề */
        .banner-title-wrap {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .banner-title-icon {
            width: 36px;
            height: 36px;
            flex-shrink: 0;
            color: var(--banner-primary);
            background: #edf4ff;
            border: 1px solid #cfe0ff;
            border-radius: 9px;
            font-size: 12px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .banner-title {
            max-width: 270px;
            color: #233f7a;
            font-size: 12px;
            font-weight: 750;
            overflow-wrap: anywhere;
        }

        .banner-code {
            margin-top: 3px;
            color: #8b97aa;
            font-size: 9px;
        }

        /* Loại banner */
        .banner-type {
            padding: 5px 10px;
            color: #405fc0;
            background: #eef3ff;
            border: 1px solid #cfddff;
            border-radius: 999px;
            font-size: 9px;
            font-weight: 750;
            white-space: nowrap;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 5px;
        }

        .banner-type i {
            font-size: 8px;
        }

        /* Trạng thái */
        .banner-status {
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

        .banner-status-dot {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: currentColor;
        }

        .banner-status-active {
            color: var(--banner-success);
            background: var(--banner-success-bg);
            border-color: #c5ead8;
        }

        .banner-status-hidden {
            color: var(--banner-danger);
            background: var(--banner-danger-bg);
            border-color: #f0c9d1;
        }

        /* Actions */
        .banner-actions {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 5px;
        }

        .banner-actions form {
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

        .btn-view-banner {
            color: #2d5fd7;
            background: #eaf2ff;
            border-color: #c7dafe;
        }

        .btn-view-banner:hover {
            color: var(--banner-white);
            background: #3867e5;
            border-color: #3867e5;
        }

        .btn-edit-banner {
            color: var(--banner-warning);
            background: var(--banner-warning-bg);
            border-color: #f1dba9;
        }

        .btn-edit-banner:hover {
            color: var(--banner-white);
            background: #e39a25;
            border-color: #e39a25;
        }

        .btn-delete-banner {
            color: var(--banner-danger);
            background: var(--banner-danger-bg);
            border-color: #f0c9d1;
        }

        .btn-delete-banner:hover {
            color: var(--banner-white);
            background: #df5067;
            border-color: #df5067;
        }

        /* Empty */
        .banner-empty-row {
            padding: 52px 20px !important;
            color: #8793aa !important;
            text-align: center !important;
        }

        .banner-empty-icon {
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

        .banner-empty-title {
            color: #506181;
            font-size: 14px;
            font-weight: 700;
        }

        .banner-empty-text {
            margin-top: 4px;
            font-size: 12px;
        }

        /* Footer */
        .banner-card-footer {
            padding: 16px 22px;
            background: #fafcff;
            border-top: 1px solid var(--banner-border);
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
        }

        .banner-result-info {
            color: var(--banner-muted);
            font-size: 11px;
        }

        .banner-card-footer .pagination {
            margin: 0;
            gap: 4px;
        }

        .banner-card-footer .page-link {
            min-width: 34px;
            height: 34px;
            padding: 6px 10px;
            color: #3158ce;
            background: var(--banner-white);
            border: 1px solid #d6e1f2;
            border-radius: 7px !important;
            font-size: 12px;
            box-shadow: none;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .banner-card-footer .page-link:hover {
            color: var(--banner-white);
            background: #416ce5;
            border-color: #416ce5;
        }

        .banner-card-footer .page-item.active .page-link {
            color: var(--banner-white);
            background: linear-gradient(
                135deg,
                #315be8,
                #584be8
            );
            border-color: #315be8;
        }

        .banner-card-footer .page-item.disabled .page-link {
            color: #aab3c5;
            background: #f8f9fc;
        }

        @media (max-width: 768px) {
            .banner-page {
                padding: 14px 0;
            }

            .banner-page-top {
                align-items: stretch;
                flex-direction: column;
            }

            .banner-page-heading h3 {
                font-size: 20px;
            }

            .btn-add-banner {
                width: 100%;
            }

            .banner-card-header {
                padding: 20px 18px;
            }

            .banner-card-body {
                padding: 16px;
            }

            .banner-filter-form {
                grid-template-columns: 1fr;
            }

            .btn-filter-action {
                width: 100%;
            }

            .banner-card-footer {
                align-items: stretch;
                flex-direction: column;
            }

            .banner-result-info {
                text-align: center;
            }
        }

        @media (max-width: 520px) {
            .banner-card-header {
                align-items: flex-start;
                flex-direction: column;
            }
        }
    </style>

    <div class="container-fluid banner-page">
        <div class="banner-page-top">
            <div class="banner-page-heading">
                <span class="banner-page-icon">
                    <i class="fas fa-images"></i>
                </span>

                <div>
                    <h3>Quản lý Banner</h3>

                    <p>
                        Quản lý hình ảnh quảng bá và trạng thái hiển thị Banner.
                    </p>
                </div>
            </div>

            <a
                href="{{ route('Admin.banners.create') }}"
                class="btn-add-banner"
            >
                <i class="fas fa-plus"></i>
                Thêm Banner
            </a>
        </div>

        @if (session('success'))
            <div class="banner-alert banner-alert-success">
                <i class="fas fa-check-circle"></i>
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="banner-alert banner-alert-danger">
                <i class="fas fa-exclamation-circle"></i>
                {{ session('error') }}
            </div>
        @endif

        <div class="banner-card">
            <div class="banner-card-header">
                <div class="banner-card-heading">
                    <span class="banner-card-icon">
                        <i class="fas fa-images"></i>
                    </span>

                    <div>
                        <h4>Danh sách Banner</h4>

                        <p>
                            Theo dõi hình ảnh, tiêu đề, loại và trạng thái Banner.
                        </p>
                    </div>
                </div>

                <div class="banner-total">
                    <strong>{{ $banners->total() }}</strong>
                    <span>Banner</span>
                </div>
            </div>

            <div class="banner-card-body">
                <div class="banner-filter-box">
                    <div class="banner-filter-title">
                        <i class="fas fa-filter"></i>
                        Bộ lọc tìm kiếm
                    </div>

                    <form
                        method="GET"
                        action="{{ route('Admin.banners.index') }}"
                        class="banner-filter-form"
                    >
                        <div class="banner-filter-field">
                            <label for="keyword">
                                Tìm kiếm Banner
                            </label>

                            <div class="banner-filter-control">
                                <i class="fas fa-search banner-filter-icon"></i>

                                <input
                                    type="text"
                                    name="keyword"
                                    id="keyword"
                                    value="{{ request('keyword', $keyword ?? '') }}"
                                    class="form-control"
                                    placeholder="Nhập tiêu đề Banner..."
                                    autocomplete="off"
                                >
                            </div>
                        </div>

                        <button
                            type="submit"
                            class="btn-filter-action btn-search-banner"
                        >
                            <i class="fas fa-search"></i>
                            Tìm kiếm
                        </button>

                        <a
                            href="{{ route('Admin.banners.index') }}"
                            class="btn-filter-action btn-reset-banner"
                        >
                            <i class="fas fa-redo-alt"></i>
                            Đặt lại
                        </a>
                    </form>
                </div>

                <div class="banner-table-wrapper">
                    <table class="table banner-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Hình ảnh</th>
                                <th>Tiêu đề</th>
                                <th>Loại Banner</th>
                                <th>Trạng thái</th>
                                <th>Thao tác</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse ($banners as $item)
                                @php
                                    $imagePath = trim(
                                        (string) ($item->hinh_anh ?? '')
                                    );

                                    $imageUrl = null;

                                    if ($imagePath !== '') {
                                        if (
                                            \Illuminate\Support\Str::startsWith(
                                                $imagePath,
                                                [
                                                    'http://',
                                                    'https://',
                                                    '//',
                                                    'data:'
                                                ]
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
                                                [
                                                    'storage/',
                                                    'images/',
                                                    'uploads/'
                                                ]
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
                                        <span class="banner-id">
                                            #{{ $item->id }}
                                        </span>
                                    </td>

                                    <td>
                                        <div class="banner-image-box">
                                            @if ($imageUrl)
                                                <img
                                                    src="{{ $imageUrl }}"
                                                    alt="{{ $item->tieu_de ?? 'Banner' }}"
                                                    class="banner-image"
                                                    loading="lazy"
                                                    onerror="
                                                        this.style.display='none';
                                                        this.nextElementSibling.style.display='flex';
                                                    "
                                                >

                                                <span
                                                    class="banner-image-empty"
                                                    style="display: none;"
                                                    title="Không tải được ảnh"
                                                >
                                                    <i class="fas fa-image"></i>
                                                </span>
                                            @else
                                                <span
                                                    class="banner-image-empty"
                                                    title="Chưa có ảnh Banner"
                                                >
                                                    <i class="fas fa-image"></i>
                                                </span>
                                            @endif
                                        </div>
                                    </td>

                                    <td>
                                        <div class="banner-title-wrap">
                                            <span class="banner-title-icon">
                                                <i class="fas fa-heading"></i>
                                            </span>

                                            <div>
                                                <div class="banner-title">
                                                    {{ $item->tieu_de ?: 'Chưa có tiêu đề' }}
                                                </div>

                                                <div class="banner-code">
                                                    Banner #{{ $item->id }}
                                                </div>
                                            </div>
                                        </div>
                                    </td>

                                    <td>
                                        @if ($item->loai_banner)
                                            <span class="banner-type">
                                                <i class="fas fa-tag"></i>

                                                {{ $item->loai_banner }}
                                            </span>
                                        @else
                                            <span class="text-muted">
                                                Chưa phân loại
                                            </span>
                                        @endif
                                    </td>

                                    <td>
                                        @if ($item->trang_thai_hoat_dong)
                                            <span class="banner-status banner-status-active">
                                                <span class="banner-status-dot"></span>
                                                Hoạt động
                                            </span>
                                        @else
                                            <span class="banner-status banner-status-hidden">
                                                <span class="banner-status-dot"></span>
                                                Đang ẩn
                                            </span>
                                        @endif
                                    </td>

                                    <td>
                                        <div class="banner-actions">
                                            <a
                                                href="{{ route('Admin.banners.show', $item) }}"
                                                class="btn-table-action btn-view-banner"
                                                title="Xem chi tiết"
                                            >
                                                <i class="fas fa-eye"></i>
                                            </a>

                                            <a
                                                href="{{ route('Admin.banners.edit', $item) }}"
                                                class="btn-table-action btn-edit-banner"
                                                title="Chỉnh sửa Banner"
                                            >
                                                <i class="fas fa-edit"></i>
                                            </a>

                                            <form
                                                method="POST"
                                                action="{{ route('Admin.banners.destroy', $item) }}"
                                                onsubmit="return confirm('Bạn có chắc muốn xóa Banner này?');"
                                            >
                                                @csrf
                                                @method('DELETE')

                                                <button
                                                    type="submit"
                                                    class="btn-table-action btn-delete-banner"
                                                    title="Xóa Banner"
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
                                        class="banner-empty-row"
                                    >
                                        <div class="banner-empty-icon">
                                            <i class="fas fa-images"></i>
                                        </div>

                                        <div class="banner-empty-title">
                                            Chưa có Banner
                                        </div>

                                        <div class="banner-empty-text">
                                            Không tìm thấy Banner phù hợp với
                                            điều kiện tìm kiếm.
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="banner-card-footer">
                <div class="banner-result-info">
                    @if ($banners->total() > 0)
                        Hiển thị {{ $banners->firstItem() }}
                        đến {{ $banners->lastItem() }}
                        trong tổng số {{ $banners->total() }} Banner
                    @else
                        Không có Banner nào
                    @endif
                </div>

                {{ $banners->withQueryString()->links() }}
            </div>
        </div>
    </div>
@endsection
