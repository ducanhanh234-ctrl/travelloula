@extends('layouts.admin')

@section('content')
    <div class="container">
        {{-- header --}}
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h3 class="fw-bold mb-1">Quản lý Tour</h3>
                <p class="text-muted mb-0">
                    Quản lý danh sách các tour du lịch trong hệ thống
                </p>
            </div>

            <a href="{{ route('Admin.tours.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Thêm Tour
            </a>
        </div>
        <div class="stats-grid">

            <div class="stat-card">
                <div class="stat-icon stat-icon-primary">
                    <i class="fas fa-route"></i>
                </div>
                <div class="stat-value">{{ $tongTour }}</div>
                <div class="stat-label">Tổng Tour</div>
            </div>

            <div class="stat-card">
                <div class="stat-icon stat-icon-success">
                    <i class="fas fa-check-circle"></i>
                </div>
                <div class="stat-value">{{ $activeTour }}</div>
                <div class="stat-label">Đang hoạt động</div>
            </div>

            <div class="stat-card">
                <div class="stat-icon stat-icon-danger">
                    <i class="fas fa-ban"></i>
                </div>
                <div class="stat-value">{{ $inactiveTour }}</div>
                <div class="stat-label">Ngừng hoạt động</div>
            </div>

            <div class="stat-card">
                <div class="stat-icon stat-icon-warning">
                    <i class="fas fa-list"></i>
                </div>
                <div class="stat-value">{{ $tongDanhMuc }}</div>
                <div class="stat-label">Danh mục</div>
            </div>

        </div>
        <div class="card mb-4">

            <div class="card-header">
                <i class="fas fa-filter me-2"></i>
                Bộ lọc tìm kiếm
            </div>

            <div class="card-body">

                <form method="GET">

                    <div class="row g-3">

                        <div class="col-md-3">
                            <input class="form-control" name="keyword" value="{{ request('keyword') }}"
                                placeholder="Tên tour...">
                        </div>

                        <div class="col-md-3">

                            <select name="danh_muc_id" class="form-select">

                                <option value="">Tất cả danh mục</option>

                                @foreach ($danhMucs as $item)
                                    <option value="{{ $item->id }}"
                                        {{ request('danh_muc_id') == $item->id ? 'selected' : '' }}>

                                        {{ $item->ten_danh_muc }}

                                    </option>
                                @endforeach

                            </select>

                        </div>

                        <div class="col-md-2">

                            <select name="trang_thai" class="form-select">

                                <option value="">Trạng thái</option>

                                <option value="active">Đang hoạt động</option>

                                <option value="inactive">Ngừng hoạt động</option>

                            </select>

                        </div>

                        <div class="col-md-2">

                            <select name="sort_price" class="form-select">

                                <option value="">Sắp xếp giá</option>

                                <option value="asc">Giá tăng</option>

                                <option value="desc">Giá giảm</option>

                            </select>

                        </div>

                        <div class="col-md-2 d-flex gap-2">

                            <button class="btn btn-primary flex-fill">

                                <i class="fas fa-search"></i>

                            </button>

                            <a href="{{ route('Admin.tours.index') }}" class="btn btn-secondary">

                                <i class="fas fa-rotate-right"></i>

                            </a>

                        </div>

                    </div>

                </form>

            </div>

        </div>

        <div class="card">

            <div class="card-header d-flex justify-content-between">

                <span>

                    <i class="fas fa-route me-2"></i>

                    Danh sách Tour

                </span>

                <span class="badge badge-primary">

                    {{ $tours->total() }} Tour

                </span>

            </div>

            <div class="card-body p-0">

                <div class="table-responsive">

                    <table class="table mb-0">



                        <thead>

                            <tr>
                                <th>ID</th>
                                <th>Ảnh</th>
                                <th>Tên Tour</th>
                                <th>Giá</th>
                                <th>Danh mục</th>
                                <th>Thời lượng</th>
                                <th>Trạng thái</th>
                                <th width="220">Thao tác</th>
                            </tr>

                        </thead>

                        <tbody>

                            @foreach ($tours as $tour)
                                <tr>

                                    <td>
                                        {{ ($tours->currentPage() - 1) * $tours->perPage() + $loop->iteration }}
                                    </td>

                                    <td>

                                        @if ($tour->anh_dai_dien)
                                            <img src="{{ asset('storage/' . $tour->anh_dai_dien) }}" width="100">
                                        @endif

                                    </td>

                                    <td>{{ $tour->ten_tour }}</td>

                                    <td>

                                        {{ number_format($tour->gia_tour) }} VNĐ

                                    </td>
                                    <td>
                                        {{ $tour->danhMuc?->ten_danh_muc }}
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

                                        <div class="d-flex gap-1">

                                            <a href="{{ route('Admin.tours.show', $tour) }}"
                                                class="btn btn-outline-primary btn-sm">

                                                <i class="fas fa-eye"></i>

                                            </a>

                                            <a href="{{ route('Admin.tours.edit', $tour) }}"
                                                class="btn btn-warning btn-sm">

                                                <i class="fas fa-edit"></i>

                                            </a>

                                            <form action="{{ route('Admin.tours.destroy', $tour) }}" method="POST"
                                                class="d-inline">

                                                @csrf
                                                @method('DELETE')

                                                <button class="btn btn-danger btn-sm"
                                                    onclick="return confirm('Bạn có chắc muốn xóa?')">

                                                    <i class="fas fa-trash"></i>

                                                </button>

                                            </form>

                                        </div>

                                        </form>

                                    </td>

                                </tr>
                            @endforeach

                        </tbody>

                    </table>
                </div>
            </div>
        </div>

        <div class="card-footer text-center">

            {{ $tours->appends(request()->query())->links() }}

        </div>

    </div>
@endsection
