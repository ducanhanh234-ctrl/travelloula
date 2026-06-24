@extends('layouts/admin_pro')

@section('title', 'Báo cáo & Thống kê')

@section('breadcrumb')
<li class="breadcrumb-item active">
    Báo cáo & Thống kê
</li>
@endsection

@section('content')

<div class="fade-in">

    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h3 class="fw-bold mb-1">
                Báo cáo & Thống kê
            </h3>

            <p class="text-muted mb-0">
                Tổng quan hoạt động hệ thống Tour365
            </p>
        </div>

        <div>
            <a href="{{ route('Admin.thong_ke.export') }}" class="btn btn-primary">
                <i class="fas fa-file-export"></i>
                Xuất báo cáo
            </a>
        </div>

    </div>

    {{-- KPI --}}
    <div class="stats-grid">

        <div class="stat-card">
            <div class="stat-icon stat-icon-success">
                <i class="fas fa-money-bill-wave"></i>
            </div>

            <div class="stat-value">
                {{ number_format($tongDoanhThu,0,',','.') }}đ
            </div>

            <div class="stat-label">
                Tổng doanh thu
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon stat-icon-primary">
                <i class="fas fa-file-invoice"></i>
            </div>

            <div class="stat-value">
                {{ $tongDon }}
            </div>

            <div class="stat-label">
                Tổng đơn đặt tour
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon stat-icon-warning">
                <i class="fas fa-users"></i>
            </div>

            <div class="stat-value">
                {{ $tongKhachHang }}
            </div>

            <div class="stat-label">
                Khách hàng
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon stat-icon-info">
                <i class="fas fa-star"></i>
            </div>

            <div class="stat-value">
                {{ $tongDanhGia }}
            </div>

            <div class="stat-label">
                Đánh giá
            </div>
        </div>

    </div>

    <div class="row">

        {{-- Biểu đồ doanh thu --}}
        <div class="col-lg-8">

            <div class="card mb-4">

                <div class="card-header">
                    <i class="fas fa-chart-bar me-2"></i>
                    Doanh thu theo tháng
                </div>

                <div class="card-body">

                    <canvas id="revenueChart" height="100"></canvas>

                </div>

            </div>

        </div>

        {{-- Trạng thái đơn --}}
        <div class="col-lg-4">

            <div class="card mb-4">

                <div class="card-header">
                    <i class="fas fa-chart-pie me-2"></i>
                    Đơn đặt tour
                </div>

                <div class="card-body">

                    <ul class="list-group list-group-flush">

                        <li class="list-group-item d-flex justify-content-between">
                            <span>Chờ xác nhận</span>
                            <span class="badge bg-warning">
                                {{ $choXuLy }}
                            </span>
                        </li>

                        <li class="list-group-item d-flex justify-content-between">
                            <span>Đã xác nhận</span>
                            <span class="badge bg-success">
                                {{ $daXacNhan }}
                            </span>
                        </li>

                        <li class="list-group-item d-flex justify-content-between">
                            <span>Đã hủy</span>
                            <span class="badge bg-danger">
                                {{ $daHuy }}
                            </span>
                        </li>

                    </ul>

                </div>

            </div>

        </div>

    </div>

    {{-- Top tour --}}
    <div class="card mb-4">

        <div class="card-header">
            <i class="fas fa-trophy me-2"></i>
            Top 5 tour được đặt nhiều nhất
        </div>

        <div class="card-body p-0">

            <div class="table-responsive">

                <table class="table table-hover mb-0">

                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Tên tour</th>
                            <th>Số lượt đặt</th>
                        </tr>
                    </thead>

                    <tbody>

                        @forelse($tourNoiBat as $index => $tour)

                        <tr>

                            <td>
                                {{ $index + 1 }}
                            </td>

                            <td>
                                {{ $tour->tour->ten_tour ?? 'N/A' }}
                            </td>

                            <td>
                                <span class="badge bg-primary">
                                    {{ $tour->so_luot_dat }}
                                </span>
                            </td>

                        </tr>

                        @empty

                        <tr>
                            <td colspan="3" class="text-center text-muted">

                                Chưa có dữ liệu

                            </td>
                        </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </div>

    {{-- Thống kê đánh giá --}}
    <div class="card">

        <div class="card-header">
            <i class="fas fa-star me-2"></i>
            Thống kê đánh giá
        </div>

        <div class="card-body">

            <div class="row text-center">

                <div class="col-md-3">

                    <h3 class="text-warning">
                        {{ number_format($diemTrungBinh,1) }}
                    </h3>

                    <small>Điểm trung bình</small>

                </div>

                <div class="col-md-3">

                    <h3 class="text-success">
                        {{ $danhGia5Sao }}
                    </h3>

                    <small>5 sao</small>

                </div>

                <div class="col-md-3">

                    <h3 class="text-primary">
                        {{ $danhGia4Sao }}
                    </h3>

                    <small>4 sao</small>

                </div>

                <div class="col-md-3">

                    <h3 class="text-danger">
                        {{ $danhGia1Sao }}
                    </h3>

                    <small>1 sao</small>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection

@push('scripts')
{{-- Thêm CDN Chart.js --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Lấy dữ liệu an toàn từ Laravel, nếu null sẽ tự gán mảng rỗng []
        const labels = @json($labels);
        const revenueData = @json($revenues);

        const ctx = document.getElementById('revenueChart');

        if (ctx) {
            new Chart(ctx, {
                type: 'bar'
                , data: {
                    labels: labels
                    , datasets: [{
                        label: 'Doanh thu (VND)'
                        , data: revenueData
                        , backgroundColor: 'rgba(54, 162, 235, 0.6)', // Màu nền cột xanh dương thanh lịch
                        borderColor: 'rgba(54, 162, 235, 1)', // Màu viền cột
                        borderWidth: 1
                        , borderRadius: 4 // Bo góc nhẹ cho cột hiện đại hơn
                    }]
                }
                , options: {
                    responsive: true
                    , scales: {
                        y: {
                            beginAtZero: true
                            , ticks: {
                                // Định dạng số tiền ở trục Y thành dạng: 10.000.000 đ
                                callback: function(value) {
                                    return value.toLocaleString('vi-VN') + ' đ';
                                }
                            }
                        }
                    }
                    , plugins: {
                        tooltip: {
                            callbacks: {
                                // Định dạng số tiền khi di chuột vào cột
                                label: function(context) {
                                    let label = context.dataset.label || '';
                                    if (label) {
                                        label += ': ';
                                    }
                                    if (context.parsed.y !== null) {
                                        label += context.parsed.y.toLocaleString('vi-VN') + ' đ';
                                    }
                                    return label;
                                }
                            }
                        }
                    }
                }
            });
        }
    });

</script>
@endpush
