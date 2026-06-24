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
<div class="container">

    <div class="d-flex justify-content-between mb-3">

        <h3>Quản lý Tour</h3>

        <a href="{{ route('Admin.tours.create') }}" class="btn btn-primary">
            Thêm Tour
        </a>

    </div>
    <div class="card mb-3">

        <div class="card-body">

            <form method="GET">

                <div class="row">

                    <div class="col-md-3">

                        <input type="text" name="keyword" class="form-control" placeholder="Tên tour..." value="{{ request('keyword') }}">

                    </div>

                    <div class="col-md-3">

                        <select name="danh_muc_id" class="form-control">

                            <option value="">
                                Tất cả danh mục
                            </option>

                            @foreach ($danhMucs as $item)
                            <option value="{{ $item->id }}" {{ request('danh_muc_id') == $item->id ? 'selected' : '' }}>

                                {{ $item->ten_danh_muc }}

                            </option>
                            @endforeach

                        </select>

                    </div>

                    <div class="col-md-2">

                        <select name="trang_thai" class="form-control">

                            <option value="">
                                Trạng thái
                            </option>

                            <option value="active" {{ request('trang_thai') == 'active' ? 'selected' : '' }}>

                                Đang hoạt động

                            </option>

                            <option value="inactive" {{ request('trang_thai') == 'inactive' ? 'selected' : '' }}>

                                Ngừng hoạt động

                            </option>

                        </select>

                    </div>

                    <div class="col-md-2">

                        <select name="sort_price" class="form-control">

                            <option value="">
                                Sắp xếp giá
                            </option>

                            <option value="asc" {{ request('sort_price') == 'asc' ? 'selected' : '' }}>

                                Giá tăng dần

                            </option>

                            <option value="desc" {{ request('sort_price') == 'desc' ? 'selected' : '' }}>

                                Giá giảm dần

                            </option>

                        </select>

                    </div>

                    <div class="col-md-2">

                        <button class="btn btn-primary w-100">

                            Tìm Kiếm

                        </button>

                    </div>

                </div>

            </form>

        </div>

    </div>


    <table class="table table-bordered">

        <thead>

            <tr>
                <th>ID</th>
                <th>Ảnh</th>
                <th>Tên Tour</th>
                <th>Giá</th>
                <th>Danh mục</th>
                <th>Điểm đến</th>
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

                    {{ $tour->diem_den }}

                </td>

                <td>
                    @if ($tour->trang_thai == 'active')
                    <span class="badge bg-success">
                        Đang hoạt động
                    </span>
                    @else
                    <span class="badge bg-danger">
                        Ngừng hoạt động
                    </span>
                    @endif
                </td>

                <td>

                    <a href="{{ route('Admin.tours.show', $tour) }}" class="btn btn-info btn-sm">

                        Xem

                    </a>

                    <a href="{{ route('Admin.tours.edit', $tour) }}" class="btn btn-warning btn-sm">

                        Sửa

                    </a>

                    <form action="{{ route('Admin.tours.destroy', $tour) }}" method="POST" class="d-inline">

                        @csrf
                        @method('DELETE')

                        <button onclick="return confirm('Xóa?')" class="btn btn-danger btn-sm">

                            Xóa

                        </button>

                    </form>

                </td>

            </tr>
            @endforeach

        </tbody>

    </table>

    {{ $tours->appends(request()->query())->links() }}

</div>
@endsection
