@extends('layouts.admin')

@section('title', 'Quản lý Thanh toán')

@section('breadcrumb')
<li class="breadcrumb-item active">Quản lý Thanh toán</li>
@endsection

@section('content')

<div class="fade-in">

    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold mb-1">Quản lý Thanh toán</h3>
            <p class="text-muted mb-0">
                Theo dõi và quản lý các giao dịch thanh toán của khách hàng
            </p>
        </div>

    </div>

    {{-- Thống kê --}}
    <div class="stats-grid">

        <div class="stat-card">
            <div class="stat-icon stat-icon-primary">
                <i class="fas fa-money-bill-wave"></i>
            </div>
            <div class="stat-value">{{ number_format($tongDoanhThu, 0, ',', '.') }}đ</div>
            <div class="stat-label">Tổng doanh thu</div>
            <div class="stat-change positive">
                <i class="fas fa-arrow-up"></i>
                +15.2%
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon stat-icon-success">
                <i class="fas fa-check-circle"></i>
            </div>
            <div class="stat-value">{{ $daThanhToan }}</div>
            <div class="stat-label">Thanh toán thành công</div>
            <div class="stat-change positive">
                <i class="fas fa-arrow-up"></i>
                +8%
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon stat-icon-warning">
                <i class="fas fa-clock"></i>
            </div>
            <div class="stat-value">{{ $dangXuLy }}</div>
            <div class="stat-label">Đang chờ xử lý</div>
        </div>

        <div class="stat-card">
            <div class="stat-icon stat-icon-info">
                <i class="fas fa-credit-card"></i>
            </div>
            <div class="stat-value">{{ $hoanTien }}</div>
            <div class="stat-label">Hoàn tiền</div>
        </div>

    </div>

    {{-- Bộ lọc --}}
    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-filter me-2"></i>
            Bộ lọc tìm kiếm
        </div>

        <div class="card-body">

            <form method="GET" action="{{ route('admin.thanh_toans.index') }}">

                <div class="row g-3">

                    <div class="col-md-5">
                        <input type="text" class="form-control" name="search" value="{{ request('search') }}" placeholder="Tìm mã giao dịch...">
                    </div>

                    <div class="col-md-4">
                        <select class="form-select" name="status">

                            <option value="">
                                Tất cả trạng thái
                            </option>

                            <option value="1" {{ request('status') == '1' ? 'selected' : '' }}>
                                Đã thanh toán
                            </option>

                            <option value="2" {{ request('status') == '2' ? 'selected' : '' }}>
                                Chờ xử lý
                            </option>

                            <option value="3" {{ request('status') == '3' ? 'selected' : '' }}>
                                Thất bại
                            </option>

                            <option value="4" {{ request('status') == '4' ? 'selected' : '' }}>
                                Hoàn tiền
                            </option>

                        </select>
                    </div>

                    <div class="col-md-3 d-flex gap-2">

                        <button type="submit" class="btn btn-primary flex-fill">

                            <i class="fas fa-search"></i>
                            Tìm kiếm

                        </button>

                        <a href="{{ route('admin.thanh_toans.index') }}" class="btn btn-secondary">

                            <i class="fas fa-rotate-right"></i>

                        </a>

                    </div>

                </div>

            </form>

        </div>
    </div>

    {{-- Danh sách thanh toán --}}
    <div class="card">

        <div class="card-header d-flex justify-content-between align-items-center">
            <span>
                <i class="fas fa-credit-card me-2"></i>
                Danh sách giao dịch
            </span>

            <span class="badge badge-primary">
                {{ $thanh_toans->total() }} giao dịch
            </span>
        </div>

        <div class="card-body p-0">

            <div class="table-responsive">

                <table class="table mb-0">

                    <thead>
                        <tr>
                            <th>Mã GD</th>
                            <th>Khách hàng</th>
                            <th>Tour</th>
                            <th>Phương thức</th>
                            <th>Số tiền</th>
                            <th>Ngày thanh toán</th>
                            <th>Trạng thái</th>
                            <th width="150">Thao tác</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($thanh_toans as $thanh_toan)
                        <tr>
                            <td>{{ $thanh_toan->ma_giao_dich }}</td>
                            <td>{{ $thanh_toan->nguoiDung->name ?? 'Không xác định' }}</td>
                            <td>{{ $thanh_toan->datTour->tour->ten_tour ?? 'Không xác định' }}</td>
                            <td>
                                <span class="badge badge-info">
                                    {{ $thanh_toan->phuong_thuc_thanh_toan }}
                                </span>
                            </td>
                            <td class="fw-bold text-success">
                                {{ number_format($thanh_toan->so_tien, 0, ',', '.') }}đ
                            </td>
                            <td>{{ $thanh_toan->thoi_gian_thanh_toan ? date('d/m/Y H:i:s', strtotime($thanh_toan->thoi_gian_thanh_toan)) : 'Không xác định' }}</td>
                            <td>
                                @if ($thanh_toan->trang_thai == 1)
                                <span class="badge badge-success">
                                    Đã thanh toán
                                </span>
                                @elseif ($thanh_toan->trang_thai == 2)
                                <span class="badge badge-warning">
                                    Chờ xử lý
                                </span>
                                @elseif ($thanh_toan->trang_thai == 3)
                                <span class="badge badge-danger">
                                    Thất bại
                                </span>
                                @elseif ($thanh_toan->trang_thai == 4)
                                <span class="badge badge-info">
                                    Hoàn tiền
                                </span>
                                @else
                                <span class="badge badge-secondary">
                                    Không xác định
                                </span>
                                @endif
                            </td>
                            <td>
                                <div class="d-flex gap-1">

                                    <a href="{{ route('admin.thanh_toans.show', $thanh_toan->id) }}" class="btn btn-sm btn-outline-primary" title="Chi tiết">

                                        <i class="fas fa-eye"></i>

                                    </a>

                                    <a href="{{ route('admin.thanh_toans.edit_status', $thanh_toan->id) }}" class="btn btn-sm btn-warning" title="Cập nhật trạng thái">

                                        <i class="fas fa-edit"></i>

                                    </a>

                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center text-muted">
                                Không có giao dịch nào để hiển thị.
                            </td>
                        </tr>
                        @endforelse
                        <tr>
                            <td colspan="8" class="text-center">
                                {{ $thanh_toans->links() }}
                            </td>
                        </tr>
                    </tbody>

                </table>

            </div>

        </div>



    </div>

</div>

@endsection
