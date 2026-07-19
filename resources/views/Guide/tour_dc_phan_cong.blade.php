@extends('layouts.guide')

@section('title', 'Tour được phân công')

@section('guide', 'Tour được phân công')

@section('page-title', 'Tour được phân công')

@section('breadcrumb')
<li class="breadcrumb-item active">
    Tour được phân công
</li>
@endsection

@section('content')
<style>
    :root {
        --assigned-primary: #315be8;
        --assigned-primary-dark: #264ed4;
        --assigned-purple: #5b4dea;

        --assigned-dark: #173576;
        --assigned-text: #344563;
        --assigned-muted: #6b7895;
        --assigned-light: #98a2b3;

        --assigned-white: #ffffff;
        --assigned-soft: #f5f8ff;
        --assigned-hover: #f3f7ff;

        --assigned-border: #dce6f5;
        --assigned-border-light: #e8eef8;

        --assigned-success: #08754a;
        --assigned-success-bg: #eaf9f1;

        --assigned-warning: #ae6c0d;
        --assigned-warning-bg: #fff7e8;

        --assigned-danger: #c13d55;
        --assigned-danger-bg: #fff0f3;

        --assigned-info: #1975a8;
        --assigned-info-bg: #ebf8ff;
    }

    .assigned-page {
        padding: 4px 0 24px;
        color: var(--assigned-text);
    }

    /* Header */
    .assigned-page-header {
        margin-bottom: 20px;

        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 16px;
        flex-wrap: wrap;
    }

    .assigned-page-heading {
        min-width: 0;

        display: flex;
        align-items: center;
        gap: 13px;
    }

    .assigned-page-icon {
        width: 48px;
        height: 48px;
        flex-shrink: 0;

        color: var(--assigned-white);

        background: linear-gradient(135deg,
                var(--assigned-primary),
                var(--assigned-purple));

        border-radius: 12px;

        box-shadow:
            0 7px 18px rgba(49, 91, 232, 0.22);

        font-size: 18px;

        display: inline-flex;
        align-items: center;
        justify-content: center;
    }

    .assigned-page-heading h2 {
        margin: 0;

        color: var(--assigned-dark);
        font-size: 23px;
        font-weight: 800;
        letter-spacing: -0.2px;
    }

    .assigned-page-heading p {
        margin: 5px 0 0;

        color: var(--assigned-muted);
        font-size: 13px;
    }

    .btn-assigned-refresh {
        min-height: 41px;
        padding: 9px 15px;

        color: #53698f;
        background: var(--assigned-white);

        border: 1px solid #ccd9ed;
        border-radius: 9px;

        font-size: 12px;
        font-weight: 700;
        text-decoration: none;

        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 7px;

        transition:
            color 0.18s ease,
            background-color 0.18s ease,
            border-color 0.18s ease,
            transform 0.18s ease;
    }

    .btn-assigned-refresh:hover {
        color: var(--assigned-primary);
        background: var(--assigned-soft);
        border-color: #bfcff0;

        text-decoration: none;
        transform: translateY(-1px);
    }

    /* Thống kê */
    .assigned-stats-grid {
        margin-bottom: 21px;

        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 15px;
    }

    .assigned-stat-card {
        position: relative;

        min-height: 124px;
        padding: 19px;

        overflow: hidden;

        background: var(--assigned-white);
        border: 1px solid var(--assigned-border);
        border-radius: 14px;

        box-shadow:
            0 7px 24px rgba(28, 65, 139, 0.08);

        display: flex;
        align-items: center;
        gap: 14px;

        transition:
            transform 0.18s ease,
            box-shadow 0.18s ease;
    }

    .assigned-stat-card:hover {
        box-shadow:
            0 10px 29px rgba(28, 65, 139, 0.13);

        transform: translateY(-2px);
    }

    .assigned-stat-card::after {
        position: absolute;
        right: -28px;
        bottom: -42px;

        width: 115px;
        height: 115px;

        content: "";

        background: rgba(49, 91, 232, 0.04);
        border-radius: 50%;
    }

    .assigned-stat-icon {
        position: relative;
        z-index: 2;

        width: 51px;
        height: 51px;
        flex-shrink: 0;

        border: 1px solid transparent;
        border-radius: 13px;

        font-size: 18px;

        display: inline-flex;
        align-items: center;
        justify-content: center;
    }

    .assigned-stat-total {
        color: var(--assigned-primary);
        background: #edf3ff;
        border-color: #d2e0ff;
    }

    .assigned-stat-running {
        color: var(--assigned-info);
        background: var(--assigned-info-bg);
        border-color: #c8e8f5;
    }

    .assigned-stat-completed {
        color: var(--assigned-success);
        background: var(--assigned-success-bg);
        border-color: #c5ead8;
    }

    .assigned-stat-content {
        position: relative;
        z-index: 2;
    }

    .assigned-stat-value {
        color: #203e78;
        font-size: 25px;
        font-weight: 800;
        line-height: 1.15;
    }

    .assigned-stat-label {
        margin-top: 5px;

        color: var(--assigned-muted);
        font-size: 11px;
        font-weight: 650;
    }

    /* Danh sách Tour */
    .assigned-section-header {
        margin-bottom: 15px;

        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 14px;
    }

    .assigned-section-title {
        color: #24417d;
        font-size: 15px;
        font-weight: 780;

        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .assigned-section-title i {
        color: var(--assigned-primary);
    }

    .assigned-section-count {
        padding: 6px 11px;

        color: #3158ce;
        background: #e9f1ff;

        border: 1px solid #cfdeff;
        border-radius: 999px;

        font-size: 10px;
        font-weight: 800;
        white-space: nowrap;
    }

    .assigned-tour-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 18px;
    }

    .assigned-tour-card {
        position: relative;

        min-width: 0;
        overflow: hidden;

        background: var(--assigned-white);
        border: 1px solid var(--assigned-border);
        border-radius: 15px;

        box-shadow:
            0 8px 28px rgba(28, 65, 139, 0.09);

        display: flex;
        flex-direction: column;

        transition:
            transform 0.18s ease,
            border-color 0.18s ease,
            box-shadow 0.18s ease;
    }

    .assigned-tour-card:hover {
        border-color: #bfd0ec;

        box-shadow:
            0 12px 32px rgba(28, 65, 139, 0.14);

        transform: translateY(-3px);
    }

    .assigned-tour-card::before {
        position: absolute;
        top: 0;
        right: 0;
        left: 0;
        z-index: 2;

        height: 4px;
        content: "";

        background: linear-gradient(90deg,
                var(--assigned-primary),
                #3b79ee,
                var(--assigned-purple));
    }

    .assigned-tour-card-body {
        flex: 1;
        padding: 22px 20px 18px;
    }

    .assigned-tour-top {
        margin-bottom: 17px;

        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 15px;
    }

    .assigned-tour-heading {
        min-width: 0;
    }

    .assigned-tour-name {
        margin: 0 0 9px;

        color: #233f7a;
        font-size: 16px;
        font-weight: 800;
        line-height: 1.5;
        overflow-wrap: anywhere;
    }

    .assigned-tour-code {
        margin-top: 5px;

        color: #8b97aa;
        font-size: 9px;
    }

    .assigned-tour-large-icon {
        width: 48px;
        height: 48px;
        flex-shrink: 0;

        color: var(--assigned-primary);
        background: #edf3ff;

        border: 1px solid #d3e1ff;
        border-radius: 12px;

        font-size: 18px;

        display: inline-flex;
        align-items: center;
        justify-content: center;
    }

    /* Trạng thái */
    .assigned-status {
        padding: 5px 10px;

        border: 1px solid transparent;
        border-radius: 999px;

        font-size: 9px;
        font-weight: 750;
        white-space: nowrap;

        display: inline-flex;
        align-items: center;
        gap: 5px;
    }

    .assigned-status-dot {
        width: 6px;
        height: 6px;
        flex-shrink: 0;

        background: currentColor;
        border-radius: 50%;
    }

    .assigned-status-assigned {
        color: var(--assigned-success);
        background: var(--assigned-success-bg);
        border-color: #c5ead8;
    }

    .assigned-status-upcoming {
        color: var(--assigned-warning);
        background: var(--assigned-warning-bg);
        border-color: #f1dba9;
    }

    /* Thông tin Tour */
    .assigned-tour-divider {
        height: 1px;
        margin: 0 0 17px;

        background: var(--assigned-border-light);
    }

    .assigned-tour-info-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 13px;
    }

    .assigned-tour-info-item {
        min-width: 0;
        padding: 12px;

        background: #fafcff;
        border: 1px solid var(--assigned-border);
        border-radius: 10px;

        display: flex;
        align-items: flex-start;
        gap: 9px;
    }

    .assigned-tour-info-icon {
        width: 32px;
        height: 32px;
        flex-shrink: 0;

        color: var(--assigned-primary);
        background: #edf3ff;

        border: 1px solid #d4e2ff;
        border-radius: 8px;

        font-size: 10px;

        display: inline-flex;
        align-items: center;
        justify-content: center;
    }

    .assigned-tour-info-content {
        min-width: 0;
    }

    .assigned-tour-info-label {
        margin-bottom: 3px;

        color: var(--assigned-muted);
        font-size: 8px;
        font-weight: 750;
        letter-spacing: 0.035em;
        text-transform: uppercase;
    }

    .assigned-tour-info-value {
        color: #425474;
        font-size: 11px;
        font-weight: 700;
        line-height: 1.5;
        overflow-wrap: anywhere;
    }

    .assigned-capacity {
        margin-top: 5px;
    }

    .assigned-capacity-track {
        width: 100%;
        height: 5px;

        overflow: hidden;

        background: #e5eaf3;
        border-radius: 999px;
    }

    .assigned-capacity-bar {
        height: 100%;

        background: linear-gradient(90deg,
                var(--assigned-primary),
                var(--assigned-purple));

        border-radius: inherit;
    }

    /* Footer */
    .assigned-tour-card-footer {
        padding: 14px 20px;

        background: #fafcff;
        border-top: 1px solid var(--assigned-border);

        display: flex;
        align-items: center;
        justify-content: flex-end;
    }

    .btn-assigned-detail {
        min-height: 37px;
        padding: 8px 14px;

        color: var(--assigned-white);

        background: linear-gradient(135deg,
                var(--assigned-primary),
                var(--assigned-purple));

        border: 1px solid var(--assigned-primary);
        border-radius: 8px;

        box-shadow:
            0 5px 13px rgba(49, 91, 232, 0.2);

        font-size: 10px;
        font-weight: 750;
        white-space: nowrap;
        text-decoration: none;

        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 6px;

        transition:
            color 0.18s ease,
            background-color 0.18s ease,
            border-color 0.18s ease,
            box-shadow 0.18s ease,
            transform 0.18s ease;
    }

    .btn-assigned-detail:hover {
        color: var(--assigned-white);

        background: linear-gradient(135deg,
                var(--assigned-primary-dark),
                #4c40d7);

        border-color: var(--assigned-primary-dark);

        box-shadow:
            0 7px 16px rgba(49, 91, 232, 0.27);

        text-decoration: none;
        transform: translateY(-1px);
    }

    /* Empty */
    .assigned-empty {
        padding: 65px 20px;

        background: var(--assigned-white);
        border: 1px solid var(--assigned-border);
        border-radius: 15px;

        box-shadow:
            0 8px 28px rgba(28, 65, 139, 0.09);

        text-align: center;
    }

    .assigned-empty-icon {
        width: 64px;
        height: 64px;
        margin: 0 auto 14px;

        color: var(--assigned-primary);
        background: #edf3ff;

        border: 1px solid #d3e1ff;
        border-radius: 16px;

        font-size: 23px;

        display: flex;
        align-items: center;
        justify-content: center;
    }

    .assigned-empty-title {
        color: #425474;
        font-size: 15px;
        font-weight: 750;
    }

    .assigned-empty-text {
        max-width: 450px;
        margin: 5px auto 0;

        color: #8793aa;
        font-size: 12px;
        line-height: 1.7;
    }

    /* Pagination */
    .assigned-pagination {
        margin-top: 22px;

        display: flex;
        justify-content: center;
    }

    .assigned-pagination .pagination {
        margin: 0;
        gap: 4px;
    }

    .assigned-pagination .page-link {
        min-width: 34px;
        height: 34px;
        padding: 6px 10px;

        color: #3158ce;
        background: var(--assigned-white);

        border: 1px solid #d6e1f2;
        border-radius: 7px !important;

        font-size: 12px;
        box-shadow: none;

        display: flex;
        align-items: center;
        justify-content: center;
    }

    .assigned-pagination .page-link:hover {
        color: var(--assigned-white);
        background: var(--assigned-primary);
        border-color: var(--assigned-primary);
    }

    .assigned-pagination .page-item.active .page-link {
        color: var(--assigned-white);

        background: linear-gradient(135deg,
                var(--assigned-primary),
                var(--assigned-purple));

        border-color: var(--assigned-primary);
    }

    .assigned-pagination .page-item.disabled .page-link {
        color: #aab3c5;
        background: #f8f9fc;
    }

    @media (max-width: 1100px) {
        .assigned-tour-grid {
            grid-template-columns: 1fr;
        }
    }

    @media (max-width: 768px) {
        .assigned-page-header {
            align-items: stretch;
            flex-direction: column;
        }

        .assigned-page-heading h2 {
            font-size: 20px;
        }

        .btn-assigned-refresh {
            width: 100%;
        }

        .assigned-stats-grid,
        .assigned-tour-info-grid {
            grid-template-columns: 1fr;
        }

        .assigned-section-header {
            align-items: flex-start;
            flex-direction: column;
        }

        .assigned-tour-card-footer,
        .btn-assigned-detail {
            width: 100%;
        }
    }

</style>

@php
$tourCollection = collect($tours);

$tongTour = $tourCollection->count();

$dangThucHien = $tourCollection
->where('trang_thai', 'dang_dien_ra')
->count();

$hoanThanh = $tourCollection
->where('trang_thai', 'hoan_thanh')
->count();
@endphp

<div class="assigned-page fade-in">
    {{-- Header --}}
    <div class="assigned-page-header">
        <div class="assigned-page-heading">
            <span class="assigned-page-icon">
                <i class="fas fa-route"></i>
            </span>

            <div>
                <h2>Tour được phân công</h2>

                <p>
                    Theo dõi các Tour và lịch khởi hành được quản trị viên phân công.
                </p>
            </div>
        </div>

        <a href="{{ route('Guide.tour-phan-cong.index') }}" class="btn-assigned-refresh">
            <i class="fas fa-rotate-right"></i>
            Làm mới
        </a>
    </div>

    {{-- Thống kê --}}
    <div class="assigned-stats-grid">
        <div class="assigned-stat-card">
            <span class="assigned-stat-icon assigned-stat-total">
                <i class="fas fa-map-marked-alt"></i>
            </span>

            <div class="assigned-stat-content">
                <div class="assigned-stat-value">
                    {{ $tongTour }}
                </div>

                <div class="assigned-stat-label">
                    Tổng Tour được phân công
                </div>
            </div>
        </div>

        <div class="assigned-stat-card">
            <span class="assigned-stat-icon assigned-stat-running">
                <i class="fas fa-route"></i>
            </span>

            <div class="assigned-stat-content">
                <div class="assigned-stat-value">
                    {{ $dangThucHien }}
                </div>

                <div class="assigned-stat-label">
                    Đang thực hiện
                </div>
            </div>
        </div>

        <div class="assigned-stat-card">
            <span class="assigned-stat-icon assigned-stat-completed">
                <i class="fas fa-check-circle"></i>
            </span>

            <div class="assigned-stat-content">
                <div class="assigned-stat-value">
                    {{ $hoanThanh }}
                </div>

                <div class="assigned-stat-label">
                    Đã hoàn thành
                </div>
            </div>
        </div>
    </div>

    {{-- Tiêu đề danh sách --}}
    <div class="assigned-section-header">
        <div class="assigned-section-title">
            <i class="fas fa-list-alt"></i>
            Danh sách Tour
        </div>

        <span class="assigned-section-count">
            {{ $tongTour }} Tour
        </span>
    </div>

    @forelse ($tours as $tour)
    @php
    $lichKhoiHanh = $tour->lichKhoiHanh;
    $tourInfo = $lichKhoiHanh->tour ?? null;
    $phuongTien = $tour->phuongTien;

    $soChoDaDat = (int) (
    $lichKhoiHanh->so_cho_da_dat ?? 0
    );

    $tongSoCho = (int) (
    $lichKhoiHanh->so_cho ?? 0
    );

    $phanTramCho = $tongSoCho > 0
    ? round(($soChoDaDat / $tongSoCho) * 100)
    : 0;

    $phanTramCho = min(
    max($phanTramCho, 0),
    100
    );
    @endphp

    @if ($loop->first)
    <div class="assigned-tour-grid">
        @endif

        <article class="assigned-tour-card">
            <div class="assigned-tour-card-body">
                <div class="assigned-tour-top">
                    <div class="assigned-tour-heading">
                        <h3 class="assigned-tour-name">
                            {{
                                    $tourInfo->ten_tour
                                    ?? 'Tour không xác định'
                                }}
                        </h3>

                        @if (
                        (int) ($lichKhoiHanh->trang_thai ?? 0)
                        === 2
                        )
                        <span class="assigned-status assigned-status-assigned">
                            <span class="assigned-status-dot"></span>
                            Đã phân công
                        </span>
                        @else
                        <span class="assigned-status assigned-status-upcoming">
                            <span class="assigned-status-dot"></span>
                            Chưa diễn ra
                        </span>
                        @endif

                        <div class="assigned-tour-code">
                            Phân công #{{ $tour->id }}
                        </div>
                    </div>

                    <span class="assigned-tour-large-icon">
                        <i class="fas fa-route"></i>
                    </span>
                </div>

                <div class="assigned-tour-divider"></div>

                <div class="assigned-tour-info-grid">
                    <div class="assigned-tour-info-item">
                        <span class="assigned-tour-info-icon">
                            <i class="fas fa-plane-departure"></i>
                        </span>

                        <div class="assigned-tour-info-content">
                            <div class="assigned-tour-info-label">
                                Ngày khởi hành
                            </div>

                            <div class="assigned-tour-info-value">
                                @if ($lichKhoiHanh->ngay_khoi_hanh)
                                {{
                                            \Carbon\Carbon::parse(
                                                $lichKhoiHanh->ngay_khoi_hanh
                                            )->format('d/m/Y')
                                        }}
                                @else
                                Chưa cập nhật
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="assigned-tour-info-item">
                        <span class="assigned-tour-info-icon">
                            <i class="fas fa-bus"></i>
                        </span>

                        <div class="assigned-tour-info-content">
                            <div class="assigned-tour-info-label">
                                Phương tiện
                            </div>

                            <div class="assigned-tour-info-value">

                                @if($tour->dsPhuongTien->count())

                                @foreach($tour->dsPhuongTien as $xe)

                                <div>
                                    {{ $xe->ten_phuong_tien }}
                                    @if($xe->bien_so_xe)
                                    ({{ $xe->bien_so_xe }})
                                    @endif
                                </div>

                                @endforeach

                                @else

                                Chưa phân công

                                @endif

                            </div>
                        </div>
                    </div>

                    <div class="assigned-tour-info-item">
                        <span class="assigned-tour-info-icon">
                            <i class="fas fa-flag-checkered"></i>
                        </span>

                        <div class="assigned-tour-info-content">
                            <div class="assigned-tour-info-label">
                                Ngày kết thúc
                            </div>

                            <div class="assigned-tour-info-value">
                                @if ($lichKhoiHanh->ngay_ket_thuc)
                                {{
                                            \Carbon\Carbon::parse(
                                                $lichKhoiHanh->ngay_ket_thuc
                                            )->format('d/m/Y')
                                        }}
                                @else
                                Chưa cập nhật
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="assigned-tour-info-item">
                        <span class="assigned-tour-info-icon">
                            <i class="fas fa-users"></i>
                        </span>

                        <div class="assigned-tour-info-content">
                            <div class="assigned-tour-info-label">
                                Số chỗ
                            </div>

                            <div class="assigned-tour-info-value">
                                {{ $soChoDaDat }}/{{ $tongSoCho }} khách
                            </div>

                            <div class="assigned-capacity">
                                <div class="assigned-capacity-track">
                                    <div class="assigned-capacity-bar" style="width: {{ $phanTramCho }}%;"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <footer class="assigned-tour-card-footer">
                <a href="{{ route(
                            'Guide.tour-phan-cong.show',
                            $tour->id
                        ) }}" class="btn-assigned-detail">
                    <i class="fas fa-eye"></i>
                    Xem chi tiết
                </a>
            </footer>
        </article>

        @if ($loop->last)
    </div>
    @endif
    @empty
    <div class="assigned-empty">
        <div class="assigned-empty-icon">
            <i class="fas fa-map-location-dot"></i>
        </div>

        <div class="assigned-empty-title">
            Chưa có Tour nào được phân công
        </div>

        <div class="assigned-empty-text">
            Khi quản trị viên phân công Tour, thông tin Tour và lịch khởi hành sẽ hiển thị tại đây.
        </div>
    </div>
    @endforelse

    @if (
    method_exists($tours, 'hasPages') &&
    $tours->hasPages()
    )
    <div class="assigned-pagination">
        {{ $tours->withQueryString()->links() }}
    </div>
    @endif
</div>
@endsection
