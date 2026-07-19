@extends('layouts.guide') {{-- Thay bằng tên file layout thực tế của bạn --}}

@section('title', 'Danh sách khách - Travelloula')
@section('page-title', 'Quản lý danh sách khách hàng')

@section('styles')
<style>
    .info-card {
        background: var(--primary-50);
        border: 1px solid var(--primary-100);
        border-radius: var(--radius);
        padding: 16px;
        height: 100%;
    }

    .info-label {
        font-size: 12px;
        color: var(--gray-500);
        text-transform: uppercase;
        font-weight: 700;
        margin-bottom: 4px;
    }

    .info-value {
        font-size: 15px;
        font-weight: 600;
        color: var(--gray-900);
    }

    .table-custom th {
        background-color: var(--gray-50);
        color: var(--gray-600);
        font-weight: 600;
        font-size: 13px;
        text-transform: uppercase;
        padding: 12px 16px;
        border-bottom: 2px solid var(--gray-200);
    }

    .table-custom td {
        padding: 16px;
        vertical-align: middle;
        font-size: 14px;
        color: var(--gray-700);
        border-bottom: 1px solid var(--gray-200);
    }

    .badge-status {
        padding: 6px 12px;
        border-radius: 999px;
        font-size: 12px;
        font-weight: 600;
    }

    .status-paid {
        background: var(--primary-100);
        color: var(--primary-600);
    }

    .status-pending {
        background: #fef3c7;
        color: #d97706;
    }

</style>
@endsection

@section('content')
<div class="row g-4">

    <div class="col-12">
        <div class="card border-0">
            <div class="card-header py-3 d-flex justify-content-between align-items-center">
                <h5 class="mb-0 fw-bold">
                    <i class="fas fa-clipboard-list me-2" style="color: var(--primary-500);"></i>
                    Thông tin Tour
                </h5>
                <a href="{{ route('Guide.tour-phan-cong.index') }}" class="btn btn-sm btn-light border">
                    <i class="fas fa-arrow-left me-1"></i> Quay lại
                </a>
            </div>
            <div class="card-body p-4">
                <div class="row g-3">
                    <div class="col-md-3 col-sm-6">
                        <div class="info-card">
                            <div class="info-label">Mã Phân Công</div>
                            <div class="info-value">#PC-{{ $phanCong->id }}</div>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6">
                        <div class="info-card">
                            <div class="info-label">Tên Tour / Lịch trình</div>
                            {{-- Giả định lichKhoiHanh có quan hệ với tour --}}
                            <div class="info-value text-truncate" title="{{ $phanCong->lichKhoiHanh->tour->ten_tour ?? 'Đang cập nhật' }}">
                                {{ $phanCong->lichKhoiHanh->tour->ten_tour ?? 'Đang cập nhật' }}
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6">
                        <div class="info-card">
                            <div class="info-label">Ngày Khởi Hành</div>
                            <div class="info-value">
                                <i class="far fa-calendar-alt me-1 text-primary"></i>
                                {{ \Carbon\Carbon::parse($phanCong->lichKhoiHanh->ngay_khoi_hanh)->format('d/m/Y') ?? 'N/A' }}
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6">
                        <div class="info-card">
                            <div class="info-label">Phương tiện</div>

                            <div class="info-value">
                                @forelse($phanCong->dsPhuongTien as $xe)
                                <div>
                                    <i class="fas fa-bus me-1 text-primary"></i>
                                    @if($xe->bien_so_xe)
                                    {{ $xe->bien_so_xe }}
                                    @endif
                                </div>
                                @empty
                                Không có
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-12">
        <div class="card border-0">
            <div class="card-header py-3 d-flex justify-content-between align-items-center">
                <h5 class="mb-0 fw-bold">
                    <i class="fas fa-users me-2" style="color: var(--primary-500);"></i>
                    Danh sách hành khách ({{ $khachHangs->count() }})
                </h5>
                <div>
                    <button class="btn btn-sm btn-primary">
                        <i class="fas fa-file-excel me-1"></i> Xuất File Mems
                    </button>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-custom mb-0 table-hover">
                    <thead>
                        <tr>
                            <th class="text-center" width="5%">STT</th>
                            <th width="15%">Mã Booking</th>
                            <th width="25%">Họ và tên</th>
                            <th width="15%">Điện thoại</th>
                            <th width="10%" class="text-center">Loại Khách</th>
                            <th width="15%" class="text-center">Trạng thái</th>

                        </tr>
                    </thead>
                    <tbody>
                        @forelse($khachHangs as $index => $khach)
                        <tr>
                            <td class="text-center fw-bold">{{ $index + 1 }}</td>
                            <td>
                                <span class="text-primary fw-bold">#BK-{{ $khach->datTour->id ?? $khach->id }}</span>
                            </td>
                            <td>
                                <div class="fw-bold" style="color: var(--gray-900);">
                                    {{ $khach->ho_ten ?? 'Chưa cập nhật' }}
                                </div>
                                @if($khach->email)
                                <small class="text-muted">{{ $khach->email }}</small>
                                @endif
                            </td>
                            <td>{{ $khach->so_dien_thoai ?? 'N/A' }}</td>
                            <td class="text-center">
                                {{ $khach->loai_hanh_khach ?? 'N/A' }}
                            </td>
                            <td class="text-center">
                                {{-- Giả định thuộc tính trạng thái --}}
                                @if(($khach->datTour->trang_thai ?? '') == 'da_thanh_toan')
                                <span class="badge-status status-paid bg-success text-white">Đã thanh toán</span>
                                @elseif($khach->datTour->trang_thai ?? '' == 'cho_xac_nhan')
                                <span class="badge-status status-pending bg-warning text-dark">Chờ xác nhận</span>
                                @elseif($khach->datTour->trang_thai ?? '' == 'da_huy')
                                <span class="badge-status status-cancelled bg-danger text-white">Đã hủy</span>
                                @endif
                            </td>

                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-5">
                                <div class="text-muted">
                                    <i class="fas fa-inbox fa-3x mb-3" style="color: var(--gray-300);"></i>
                                    <p class="mb-0">Hiện chưa có khách hàng nào đặt tour này.</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
@endsection
