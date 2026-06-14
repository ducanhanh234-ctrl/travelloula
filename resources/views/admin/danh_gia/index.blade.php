@extends('layouts.admin')

@section('title', 'Quản lý Đánh giá')

@section('breadcrumb')
<li class="breadcrumb-item active">
    Quản lý Đánh giá
</li>
@endsection

@section('content')

<div class="fade-in">

    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h3 class="fw-bold mb-1">
                Quản lý Đánh giá
            </h3>

            <p class="text-muted mb-0">
                Quản lý phản hồi và đánh giá từ khách hàng
            </p>
        </div>

    </div>

    {{-- Thống kê --}}
    <div class="stats-grid">

        <div class="stat-card">
            <div class="stat-icon stat-icon-primary">
                <i class="fas fa-comments"></i>
            </div>

            <div class="stat-value">
                {{ $tongDanhGia }}
            </div>

            <div class="stat-label">
                Tổng đánh giá
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon stat-icon-success">
                <i class="fas fa-star"></i>
            </div>

            <div class="stat-value">
                {{ $danhGia5Sao }}
            </div>

            <div class="stat-label">
                Đánh giá 5 sao
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon stat-icon-info">
                <i class="fas fa-chart-line"></i>
            </div>

            <div class="stat-value">
                {{ $diemTrungBinh }}
            </div>

            <div class="stat-label">
                Điểm trung bình
            </div>
        </div>

    </div>

    {{-- Bộ lọc --}}
    <div class="card mb-4">

        <div class="card-header">
            <i class="fas fa-filter me-2"></i>
            Bộ lọc tìm kiếm
        </div>

        <div class="card-body">

            <form method="GET">

                <div class="row g-3">

                    <div class="col-md-8">
                        <input type="text" name="search" class="form-control" value="{{ request('search') }}" placeholder="Tìm theo khách hàng, tour hoặc nội dung đánh giá">
                    </div>

                    <div class="col-md-2">
                        <select name="so_sao" class="form-select">

                            <option value="">
                                Tất cả sao
                            </option>

                            <option value="5">
                                5 Sao
                            </option>

                            <option value="4">
                                4 Sao
                            </option>

                            <option value="3">
                                3 Sao
                            </option>

                            <option value="2">
                                2 Sao
                            </option>

                            <option value="1">
                                1 Sao
                            </option>

                        </select>
                    </div>

                    <div class="col-md-2">

                        <button class="btn btn-primary w-100">
                            <i class="fas fa-search"></i>
                            Tìm kiếm
                        </button>

                    </div>

                </div>

            </form>

        </div>

    </div>

    {{-- Danh sách đánh giá --}}
    <div class="card">

        <div class="card-header d-flex justify-content-between align-items-center">

            <span>
                <i class="fas fa-comments me-2"></i>
                Danh sách đánh giá
            </span>

            <span class="badge badge-primary">
                {{ $danh_gias->total() }} đánh giá
            </span>

        </div>

        <div class="card-body p-0">

            <div class="table-responsive">

                <table class="table mb-0">

                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Khách hàng</th>
                            <th>Tour</th>
                            <th>Số sao</th>
                            <th>Ngày đánh giá</th>
                            <th width="140">
                                Thao tác
                            </th>
                        </tr>
                    </thead>

                    <tbody>

                        @forelse($danh_gias as $danh_gia)

                        <tr>

                            <td>
                                {{ $danh_gia->id }}
                            </td>

                            <td>
                                {{ $danh_gia->khachHangDatTour->ho_ten ?? 'N/A' }}
                            </td>

                            <td>
                                {{ $danh_gia->tour->ten_tour ?? 'N/A' }}
                            </td>



                            <td>

                                @for($i = 1; $i <= 5; $i++) <i class="fas fa-star
                                    {{ $i <= $danh_gia->so_sao ? 'text-warning' : 'text-secondary' }}">
                                    </i>
                                    @endfor

                            </td>

                            <td>
                                {{ strtotime($danh_gia->thoi_gian_danh_gia) ? date('d/m/Y H:i:s', strtotime($danh_gia->thoi_gian_danh_gia)) : 'N/A' }}
                            </td>

                            <td>

                                <div class="d-flex gap-1">

                                    <a href="{{ route('admin.danh_gias.show',$danh_gia->id) }}" class="btn btn-sm btn-outline-primary">

                                        <i class="fas fa-eye"></i>

                                    </a>

                                    <form action="{{ route('admin.danh_gias.destroy',$danh_gia->id) }}" method="POST">

                                        @csrf
                                        @method('DELETE')

                                        <button onclick="return confirm('Bạn có chắc muốn xóa đánh giá này?')" class="btn btn-sm btn-outline-danger">

                                            <i class="fas fa-trash"></i>

                                        </button>

                                    </form>

                                </div>

                            </td>

                        </tr>

                        @empty

                        <tr>

                            <td colspan="7" class="text-center text-muted py-4">

                                Không có đánh giá nào.

                            </td>

                        </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

        <div class="card-footer">

            {{ $danh_gias->links() }}

        </div>

    </div>

</div>

@endsection
