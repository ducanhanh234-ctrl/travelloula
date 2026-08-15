@extends('Layouts.admin')

@section('title', 'Điểm danh hướng dẫn viên')
@section('admin', 'Điểm danh hướng dẫn viên')

@section('content')
    <style>
        :root {
            --check-admin-primary: #315be8;
            --check-admin-primary-dark: #264ed4;
            --check-admin-purple: #5b4dea;

            --check-admin-navy: #183873;
            --check-admin-text: #405273;
            --check-admin-muted: #8190aa;

            --check-admin-border: #dce6f5;
            --check-admin-border-soft: #e8eef8;

            --check-admin-bg: #f7f9fd;
            --check-admin-white: #ffffff;

            --check-admin-success: #078954;
            --check-admin-success-bg: #ebfaf2;

            --check-admin-info: #2875d8;
            --check-admin-info-bg: #edf5ff;

            --check-admin-warning: #b7790b;
            --check-admin-warning-bg: #fff8e8;
        }

        .admin-checkin-page {
            padding: 8px 0 30px;
            color: var(--check-admin-text);
        }

        /* ===== Page heading ===== */
        .admin-checkin-page-heading {
            margin-bottom: 18px;

            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            flex-wrap: wrap;
        }

        .admin-checkin-heading-main {
            display: flex;
            align-items: center;
            gap: 13px;
        }

        .admin-checkin-heading-icon {
            width: 48px;
            height: 48px;
            flex-shrink: 0;

            color: #fff;

            background: linear-gradient(
                135deg,
                var(--check-admin-primary),
                var(--check-admin-purple)
            );

            border-radius: 12px;

            box-shadow:
                0 8px 20px rgba(49, 91, 232, .22);

            display: inline-flex;
            align-items: center;
            justify-content: center;

            font-size: 18px;
        }

        .admin-checkin-title {
            margin: 0;

            color: var(--check-admin-navy);

            font-size: 23px;
            font-weight: 800;
            letter-spacing: -.2px;
        }

        .admin-checkin-subtitle {
            margin: 5px 0 0;

            color: var(--check-admin-muted);

            font-size: 12px;
        }

        /* ===== Summary ===== */
        .admin-checkin-stats {
            margin-bottom: 18px;

            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 13px;
        }

        .admin-checkin-stat {
            position: relative;

            min-height: 104px;
            padding: 17px;

            overflow: hidden;

            background: var(--check-admin-white);

            border: 1px solid var(--check-admin-border);
            border-radius: 13px;

            box-shadow:
                0 7px 22px rgba(28, 65, 139, .07);

            display: flex;
            align-items: center;
            gap: 13px;
        }

        .admin-checkin-stat::after {
            position: absolute;
            right: -27px;
            bottom: -44px;

            width: 105px;
            height: 105px;

            content: "";

            background: rgba(49, 91, 232, .04);

            border-radius: 50%;
        }

        .admin-checkin-stat-icon {
            position: relative;
            z-index: 2;

            width: 45px;
            height: 45px;
            flex-shrink: 0;

            border-radius: 11px;

            display: inline-flex;
            align-items: center;
            justify-content: center;

            font-size: 15px;
        }

        .stat-tour-icon {
            color: var(--check-admin-primary);
            background: #edf3ff;
            border: 1px solid #d3e1ff;
        }

        .stat-guest-icon {
            color: #1574a7;
            background: #ecf8ff;
            border: 1px solid #d2ecfa;
        }

        .stat-guide-icon {
            color: #6a4bd2;
            background: #f3efff;
            border: 1px solid #e0d9ff;
        }

        .admin-checkin-stat-content {
            position: relative;
            z-index: 2;
        }

        .admin-checkin-stat-value {
            color: #203e78;

            font-size: 22px;
            font-weight: 800;
            line-height: 1.1;
        }

        .admin-checkin-stat-label {
            margin-top: 5px;

            color: var(--check-admin-muted);

            font-size: 10px;
            font-weight: 650;
        }

        /* ===== Main card ===== */
        .admin-checkin-panel {
            overflow: hidden;

            background: #fff;

            border: 1px solid var(--check-admin-border);
            border-radius: 14px;

            box-shadow:
                0 9px 28px rgba(28, 65, 139, .08);
        }

        .admin-checkin-panel-head {
            min-height: 79px;
            padding: 17px 19px;

            color: #fff;

            background:
                radial-gradient(
                    circle at 92% 30%,
                    rgba(255, 255, 255, .10) 0,
                    rgba(255, 255, 255, .10) 53px,
                    transparent 54px
                ),
                radial-gradient(
                    circle at 96% 80%,
                    rgba(255, 255, 255, .07) 0,
                    rgba(255, 255, 255, .07) 72px,
                    transparent 73px
                ),
                linear-gradient(
                    135deg,
                    #2860e6,
                    #554ceb
                );

            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 14px;
        }

        .admin-checkin-panel-title-wrap {
            display: flex;
            align-items: center;
            gap: 11px;
        }

        .admin-checkin-panel-icon {
            width: 40px;
            height: 40px;

            color: #fff;
            background: rgba(255, 255, 255, .14);

            border: 1px solid rgba(255, 255, 255, .28);
            border-radius: 10px;

            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .admin-checkin-panel-title {
            margin: 0;

            font-size: 17px;
            font-weight: 800;
        }

        .admin-checkin-panel-desc {
            margin-top: 4px;

            color: rgba(255, 255, 255, .83);

            font-size: 10px;
        }

        .admin-checkin-running-count {
            min-width: 72px;
            padding: 9px 13px;

            text-align: center;

            background: rgba(255, 255, 255, .14);

            border: 1px solid rgba(255, 255, 255, .28);
            border-radius: 10px;
        }

        .admin-checkin-running-number {
            font-size: 18px;
            font-weight: 800;
            line-height: 1;
        }

        .admin-checkin-running-label {
            margin-top: 4px;

            font-size: 8px;
            font-weight: 650;
        }

        /* ===== Filter ===== */
        .admin-checkin-filter-wrap {
            margin: 15px 16px;
            padding: 13px;

            background: #f7f9fe;

            border: 1px solid var(--check-admin-border);
            border-radius: 10px;
        }

        .admin-checkin-filter-title {
            margin-bottom: 9px;

            color: #31518b;

            font-size: 11px;
            font-weight: 750;
        }

        .admin-checkin-filter {
            display: grid;
            grid-template-columns: minmax(0, 1fr) auto auto;
            gap: 9px;
        }

        .admin-checkin-filter .form-control {
            min-height: 38px;

            border-color: #d7e2f3;
            border-radius: 8px;

            font-size: 11px;

            box-shadow: none;
        }

        .admin-checkin-filter .form-control:focus {
            border-color: #9bb3ef;

            box-shadow:
                0 0 0 .15rem rgba(49, 91, 232, .10);
        }

        .btn-admin-search {
            min-height: 38px;
            padding: 8px 14px;

            color: #fff;
            background: linear-gradient(
                135deg,
                var(--check-admin-primary),
                var(--check-admin-purple)
            );

            border: 0;
            border-radius: 8px;

            font-size: 10px;
            font-weight: 750;
        }

        .btn-admin-reset {
            min-height: 38px;
            padding: 8px 13px;

            color: #596d91;
            background: #fff;

            border: 1px solid #d4dfef;
            border-radius: 8px;

            font-size: 10px;
            font-weight: 700;

            text-decoration: none;

            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
        }

        /* ===== Table ===== */
        .admin-checkin-table-wrap {
            margin: 0 16px 16px;

            overflow: hidden;

            border: 1px solid var(--check-admin-border);
            border-radius: 10px;
        }

        .admin-checkin-table {
            margin: 0;
        }

        .admin-checkin-table thead th {
            padding: 11px 12px;

            color: #31518b;
            background: #f7f9fd;

            border-bottom: 1px solid var(--check-admin-border);

            font-size: 9px;
            font-weight: 800;
            letter-spacing: .02em;
            text-transform: uppercase;
            white-space: nowrap;
        }

        .admin-checkin-table tbody td {
            padding: 12px;

            color: #475a78;

            border-color: var(--check-admin-border-soft);

            vertical-align: middle;

            font-size: 10px;
        }

        .admin-checkin-table tbody tr:hover {
            background: #f8fbff;
        }

        .tour-name {
            color: #213f7d;

            font-size: 11px;
            font-weight: 800;
        }

        .tour-code {
            margin-top: 3px;

            color: #8995aa;

            font-size: 8px;
        }

        .departure-date {
            color: #29477f;

            font-weight: 750;
        }

        .departure-date i {
            margin-right: 5px;

            color: var(--check-admin-primary);
        }

        .guide-list {
            display: flex;
            align-items: center;
            flex-wrap: wrap;
            gap: 5px;
        }

        .guide-badge {
            padding: 5px 8px;

            color: #315be8;
            background: #edf3ff;

            border: 1px solid #d6e2ff;
            border-radius: 7px;

            font-size: 9px;
            font-weight: 700;
        }

        .stat-group {
            display: flex;
            align-items: center;
            flex-wrap: wrap;
            gap: 4px;
        }

        .stat-chip {
            padding: 4px 7px;

            border: 1px solid var(--check-admin-border);
            border-radius: 999px;

            background: #f8fbff;

            font-size: 8px;
            font-weight: 750;
            white-space: nowrap;
        }

        .stat-chip-total {
            color: #4c5f80;
        }

        .stat-chip-checkin {
            color: var(--check-admin-info);
            background: var(--check-admin-info-bg);
            border-color: #cfe2fb;
        }

        .stat-chip-checkout {
            color: var(--check-admin-success);
            background: var(--check-admin-success-bg);
            border-color: #c9ead9;
        }

        .stat-chip-warning {
            color: var(--check-admin-warning);
            background: var(--check-admin-warning-bg);
            border-color: #efdba7;
        }

        .running-badge {
            padding: 5px 8px;

            color: #08754a;
            background: #eaf9f1;

            border: 1px solid #c8ead9;
            border-radius: 999px;

            font-size: 8px;
            font-weight: 800;

            display: inline-flex;
            align-items: center;
            gap: 5px;
        }

        .running-dot {
            width: 5px;
            height: 5px;

            background: #0c9b61;

            border-radius: 50%;
        }

        .btn-admin-view {
            width: 32px;
            height: 32px;

            color: var(--check-admin-primary);
            background: #edf3ff;

            border: 1px solid #cfe0ff;
            border-radius: 8px;

            display: inline-flex;
            align-items: center;
            justify-content: center;

            text-decoration: none;

            transition:
                background-color .18s ease,
                color .18s ease,
                transform .18s ease;
        }

        .btn-admin-view:hover {
            color: #fff;
            background: var(--check-admin-primary);

            transform: translateY(-1px);
        }

        .admin-checkin-empty {
            padding: 48px 20px;

            color: var(--check-admin-muted);

            text-align: center;
        }

        .admin-checkin-empty-icon {
            width: 52px;
            height: 52px;
            margin: 0 auto 10px;

            color: var(--check-admin-primary);
            background: #edf3ff;

            border: 1px solid #d5e2ff;
            border-radius: 13px;

            display: flex;
            align-items: center;
            justify-content: center;
        }

        .admin-checkin-pagination {
            padding: 0 16px 16px;
        }

        @media (max-width: 992px) {
            .admin-checkin-stats {
                grid-template-columns: 1fr;
            }

            .admin-checkin-filter {
                grid-template-columns: 1fr;
            }
        }
    </style>

    @php
        $totalRunning = $lichKhoiHanhs->total();

        $pageGuestTotal = 0;
        $guideSet = collect();

        foreach ($lichKhoiHanhs as $lich) {
            $pageGuestTotal += $stats[$lich->id]['tong_khach'] ?? 0;

            foreach (($guideNames[$lich->id] ?? collect()) as $name) {
                $guideSet->push($name);
            }
        }

        $pageGuideTotal = $guideSet->unique()->count();
    @endphp

    <div class="container-fluid admin-checkin-page">

        {{-- Tiêu đề --}}
        <div class="admin-checkin-page-heading">
            <div class="admin-checkin-heading-main">
                <span class="admin-checkin-heading-icon">
                    <i class="fas fa-clipboard-check"></i>
                </span>

                <div>
                    <h2 class="admin-checkin-title">
                        Theo dõi điểm danh HDV
                    </h2>

                    <p class="admin-checkin-subtitle">
                        Theo dõi tình trạng điểm danh của các tour đang diễn ra.
                    </p>
                </div>
            </div>
        </div>

        {{-- Thống kê --}}
        <div class="admin-checkin-stats">
            <div class="admin-checkin-stat">
                <span class="admin-checkin-stat-icon stat-tour-icon">
                    <i class="fas fa-route"></i>
                </span>

                <div class="admin-checkin-stat-content">
                    <div class="admin-checkin-stat-value">
                        {{ $totalRunning }}
                    </div>

                    <div class="admin-checkin-stat-label">
                        Tour đang diễn ra
                    </div>
                </div>
            </div>

            <div class="admin-checkin-stat">
                <span class="admin-checkin-stat-icon stat-guest-icon">
                    <i class="fas fa-users"></i>
                </span>

                <div class="admin-checkin-stat-content">
                    <div class="admin-checkin-stat-value">
                        {{ $pageGuestTotal }}
                    </div>

                    <div class="admin-checkin-stat-label">
                        Khách trong danh sách hiện tại
                    </div>
                </div>
            </div>

            <div class="admin-checkin-stat">
                <span class="admin-checkin-stat-icon stat-guide-icon">
                    <i class="fas fa-user-tie"></i>
                </span>

                <div class="admin-checkin-stat-content">
                    <div class="admin-checkin-stat-value">
                        {{ $pageGuideTotal }}
                    </div>

                    <div class="admin-checkin-stat-label">
                        Hướng dẫn viên phụ trách
                    </div>
                </div>
            </div>
        </div>

        {{-- Danh sách --}}
        <div class="admin-checkin-panel">

            <div class="admin-checkin-panel-head">
                <div class="admin-checkin-panel-title-wrap">
                    <span class="admin-checkin-panel-icon">
                        <i class="fas fa-list-check"></i>
                    </span>

                    <div>
                        <h4 class="admin-checkin-panel-title">
                            Tour đang diễn ra
                        </h4>

                        <div class="admin-checkin-panel-desc">
                            Xem tiến độ Check-in / Check-out của hướng dẫn viên.
                        </div>
                    </div>
                </div>

                <div class="admin-checkin-running-count">
                    <div class="admin-checkin-running-number">
                        {{ $totalRunning }}
                    </div>

                    <div class="admin-checkin-running-label">
                        Đang diễn ra
                    </div>
                </div>
            </div>

            {{-- Tìm kiếm --}}
            <div class="admin-checkin-filter-wrap">
                <div class="admin-checkin-filter-title">
                    <i class="fas fa-filter me-1"></i>
                    Bộ lọc tìm kiếm
                </div>

                <form method="GET"
                    action="{{ route('Admin.checkin-hdv.index') }}"
                    class="admin-checkin-filter">

                    <input type="text"
                        name="q"
                        value="{{ request('q') }}"
                        class="form-control"
                        placeholder="Tên tour hoặc ID lịch khởi hành...">

                    <button type="submit" class="btn-admin-search">
                        <i class="fas fa-search me-1"></i>
                        Tìm kiếm
                    </button>

                    <a href="{{ route('Admin.checkin-hdv.index') }}"
                        class="btn-admin-reset">
                        <i class="fas fa-rotate-left"></i>
                        Đặt lại
                    </a>
                </form>
            </div>

            {{-- Bảng --}}
            <div class="admin-checkin-table-wrap">
                <div class="table-responsive">
                    <table class="table admin-checkin-table">
                        <thead>
                            <tr>
                                <th>Ngày khởi hành</th>
                                <th>Tour</th>
                                <th>Hướng dẫn viên</th>
                                <th>Tiến độ điểm danh</th>
                                <th>Trạng thái</th>
                                <th class="text-center">Thao tác</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse ($lichKhoiHanhs as $lich)
                                @php
                                    $rowStat = $stats[$lich->id] ?? [
                                        'tong_khach' => 0,
                                        'da_check_in' => 0,
                                        'da_check_out' => 0,
                                        'checkin_bu' => 0,
                                        'checkout_bu' => 0,
                                    ];

                                    $names = $guideNames[$lich->id] ?? collect();
                                @endphp

                                <tr>
                                    <td>
                                        <div class="departure-date">
                                            <i class="fas fa-calendar-day"></i>

                                            @if ($lich->ngay_khoi_hanh)
                                                {{ \Carbon\Carbon::parse($lich->ngay_khoi_hanh)->format('d/m/Y') }}
                                            @else
                                                Chưa cập nhật
                                            @endif
                                        </div>

                                        @if ($lich->ngay_ket_thuc)
                                            <div class="tour-code">
                                                Kết thúc:
                                                {{ \Carbon\Carbon::parse($lich->ngay_ket_thuc)->format('d/m/Y') }}
                                            </div>
                                        @endif
                                    </td>

                                    <td>
                                        <div class="tour-name">
                                            {{ $lich->tour->ten_tour ?? 'Không xác định' }}
                                        </div>

                                        <div class="tour-code">
                                            Lịch khởi hành #{{ $lich->id }}
                                        </div>
                                    </td>

                                    <td>
                                        <div class="guide-list">
                                            @forelse ($names as $name)
                                                <span class="guide-badge">
                                                    <i class="fas fa-user-tie me-1"></i>
                                                    {{ $name }}
                                                </span>
                                            @empty
                                                <span class="text-muted">
                                                    Chưa phân công
                                                </span>
                                            @endforelse
                                        </div>
                                    </td>

                                    <td>
                                        <div class="stat-group">
                                            <span class="stat-chip stat-chip-total">
                                                <i class="fas fa-users me-1"></i>
                                                {{ $rowStat['tong_khach'] }} khách
                                            </span>

                                            <span class="stat-chip stat-chip-checkin">
                                                <i class="fas fa-user-check me-1"></i>
                                                {{ $rowStat['da_check_in'] }} Check-in
                                            </span>

                                            <span class="stat-chip stat-chip-checkout">
                                                <i class="fas fa-check-double me-1"></i>
                                                {{ $rowStat['da_check_out'] }} Check-out
                                            </span>

                                            @if ($rowStat['checkin_bu'] > 0)
                                                <span class="stat-chip stat-chip-warning">
                                                    {{ $rowStat['checkin_bu'] }} CI bù
                                                </span>
                                            @endif

                                            @if ($rowStat['checkout_bu'] > 0)
                                                <span class="stat-chip stat-chip-warning">
                                                    {{ $rowStat['checkout_bu'] }} CO bù
                                                </span>
                                            @endif
                                        </div>
                                    </td>

                                    <td>
                                        <span class="running-badge">
                                            <span class="running-dot"></span>
                                            Đang diễn ra
                                        </span>
                                    </td>

                                    <td class="text-center">
                                        <a href="{{ route('Admin.checkin-hdv.show', $lich->id) }}"
                                            class="btn-admin-view"
                                            title="Xem chi tiết điểm danh">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    </td>
                                </tr>

                            @empty
                                <tr>
                                    <td colspan="6" class="p-0">
                                        <div class="admin-checkin-empty">
                                            <div class="admin-checkin-empty-icon">
                                                <i class="fas fa-route"></i>
                                            </div>

                                            <div class="fw-bold">
                                                Không có tour đang diễn ra
                                            </div>

                                            <div class="mt-1">
                                                Hiện tại chưa có lịch khởi hành nào ở trạng thái running.
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            @if ($lichKhoiHanhs->hasPages())
                <div class="admin-checkin-pagination">
                    {{ $lichKhoiHanhs->links() }}
                </div>
            @endif

        </div>
    </div>
@endsection
