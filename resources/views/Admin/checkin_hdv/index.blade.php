@extends('Layouts.admin')

@section('title', 'Theo dõi điểm danh HDV')
@section('admin', 'Theo dõi điểm danh HDV')

@section('content')
    <style>
        .admin-checkin-page {
            padding-bottom: 24px;
        }

        .admin-checkin-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            flex-wrap: wrap;
            margin-bottom: 18px;
        }

        .admin-checkin-title {
            margin: 0;
            font-weight: 800;
            color: #233f7a;
        }

        .admin-checkin-subtitle {
            margin-top: 4px;
            color: #7b879d;
            font-size: 13px;
        }

        .admin-checkin-card {
            border: 1px solid #e1e9f5;
            border-radius: 14px;
            box-shadow: 0 8px 24px rgba(28, 65, 139, .07);
        }

        .admin-checkin-filter {
            display: grid;
            grid-template-columns: minmax(220px, 1fr) 220px auto;
            gap: 10px;
        }

        .admin-checkin-table th {
            white-space: nowrap;
            color: #60708d;
            font-size: 12px;
        }

        .admin-checkin-table td {
            vertical-align: middle;
            font-size: 13px;
        }

        .stat-chip {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 5px 8px;
            margin: 2px;
            border-radius: 999px;
            border: 1px solid #e1e9f5;
            background: #f8fbff;
            font-size: 11px;
            font-weight: 700;
            white-space: nowrap;
        }

        .stat-chip-success {
            color: #08754a;
            background: #eaf9f1;
            border-color: #c9ead9;
        }

        .stat-chip-info {
            color: #1975a8;
            background: #ebf8ff;
            border-color: #cbe9f7;
        }

        .stat-chip-warning {
            color: #9a630f;
            background: #fff7e8;
            border-color: #efd79f;
        }

        .guide-list {
            display: flex;
            flex-wrap: wrap;
            gap: 5px;
        }

        .guide-badge {
            padding: 5px 8px;
            border-radius: 999px;
            background: #eef3ff;
            color: #315be8;
            border: 1px solid #d9e4ff;
            font-size: 10px;
            font-weight: 700;
        }

        @media (max-width: 768px) {
            .admin-checkin-filter {
                grid-template-columns: 1fr;
            }
        }
    </style>

    <div class="container-fluid admin-checkin-page">

        <div class="admin-checkin-header">
            <div>
                <h3 class="admin-checkin-title">
                    <i class="fas fa-clipboard-check me-2"></i>
                    Theo dõi điểm danh HDV
                </h3>

                <div class="admin-checkin-subtitle">
                    Admin chỉ xem dữ liệu điểm danh của hướng dẫn viên.
                </div>
            </div>
        </div>

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        <div class="card admin-checkin-card mb-4">
            <div class="card-body">
                <form method="GET"
                    action="{{ route('Admin.checkin-hdv.index') }}"
                    class="admin-checkin-filter">

                    <input type="text"
                        name="q"
                        value="{{ request('q') }}"
                        class="form-control"
                        placeholder="Tìm theo ID lịch hoặc tên tour...">

                    <select name="trang_thai" class="form-select">
                        <option value="">Tất cả trạng thái</option>

                        <option value="running"
                            {{ request('trang_thai') === 'running' ? 'selected' : '' }}>
                            Đang diễn ra
                        </option>

                        <option value="completed"
                            {{ request('trang_thai') === 'completed' ? 'selected' : '' }}>
                            Hoàn thành
                        </option>

                        <option value="pending"
                            {{ request('trang_thai') === 'pending' ? 'selected' : '' }}>
                            Chờ khởi hành
                        </option>
                    </select>

                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-search me-1"></i>
                        Tìm kiếm
                    </button>
                </form>
            </div>
        </div>

        <div class="card admin-checkin-card">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover admin-checkin-table mb-0">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Tour</th>
                                <th>Khởi hành</th>
                                <th>Hướng dẫn viên</th>
                                <th>Thống kê điểm danh</th>
                                <th>Trạng thái chuyến</th>
                                <th width="130">Chi tiết</th>
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
                                        <strong>#{{ $lich->id }}</strong>
                                    </td>

                                    <td>
                                        <strong>{{ $lich->tour->ten_tour ?? 'Không xác định' }}</strong>
                                    </td>

                                    <td>
                                        @if ($lich->ngay_khoi_hanh)
                                            {{ \Carbon\Carbon::parse($lich->ngay_khoi_hanh)->format('d/m/Y') }}
                                        @else
                                            —
                                        @endif
                                    </td>

                                    <td>
                                        <div class="guide-list">
                                            @forelse ($names as $name)
                                                <span class="guide-badge">
                                                    <i class="fas fa-user-tie me-1"></i>
                                                    {{ $name }}
                                                </span>
                                            @empty
                                                <span class="text-muted">Chưa phân công</span>
                                            @endforelse
                                        </div>
                                    </td>

                                    <td>
                                        <span class="stat-chip">
                                            <i class="fas fa-users"></i>
                                            {{ $rowStat['tong_khach'] }} khách
                                        </span>

                                        <span class="stat-chip stat-chip-info">
                                            <i class="fas fa-user-check"></i>
                                            {{ $rowStat['da_check_in'] }} check-in
                                        </span>

                                        <span class="stat-chip stat-chip-success">
                                            <i class="fas fa-check-double"></i>
                                            {{ $rowStat['da_check_out'] }} check-out
                                        </span>

                                        @if ($rowStat['checkin_bu'] > 0)
                                            <span class="stat-chip stat-chip-warning">
                                                {{ $rowStat['checkin_bu'] }} check-in bù
                                            </span>
                                        @endif

                                        @if ($rowStat['checkout_bu'] > 0)
                                            <span class="stat-chip stat-chip-warning">
                                                {{ $rowStat['checkout_bu'] }} check-out bù
                                            </span>
                                        @endif
                                    </td>

                                    <td>
                                        @if ($lich->trang_thai === 'running')
                                            <span class="badge bg-success">
                                                Đang diễn ra
                                            </span>
                                        @elseif ($lich->trang_thai === 'completed')
                                            <span class="badge bg-primary">
                                                Hoàn thành
                                            </span>
                                        @else
                                            <span class="badge bg-secondary">
                                                {{ $lich->trang_thai ?? 'Không xác định' }}
                                            </span>
                                        @endif
                                    </td>

                                    <td>
                                        <a href="{{ route('Admin.checkin-hdv.show', $lich->id) }}"
                                            class="btn btn-sm btn-outline-primary">
                                            <i class="fas fa-eye me-1"></i>
                                            Xem
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7"
                                        class="text-center text-muted py-5">
                                        Chưa có lịch khởi hành phù hợp.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="mt-3">
            {{ $lichKhoiHanhs->links() }}
        </div>
    </div>
@endsection
