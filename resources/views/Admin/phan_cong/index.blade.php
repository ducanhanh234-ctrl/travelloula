@extends('layouts.admin')

@section('title', 'Quản lý Phân công')

@section('breadcrumb')
<li class="breadcrumb-item active">
    Quản lý Phân công
</li>
@endsection

@section('content')

<div class="fade-in">

    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h3 class="fw-bold mb-1">
                Quản lý Phân công
            </h3>

            <p class="text-muted mb-0">
                Quản lý phân công hướng dẫn viên và phương tiện cho các lịch khởi hành
            </p>
        </div>

        <a href="{{ route('Admin.phan-cong.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i>
            Phân công mới
        </a>

    </div>
    @if (session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
    @endif
    {{-- Thống kê --}}
    {{-- <div class="stats-grid">

        <div class="stat-card">
            <div class="stat-icon stat-icon-primary">
                <i class="fas fa-clipboard-list"></i>
            </div>

            <div class="stat-value">
                {{ $tongPhanCong }}
</div>

<div class="stat-label">
    Tổng phân công
</div>
</div>

{{-- <div class="stat-card">
            <div class="stat-icon stat-icon-success">
                <i class="fas fa-check-circle"></i>
            </div>

            <div class="stat-value">
                {{ $daPhanCong }}
</div>

<div class="stat-label">
    Đã phân công
</div>
</div> --}}

{{-- <div class="stat-card">
            <div class="stat-icon stat-icon-warning">
                <i class="fas fa-bus"></i>
            </div>

            <div class="stat-value">
                {{ $dangKhoiHanh }}
</div>

<div class="stat-label">
    Đang khởi hành
</div>
</div> --}}

{{-- <div class="stat-card">
            <div class="stat-icon stat-icon-info">
                <i class="fas fa-flag-checkered"></i>
            </div>

            <div class="stat-value">
                {{ $hoanThanh }}
</div>

<div class="stat-label">
    Hoàn thành
</div>
</div>

</div> --}}

{{-- Bộ lọc --}}
<div class="card mb-4">

    <div class="card-header">
        <i class="fas fa-filter me-2"></i>
        Bộ lọc tìm kiếm
    </div>

    <div class="card-body">

        <form method="GET" action="{{ route('Admin.phan-cong.index') }}">

            <div class="row align-items-end g-3">

                <div class="col-md-9">

                    <label class="form-label fw-semibold">
                        <i class="fas fa-search me-1"></i>
                        Tìm kiếm
                    </label>

                    <input type="text" class="form-control" name="keyword" value="{{ request('keyword') }}" placeholder="Nhập tên hướng dẫn viên hoặc biển số xe...">

                </div>

                <div class="col-md-3">

                    <label class="form-label d-block">&nbsp;</label>

                    <div class="d-flex gap-2">

                        <button type="submit" class="btn btn-primary flex-fill">
                            <i class="fas fa-search me-1"></i>
                            Tìm kiếm
                        </button>

                        <a href="{{ route('Admin.phan-cong.index') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-rotate-right"></i>
                        </a>

                    </div>

                </div>

            </div>

        </form>

    </div>

</div>

{{-- Danh sách --}}
<div class="card">

    <div class="card-header d-flex justify-content-between">

        <span>

            <i class="fas fa-list me-2"></i>

            Danh sách phân công

        </span>

        <span class="badge badge-primary">

            {{ $phanCongs->total() }}

            phân công

        </span>

    </div>

    <div class="card-body p-0">

        <div class="table-responsive">

            <table class="table mb-0">

                <thead>

                    <tr>

                        <th>#</th>

                        <th>Lịch khởi hành</th>

                        <th>Hướng dẫn viên</th>

                        <th>Phương tiện</th>

                        <th>Ngày phân công</th>

                        <th>Thao tác</th>

                    </tr>

                </thead>

                <tbody>

                    @forelse($phanCongs as $phanCong)

                    <tr>

                        <td>{{ $phanCong->id }}</td>

                        <td>

                            MKH {{ $phanCong->lichKhoiHanh->id ?? '-' }}

                        </td>

                        <td>

                            {{ $phanCong->hdv->ho_ten ?? '-' }}

                        </td>

                        <td>

                            {{ $phanCong->phuongTien->bien_so_xe ?? '-' }} -- {{ $phanCong->phuongTien->loai_phuong_tien ?? '-' }}

                        </td>

                        <td>

                            {{ $phanCong->ngay_phan_cong ? \Carbon\Carbon::parse($phanCong->ngay_phan_cong)->format('d/m/Y') : '-' }}

                        </td>



                        <td>

                            <a href="{{ route('Admin.phan-cong.show',$phanCong->id) }}" class="btn btn-sm btn-outline-primary">

                                <i class="fas fa-eye"></i>

                            </a>

                            <a href="{{ route('Admin.phan-cong.edit',$phanCong->id) }}" class="btn btn-sm btn-warning">

                                <i class="fas fa-edit"></i>

                            </a>
                            <form action="{{ route('Admin.phan-cong.destroy', $phanCong->id) }}" method="POST" class="d-inline form-delete" onsubmit="confirm('Bạn có chắc muốn xóa không?')">

                                @csrf
                                @method('DELETE')

                                <button type="submit" class="btn btn-sm btn-outline-danger">

                                    <i class="fas fa-trash"></i>

                                </button>

                            </form>

                        </td>

                    </tr>

                    @empty

                    <tr>

                        <td colspan="7" class="text-center text-muted">

                            Chưa có dữ liệu phân công

                        </td>

                    </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

    <div class="card-footer">

        {{ $phanCongs->links() }}

    </div>

</div>

</div>

@endsection
