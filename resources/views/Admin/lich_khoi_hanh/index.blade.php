@extends('layouts.admin')

@section('title', 'Quản lý lịch khởi hành')

@section('content')

    <div class="container-fluid fade-in">

        {{-- HEADER --}}
        <link rel="stylesheet" href="{{ asset('admin-assets/css/lich-khoi-hanh.css') }}">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h3 class="fw-bold mb-1">
                    <i class="fas fa-plane-departure text-primary"></i>
                    Quản lý lịch khởi hành
                </h3>
                <div class="text-muted">
                    Danh sách tất cả lịch khởi hành tour
                </div>
            </div>

            <a href="{{ route('Admin.lich-khoi-hanh.create') }}" class="btn btn-primary shadow-sm">
                <i class="fas fa-plus"></i> Thêm lịch mới
            </a>
        </div>

        {{-- ALERT --}}
        @if (session('success'))
            <div class="alert alert-success">
                <i class="fas fa-check-circle"></i>
                {{ session('success') }}
            </div>
        @endif

        {{-- STATS --}}
        <div class="stats-grid"
            style="display:grid;
            grid-template-columns:repeat(6,1fr);
            gap:20px;padding: 20px;">

            {{-- Tổng lịch --}}
            <div class="stat-card">
                <div class="stat-icon stat-icon-primary">
                    <i class="fas fa-calendar"></i>
                </div>

                <div class="stat-value">
                    {{ $data->count() }}
                </div>

                <div class="stat-label">
                    Tổng lịch khởi hành
                </div>
            </div>

            {{-- Mở bán --}}
            <div class="stat-card">
                <div class="stat-icon stat-icon-success">
                    <i class="fas fa-check"></i>
                </div>

                <div class="stat-value">
                    {{ $moBan }}
                </div>

                <div class="stat-label">
                    Mở bán
                </div>
            </div>

            {{-- Đang diễn ra --}}
            <div class="stat-card">
                <div class="stat-icon stat-icon-warning">
                    <i class="fas fa-route"></i>
                </div>

                <div class="stat-value">
                    {{ $dangDienRa }}
                </div>

                <div class="stat-label">
                    Đang diễn ra
                </div>
            </div>

            {{-- Hết chỗ --}}
            <div class="stat-card">
                <div class="stat-icon stat-icon-danger">
                    <i class="fas fa-users-slash"></i>
                </div>

                <div class="stat-value">
                    {{ $hetCho }}
                </div>

                <div class="stat-label">
                    Hết chỗ
                </div>
            </div>

            {{-- Đã kết thúc --}}
            <div class="stat-card">
                <div class="stat-icon stat-icon-secondary">
                    <i class="fas fa-flag-checkered"></i>
                </div>

                <div class="stat-value">
                    {{ $daKetThuc }}
                </div>

                <div class="stat-label">
                    Đã kết thúc
                </div>
            </div>

            {{-- Đã đóng --}}
            <div class="stat-card">
                <div class="stat-icon stat-icon-dark">
                    <i class="fas fa-lock"></i>
                </div>

                <div class="stat-value">
                    {{ $daDong }}
                </div>

                <div class="stat-label">
                    Đã đóng
                </div>
            </div>

        </div>

        {{-- TABLE --}}
        <div class="card shadow-sm border-0">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="mb-0 fw-bold">
                        <i class="fas fa-table text-primary"></i>
                        Danh sách lịch khởi hành
                    </h5>
                </div>

                <form method="GET">
                    <div class="row g-2 align-items-center">

                        {{-- Tìm kiếm tour --}}
                        <div class="col-md-3">
                            <div class="input-group">
                                <span class="input-group-text bg-white">
                                    <i class="fas fa-search text-muted"></i>
                                </span>

                                <input type="text" name="keyword" class="form-control" placeholder="Tìm kiếm"
                                    value="{{ request('keyword') }}">
                            </div>
                        </div>

                        {{-- Trạng thái --}}
                        <div class="col-md-2">
                            <select name="status" class="form-control">
                                <option value="">-- Trạng thái --</option>

                                <option value="Mở bán" {{ request('status') == 'Mở bán' ? 'selected' : '' }}>
                                    Mở bán
                                </option>

                                <option value="Đang diễn ra" {{ request('status') == 'Đang diễn ra' ? 'selected' : '' }}>
                                    Đang diễn ra
                                </option>

                                <option value="Hết chỗ" {{ request('status') == 'Hết chỗ' ? 'selected' : '' }}>
                                    Hết chỗ
                                </option>

                                <option value="Đã kết thúc" {{ request('status') == 'Đã kết thúc' ? 'selected' : '' }}>
                                    Đã kết thúc
                                </option>

                                <option value="Đã đóng" {{ request('status') == 'Đã đóng' ? 'selected' : '' }}>
                                    Đã đóng
                                </option>

                                <option value="Đã hủy" {{ request('status') == 'Đã hủy' ? 'selected' : '' }}>
                                    Đã hủy
                                </option>
                            </select>
                        </div>

                        {{-- Từ ngày --}}
                        <div class="col-md-2">
                            <input type="date" name="from_date" class="form-control" value="{{ request('from_date') }}">
                        </div>

                        {{-- Đến ngày --}}
                        <div class="col-md-2">
                            <input type="date" name="to_date" class="form-control" value="{{ request('to_date') }}">
                        </div>

                        <div class="col-md-auto">
                            <button type="submit" class="btn btn-primary btn-action">
                                <i class="fas fa-search"></i>
                                <span>Tìm kiếm</span>
                            </button>
                        </div>

                        <div class="col-md-auto">
                            <a href="{{ route('Admin.lich-khoi-hanh.index') }}" class="btn btn-secondary btn-action">
                                <i class="fas fa-sync"></i>
                                <span>Làm mới</span>
                            </a>
                        </div>
                    </div>

                </form>

            </div>

            <div class="card-body p-0">

                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">

                        <thead>
                            <tr>
                                <th>STT</th>
                                <th style="min-width: 200px">
                                    Tour
                                </th>
                                <th style="min-width: 200px" class="text-nowrap">
                                    Hướng dẫn viên
                                </th>
                                <th>Thời gian</th>
                                <th>Số chỗ</th>
                                <th>Giá</th>
                                <th class="text-center">
                                    Trạng thái
                                </th>
                                <th width="100">Thao tác</th>
                            </tr>
                        </thead>

                        <tbody>

                            @forelse ($data as $item)
                                <tr>
                                    <td>
                                        <span class="fw-bold">
                                            {{ $loop->iteration }}
                                        </span>
                                    </td>

                                    <td>
                                        <div class="fw-semibold">
                                            {{ $item->tour->ten_tour ?? 'Không có tour' }}
                                        </div>
                                        <small class="text-muted">
                                            ID tour hệ thống
                                        </small>
                                    </td>

                                    <td>
                                        @if ($item->huongDanVien)
                                            <div class="guide-cell">
                                                <div>
                                                    <div class="fw-semibold">
                                                        {{ $item->huongDanVien->ho_ten }}
                                                    </div>

                                                    <small class="text-muted">
                                                        HDV phụ trách
                                                    </small>
                                                </div>
                                            </div>
                                        @else
                                            <span class="badge bg-secondary">
                                                Chưa phân công
                                            </span>
                                        @endif
                                    </td>

                                    <td>
                                        <div>
                                            {{ \Carbon\Carbon::parse($item->ngay_khoi_hanh)->format('d/m/Y') }}
                                        </div>

                                        <small class="text-muted">
                                            đến
                                            {{ \Carbon\Carbon::parse($item->ngay_ket_thuc)->format('d/m/Y') }}
                                        </small>
                                    </td>

                                    {{-- <td>
                                        @php
                                            $tyLe = ($item->so_cho_con_lai / $item->so_cho) * 100;
                                        @endphp

                                        @if ($tyLe > 50)
                                            <span class="badge bg-success">
                                            @elseif ($tyLe > 20)
                                                <span class="badge bg-warning">
                                                @else
                                                    <span class="badge bg-danger">
                                        @endif

                                        {{ $item->so_cho_con_lai }}/{{ $item->so_cho }}

                                        </span>

                                        <br>

                                        <small class="text-muted">
                                            Đã đặt: {{ $item->so_cho_da_dat }}
                                        </small>

                                    </td> --}}

                                    <td>

                                        @php
                                            $tyLe =
                                                $item->so_cho > 0 ? ($item->so_cho_da_dat / $item->so_cho) * 100 : 0;
                                        @endphp

                                        @if ($tyLe < 50)
                                            <span class="badge bg-success">
                                            @elseif($tyLe < 80)
                                                <span class="badge bg-warning">
                                                @else
                                                    <span class="badge bg-danger">
                                        @endif

                                        {{ $item->so_cho_da_dat }}/{{ $item->so_cho }}

                                        </span>

                                        <br>

                                        <small class="text-muted">
                                            Còn {{ $item->so_cho_con_lai }} chỗ
                                        </small>

                                    </td>

                                    <td>
                                        <div class="fw-bold text-primary">
                                            Người lớn: {{ number_format($item->gia_nguoi_lon, 0, ',', '.') }}₫
                                        </div>

                                        <small class="text-muted">
                                            Trẻ em: {{ number_format($item->gia_tre_em, 0, ',', '.') }}₫
                                        </small>
                                    </td>

                                    <td>

                                        @switch($item->trang_thai_hien_thi)
                                            @case('Mở bán')
                                                <span class="badge bg-success">
                                                    Mở bán
                                                </span>
                                            @break

                                            @case('Đã đóng')
                                                <span class="badge bg-info text-dark">
                                                    Đã đóng
                                                </span>
                                            @break

                                            @case('Đang diễn ra')
                                                <span class="badge bg-warning text-dark">
                                                    Đang diễn ra
                                                </span>
                                            @break

                                            @case('Hết chỗ')
                                                <span class="badge bg-danger">
                                                    Hết chỗ
                                                </span>
                                            @break

                                            @case('Đã kết thúc')
                                                <span class="badge bg-secondary">
                                                    Đã kết thúc
                                                </span>
                                            @break

                                            @case('Đã hủy')
                                                <span class="badge bg-dark">
                                                    Đã hủy
                                                </span>
                                            @break
                                        @endswitch
                                    </td>

                                    <td>
                                        <div class="d-flex gap-2">
                                            <a href="{{ route('Admin.lich-khoi-hanh.show', $item->id) }}"
                                                class="btn btn-sm btn-info" title="Xem chi tiết">
                                                <i class="fas fa-eye"></i>
                                            </a>

                                            <a href="{{ route('Admin.lich-khoi-hanh.edit', $item->id) }}"
                                                class="btn btn-sm btn-primary" title="Sửa">
                                                <i class="fas fa-edit"></i>
                                            </a>

                                            <form action="{{ route('Admin.lich-khoi-hanh.destroy', $item->id) }}"
                                                method="POST">

                                                @csrf
                                                @method('DELETE')

                                                <button type="button" class="btn btn-sm btn-danger btn-delete"
                                                    title="Xóa">

                                                    <i class="fas fa-trash"></i>

                                                </button>

                                            </form>

                                        </div>
                                    </td>

                                </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center py-5">
                                            <i class="fas fa-inbox fa-2x text-muted mb-2"></i>
                                            <div>Chưa có lịch khởi hành</div>
                                        </td>
                                    </tr>
                                @endforelse

                            </tbody>

                        </table>
                    </div>

                </div>
                {{-- <div class="p-3">
                    {{ $data->links() }}
                </div> --}}
                <div class="card-footer d-flex justify-content-between align-items-center">

                    <small class="text-muted">
                        Hiển thị {{ $data->firstItem() }}
                        đến {{ $data->lastItem() }}
                        của {{ $data->total() }} lịch khởi hành
                    </small>

                    {{ $data->links() }}

                </div>
            </div>
        </div>

        <script>
            document.querySelectorAll('.btn-delete').forEach(button => {

                button.addEventListener('click', function() {

                    let form = this.closest('form');

                    Swal.fire({
                        title: 'Xóa lịch khởi hành?',
                        text: 'Dữ liệu sẽ không thể khôi phục',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Xóa',
                        cancelButtonText: 'Hủy'
                    }).then((result) => {

                        if (result.isConfirmed) {
                            form.submit();
                        }

                    });

                });

            });
        </script>

    @endsection
