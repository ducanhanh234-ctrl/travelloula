@extends('layouts.admin')

@section('title', 'Quản lý Lịch trình Tour')

@section('breadcrumb')
    <li class="breadcrumb-item">
        <a href="{{ route('Admin.tours.index') }}">Tour</a>
    </li>
    <li class="breadcrumb-item active">
        Lịch trình
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
                    Tour:
                    <strong>{{ $tour->ten_tour }}</strong>
                </p>

            </div>

            <a href="{{ route('Admin.lich_trinh_tours.create', ['tour_id' => $tour->id]) }}" class="btn btn-primary">

                <i class="fas fa-plus"></i>

                Thêm lịch trình

            </a>

        </div>

        {{-- Thống kê --}}
        <div class="stats-grid mb-4">

            <div class="stat-card">

                <div class="stat-icon stat-icon-primary">
                    <i class="fas fa-route"></i>
                </div>

                <div class="stat-value">
                    {{ $tongNgay }}
                </div>

                <div class="stat-label">
                    Tổng ngày lịch trình
                </div>

            </div>

            <div class="stat-card">

                <div class="stat-icon stat-icon-success">
                    <i class="fas fa-map-marker-alt"></i>
                </div>

                <div class="stat-value">
                    {{ $tongDiaDiem }}
                </div>

                <div class="stat-label">
                    Địa điểm
                </div>

            </div>

            {{-- <div class="stat-card">

                <div class="stat-icon stat-icon-warning">
                    <i class="fas fa-calendar-alt"></i>
                </div>

                <div class="stat-value">
                    {{ $ngayCuoi }}
                </div>

                <div class="stat-label">
                    Ngày cuối
                </div>

            </div>

            <div class="stat-card">

                <div class="stat-icon stat-icon-info">
                    <i class="fas fa-list"></i>
                </div>

                <div class="stat-value">
                    {{ $tour->id }}
                </div>

                <div class="stat-label">
                    Mã Tour
                </div>

            </div> --}}

        </div>

        {{-- Danh sách --}}
        <div class="card">

            <div class="card-header d-flex justify-content-between align-items-center">

                <span>

                    <i class="fas fa-list me-2"></i>

                    Danh sách lịch trình

                </span>

                <span class="badge badge-primary">

                    {{ $lichTrinhs->count() }} ngày

                </span>

            </div>

            <div class="card-body p-0">

                <div class="table-responsive">

                    <table class="table mb-0">

                        <thead>

                            <tr>

                                <th width="90">
                                    Ngày
                                </th>

                                <th>
                                    Tiêu đề
                                </th>

                                <th>
                                    Địa điểm
                                </th>

                                <th width="160">
                                    Thao tác
                                </th>

                            </tr>

                        </thead>

                        <tbody>

                            @forelse($lichTrinhs as $item)
                                <tr>

                                    <td>

                                        <span class="badge badge-info">

                                            Ngày {{ $item->ngay_thu }}

                                        </span>

                                    </td>

                                    <td>

                                        <strong>

                                            {{ $item->tieu_de }}

                                        </strong>

                                    </td>

                                    <td>

                                        <i class="fas fa-map-marker-alt text-danger me-1"></i>

                                        {{ $item->dia_diem }}

                                    </td>

                                    <td>

                                        <div class="d-flex gap-1">

                                            <a href="{{ route('Admin.lich_trinh_tours.edit', $item->id) }}"
                                                class="btn btn-warning btn-sm" title="Sửa">

                                                <i class="fas fa-edit"></i>

                                            </a>

                                            <form action="{{ route('Admin.lich_trinh_tours.destroy', $item->id) }}"
                                                method="POST" class="d-inline">

                                                @csrf
                                                @method('DELETE')

                                                <button type="submit" onclick="return confirm('Bạn có chắc muốn xóa?')"
                                                    class="btn btn-danger btn-sm">

                                                    <i class="fas fa-trash"></i>

                                                </button>

                                            </form>

                                        </div>

                                    </td>

                                </tr>

                            @empty

                                <tr>

                                    <td colspan="4" class="text-center text-muted py-4">

                                        <i class="fas fa-folder-open fa-2x mb-2"></i>

                                        <br>

                                        Chưa có lịch trình nào.

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
