@extends('layouts.admin')

@section('title', 'Quản lý Đánh giá')

@section('breadcrumb')
    <li class="breadcrumb-item active">
        Quản lý Đánh giá
    </li>
@endsection

@section('content')
    <style>
        :root {
            --review-primary: #315be8;
            --review-purple: #5b4dea;
            --review-dark: #173576;
            --review-text: #344563;
            --review-muted: #6b7895;
            --review-light: #98a2b3;
            --review-border: #dce6f5;
            --review-border-light: #e8eef8;
            --review-white: #ffffff;
            --review-soft: #f5f8ff;
            --review-hover: #f3f7ff;

            --review-success: #08754a;
            --review-success-bg: #eaf9f1;

            --review-info: #1975a8;
            --review-info-bg: #ebf8ff;

            --review-warning: #b7770d;
            --review-warning-bg: #fff7e6;

            --review-danger: #c13d55;
            --review-danger-bg: #fff0f3;
        }

        .review-page {
            padding: 24px 0;
            color: var(--review-text);
        }

        /* Header trang */
        .review-page-header {
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            flex-wrap: wrap;
        }

        .review-page-heading {
            min-width: 0;
            display: flex;
            align-items: center;
            gap: 13px;
        }

        .review-page-icon {
            width: 47px;
            height: 47px;
            flex-shrink: 0;
            color: var(--review-primary);
            background: #edf4ff;
            border: 1px solid #cfe0ff;
            border-radius: 12px;
            font-size: 18px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .review-page-heading h3 {
            margin: 0;
            color: var(--review-dark);
            font-size: 23px;
            font-weight: 750;
            letter-spacing: -0.2px;
        }

        .review-page-heading p {
            margin: 6px 0 0;
            color: var(--review-muted);
            font-size: 14px;
        }

        /* Thống kê */
        .review-stats-grid {
            margin-bottom: 20px;
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 16px;
        }

        .review-stat-card {
            position: relative;
            overflow: hidden;
            min-height: 126px;
            padding: 20px;
            background: var(--review-white);
            border: 1px solid var(--review-border);
            border-radius: 14px;
            box-shadow: 0 7px 24px rgba(28, 65, 139, 0.08);
            display: flex;
            align-items: center;
            gap: 15px;
            transition:
                transform 0.18s ease,
                box-shadow 0.18s ease;
        }

        .review-stat-card:hover {
            box-shadow: 0 10px 28px rgba(28, 65, 139, 0.13);
            transform: translateY(-2px);
        }

        .review-stat-card::after {
            position: absolute;
            right: -28px;
            bottom: -40px;
            width: 115px;
            height: 115px;
            content: "";
            background: rgba(49, 91, 232, 0.04);
            border-radius: 50%;
        }

        .review-stat-icon {
            width: 52px;
            height: 52px;
            flex-shrink: 0;
            border: 1px solid transparent;
            border-radius: 13px;
            font-size: 19px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .review-stat-primary {
            color: #315be8;
            background: #edf3ff;
            border-color: #d2e0ff;
        }

        .review-stat-success {
            color: var(--review-success);
            background: var(--review-success-bg);
            border-color: #c5ead8;
        }

        .review-stat-info {
            color: var(--review-info);
            background: var(--review-info-bg);
            border-color: #c8e8f5;
        }

        .review-stat-content {
            position: relative;
            z-index: 2;
            min-width: 0;
        }

        .review-stat-value {
            color: #203e78;
            font-size: 25px;
            font-weight: 800;
            line-height: 1.15;
        }

        .review-stat-label {
            margin-top: 5px;
            color: var(--review-muted);
            font-size: 12px;
            font-weight: 650;
        }

        /* Card chung */
        .review-card {
            position: relative;
            overflow: hidden;
            background: var(--review-white);
            border: 1px solid #d8e4f6;
            border-radius: 14px;
            box-shadow: 0 8px 28px rgba(28, 65, 139, 0.09);
        }

        .review-filter-card {
            margin-bottom: 20px;
        }

        .review-card-header {
            min-height: 58px;
            padding: 15px 19px;
            color: #24417d;
            background: #f1f6ff;
            border-bottom: 1px solid var(--review-border);
            font-size: 14px;
            font-weight: 750;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 14px;
        }

        .review-card-title {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .review-card-title i {
            color: var(--review-primary);
        }

        .review-total-badge {
            padding: 6px 11px;
            color: #3158ce;
            background: #e9f1ff;
            border: 1px solid #cfdeff;
            border-radius: 999px;
            font-size: 10px;
            font-weight: 750;
            white-space: nowrap;
        }

        .review-card-body {
            padding: 19px;
        }

        /* Bộ lọc */
        .review-filter-form {
            display: grid;
            grid-template-columns: minmax(260px, 1fr) 170px auto auto;
            gap: 10px;
            align-items: end;
        }

        .review-filter-group {
            min-width: 0;
        }

        .review-filter-label {
            margin-bottom: 6px;
            color: #40537a;
            font-size: 12px;
            font-weight: 700;
            display: block;
        }

        .review-input-wrapper {
            position: relative;
        }

        .review-input-icon {
            position: absolute;
            top: 50%;
            left: 12px;
            z-index: 2;
            color: #7686a5;
            font-size: 12px;
            pointer-events: none;
            transform: translateY(-50%);
        }

        .review-filter-form .form-control,
        .review-filter-form .form-select {
            width: 100%;
            min-height: 41px;
            color: var(--review-text);
            background-color: var(--review-white);
            border: 1px solid #ccd9ed;
            border-radius: 8px;
            font-size: 13px;
            box-shadow: none;
        }

        .review-filter-form .form-control {
            padding-left: 34px;
        }

        .review-filter-form .form-select {
            padding-left: 13px;
        }

        .review-filter-form .form-control::placeholder {
            color: #9ca8bd;
        }

        .review-filter-form .form-control:focus,
        .review-filter-form .form-select:focus {
            border-color: #4f78eb;
            outline: none;
            box-shadow: 0 0 0 3px rgba(49, 91, 232, 0.1);
        }

        .btn-review-filter {
            min-height: 41px;
            padding: 9px 14px;
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

        .btn-review-filter:hover {
            text-decoration: none;
            transform: translateY(-1px);
        }

        .btn-review-search {
            color: var(--review-white);
            background: linear-gradient(
                135deg,
                #315be8,
                #584be8
            );
            border-color: #315be8;
            box-shadow: 0 4px 12px rgba(49, 91, 232, 0.2);
        }

        .btn-review-search:hover {
            color: var(--review-white);
            background: linear-gradient(
                135deg,
                #264ed4,
                #4c40d7
            );
        }

        .btn-review-reset {
            color: #53698f;
            background: var(--review-white);
            border-color: #ccd9ed;
        }

        .btn-review-reset:hover {
            color: #304d83;
            background: #eaf1fb;
            border-color: #b9c9e0;
        }

        /* Bảng */
        .review-table-wrapper {
            width: 100%;
            overflow-x: auto;
        }

        .review-table {
            width: 100%;
            min-width: 1020px;
            margin-bottom: 0;
            vertical-align: middle;
        }

        .review-table thead th {
            padding: 14px;
            color: #24417d;
            background: #f7f9fd;
            border-top: none;
            border-bottom: 1px solid #d8e5f8;
            font-size: 10px;
            font-weight: 750;
            letter-spacing: 0.025em;
            text-transform: uppercase;
            white-space: nowrap;
        }

        .review-table tbody td {
            padding: 14px;
            color: #4d5d7d;
            border-bottom: 1px solid var(--review-border-light);
            font-size: 12px;
            line-height: 1.6;
            vertical-align: middle;
        }

        .review-table tbody tr:last-child td {
            border-bottom: none;
        }

        .review-table tbody tr {
            transition:
                background-color 0.18s ease,
                box-shadow 0.18s ease;
        }

        .review-table tbody tr:hover {
            background: var(--review-hover);
            box-shadow: inset 3px 0 0 #3a67ea;
        }

        .review-table th:nth-child(1),
        .review-table td:nth-child(1) {
            width: 70px;
            text-align: center;
        }

        .review-table th:nth-child(2),
        .review-table td:nth-child(2) {
            width: 220px;
        }

        .review-table th:nth-child(3),
        .review-table td:nth-child(3) {
            min-width: 250px;
        }

        .review-table th:nth-child(4),
        .review-table td:nth-child(4) {
            width: 155px;
            text-align: center;
        }

        .review-table th:nth-child(5),
        .review-table td:nth-child(5) {
            width: 175px;
            text-align: center;
        }

        .review-table th:nth-child(6),
        .review-table td:nth-child(6) {
            width: 120px;
            text-align: center;
        }

        .review-id {
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

        /* Khách hàng */
        .review-customer {
            display: flex;
            align-items: center;
            gap: 9px;
        }

        .review-customer-avatar {
            width: 36px;
            height: 36px;
            flex-shrink: 0;
            color: #315be8;
            background: #edf3ff;
            border: 1px solid #d3e1ff;
            border-radius: 50%;
            font-size: 12px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .review-customer-name {
            max-width: 175px;
            overflow: hidden;
            color: #233f7a;
            font-size: 12px;
            font-weight: 750;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .review-customer-label {
            margin-top: 2px;
            color: #8b97aa;
            font-size: 9px;
        }

        /* Tour */
        .review-tour {
            display: flex;
            align-items: flex-start;
            gap: 8px;
        }

        .review-tour-icon {
            width: 31px;
            height: 31px;
            flex-shrink: 0;
            color: #5c51d8;
            background: #f0efff;
            border: 1px solid #dcd9ff;
            border-radius: 8px;
            font-size: 10px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .review-tour-name {
            max-width: 260px;
            color: #4b5b79;
            font-size: 12px;
            font-weight: 650;
            line-height: 1.55;
            overflow-wrap: anywhere;
        }

        /* Số sao */
        .review-stars {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 2px;
            white-space: nowrap;
        }

        .review-stars i {
            color: #d3d8e3;
            font-size: 12px;
        }

        .review-stars i.review-star-active {
            color: #f2a900;
        }

        .review-score {
            margin-left: 6px;
            padding: 3px 7px;
            color: #9b650a;
            background: var(--review-warning-bg);
            border: 1px solid #f1dcae;
            border-radius: 999px;
            font-size: 9px;
            font-weight: 750;
        }

        /* Ngày */
        .review-date {
            color: #506181;
            font-size: 11px;
            font-weight: 650;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            white-space: nowrap;
        }

        .review-date i {
            color: #6380c8;
        }

        /* Nút thao tác */
        .review-actions {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 5px;
        }

        .review-actions form {
            margin: 0;
            display: inline-flex;
        }

        .btn-review-action {
            width: 31px;
            height: 31px;
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

        .btn-review-action:hover {
            text-decoration: none;
            transform: translateY(-2px);
        }

        .btn-review-view {
            color: #2d5fd7;
            background: #eaf2ff;
            border-color: #c7dafe;
        }

        .btn-review-view:hover {
            color: var(--review-white);
            background: #3867e5;
            border-color: #3867e5;
            box-shadow: 0 5px 12px rgba(56, 103, 229, 0.24);
        }

        .btn-review-delete {
            color: var(--review-danger);
            background: var(--review-danger-bg);
            border-color: #f0c9d1;
        }

        .btn-review-delete:hover {
            color: var(--review-white);
            background: #df5067;
            border-color: #df5067;
            box-shadow: 0 5px 12px rgba(223, 80, 103, 0.23);
        }

        /* Không có dữ liệu */
        .review-empty-row {
            padding: 52px 20px !important;
            color: #8793aa !important;
            text-align: center !important;
        }

        .review-empty-icon {
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

        .review-empty-title {
            color: #506181;
            font-size: 14px;
            font-weight: 700;
        }

        .review-empty-text {
            margin-top: 4px;
            font-size: 12px;
        }

        /* Footer */
        .review-card-footer {
            padding: 16px 20px;
            background: #fafcff;
            border-top: 1px solid var(--review-border);
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
        }

        .review-result-info {
            color: var(--review-muted);
            font-size: 11px;
        }

        .review-card-footer .pagination {
            margin: 0;
            gap: 4px;
        }

        .review-card-footer .page-link {
            min-width: 34px;
            height: 34px;
            padding: 6px 10px;
            color: #3158ce;
            background: var(--review-white);
            border: 1px solid #d6e1f2;
            border-radius: 7px !important;
            font-size: 12px;
            box-shadow: none;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .review-card-footer .page-link:hover {
            color: var(--review-white);
            background: #416ce5;
            border-color: #416ce5;
        }

        .review-card-footer .page-item.active .page-link {
            color: var(--review-white);
            background: linear-gradient(
                135deg,
                #315be8,
                #584be8
            );
            border-color: #315be8;
        }

        .review-card-footer .page-item.disabled .page-link {
            color: #aab3c5;
            background: #f8f9fc;
        }

        @media (max-width: 992px) {
            .review-stats-grid {
                grid-template-columns: 1fr;
            }

            .review-filter-form {
                grid-template-columns: 1fr 1fr;
            }
        }

        @media (max-width: 768px) {
            .review-page {
                padding: 14px 0;
            }

            .review-page-header {
                align-items: stretch;
                flex-direction: column;
            }

            .review-page-heading h3 {
                font-size: 20px;
            }

            .review-filter-form {
                grid-template-columns: 1fr;
            }

            .btn-review-filter {
                width: 100%;
            }

            .review-card-header {
                align-items: flex-start;
                flex-direction: column;
            }

            .review-card-body {
                padding: 15px;
            }

            .review-card-footer {
                align-items: stretch;
                flex-direction: column;
            }

            .review-result-info {
                text-align: center;
            }
        }
    </style>

    <div class="container-fluid review-page">
        <div class="review-page-header">
            <div class="review-page-heading">
                <span class="review-page-icon">
                    <i class="fas fa-comments"></i>
                </span>

                <div>
                    <h3>Quản lý Đánh giá</h3>

                    <p>
                        Theo dõi phản hồi và mức độ hài lòng của khách hàng.
                    </p>
                </div>
            </div>
        </div>

        <div class="review-stats-grid">
            <div class="review-stat-card">
                <span class="review-stat-icon review-stat-primary">
                    <i class="fas fa-comments"></i>
                </span>

                <div class="review-stat-content">
                    <div class="review-stat-value">
                        {{ $tongDanhGia }}
                    </div>

                    <div class="review-stat-label">
                        Tổng đánh giá
                    </div>
                </div>
            </div>

            <div class="review-stat-card">
                <span class="review-stat-icon review-stat-success">
                    <i class="fas fa-star"></i>
                </span>

                <div class="review-stat-content">
                    <div class="review-stat-value">
                        {{ $danhGia5Sao }}
                    </div>

                    <div class="review-stat-label">
                        Đánh giá 5 sao
                    </div>
                </div>
            </div>

            <div class="review-stat-card">
                <span class="review-stat-icon review-stat-info">
                    <i class="fas fa-chart-line"></i>
                </span>

                <div class="review-stat-content">
                    <div class="review-stat-value">
                        {{ $diemTrungBinh }}
                    </div>

                    <div class="review-stat-label">
                        Điểm trung bình
                    </div>
                </div>
            </div>
        </div>

        <div class="review-card review-filter-card">
            <div class="review-card-header">
                <div class="review-card-title">
                    <i class="fas fa-filter"></i>
                    Bộ lọc tìm kiếm
                </div>
            </div>

            <div class="review-card-body">
                <form
                    method="GET"
                    class="review-filter-form"
                >
                    <div class="review-filter-group">
                        <label
                            for="search"
                            class="review-filter-label"
                        >
                            Tìm kiếm đánh giá
                        </label>

                        <div class="review-input-wrapper">
                            <i class="fas fa-search review-input-icon"></i>

                            <input
                                type="text"
                                name="search"
                                id="search"
                                class="form-control"
                                value="{{ request('search') }}"
                                placeholder="Tìm theo khách hàng, Tour hoặc nội dung..."
                                autocomplete="off"
                            >
                        </div>
                    </div>

                    <div class="review-filter-group">
                        <label
                            for="so_sao"
                            class="review-filter-label"
                        >
                            Số sao
                        </label>

                        <select
                            name="so_sao"
                            id="so_sao"
                            class="form-select"
                        >
                            <option value="">
                                Tất cả số sao
                            </option>

                            @for ($star = 5; $star >= 1; $star--)
                                <option
                                    value="{{ $star }}"
                                    @selected((string) request('so_sao') === (string) $star)
                                >
                                    {{ $star }} sao
                                </option>
                            @endfor
                        </select>
                    </div>

                    <button
                        type="submit"
                        class="btn-review-filter btn-review-search"
                    >
                        <i class="fas fa-search"></i>
                        Tìm kiếm
                    </button>

                    <a
                        href="{{ url()->current() }}"
                        class="btn-review-filter btn-review-reset"
                    >
                        <i class="fas fa-redo-alt"></i>
                        Đặt lại
                    </a>
                </form>
            </div>
        </div>

        <div class="review-card">
            <div class="review-card-header">
                <div class="review-card-title">
                    <i class="fas fa-comments"></i>
                    Danh sách đánh giá
                </div>

                <span class="review-total-badge">
                    {{ $danh_gias->total() }} đánh giá
                </span>
            </div>

            <div class="review-table-wrapper">
                <table class="table review-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Khách hàng</th>
                            <th>Tour</th>
                            <th>Số sao</th>
                            <th>Ngày đánh giá</th>
                            <th>Thao tác</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($danh_gias as $danh_gia)
                            <tr>
                                <td>
                                    <span class="review-id">
                                        #{{ $danh_gia->id }}
                                    </span>
                                </td>

                                <td>
                                    <div class="review-customer">
                                        <span class="review-customer-avatar">
                                            <i class="fas fa-user"></i>
                                        </span>

                                        <div>
                                            <div
                                                class="review-customer-name"
                                                title="{{ $danh_gia->khachHangDatTour->ho_ten ?? 'Không xác định' }}"
                                            >
                                                {{ $danh_gia->khachHangDatTour->ho_ten ?? 'Không xác định' }}
                                            </div>

                                            <div class="review-customer-label">
                                                Khách hàng
                                            </div>
                                        </div>
                                    </div>
                                </td>

                                <td>
                                    <div class="review-tour">
                                        <span class="review-tour-icon">
                                            <i class="fas fa-map-marked-alt"></i>
                                        </span>

                                        <div class="review-tour-name">
                                            {{ $danh_gia->tour->ten_tour ?? 'Không xác định' }}
                                        </div>
                                    </div>
                                </td>

                                <td>
                                    <div class="review-stars">
                                        @for ($i = 1; $i <= 5; $i++)
                                            <i
                                                class="fas fa-star {{ $i <= $danh_gia->so_sao ? 'review-star-active' : '' }}"
                                            ></i>
                                        @endfor

                                        <span class="review-score">
                                            {{ $danh_gia->so_sao }}/5
                                        </span>
                                    </div>
                                </td>

                                <td>
                                    @if ($danh_gia->thoi_gian_danh_gia)
                                        <span class="review-date">
                                            <i class="fas fa-calendar-alt"></i>

                                            {{ \Carbon\Carbon::parse($danh_gia->thoi_gian_danh_gia)->format('d/m/Y H:i') }}
                                        </span>
                                    @else
                                        <span class="text-muted">
                                            Không có dữ liệu
                                        </span>
                                    @endif
                                </td>

                                <td>
                                    <div class="review-actions">
                                        <a
                                            href="{{ route('Admin.danh_gias.show', $danh_gia->id) }}"
                                            class="btn-review-action btn-review-view"
                                            title="Xem chi tiết"
                                        >
                                            <i class="fas fa-eye"></i>
                                        </a>

                                        <form
                                            action="{{ route('Admin.danh_gias.destroy', $danh_gia->id) }}"
                                            method="POST"
                                            onsubmit="return confirm('Bạn có chắc muốn xóa đánh giá này?');"
                                        >
                                            @csrf
                                            @method('DELETE')

                                            <button
                                                type="submit"
                                                class="btn-review-action btn-review-delete"
                                                title="Xóa đánh giá"
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
                                    class="review-empty-row"
                                >
                                    <div class="review-empty-icon">
                                        <i class="fas fa-comment-slash"></i>
                                    </div>

                                    <div class="review-empty-title">
                                        Chưa có đánh giá
                                    </div>

                                    <div class="review-empty-text">
                                        Không tìm thấy đánh giá phù hợp với điều kiện tìm kiếm.
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="review-card-footer">
                <div class="review-result-info">
                    @if ($danh_gias->total() > 0)
                        Hiển thị {{ $danh_gias->firstItem() }}
                        đến {{ $danh_gias->lastItem() }}
                        trong tổng số {{ $danh_gias->total() }} đánh giá
                    @else
                        Không có đánh giá nào
                    @endif
                </div>

                {{ $danh_gias->withQueryString()->links() }}
            </div>
        </div>
    </div>
@endsection
