@extends('Layouts.admin')

@section('title', 'Chi tiết điểm danh HDV')
@section('admin', 'Chi tiết điểm danh HDV')

@section('content')
    <style>
        .admin-detail-page {
            padding-bottom: 26px;
        }

        .admin-detail-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 16px;
            flex-wrap: wrap;
            margin-bottom: 18px;
        }

        .admin-detail-title {
            margin: 0;
            color: #233f7a;
            font-weight: 800;
        }

        .admin-info-card,
        .admin-day-card {
            border: 1px solid #e1e9f5;
            border-radius: 14px;
            box-shadow: 0 8px 24px rgba(28, 65, 139, .07);
        }

        .admin-info-grid {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 12px;
        }

        .admin-info-item {
            padding: 13px;
            border: 1px solid #e5ebf5;
            border-radius: 10px;
            background: #fafcff;
        }

        .admin-info-label {
            color: #7b879d;
            font-size: 10px;
            font-weight: 700;
            text-transform: uppercase;
        }

        .admin-info-value {
            margin-top: 4px;
            color: #29457d;
            font-size: 13px;
            font-weight: 750;
        }

        .admin-day-header {
            padding: 14px 17px;
            color: #fff;
            background: linear-gradient(135deg, #315be8, #5b4dea);
            border-radius: 14px 14px 0 0;
            font-weight: 800;
        }

        .admin-activity {
            margin: 14px;
            border: 1px solid #dfe7f4;
            border-radius: 12px;
            overflow: hidden;
        }

        .admin-activity-head {
            padding: 13px 15px;
            background: #f8fbff;
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 12px;
            flex-wrap: wrap;
        }

        .activity-title {
            color: #233f7a;
            font-weight: 800;
        }

        .activity-time {
            margin-top: 3px;
            color: #7b879d;
            font-size: 11px;
        }

        .change-note {
            margin-top: 7px;
            padding: 7px 9px;
            color: #6b4ca5;
            background: #f5f0ff;
            border: 1px solid #ded2f5;
            border-radius: 8px;
            font-size: 11px;
        }

        .activity-stats {
            display: flex;
            gap: 6px;
            flex-wrap: wrap;
        }

        .activity-stat {
            padding: 5px 8px;
            border-radius: 999px;
            background: #eef3ff;
            border: 1px solid #dbe5fa;
            color: #315be8;
            font-size: 10px;
            font-weight: 700;
        }

        .guest-table th {
            color: #60708d;
            font-size: 11px;
            white-space: nowrap;
        }

        .guest-table td {
            vertical-align: middle;
            font-size: 12px;
        }

        .status-waiting {
            color: #68768e;
            background: #f1f4f8;
        }

        .status-checkin {
            color: #08754a;
            background: #eaf9f1;
        }

        .status-checkout {
            color: #1975a8;
            background: #ebf8ff;
        }

        .status-cancelled {
            color: #c13d55;
            background: #fff0f3;
        }

        .status-pill {
            display: inline-flex;
            align-items: center;
            padding: 5px 8px;
            border-radius: 999px;
            font-size: 10px;
            font-weight: 750;
        }

        .reason-box {
            max-width: 360px;
            color: #69758b;
            font-size: 10px;
            line-height: 1.5;
        }

        @media (max-width: 992px) {
            .admin-info-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
        }

        @media (max-width: 600px) {
            .admin-info-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>

    <div class="container-fluid admin-detail-page">

        <div class="admin-detail-header">
            <div>
                <h3 class="admin-detail-title">
                    <i class="fas fa-clipboard-list me-2"></i>
                    {{ $lichKhoiHanh->tour->ten_tour ?? 'Tour' }}
                </h3>

                <div class="text-muted mt-1">
                    Theo dõi điểm danh của lịch khởi hành #{{ $lichKhoiHanh->id }}
                </div>
            </div>

            <a href="{{ route('Admin.checkin-hdv.index') }}"
                class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-1"></i>
                Quay lại
            </a>
        </div>

        <div class="card admin-info-card mb-4">
            <div class="card-body">
                <div class="admin-info-grid">
                    <div class="admin-info-item">
                        <div class="admin-info-label">Ngày khởi hành</div>
                        <div class="admin-info-value">
                            {{ $lichKhoiHanh->ngay_khoi_hanh
                                ? \Carbon\Carbon::parse($lichKhoiHanh->ngay_khoi_hanh)->format('d/m/Y')
                                : '—' }}
                        </div>
                    </div>

                    <div class="admin-info-item">
                        <div class="admin-info-label">Tổng khách</div>
                        <div class="admin-info-value">
                            {{ $tongKhach }} hành khách
                        </div>
                    </div>

                    <div class="admin-info-item">
                        <div class="admin-info-label">HDV phụ trách</div>
                        <div class="admin-info-value">
                            @forelse ($guides as $guide)
                                <div>
                                    <i class="fas fa-user-tie me-1"></i>
                                    {{ $guide->ho_ten ?? ('HDV #' . $guide->id) }}
                                </div>
                            @empty
                                Chưa phân công
                            @endforelse
                        </div>
                    </div>

                    <div class="admin-info-item">
                        <div class="admin-info-label">Khởi hành / Kết thúc</div>
                        <div class="admin-info-value">
                            <div>
                                Khởi hành:
                                <span class="badge {{ $departureDone ? 'bg-success' : 'bg-secondary' }}">
                                    {{ $departureDone ? 'Đã xác nhận' : 'Chưa xác nhận' }}
                                </span>
                            </div>

                            <div class="mt-1">
                                Kết thúc tour:
                                <span class="badge {{ $finishDone ? 'bg-primary' : 'bg-secondary' }}">
                                    {{ $finishDone ? 'Đã xác nhận' : 'Chưa xác nhận' }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @forelse ($lichKhoiHanh->tour->lichTrinhTours as $ngay)
            <div class="card admin-day-card mb-4">
                <div class="admin-day-header">
                    <i class="fas fa-calendar-day me-2"></i>
                    Ngày {{ $ngay->ngay_thu }}
                </div>

                <div class="card-body p-0">
                    @forelse ($ngay->chiTiets as $chiTiet)
                        @php
                            $activity = $activityData[$chiTiet->id] ?? null;
                        @endphp

                        @if ($activity)
                            <div class="admin-activity">
                                <div class="admin-activity-head">
                                    <div>
                                        <div class="activity-title">
                                            {{ $activity['title'] }}
                                        </div>

                                        <div class="activity-time">
                                            <i class="fas fa-clock me-1"></i>
                                            {{ $activity['start'] ?? '--:--' }}
                                            -
                                            {{ $activity['end'] ?? '--:--' }}
                                        </div>

                                        @if ($activity['change'])
                                            <div class="change-note">
                                                <strong>
                                                    @if ($activity['cancelled'])
                                                        Hoạt động đã bị hủy
                                                    @elseif ($activity['change']->loai_thay_doi === 'doi_gio')
                                                        HDV đã đổi giờ hoạt động
                                                    @else
                                                        HDV đã thay đổi hoạt động
                                                    @endif
                                                </strong>

                                                <div class="mt-1">
                                                    Lý do:
                                                    {{ $activity['change']->ly_do }}
                                                </div>
                                            </div>
                                        @endif
                                    </div>

                                    <div>
                                        <div class="activity-stats">
                                            <span class="activity-stat">
                                                {{ $activity['checked_in_count'] }}/{{ $tongKhach }}
                                                đã Check-in
                                            </span>

                                            <span class="activity-stat">
                                                {{ $activity['checked_out_count'] }}/{{ $tongKhach }}
                                                đã Check-out
                                            </span>

                                            @if ($activity['checkin_bu_count'] > 0)
                                                <span class="activity-stat">
                                                    {{ $activity['checkin_bu_count'] }}
                                                    Check-in bù
                                                </span>
                                            @endif

                                            @if ($activity['checkout_bu_count'] > 0)
                                                <span class="activity-stat">
                                                    {{ $activity['checkout_bu_count'] }}
                                                    Check-out bù
                                                </span>
                                            @endif
                                        </div>

                                        <div class="text-end mt-2">
                                            @if ($activity['status'] === 'cancelled')
                                                <span class="status-pill status-cancelled">
                                                    Đã hủy
                                                </span>
                                            @elseif ($activity['status'] === 'completed')
                                                <span class="status-pill status-checkout">
                                                    Hoàn thành
                                                </span>
                                            @elseif ($activity['status'] === 'checked_in')
                                                <span class="status-pill status-checkin">
                                                    Đang điểm danh
                                                </span>
                                            @else
                                                <span class="status-pill status-waiting">
                                                    Chưa Check-in
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                @if (!$activity['cancelled'])
                                    <div class="table-responsive">
                                        <table class="table table-hover guest-table mb-0">
                                            <thead>
                                                <tr>
                                                    <th width="55">STT</th>
                                                    <th>Hành khách</th>
                                                    <th>Trạng thái</th>
                                                    <th>Check-in</th>
                                                    <th>Check-out</th>
                                                    <th>Ghi nhận bù / Ghi chú</th>
                                                </tr>
                                            </thead>

                                            <tbody>
                                                @forelse ($activity['guests'] as $index => $row)
                                                    @php
                                                        $khach = $row['khach'];
                                                        $checkIn = $row['checkin'];
                                                    @endphp

                                                    <tr>
                                                        <td>{{ $index + 1 }}</td>

                                                        <td>
                                                            <strong>{{ $khach->ho_ten }}</strong>

                                                            @if (!empty($khach->quoc_tich))
                                                                <div class="text-muted small">
                                                                    {{ $khach->quoc_tich }}
                                                                </div>
                                                            @endif
                                                        </td>

                                                        <td>
                                                            @if (!$checkIn || $row['trang_thai'] === 'chua_check_in')
                                                                <span class="status-pill status-waiting">
                                                                    Chưa Check-in
                                                                </span>

                                                            @elseif ($row['trang_thai'] === 'da_check_in')
                                                                <span class="status-pill status-checkin">
                                                                    {{ ($checkIn->is_checkin_bu ?? false)
                                                                        ? 'Đã Check-in bù'
                                                                        : 'Đã Check-in' }}
                                                                </span>

                                                            @elseif ($row['trang_thai'] === 'da_check_out')
                                                                <span class="status-pill status-checkout">
                                                                    {{ ($checkIn->is_checkout_bu ?? false)
                                                                        ? 'Hoàn thành (bù)'
                                                                        : 'Hoàn thành' }}
                                                                </span>
                                                            @endif
                                                        </td>

                                                        <td>
                                                            @if ($checkIn && $checkIn->thoi_gian_check_in)
                                                                {{ \Carbon\Carbon::parse($checkIn->thoi_gian_check_in)->format('H:i d/m/Y') }}
                                                            @else
                                                                —
                                                            @endif
                                                        </td>

                                                        <td>
                                                            @if ($checkIn && $checkIn->thoi_gian_check_out)
                                                                {{ \Carbon\Carbon::parse($checkIn->thoi_gian_check_out)->format('H:i d/m/Y') }}
                                                            @else
                                                                —
                                                            @endif
                                                        </td>

                                                        <td>
                                                            <div class="reason-box">
                                                                @if ($checkIn && ($checkIn->is_checkin_bu ?? false))
                                                                    <div>
                                                                        <strong>Check-in bù:</strong>
                                                                        {{ $checkIn->ly_do_checkin_bu }}
                                                                    </div>
                                                                @endif

                                                                @if ($checkIn && ($checkIn->is_checkout_bu ?? false))
                                                                    <div class="mt-1">
                                                                        <strong>Check-out bù:</strong>
                                                                        {{ $checkIn->ly_do_checkout_bu }}
                                                                    </div>
                                                                @endif

                                                                @if ($checkIn && $checkIn->ghi_chu)
                                                                    <div class="mt-1">
                                                                        <strong>Ghi chú:</strong>
                                                                        {{ $checkIn->ghi_chu }}
                                                                    </div>
                                                                @endif

                                                                @if (
                                                                    !$checkIn
                                                                    || (
                                                                        !($checkIn->is_checkin_bu ?? false)
                                                                        && !($checkIn->is_checkout_bu ?? false)
                                                                        && !$checkIn->ghi_chu
                                                                    )
                                                                )
                                                                    —
                                                                @endif
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @empty
                                                    <tr>
                                                        <td colspan="6"
                                                            class="text-center text-muted py-4">
                                                            Chưa có hành khách.
                                                        </td>
                                                    </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                    </div>
                                @else
                                    <div class="p-3 text-muted">
                                        Hoạt động này đã được HDV hủy nên không yêu cầu
                                        Check-in/Check-out hành khách.
                                    </div>
                                @endif
                            </div>
                        @endif
                    @empty
                        <div class="p-4 text-center text-muted">
                            Ngày này chưa có hoạt động.
                        </div>
                    @endforelse
                </div>
            </div>
        @empty
            <div class="alert alert-secondary">
                Tour chưa có lịch trình.
            </div>
        @endforelse
    </div>
@endsection
