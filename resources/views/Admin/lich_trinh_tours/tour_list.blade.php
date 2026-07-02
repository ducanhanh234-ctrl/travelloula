@extends('layouts.admin')

@section('title', 'Quản lý Lịch trình Tour')

@section('breadcrumb')
    <li class="breadcrumb-item active">
        Quản lý Lịch trình Tour
    </li>
@endsection

@section('content')

    <div class="fade-in">

        {{-- Header --}}
        <div class="d-flex justify-content-between align-items-center mb-4">

            <div>

                <h3 class="fw-bold mb-1">
                    Quản lý Lịch trình Tour
                </h3>

                <p class="text-muted mb-0">
                    Chọn tour để quản lý lịch trình chi tiết.
                </p>

            </div>

        </div>

        {{-- Thống kê --}}
        <div class="stats-grid mb-4">

            <div class="stat-card">

                <div class="stat-icon stat-icon-primary">
                    <i class="fas fa-route"></i>
                </div>

                <div class="stat-value">
                    {{ $tongTour }}
                </div>

                <div class="stat-label">
                    Tổng Tour
                </div>

            </div>

            <div class="stat-card">

                <div class="stat-icon stat-icon-success">
                    <i class="fas fa-check-circle"></i>
                </div>

                <div class="stat-value">
                    {{ $activeTour }}
                </div>

                <div class="stat-label">
                    Đang hoạt động
                </div>

            </div>

            <div class="stat-card">

                <div class="stat-icon stat-icon-danger">
                    <i class="fas fa-ban"></i>
                </div>

                <div class="stat-value">
                    {{ $inactiveTour }}
                </div>

                <div class="stat-label">
                    Ngừng hoạt động
                </div>

            </div>

            <div class="stat-card">

                <div class="stat-icon stat-icon-info">
                    <i class="fas fa-list"></i>
                </div>

                <div class="stat-value">
                    {{ $tours->count() }}
                </div>

                <div class="stat-label">
                    Hiển thị
                </div>

            </div>

        </div>
        <div class="card mb-4">

            <div class="card-header">
                <i class="fas fa-filter me-2"></i>
                Bộ lọc tìm kiếm
            </div>

            <div class="card-body">

                <form method="GET" action="{{ route('Admin.lich_trinh_tours.index') }}">

                    <div class="row g-3">

                        <div class="col-md-5">

                            <input type="text" name="keyword" class="form-control" placeholder="Tìm tên tour..."
                                value="{{ request('keyword') }}">

                        </div>

                        <div class="col-md-4">

                            <select name="trang_thai" class="form-select">

                                <option value="">
                                    Tất cả trạng thái
                                </option>

                                <option value="active" {{ request('trang_thai') == 'active' ? 'selected' : '' }}>
                                    Đang hoạt động
                                </option>

                                <option value="inactive" {{ request('trang_thai') == 'inactive' ? 'selected' : '' }}>
                                    Ngừng hoạt động
                                </option>

                            </select>

                        </div>

                        <div class="col-md-3 d-flex gap-2">

                            <button class="btn btn-primary flex-fill">

                                <i class="fas fa-search"></i>

                                Tìm kiếm

                            </button>

                            <a href="{{ route('Admin.lich_trinh_tours.index') }}" class="btn btn-secondary">

                                <i class="fas fa-rotate-right"></i>

                            </a>

                        </div>

                    </div>

                </form>

            </div>

        </div>

        {{-- Danh sách --}}
        <div class="card">

            <div class="card-header d-flex justify-content-between align-items-center">

                <span>

                    <i class="fas fa-map me-2"></i>

                    Danh sách Tour

                </span>

                <span class="badge badge-primary">

                    {{ $tours->count() }} Tour

                </span>

            </div>

            <div class="card-body p-0">

                <div class="table-responsive">

                    <table class="table mb-0">

                        <thead>

                            <tr>

                                <th width="70">
                                    STT
                                </th>
                                <th width="100">
                                    Ảnh
                                </th>

                                <th>
                                    Tên Tour
                                </th>

                                <th width="150">
                                    Thời lượng
                                </th>

                                <th width="150">
                                    Trạng thái
                                </th>

                                <th width="140">
                                    Thao tác
                                </th>

                            </tr>

                        </thead>

                        <tbody>

                            @forelse($tours as $tour)
                                <tr>

                                    <td>

                                        {{ $loop->iteration }}

                                    </td>
                                    <td>

                                        @if ($tour->anh_dai_dien)
                                            <img src="{{ asset('storage/' . $tour->anh_dai_dien) }}"
                                                class="rounded shadow-sm" style="width:80px;height:60px;object-fit:cover;">
                                        @else
                                            <img src="{{ asset('images/no-image.png') }}" class="rounded shadow-sm"
                                                style="width:80px;height:60px;object-fit:cover;">
                                        @endif

                                    </td>
                                    <td>

                                        <strong>

                                            {{ $tour->ten_tour }}

                                        </strong>

                                    </td>

                                    <td>

                                        {{ $tour->thoi_luong }}

                                    </td>

                                    <td>

                                        @if ($tour->trang_thai == 'active')
                                            <span class="badge badge-success">

                                                Đang hoạt động

                                            </span>
                                        @else
                                            <span class="badge badge-danger">

                                                Ngừng hoạt động

                                            </span>
                                        @endif

                                    </td>

                                    <td>

                                        <a href="{{ route('Admin.lich_trinh_tours.tour', $tour->id) }}"
                                            class="btn btn-outline-primary btn-sm" title="Xem lịch trình">

                                            <i class="fas fa-eye"></i>

                                        </a>

                                    </td>

                                </tr>

                            @empty

                                <tr>

                                    <td colspan="5" class="text-center text-muted py-4">

                                        <i class="fas fa-folder-open fa-2x mb-2"></i>

                                        <br>

                                        Chưa có tour nào.

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
