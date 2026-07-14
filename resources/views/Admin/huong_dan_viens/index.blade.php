@extends('layouts.admin')

@section('title', 'Quản lý hướng dẫn viên')

@section('content')

    <div class="container">

        {{-- Header --}}
        <div class="d-flex justify-content-between align-items-center mb-4">

            <div>

                <h3 class="fw-bold mb-1">
                    Quản lý Hướng dẫn viên
                </h3>

                <p class="text-muted mb-0">
                    Quản lý danh sách hướng dẫn viên trong hệ thống
                </p>

            </div>

            <a href="{{ route('Admin.huong-dan-viens.create') }}" class="btn btn-primary">

                <i class="fas fa-plus"></i>

                Thêm hướng dẫn viên

            </a>

        </div>

        {{-- Thống kê --}}
        <div class="stats-grid">

            <div class="stat-card">

                <div class="stat-icon stat-icon-primary">

                    <i class="fas fa-user-tie"></i>

                </div>

                <div class="stat-value">

                    {{ $tongHDV }}

                </div>

                <div class="stat-label">

                    Tổng HDV

                </div>

            </div>

            <div class="stat-card">

                <div class="stat-icon stat-icon-success">

                    <i class="fas fa-check-circle"></i>

                </div>

                <div class="stat-value">

                    {{ $sanSang }}

                </div>

                <div class="stat-label">

                    Sẵn sàng

                </div>

            </div>

            <div class="stat-card">

                <div class="stat-icon stat-icon-warning">

                    <i class="fas fa-route"></i>

                </div>

                <div class="stat-value">

                    {{ $dangDanTour }}

                </div>

                <div class="stat-label">

                    Đang dẫn tour

                </div>

            </div>

            <div class="stat-card">

                <div class="stat-icon stat-icon-danger">

                    <i class="fas fa-user-times"></i>

                </div>

                <div class="stat-value">

                    {{ $nghiViec }}

                </div>

                <div class="stat-label">

                    Nghỉ việc

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

                        <div class="col-md-5">

                            <input type="text" name="keyword" value="{{ request('keyword') }}" class="form-control"
                                placeholder="Tên, email, số điện thoại...">

                        </div>

                        <div class="col-md-3">

                            <select name="trang_thai" class="form-select">

                                <option value="">Tất cả trạng thái</option>

                                <option value="san_sang" {{ request('trang_thai') == 'san_sang' ? 'selected' : '' }}>

                                    Sẵn sàng

                                </option>

                                <option value="dang_dan_tour" {{ request('trang_thai') == 'dang_dan_tour' ? 'selected' : '' }}>

                                    Đang dẫn tour

                                </option>

                                <option value="khong_hoat_dong"
                                    {{ request('trang_thai') == 'khong_hoat_dong' ? 'selected' : '' }}>

                                    Không hoạt động

                                </option>

                                <option value="nghi_viec" {{ request('trang_thai') == 'nghi_viec' ? 'selected' : '' }}>

                                    Nghỉ việc

                                </option>

                            </select>

                        </div>

                        <div class="col-md-2">

                            <button class="btn btn-primary w-100">

                                <i class="fas fa-search"></i>

                            </button>

                        </div>

                        <div class="col-md-2">

                            <a href="{{ route('Admin.huong-dan-viens.index') }}" class="btn btn-secondary w-100">

                                <i class="fas fa-rotate-right"></i>

                            </a>

                        </div>

                    </div>

                </form>

            </div>

        </div>

        {{-- Danh sách --}}
        <div class="card">

            <div class="card-header d-flex justify-content-between">

                <span>

                    <i class="fas fa-user-tie me-2"></i>

                    Danh sách hướng dẫn viên

                </span>

                <span class="badge badge-primary">

                    {{ $guides->total() }} HDV

                </span>

            </div>

            <div class="card-body p-0">

                <div class="table-responsive">

                    <table class="table mb-0">

                        <thead>

                            <tr>

                                <th>ID</th>

                                <th>Họ tên</th>

                                <th>Email</th>

                                <th>Số điện thoại</th>

                                <th>Kinh nghiệm</th>

                                <th>Trạng thái</th>

                                <th width="220">

                                    Thao tác

                                </th>

                            </tr>

                        </thead>

                        <tbody>

                            @forelse($guides as $guide)
                                <tr>

                                    <td>

                                        {{ ($guides->currentPage() - 1) * $guides->perPage() + $loop->iteration }}

                                    </td>

                                    <td>

                                        {{ $guide->ho_ten }}

                                    </td>

                                    <td>

                                        {{ $guide->email }}

                                    </td>

                                    <td>

                                        {{ $guide->so_dien_thoai }}

                                    </td>

                                    <td>

                                        {{ $guide->so_nam_kinh_nghiem }} năm

                                    </td>

                                    <td>
                                        @switch($guide->trang_thai)
                                            @case('san_sang')
                                                <span class="badge bg-success">Sẵn sàng</span>
                                            @break

                                            @case('dang_dan_tour')
                                                <span class="badge bg-warning text-dark">Đang dẫn tour</span>
                                            @break

                                            @case('khong_hoat_dong')
                                                <span class="badge bg-secondary">Không hoạt động</span>
                                            @break

                                            @case('bi_khoa')
                                                <span class="badge bg-danger">Bị khóa</span>
                                            @break

                                            @case('nghi_viec')
                                                <span class="badge bg-dark">Nghỉ việc</span>
                                            @break

                                            @case('hoat_dong')
                                                <span class="badge bg-primary">Hoạt động</span>
                                            @break

                                            @default
                                                <span class="badge bg-light text-dark">Không xác định</span>
                                        @endswitch
                                    </td>

                                    <td>

                                        <div class="d-flex gap-1">

                                            <a href="{{ route('Admin.huong-dan-viens.show', $guide) }}"
                                                class="btn btn-outline-primary btn-sm">

                                                <i class="fas fa-eye"></i>

                                            </a>

                                            <a href="{{ route('Admin.huong-dan-viens.edit', $guide) }}"
                                                class="btn btn-warning btn-sm">

                                                <i class="fas fa-edit"></i>

                                            </a>

                                            <form action="{{ route('Admin.huong-dan-viens.destroy', $guide) }}"
                                                method="POST">

                                                @csrf
                                                @method('DELETE')

                                                <button onclick="return confirm('Bạn có chắc muốn xóa?')"
                                                    class="btn btn-danger btn-sm">

                                                    <i class="fas fa-trash"></i>

                                                </button>

                                            </form>

                                        </div>

                                    </td>

                                </tr>

                                @empty

                                    <tr>

                                        <td colspan="7" class="text-center py-4">

                                            Chưa có hướng dẫn viên nào.

                                        </td>

                                    </tr>
                                @endforelse

                            </tbody>

                        </table>

                    </div>

                </div>

                <div class="card-footer text-center">

                    {{ $guides->appends(request()->query())->links() }}

                </div>

            </div>

        </div>

    @endsection
