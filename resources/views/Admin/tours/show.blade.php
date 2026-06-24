@extends('layouts/admin_pro')

@section('content')

<div class="container-fluid">

    <div class="card">

        <div class="card-header d-flex justify-content-between">

            <h4>Chi tiết Tour</h4>

            <a href="{{ route('Admin.tours.index') }}" class="btn btn-secondary">
                Quay lại
            </a>

        </div>

        <div class="card-body">

            <div class="row">

                <div class="col-md-4">

                    @if($tour->anh_dai_dien)

                    <img src="{{ asset('storage/'.$tour->anh_dai_dien) }}" class="img-fluid rounded border">

                    @else

                    <img src="https://via.placeholder.com/400x300" class="img-fluid rounded border">

                    @endif

                </div>

                <div class="col-md-8">

                    <table class="table table-bordered">

                        <tr>
                            <th width="250">ID</th>
                            <td>{{ $tour->id }}</td>
                        </tr>

                        <tr>
                            <th>Tên tour</th>
                            <td>{{ $tour->ten_tour }}</td>
                        </tr>

                        <tr>
                            <th>Slug</th>
                            <td>{{ $tour->duong_dan }}</td>
                        </tr>

                        <tr>
                            <th>Giá tour</th>
                            <td>
                                {{ number_format($tour->gia_tour) }} VNĐ
                            </td>
                        </tr>

                        <tr>
                            <th>Thời lượng</th>
                            <td>{{ $tour->thoi_luong }}</td>
                        </tr>

                        <tr>
                            <th>Điểm khởi hành</th>
                            <td>{{ $tour->dia_diem_khoi_hanh }}</td>
                        </tr>

                        <tr>
                            <th>Điểm đến</th>
                            <td>{{ $tour->diem_den }}</td>
                        </tr>

                        <tr>
                            <th>Số khách tối đa</th>
                            <td>{{ $tour->so_khach_toi_da }}</td>
                        </tr>

                        <tr>
                            <th>Phương tiện</th>
                            <td>{{ $tour->phuong_tien }}</td>
                        </tr>

                        <tr>
                            <th>Khách sạn</th>
                            <td>{{ $tour->tieu_chuan_khach_san }}</td>
                        </tr>

                        <tr>
                            <th>Trạng thái</th>
                            <td>

                                @if($tour->trang_thai == 'active')

                                <span class="badge bg-success">
                                    Hoạt động
                                </span>

                                @else

                                <span class="badge bg-danger">
                                    Ngừng hoạt động
                                </span>

                                @endif

                            </td>
                        </tr>

                    </table>

                </div>

            </div>

            <hr>

            <h5>Mô tả</h5>

            <div class="border p-3 rounded mb-4">
                {!! nl2br(e($tour->mo_ta)) !!}
            </div>

            <h5>Tổng quan lịch trình</h5>

            <div class="border p-3 rounded mb-4">
                {!! nl2br(e($tour->tong_quan_lich_trinh)) !!}
            </div>

            <h5>Dịch vụ bao gồm</h5>

            <div class="border p-3 rounded mb-4">
                {!! nl2br(e($tour->dich_vu_bao_gom)) !!}
            </div>

            <h5>Dịch vụ không bao gồm</h5>

            <div class="border p-3 rounded">
                {!! nl2br(e($tour->dich_vu_khong_bao_gom)) !!}
            </div>

        </div>

    </div>

</div>

@endsection
