@extends('layouts.admin')

@section('content')
    <style>
        :root {
            --page-bg: #f4f7ff;
            --primary: #315be8;
            --primary-dark: #2247c9;
            --primary-light: #eef3ff;
            --purple: #5d48e8;
            --border: #dce5f5;
            --text-main: #183b76;
            --text-muted: #7484a3;
            --success: #14996e;
            --success-bg: #e8f8f1;
            --warning: #d89008;
            --warning-bg: #fff7df;
            --danger: #e04f62;
            --danger-bg: #fff0f2;
            --info: #2388cf;
            --info-bg: #eaf7ff;
        }

        .merge-request-page {
            color: #22345c;
            padding-bottom: 30px;
        }

        /* Tiêu đề trang */
        .page-heading {
            margin-bottom: 22px;
        }

        .page-heading h3 {
            color: var(--text-main);
            font-size: 24px;
            font-weight: 800;
            margin-bottom: 6px;
        }

        .page-heading h3 i {
            color: var(--primary);
        }

        .page-heading small {
            color: var(--text-muted);
            font-size: 14px;
        }

        /* Nút quay lại */
        .btn-back {
            min-height: 42px;
            padding: 9px 17px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            color: var(--primary);
            background: #fff;
            border: 1px solid #cfdaf2;
            border-radius: 10px;
            font-weight: 700;
            transition: all 0.2s ease;
        }

        .btn-back:hover {
            color: #fff;
            background: var(--primary);
            border-color: var(--primary);
            box-shadow: 0 7px 18px rgba(49, 91, 232, 0.2);
            transform: translateY(-1px);
        }

        /* Alert */
        .merge-alert {
            border: 0;
            border-radius: 12px;
            padding: 14px 17px;
            box-shadow: 0 5px 15px rgba(35, 62, 120, 0.07);
        }

        /* Thẻ thống kê */
        .stat-card {
            height: 100%;
            position: relative;
            overflow: hidden;
            background: #fff;
            border: 1px solid var(--border);
            border-radius: 13px;
            box-shadow: 0 4px 14px rgba(32, 62, 130, 0.05);
            transition: all 0.2s ease;
        }

        .stat-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(35, 62, 130, 0.1);
        }

        .stat-card::after {
            content: "";
            position: absolute;
            width: 82px;
            height: 82px;
            right: -24px;
            bottom: -30px;
            border-radius: 50%;
            background: #f4f7ff;
        }

        .stat-card .card-body {
            min-height: 102px;
            position: relative;
            z-index: 1;
            padding: 19px 18px;
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .stat-icon {
            width: 43px;
            height: 43px;
            flex: 0 0 43px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 11px;
            font-size: 17px;
        }

        .stat-icon.primary {
            color: var(--primary);
            background: var(--primary-light);
            border: 1px solid #cfdbff;
        }

        .stat-icon.warning {
            color: var(--warning);
            background: var(--warning-bg);
            border: 1px solid #f4ddb1;
        }

        .stat-icon.success {
            color: var(--success);
            background: var(--success-bg);
            border: 1px solid #c7eddc;
        }

        .stat-icon.danger {
            color: var(--danger);
            background: var(--danger-bg);
            border: 1px solid #f3ccd2;
        }

        .stat-content {
            min-width: 0;
        }

        .stat-number {
            color: #12366f;
            font-size: 23px;
            line-height: 1;
            font-weight: 800;
            margin-bottom: 7px;
        }

        .stat-label {
            color: var(--text-muted);
            font-size: 12px;
            font-weight: 600;
        }

        /* Khối danh sách */
        .request-card {
            overflow: hidden;
            background: #fff;
            border: 1px solid var(--border);
            border-radius: 14px;
            box-shadow: 0 7px 22px rgba(37, 66, 129, 0.07);
        }

        .request-card-header {
            position: relative;
            overflow: hidden;
            min-height: 93px;
            padding: 19px 22px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            color: #fff;
            background: linear-gradient(110deg, #315be8 0%, #2871ee 65%, #5c42e7 100%);
        }

        .request-card-header::before,
        .request-card-header::after {
            content: "";
            position: absolute;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.07);
        }

        .request-card-header::before {
            width: 145px;
            height: 145px;
            right: 55px;
            top: -82px;
        }

        .request-card-header::after {
            width: 105px;
            height: 105px;
            right: -25px;
            bottom: -45px;
        }

        .header-title-group {
            position: relative;
            z-index: 2;
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .header-icon {
            width: 42px;
            height: 42px;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 1px solid rgba(255, 255, 255, 0.3);
            border-radius: 11px;
            background: rgba(255, 255, 255, 0.12);
            font-size: 18px;
        }

        .request-card-header h5 {
            color: #fff;
            font-size: 20px;
            font-weight: 800;
            margin-bottom: 4px;
        }

        .request-card-header p {
            color: rgba(255, 255, 255, 0.83);
            font-size: 13px;
            margin: 0;
        }

        .header-count {
            position: relative;
            z-index: 2;
            min-width: 84px;
            padding: 9px 14px;
            text-align: center;
            border: 1px solid rgba(255, 255, 255, 0.28);
            border-radius: 11px;
            background: rgba(255, 255, 255, 0.12);
        }

        .header-count strong {
            display: block;
            font-size: 21px;
            line-height: 1.1;
        }

        .header-count span {
            font-size: 10px;
            font-weight: 600;
            opacity: 0.88;
        }

        /* Bảng */
        .request-table-wrapper {
            padding: 17px;
            background: #fff;
        }

        .request-table-box {
            overflow: hidden;
            border: 1px solid var(--border);
            border-radius: 11px;
        }

        .request-table {
            min-width: 1250px;
            margin: 0;
        }

        .request-table thead th {
            color: #193b76;
            background: #f6f8fd;
            border-color: #e1e8f5;
            padding: 13px 10px;
            font-size: 11px;
            font-weight: 800;
            text-align: center;
            text-transform: uppercase;
            white-space: nowrap;
        }

        .request-table tbody td {
            color: #33496f;
            background: #fff;
            border-color: #e7edf7;
            padding: 14px 10px;
            font-size: 13px;
            vertical-align: middle;
        }

        .request-table tbody tr {
            transition: background 0.18s ease;
        }

        .request-table tbody tr:hover td {
            background: #f8faff;
        }

        .request-code {
            color: #173b78;
            font-weight: 800;
        }

        .copy-btn {
            color: var(--primary);
            text-decoration: none;
            border: 0;
        }

        .copy-btn:hover {
            color: var(--primary-dark);
        }

        /* Badge */
        .soft-badge {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 5px;
            padding: 6px 10px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 700;
            white-space: nowrap;
        }

        .soft-badge-primary {
            color: var(--primary);
            background: var(--primary-light);
            border: 1px solid #d1dcff;
        }

        .soft-badge-secondary {
            color: #63708a;
            background: #f0f2f6;
            border: 1px solid #dce1e9;
        }

        .soft-badge-warning {
            color: #a86d00;
            background: var(--warning-bg);
            border: 1px solid #f1d99d;
        }

        .soft-badge-success {
            color: #087956;
            background: var(--success-bg);
            border: 1px solid #bfe8d7;
        }

        .soft-badge-danger {
            color: #c23f51;
            background: var(--danger-bg);
            border: 1px solid #f0cbd1;
        }

        .soft-badge-info {
            color: #1673af;
            background: var(--info-bg);
            border: 1px solid #c4e5fa;
        }

        /* Nút xử lý */
        .btn-process {
            min-width: 86px;
            padding: 7px 11px;
            color: var(--primary);
            background: #edf3ff;
            border: 1px solid #cad9ff;
            border-radius: 8px;
            font-size: 12px;
            font-weight: 700;
            transition: all 0.2s ease;
        }

        .btn-process:hover {
            color: #fff;
            background: var(--primary);
            border-color: var(--primary);
            box-shadow: 0 5px 13px rgba(49, 91, 232, 0.22);
        }

        /* Trạng thái rỗng */
        .empty-state {
            padding: 55px 15px !important;
            text-align: center;
        }

        .empty-state i {
            display: block;
            color: #b7c4de;
            font-size: 34px;
            margin-bottom: 11px;
        }

        .empty-state span {
            color: var(--text-muted);
            font-weight: 600;
        }

        /* Phân trang */
        .pagination-wrapper {
            margin-top: 18px;
        }

        .pagination-wrapper .pagination {
            margin-bottom: 0;
            gap: 5px;
        }

        .pagination-wrapper .page-link {
            min-width: 35px;
            height: 35px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--primary);
            border: 1px solid #d7e0f2;
            border-radius: 8px !important;
            font-size: 13px;
            font-weight: 700;
            box-shadow: none;
        }

        .pagination-wrapper .page-item.active .page-link {
            color: #fff;
            background: var(--primary);
            border-color: var(--primary);
        }

        .pagination-wrapper .page-item.disabled .page-link {
            color: #aeb9cd;
            background: #f5f7fb;
        }

        @media (max-width: 767.98px) {
            .page-top {
                align-items: flex-start !important;
                flex-direction: column;
                gap: 14px;
            }

            .btn-back {
                width: 100%;
            }

            .request-card-header {
                align-items: flex-start;
                gap: 15px;
                flex-direction: column;
            }

            .header-count {
                min-width: 100%;
            }

            .request-table-wrapper {
                padding: 10px;
            }
        }
    </style>

    <div class="container-fluid merge-request-page">

        {{-- Header --}}
        <div class="page-top d-flex justify-content-between align-items-center mb-4">
            <div class="page-heading mb-0">
                <h3>
                    <i class="fas fa-list-check me-2"></i>
                    Danh sách yêu cầu gộp đoàn
                </h3>

                <small>
                    Quản lý và xử lý các yêu cầu gộp đoàn của hệ thống.
                </small>
            </div>

            <a href="{{ route('Admin.gop-doan.index') }}" class="btn btn-back">
                <i class="fas fa-arrow-left"></i>
                Quay lại Gộp đoàn
            </a>
        </div>

        {{-- Alert --}}
        @if (session('success'))
            <div class="alert alert-success merge-alert">
                <i class="fas fa-circle-check me-2"></i>
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger merge-alert">
                <i class="fas fa-circle-exclamation me-2"></i>
                {{ session('error') }}
            </div>
        @endif

        {{-- Thống kê --}}
        <div class="row g-3 mb-4">
            <div class="col-xl-3 col-md-6">
                <div class="stat-card">
                    <div class="card-body">
                        <div class="stat-icon primary">
                            <i class="fas fa-list-check"></i>
                        </div>

                        <div class="stat-content">
                            <div class="stat-number">
                                {{ $data->total() }}
                            </div>

                            <div class="stat-label">
                                Tổng yêu cầu
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6">
                <div class="stat-card">
                    <div class="card-body">
                        <div class="stat-icon warning">
                            <i class="fas fa-clock"></i>
                        </div>

                        <div class="stat-content">
                            <div class="stat-number">
                                {{ $data->where('trang_thai', 'cho_xu_ly')->count() }}
                            </div>

                            <div class="stat-label">
                                Chờ xử lý
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6">
                <div class="stat-card">
                    <div class="card-body">
                        <div class="stat-icon success">
                            <i class="fas fa-circle-check"></i>
                        </div>

                        <div class="stat-content">
                            <div class="stat-number">
                                {{ $data->where('trang_thai', 'hoan_tat')->count() }}
                            </div>

                            <div class="stat-label">
                                Hoàn tất
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6">
                <div class="stat-card">
                    <div class="card-body">
                        <div class="stat-icon danger">
                            <i class="fas fa-phone-slash"></i>
                        </div>

                        <div class="stat-content">
                            <div class="stat-number">
                                {{ $data->sum('bookingChuaLienHe') }}
                            </div>

                            <div class="stat-label">
                                Booking chưa liên hệ
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Danh sách --}}
        <div class="request-card">
            <div class="request-card-header">
                <div class="header-title-group">
                    <div class="header-icon">
                        <i class="fas fa-people-arrows"></i>
                    </div>

                    <div>
                        <h5>Danh sách yêu cầu</h5>
                        <p>
                            Theo dõi và xử lý các yêu cầu gộp đoàn trong hệ thống.
                        </p>
                    </div>
                </div>

                <div class="header-count">
                    <strong>{{ $data->total() }}</strong>
                    <span>Yêu cầu</span>
                </div>
            </div>

            <div class="request-table-wrapper">
                <div class="table-responsive request-table-box">
                    <table class="table request-table align-middle">
                        <thead>
                            <tr>
                                <th style="width: 60px">STT</th>
                                <th>Mã yêu cầu</th>
                                <th>Loại</th>
                                <th>Trạng thái</th>
                                <th>Tour</th>
                                <th>Lịch chính</th>
                                <th>Lịch gộp</th>
                                <th>Số lịch</th>
                                <th>Booking</th>
                                <th>Đồng ý</th>
                                <th>Từ chối</th>
                                <th style="width: 120px">Thao tác</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse($data as $index => $yeuCau)
                                <tr>
                                    <td class="text-center">
                                        <span class="soft-badge soft-badge-primary">
                                            {{ $data->firstItem() + $index }}
                                        </span>
                                    </td>

                                    <td>
                                        <strong class="request-code"
                                            title="{{ $yeuCau->ma_yeu_cau }}">
                                            {{ $yeuCau->ma_hien_thi }}
                                        </strong>

                                        <button type="button"
                                            class="btn btn-link btn-sm p-0 ms-1 copy-btn"
                                            onclick="navigator.clipboard.writeText(@js($yeuCau->ma_yeu_cau))"
                                            title="Sao chép mã">
                                            <i class="fas fa-copy"></i>
                                        </button>
                                    </td>

                                    <td class="text-center">
                                        @if ($yeuCau->loai_de_xuat === 'tu_dong')
                                            <span class="soft-badge soft-badge-primary">
                                                <i class="fas fa-wand-magic-sparkles"></i>
                                                AI
                                            </span>
                                        @else
                                            <span class="soft-badge soft-badge-secondary">
                                                <i class="fas fa-hand-pointer"></i>
                                                Thủ công
                                            </span>
                                        @endif
                                    </td>

                                    <td class="text-center">
                                        @if ($yeuCau->trang_thai === 'cho_xu_ly')
                                            <span class="soft-badge soft-badge-warning">
                                                <i class="fas fa-clock"></i>
                                                Chờ xử lý
                                            </span>
                                        @else
                                            <span class="soft-badge soft-badge-success">
                                                <i class="fas fa-check"></i>
                                                Hoàn tất
                                            </span>
                                        @endif
                                    </td>

                                    <td>
                                        <strong class="text-dark">
                                            {{ $yeuCau->tenTour }}
                                        </strong>
                                    </td>

                                    <td class="text-center">
                                        @if ($yeuCau->lichChinh)
                                            <span class="soft-badge soft-badge-primary">
                                                #{{ $yeuCau->lichChinh->lich_khoi_hanh_id }}
                                            </span>
                                        @else
                                            <span class="text-muted">—</span>
                                        @endif
                                    </td>

                                    <td class="text-center">
                                        @forelse($yeuCau->lich_bi_gop as $lich)
                                            <span class="soft-badge soft-badge-info mb-1">
                                                #{{ $lich }}
                                            </span>
                                        @empty
                                            <span class="text-muted">—</span>
                                        @endforelse
                                    </td>

                                    <td class="text-center">
                                        <span class="soft-badge soft-badge-primary">
                                            {{ $yeuCau->soLich }}
                                        </span>
                                    </td>

                                    <td class="text-center fw-bold">
                                        {{ $yeuCau->tongBooking }}
                                    </td>

                                    <td class="text-center">
                                        <span class="soft-badge soft-badge-success">
                                            {{ $yeuCau->bookingDongY }}
                                        </span>
                                    </td>

                                    <td class="text-center">
                                        <span class="soft-badge soft-badge-danger">
                                            {{ $yeuCau->bookingTuChoi }}
                                        </span>
                                    </td>

                                    <td class="text-center">
                                        <a href="{{ route('Admin.yeu-cau-gop-doan.show', $yeuCau->id) }}"
                                            class="btn btn-process">
                                            <i class="fas fa-eye me-1"></i>
                                            Xử lý
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="12" class="empty-state">
                                        <i class="fas fa-folder-open"></i>
                                        <span>Chưa có yêu cầu gộp đoàn.</span>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- Phân trang --}}
        @if ($data->hasPages())
            <div class="pagination-wrapper">
                {{ $data->links() }}
            </div>
        @endif
    </div>
@endsection
