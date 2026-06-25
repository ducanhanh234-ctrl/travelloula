@extends('layouts/admin_pro')
@section('title', 'Quản Lý Tour')

@section('vendor-style')
@vite('resources/assets/vendor/libs/apex-charts/apex-charts.scss')
@endsection

@section('vendor-script')
@vite('resources/assets/vendor/libs/apex-charts/apexcharts.js')
@endsection

@section('page-script')
@vite('resources/assets/js/dashboards-analytics.js')
@endsection
@section('content')
<div class="card">

    ```
    <div class="card-header d-flex justify-content-between align-items-center">
        <div>
            <h4 class="card-title mb-0">Quản lý Tour</h4>
            <small class="text-muted">
                Danh sách tất cả tour trong hệ thống
            </small>
        </div>

        <a href="{{ route('Admin.tours.create') }}" class="btn btn-primary">
            <i class="bx bx-plus"></i>
            Thêm Tour
        </a>
    </div>

    {{-- Bộ lọc --}}
    <div class="card-body border-bottom">
        <form method="GET">
            <div class="row g-3">

                <div class="col-md-3">
                    <input type="text" name="keyword" class="form-control" placeholder="Tên tour..." value="{{ request('keyword') }}">
                </div>

                <div class="col-md-3">
                    <select name="danh_muc_id" class="form-select">
                        <option value="">Tất cả danh mục</option>

                        @foreach ($danhMucs as $item)
                        <option value="{{ $item->id }}" {{ request('danh_muc_id') == $item->id ? 'selected' : '' }}>
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
                        <option value="asc">Giá tăng dần</option>
                        <option value="desc">Giá giảm dần</option>
                    </select>
                </div>

                <div class="col-md-2">
                    <button class="btn btn-primary w-100">
                        <i class="bx bx-search"></i>
                        Tìm kiếm
                    </button>
                </div>

            </div>
        </form>
    </div>

    {{-- Bảng --}}
    <div class="table-responsive text-nowrap">

        <table class="table table-hover align-middle mb-0">

            <thead class="table-dark">
                <tr>
                    <th>#</th>
                    <th>Ảnh</th>
                    <th>Tên Tour</th>
                    <th>Giá</th>
                    <th>Danh mục</th>
                    <th>Điểm đến</th>
                    <th>Trạng thái</th>
                    <th width="180">Thao tác</th>
                </tr>
            </thead>

            <tbody>

                @forelse($tours as $tour)

                <tr>

                    <td>
                        {{ ($tours->currentPage()-1)*$tours->perPage()+$loop->iteration }}
                    </td>

                    <td>
                        @if($tour->anh_dai_dien)
                        <img src="{{ asset('storage/'.$tour->anh_dai_dien) }}" class="rounded" width="90">
                        @endif
                    </td>

                    <td>
                        <strong>{{ $tour->ten_tour }}</strong>
                    </td>

                    <td>
                        {{ number_format($tour->gia_tour) }} đ
                    </td>

                    <td>
                        {{ $tour->danhMuc?->ten_danh_muc }}
                    </td>

                    <td>
                        {{ $tour->diem_den }}
                    </td>

                    <td>
                        @if($tour->trang_thai == 'active')
                        <span class="badge bg-label-success">
                            Đang hoạt động
                        </span>
                        @else
                        <span class="badge bg-label-danger">
                            Ngừng hoạt động
                        </span>
                        @endif
                    </td>

                    <td>
                        <div class="d-flex gap-1">

                            <a href="{{ route('Admin.tours.show',$tour) }}" class="btn btn-icon btn-info">
                                <i class="bx bx-show"></i>
                            </a>

                            <a href="{{ route('Admin.tours.edit',$tour) }}" class="btn btn-icon btn-warning">
                                <i class="bx bx-edit"></i>
                            </a>

                            <form action="{{ route('Admin.tours.destroy',$tour) }}" method="POST">

                                @csrf
                                @method('DELETE')

                                <button onclick="return confirm('Bạn có chắc muốn xóa?')" class="btn btn-icon btn-danger">

                                    <i class="bx bx-trash"></i>

                                </button>
                            </form>

                        </div>
                    </td>

                </tr>

                @empty

                <tr>
                    <td colspan="8" class="text-center py-4">
                        Không có dữ liệu
                    </td>
                </tr>

                @endforelse

            </tbody>

        </table>

    </div>

    <div class="card-footer">
        {{ $tours->appends(request()->query())->links() }}
    </div>
    ```

</div>

@endsection
