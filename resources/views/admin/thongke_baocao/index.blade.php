@extends('layouts.admin')

@section('title', 'Báo cáo & Thống kê')

@section('breadcrumb')
    <li class="breadcrumb-item active">
        Báo cáo & Thống kê
    </li>
@endsection

@section('content')
    <style>
        :root {
            --report-primary: #315be8;
            --report-primary-dark: #244bd2;
            --report-purple: #5b4dea;

            --report-dark: #173576;
            --report-text: #344563;
            --report-muted: #6b7895;
            --report-light: #98a2b3;

            --report-border: #dce6f5;
            --report-border-light: #e8eef8;

            --report-white: #ffffff;
            --report-soft: #f5f8ff;
            --report-hover: #f3f7ff;

            --report-success: #08754a;
            --report-success-bg: #eaf9f1;

            --report-warning: #ae6c0d;
            --report-warning-bg: #fff7e8;

            --report-danger: #c13d55;
            --report-danger-bg: #fff0f3;

            --report-info: #1975a8;
            --report-info-bg: #ebf8ff;
        }

        .report-page {
            padding: 24px 0;
            color: var(--report-text);
        }

        /* Header */
        .report-page-header {
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            flex-wrap: wrap;
        }

        .report-page-heading {
            min-width: 0;
            display: flex;
            align-items: center;
            gap: 13px;
        }

        .report-page-icon {
            width: 48px;
            height: 48px;
            flex-shrink: 0;
            color: var(--report-primary);
            background: #edf4ff;
            border: 1px solid #cfe0ff;
            border-radius: 12px;
            font-size: 19px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .report-page-heading h3 {
            margin: 0;
            color: var(--report-dark);
            font-size: 23px;
            font-weight: 750;
            letter-spacing: -0.2px;
        }

        .report-page-heading p {
            margin: 6px 0 0;
            color: var(--report-muted);
            font-size: 14px;
        }

        .btn-export-report {
            min-height: 42px;
            padding: 9px 16px;
            color: var(--report-white);
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

        .btn-export-report:hover {
            color: var(--report-white);
            background: linear-gradient(
                135deg,
                #264ed4,
                #4d40d8
            );
            border-color: #264ed4;
            box-shadow: 0 8px 20px rgba(49, 91, 232, 0.3);
            text-decoration: none;
            transform: translateY(-1px);
        }

        /* KPI */
        .report-stats-grid {
            margin-bottom: 20px;
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 16px;
        }

        .report-stat-card {
            position: relative;
            overflow: hidden;
            min-height: 132px;
            padding: 20px;
            background: var(--report-white);
            border: 1px solid var(--report-border);
            border-radius: 14px;
            box-shadow: 0 7px 24px rgba(28, 65, 139, 0.08);
            display: flex;
            align-items: center;
            gap: 15px;
            transition:
                transform 0.18s ease,
                box-shadow 0.18s ease;
        }

        .report-stat-card:hover {
            box-shadow: 0 11px 30px rgba(28, 65, 139, 0.14);
            transform: translateY(-2px);
        }

        .report-stat-card::after {
            position: absolute;
            right: -32px;
            bottom: -47px;
            width: 125px;
            height: 125px;
            content: "";
            background: rgba(49, 91, 232, 0.04);
            border-radius: 50%;
        }

        .report-stat-icon {
            position: relative;
            z-index: 2;
            width: 54px;
            height: 54px;
            flex-shrink: 0;
            border: 1px solid transparent;
            border-radius: 14px;
            font-size: 20px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .report-stat-success {
            color: var(--report-success);
            background: var(--report-success-bg);
            border-color: #c5ead8;
        }

        .report-stat-primary {
            color: var(--report-primary);
            background: #edf3ff;
            border-color: #d2e0ff;
        }

        .report-stat-warning {
            color: var(--report-warning);
            background: var(--report-warning-bg);
            border-color: #f1dba9;
        }

        .report-stat-info {
            color: var(--report-info);
            background: var(--report-info-bg);
            border-color: #c8e8f5;
        }

        .report-stat-content {
            position: relative;
            z-index: 2;
            min-width: 0;
        }

        .report-stat-value {
            color: #203e78;
            font-size: 25px;
            font-weight: 800;
            line-height: 1.2;
            overflow-wrap: anywhere;
        }

        .report-stat-value.revenue-value {
            font-size: 20px;
        }

        .report-stat-label {
            margin-top: 5px;
            color: var(--report-muted);
            font-size: 11px;
            font-weight: 650;
        }

        /* Grid nội dung */
        .report-main-grid {
            margin-bottom: 20px;
            display: grid;
            grid-template-columns: minmax(0, 2fr) minmax(300px, 1fr);
            gap: 20px;
        }

        /* Card chung */
        .report-card {
            position: relative;
            overflow: hidden;
            background: var(--report-white);
            border: 1px solid #d8e4f6;
            border-radius: 14px;
            box-shadow: 0 8px 28px rgba(28, 65, 139, 0.09);
        }

        .report-card-header {
            min-height: 60px;
            padding: 15px 19px;
            color: #24417d;
            background: #f1f6ff;
            border-bottom: 1px solid var(--report-border);
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 14px;
        }

        .report-card-title {
            font-size: 14px;
            font-weight: 750;
            display: flex;
            align-items: center;
            gap: 9px;
        }

        .report-card-title i {
            color: var(--report-primary);
        }

        .report-card-subtitle {
            color: #7a88a1;
            font-size: 10px;
            font-weight: 550;
        }

        .report-card-body {
            padding: 20px;
        }

        /* Biểu đồ */
        .report-chart-wrapper {
            position: relative;
            min-height: 330px;
        }

        .report-chart-wrapper canvas {
            width: 100% !important;
            max-height: 330px;
        }

        /* Trạng thái đơn */
        .booking-status-list {
            display: flex;
            flex-direction: column;
            gap: 14px;
        }

        .booking-status-item {
            padding: 14px;
            background: #fafcff;
            border: 1px solid var(--report-border);
            border-radius: 11px;
        }

        .booking-status-top {
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
        }

        .booking-status-name {
            color: #425474;
            font-size: 12px;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .booking-status-icon {
            width: 31px;
            height: 31px;
            flex-shrink: 0;
            border: 1px solid transparent;
            border-radius: 8px;
            font-size: 10px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .booking-status-icon.pending {
            color: var(--report-warning);
            background: var(--report-warning-bg);
            border-color: #f1dba9;
        }

        .booking-status-icon.confirmed {
            color: var(--report-success);
            background: var(--report-success-bg);
            border-color: #c5ead8;
        }

        .booking-status-icon.cancelled {
            color: var(--report-danger);
            background: var(--report-danger-bg);
            border-color: #f0c9d1;
        }

        .booking-status-number {
            min-width: 32px;
            height: 28px;
            padding: 0 8px;
            border: 1px solid transparent;
            border-radius: 999px;
            font-size: 10px;
            font-weight: 800;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .booking-status-number.pending {
            color: var(--report-warning);
            background: var(--report-warning-bg);
            border-color: #f1dba9;
        }

        .booking-status-number.confirmed {
            color: var(--report-success);
            background: var(--report-success-bg);
            border-color: #c5ead8;
        }

        .booking-status-number.cancelled {
            color: var(--report-danger);
            background: var(--report-danger-bg);
            border-color: #f0c9d1;
        }

        .booking-progress {
            width: 100%;
            height: 7px;
            overflow: hidden;
            background: #e9eef7;
            border-radius: 999px;
        }

        .booking-progress-bar {
            height: 100%;
            border-radius: inherit;
        }

        .booking-progress-bar.pending {
            background: linear-gradient(
                90deg,
                #f0a92b,
                #f4c15b
            );
        }

        .booking-progress-bar.confirmed {
            background: linear-gradient(
                90deg,
                #12a36a,
                #43c88e
            );
        }

        .booking-progress-bar.cancelled {
            background: linear-gradient(
                90deg,
                #d94f67,
                #ed8295
            );
        }

        .booking-summary {
            margin-top: 17px;
            padding: 13px 14px;
            color: #5b6b87;
            background: #f5f8ff;
            border: 1px solid #dce6f5;
            border-radius: 10px;
            font-size: 11px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 10px;
        }

        .booking-summary strong {
            color: #274887;
            font-size: 13px;
        }

        /* Top tour */
        .top-tour-card {
            margin-bottom: 20px;
        }

        .report-table-wrapper {
            width: 100%;
            overflow-x: auto;
        }

        .report-table {
            width: 100%;
            min-width: 720px;
            margin-bottom: 0;
            vertical-align: middle;
        }

        .report-table thead th {
            padding: 14px 16px;
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

        .report-table tbody td {
            padding: 14px 16px;
            color: #4d5d7d;
            border-bottom: 1px solid var(--report-border-light);
            font-size: 12px;
            line-height: 1.6;
            vertical-align: middle;
        }

        .report-table tbody tr:last-child td {
            border-bottom: none;
        }

        .report-table tbody tr {
            transition:
                background-color 0.18s ease,
                box-shadow 0.18s ease;
        }

        .report-table tbody tr:hover {
            background: var(--report-hover);
            box-shadow: inset 3px 0 0 #3a67ea;
        }

        .report-table th:nth-child(1),
        .report-table td:nth-child(1) {
            width: 95px;
            text-align: center;
        }

        .report-table th:nth-child(3),
        .report-table td:nth-child(3) {
            width: 170px;
            text-align: center;
        }

        .tour-ranking {
            width: 34px;
            height: 34px;
            margin: 0 auto;
            color: #53698f;
            background: #f2f5fa;
            border: 1px solid #dce4f0;
            border-radius: 9px;
            font-size: 11px;
            font-weight: 800;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .tour-ranking.rank-1 {
            color: #93620a;
            background: #fff4cf;
            border-color: #eed58a;
        }

        .tour-ranking.rank-2 {
            color: #59677d;
            background: #edf1f6;
            border-color: #d5dde8;
        }

        .tour-ranking.rank-3 {
            color: #935d31;
            background: #fff0e4;
            border-color: #edcfb5;
        }

        .top-tour-info {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .top-tour-icon {
            width: 37px;
            height: 37px;
            flex-shrink: 0;
            color: #5b4dea;
            background: #f0efff;
            border: 1px solid #dcd9ff;
            border-radius: 9px;
            font-size: 12px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .top-tour-name {
            color: #233f7a;
            font-size: 12px;
            font-weight: 750;
            line-height: 1.55;
            overflow-wrap: anywhere;
        }

        .top-tour-label {
            margin-top: 2px;
            color: #8b97aa;
            font-size: 9px;
        }

        .tour-booking-count {
            padding: 6px 11px;
            color: #3158ce;
            background: #edf3ff;
            border: 1px solid #d1dfff;
            border-radius: 999px;
            font-size: 10px;
            font-weight: 800;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 5px;
        }

        /* Empty */
        .report-empty-row {
            padding: 48px 20px !important;
            color: #8793aa !important;
            text-align: center !important;
        }

        .report-empty-icon {
            width: 50px;
            height: 50px;
            margin: 0 auto 11px;
            color: #3664dd;
            background: #edf3ff;
            border: 1px solid #d3e1ff;
            border-radius: 13px;
            font-size: 19px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .report-empty-title {
            color: #506181;
            font-size: 13px;
            font-weight: 700;
        }

        /* Đánh giá */
        .review-summary-grid {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 15px;
        }

        .review-summary-item {
            position: relative;
            overflow: hidden;
            padding: 20px 15px;
            background: #fafcff;
            border: 1px solid var(--report-border);
            border-radius: 12px;
            text-align: center;
            transition:
                transform 0.18s ease,
                border-color 0.18s ease;
        }

        .review-summary-item:hover {
            border-color: #bfd0ec;
            transform: translateY(-2px);
        }

        .review-summary-icon {
            width: 39px;
            height: 39px;
            margin: 0 auto 10px;
            border: 1px solid transparent;
            border-radius: 10px;
            font-size: 13px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .review-summary-value {
            color: #203e78;
            font-size: 24px;
            font-weight: 800;
            line-height: 1.2;
        }

        .review-summary-label {
            margin-top: 5px;
            color: var(--report-muted);
            font-size: 11px;
            font-weight: 650;
        }

        .review-average .review-summary-icon {
            color: var(--report-warning);
            background: var(--report-warning-bg);
            border-color: #f1dba9;
        }

        .review-five-star .review-summary-icon {
            color: var(--report-success);
            background: var(--report-success-bg);
            border-color: #c5ead8;
        }

        .review-four-star .review-summary-icon {
            color: var(--report-primary);
            background: #edf3ff;
            border-color: #d1dfff;
        }

        .review-one-star .review-summary-icon {
            color: var(--report-danger);
            background: var(--report-danger-bg);
            border-color: #f0c9d1;
        }

        @media (max-width: 1200px) {
            .report-stats-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }

            .report-main-grid {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 768px) {
            .report-page {
                padding: 14px 0;
            }

            .report-page-header {
                align-items: stretch;
                flex-direction: column;
            }

            .report-page-heading h3 {
                font-size: 20px;
            }

            .btn-export-report {
                width: 100%;
            }

            .report-stats-grid,
            .review-summary-grid {
                grid-template-columns: 1fr;
            }

            .report-card-header {
                align-items: flex-start;
                flex-direction: column;
            }

            .report-card-body {
                padding: 15px;
            }

            .report-chart-wrapper {
                min-height: 270px;
            }

            .report-chart-wrapper canvas {
                max-height: 270px;
            }
        }
    </style>

    @php
        $choXuLyValue = (int) ($choXuLy ?? 0);
        $daXacNhanValue = (int) ($daXacNhan ?? 0);
        $daHuyValue = (int) ($daHuy ?? 0);

        $tongTrangThaiDon =
            $choXuLyValue +
            $daXacNhanValue +
            $daHuyValue;

        $phanTramChoXuLy = $tongTrangThaiDon > 0
            ? round(($choXuLyValue / $tongTrangThaiDon) * 100)
            : 0;

        $phanTramDaXacNhan = $tongTrangThaiDon > 0
            ? round(($daXacNhanValue / $tongTrangThaiDon) * 100)
            : 0;

        $phanTramDaHuy = $tongTrangThaiDon > 0
            ? round(($daHuyValue / $tongTrangThaiDon) * 100)
            : 0;
    @endphp

    <div class="container-fluid report-page">
        {{-- Header --}}
        <div class="report-page-header">
            <div class="report-page-heading">
                <span class="report-page-icon">
                    <i class="fas fa-chart-line"></i>
                </span>

                <div>
                    <h3>Báo cáo & Thống kê</h3>

                    <p>
                        Tổng quan hoạt động và hiệu quả kinh doanh của Tour365.
                    </p>
                </div>
            </div>

            <a
                href="{{ route('Admin.thong_ke.export') }}"
                class="btn-export-report"
            >
                <i class="fas fa-file-export"></i>
                Xuất báo cáo
            </a>
        </div>

        {{-- KPI --}}
        <div class="report-stats-grid">
            <div class="report-stat-card">
                <span class="report-stat-icon report-stat-success">
                    <i class="fas fa-money-bill-wave"></i>
                </span>

                <div class="report-stat-content">
                    <div class="report-stat-value revenue-value">
                        {{ number_format($tongDoanhThu ?? 0, 0, ',', '.') }}đ
                    </div>

                    <div class="report-stat-label">
                        Tổng doanh thu
                    </div>
                </div>
            </div>

            <div class="report-stat-card">
                <span class="report-stat-icon report-stat-primary">
                    <i class="fas fa-file-invoice"></i>
                </span>

                <div class="report-stat-content">
                    <div class="report-stat-value">
                        {{ number_format($tongDon ?? 0, 0, ',', '.') }}
                    </div>

                    <div class="report-stat-label">
                        Tổng đơn đặt Tour
                    </div>
                </div>
            </div>

            <div class="report-stat-card">
                <span class="report-stat-icon report-stat-warning">
                    <i class="fas fa-users"></i>
                </span>

                <div class="report-stat-content">
                    <div class="report-stat-value">
                        {{ number_format($tongKhachHang ?? 0, 0, ',', '.') }}
                    </div>

                    <div class="report-stat-label">
                        Tổng khách hàng
                    </div>
                </div>
            </div>

            <div class="report-stat-card">
                <span class="report-stat-icon report-stat-info">
                    <i class="fas fa-star"></i>
                </span>

                <div class="report-stat-content">
                    <div class="report-stat-value">
                        {{ number_format($tongDanhGia ?? 0, 0, ',', '.') }}
                    </div>

                    <div class="report-stat-label">
                        Tổng đánh giá
                    </div>
                </div>
            </div>
        </div>

        <div class="report-main-grid">
            {{-- Biểu đồ doanh thu --}}
            <div class="report-card">
                <div class="report-card-header">
                    <div>
                        <div class="report-card-title">
                            <i class="fas fa-chart-bar"></i>
                            Doanh thu theo tháng
                        </div>

                        <div class="report-card-subtitle">
                            Biểu đồ doanh thu phát sinh theo từng tháng.
                        </div>
                    </div>
                </div>

                <div class="report-card-body">
                    <div class="report-chart-wrapper">
                        <canvas id="revenueChart"></canvas>
                    </div>
                </div>
            </div>

            {{-- Trạng thái đơn --}}
            <div class="report-card">
                <div class="report-card-header">
                    <div>
                        <div class="report-card-title">
                            <i class="fas fa-chart-pie"></i>
                            Trạng thái đơn đặt Tour
                        </div>

                        <div class="report-card-subtitle">
                            Phân bố tình trạng xử lý đơn hiện tại.
                        </div>
                    </div>
                </div>

                <div class="report-card-body">
                    <div class="booking-status-list">
                        <div class="booking-status-item">
                            <div class="booking-status-top">
                                <div class="booking-status-name">
                                    <span class="booking-status-icon pending">
                                        <i class="fas fa-clock"></i>
                                    </span>

                                    Chờ xác nhận
                                </div>

                                <span class="booking-status-number pending">
                                    {{ $choXuLyValue }}
                                </span>
                            </div>

                            <div class="booking-progress">
                                <div
                                    class="booking-progress-bar pending"
                                    style="width: {{ $phanTramChoXuLy }}%;"
                                ></div>
                            </div>
                        </div>

                        <div class="booking-status-item">
                            <div class="booking-status-top">
                                <div class="booking-status-name">
                                    <span class="booking-status-icon confirmed">
                                        <i class="fas fa-check"></i>
                                    </span>

                                    Đã xác nhận
                                </div>

                                <span class="booking-status-number confirmed">
                                    {{ $daXacNhanValue }}
                                </span>
                            </div>

                            <div class="booking-progress">
                                <div
                                    class="booking-progress-bar confirmed"
                                    style="width: {{ $phanTramDaXacNhan }}%;"
                                ></div>
                            </div>
                        </div>

                        <div class="booking-status-item">
                            <div class="booking-status-top">
                                <div class="booking-status-name">
                                    <span class="booking-status-icon cancelled">
                                        <i class="fas fa-times"></i>
                                    </span>

                                    Đã hủy
                                </div>

                                <span class="booking-status-number cancelled">
                                    {{ $daHuyValue }}
                                </span>
                            </div>

                            <div class="booking-progress">
                                <div
                                    class="booking-progress-bar cancelled"
                                    style="width: {{ $phanTramDaHuy }}%;"
                                ></div>
                            </div>
                        </div>
                    </div>

                    <div class="booking-summary">
                        <span>Tổng đơn theo trạng thái</span>
                        <strong>{{ $tongTrangThaiDon }}</strong>
                    </div>
                </div>
            </div>
        </div>

        {{-- Top Tour --}}
        <div class="report-card top-tour-card">
            <div class="report-card-header">
                <div>
                    <div class="report-card-title">
                        <i class="fas fa-trophy"></i>
                        Top 5 Tour được đặt nhiều nhất
                    </div>

                    <div class="report-card-subtitle">
                        Xếp hạng Tour theo tổng số lượt khách đặt.
                    </div>
                </div>
            </div>

            <div class="report-table-wrapper">
                <table class="table report-table">
                    <thead>
                        <tr>
                            <th>Xếp hạng</th>
                            <th>Tên Tour</th>
                            <th>Số lượt đặt</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($tourNoiBat as $index => $tour)
                            @php
                                $rank = $index + 1;
                            @endphp

                            <tr>
                                <td>
                                    <span
                                        class="tour-ranking {{ $rank <= 3 ? 'rank-' . $rank : '' }}"
                                    >
                                        @if ($rank === 1)
                                            <i class="fas fa-trophy"></i>
                                        @elseif ($rank === 2)
                                            <i class="fas fa-medal"></i>
                                        @elseif ($rank === 3)
                                            <i class="fas fa-award"></i>
                                        @else
                                            {{ $rank }}
                                        @endif
                                    </span>
                                </td>

                                <td>
                                    <div class="top-tour-info">
                                        <span class="top-tour-icon">
                                            <i class="fas fa-map-marked-alt"></i>
                                        </span>

                                        <div>
                                            <div class="top-tour-name">
                                                {{ $tour->tour->ten_tour ?? 'Không xác định' }}
                                            </div>

                                            <div class="top-tour-label">
                                                Tour nổi bật
                                            </div>
                                        </div>
                                    </div>
                                </td>

                                <td>
                                    <span class="tour-booking-count">
                                        <i class="fas fa-file-invoice"></i>
                                        {{ number_format($tour->so_luot_dat ?? 0, 0, ',', '.') }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td
                                    colspan="3"
                                    class="report-empty-row"
                                >
                                    <div class="report-empty-icon">
                                        <i class="fas fa-chart-bar"></i>
                                    </div>

                                    <div class="report-empty-title">
                                        Chưa có dữ liệu đặt Tour
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Thống kê đánh giá --}}
        <div class="report-card">
            <div class="report-card-header">
                <div>
                    <div class="report-card-title">
                        <i class="fas fa-star"></i>
                        Thống kê đánh giá
                    </div>

                    <div class="report-card-subtitle">
                        Tổng hợp mức độ hài lòng của khách hàng.
                    </div>
                </div>
            </div>

            <div class="report-card-body">
                <div class="review-summary-grid">
                    <div class="review-summary-item review-average">
                        <span class="review-summary-icon">
                            <i class="fas fa-chart-line"></i>
                        </span>

                        <div class="review-summary-value">
                            {{ number_format($diemTrungBinh ?? 0, 1) }}
                        </div>

                        <div class="review-summary-label">
                            Điểm trung bình
                        </div>
                    </div>

                    <div class="review-summary-item review-five-star">
                        <span class="review-summary-icon">
                            <i class="fas fa-star"></i>
                        </span>

                        <div class="review-summary-value">
                            {{ $danhGia5Sao ?? 0 }}
                        </div>

                        <div class="review-summary-label">
                            Đánh giá 5 sao
                        </div>
                    </div>

                    <div class="review-summary-item review-four-star">
                        <span class="review-summary-icon">
                            <i class="fas fa-star-half-alt"></i>
                        </span>

                        <div class="review-summary-value">
                            {{ $danhGia4Sao ?? 0 }}
                        </div>

                        <div class="review-summary-label">
                            Đánh giá 4 sao
                        </div>
                    </div>

                    <div class="review-summary-item review-one-star">
                        <span class="review-summary-icon">
                            <i class="fas fa-thumbs-down"></i>
                        </span>

                        <div class="review-summary-value">
                            {{ $danhGia1Sao ?? 0 }}
                        </div>

                        <div class="review-summary-label">
                            Đánh giá 1 sao
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const labels = @json($labels ?? []);
            const revenueData = @json($revenues ?? []);

            const chartCanvas =
                document.getElementById('revenueChart');

            if (
                !chartCanvas ||
                typeof Chart === 'undefined'
            ) {
                return;
            }

            const chartContext =
                chartCanvas.getContext('2d');

            const revenueGradient =
                chartContext.createLinearGradient(
                    0,
                    0,
                    0,
                    330
                );

            revenueGradient.addColorStop(
                0,
                'rgba(49, 91, 232, 0.92)'
            );

            revenueGradient.addColorStop(
                1,
                'rgba(91, 77, 234, 0.45)'
            );

            new Chart(chartContext, {
                type: 'bar',

                data: {
                    labels: labels,

                    datasets: [
                        {
                            label: 'Doanh thu',

                            data: revenueData,

                            backgroundColor: revenueGradient,

                            borderColor: '#315be8',

                            borderWidth: 1,

                            borderRadius: 7,

                            borderSkipped: false,

                            maxBarThickness: 48,

                            hoverBackgroundColor: '#315be8'
                        }
                    ]
                },

                options: {
                    responsive: true,

                    maintainAspectRatio: false,

                    interaction: {
                        mode: 'index',
                        intersect: false
                    },

                    scales: {
                        x: {
                            grid: {
                                display: false
                            },

                            border: {
                                display: false
                            },

                            ticks: {
                                color: '#6b7895',

                                font: {
                                    size: 11,
                                    weight: '600'
                                }
                            }
                        },

                        y: {
                            beginAtZero: true,

                            grid: {
                                color: 'rgba(220, 230, 245, 0.8)',
                                drawBorder: false
                            },

                            border: {
                                display: false
                            },

                            ticks: {
                                color: '#6b7895',

                                padding: 8,

                                font: {
                                    size: 10
                                },

                                callback: function (value) {
                                    return Number(value)
                                        .toLocaleString('vi-VN') + 'đ';
                                }
                            }
                        }
                    },

                    plugins: {
                        legend: {
                            display: false
                        },

                        tooltip: {
                            backgroundColor: '#172b4d',

                            titleColor: '#ffffff',

                            bodyColor: '#ffffff',

                            padding: 12,

                            cornerRadius: 8,

                            displayColors: false,

                            callbacks: {
                                label: function (context) {
                                    const value =
                                        context.parsed.y ?? 0;

                                    return 'Doanh thu: ' +
                                        Number(value)
                                            .toLocaleString('vi-VN') +
                                        'đ';
                                }
                            }
                        }
                    }
                }
            });
        });
    </script>
@endpush
