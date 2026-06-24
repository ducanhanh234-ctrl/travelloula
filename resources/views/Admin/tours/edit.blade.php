@extends('layouts/admin_pro')

@section('content')

<div class="container-fluid">

    <div class="card">

        <div class="card-header d-flex justify-content-between">

            <h4>Cập nhật Tour</h4>

            <a href="{{ route('Admin.tours.index') }}" class="btn btn-secondary">
                Quay lại
            </a>

        </div>

        <div class="card-body">

            <form action="{{ route('Admin.tours.update',$tour) }}" method="POST" enctype="multipart/form-data">

                @csrf
                @method('PUT')

                <div class="row">

                    <div class="col-md-6">

                        <label>Tên Tour</label>

                        <input type="text" name="ten_tour" class="form-control mb-3" value="{{ old('ten_tour',$tour->ten_tour) }}">

                    </div>

                    <div class="col-md-6">

                        <label>Danh mục</label>

                        <select name="danh_muc_id" class="form-control mb-3">

                            @foreach($danhMucs as $item)

                            <option value="{{ $item->id }}" {{ $tour->danh_muc_id == $item->id ? 'selected' : '' }}>

                                {{ $item->ten_danh_muc }}

                            </option>

                            @endforeach

                        </select>

                    </div>

                </div>

                <label>Ảnh đại diện</label>

                @if($tour->anh_dai_dien)

                <div class="mb-2">

                    <img src="{{ asset('storage/'.$tour->anh_dai_dien) }}" width="200">

                </div>

                @endif

                <input type="file" name="anh_dai_dien" class="form-control mb-3">

                <div class="row">

                    <div class="col-md-4">

                        <label>Giá Tour</label>

                        <input type="number" name="gia_tour" class="form-control mb-3" value="{{ $tour->gia_tour }}">

                    </div>

                    <div class="col-md-4">

                        <label>Thời lượng</label>

                        <input type="text" name="thoi_luong" class="form-control mb-3" value="{{ $tour->thoi_luong }}">

                    </div>

                    <div class="col-md-4">

                        <label>Số khách tối đa</label>

                        <input type="number" name="so_khach_toi_da" class="form-control mb-3" value="{{ $tour->so_khach_toi_da }}">

                    </div>

                </div>

                <div class="row">

                    <div class="col-md-6">

                        <label>Điểm khởi hành</label>

                        <input type="text" name="dia_diem_khoi_hanh" class="form-control mb-3" value="{{ $tour->dia_diem_khoi_hanh }}">

                    </div>

                    <div class="col-md-6">

                        <label>Điểm đến</label>

                        <input type="text" name="diem_den" class="form-control mb-3" value="{{ $tour->diem_den }}">

                    </div>

                </div>

                <label>Phương tiện</label>

                <input type="text" name="phuong_tien" class="form-control mb-3" value="{{ $tour->phuong_tien }}">

                <label>Tiêu chuẩn khách sạn</label>

                <input type="text" name="tieu_chuan_khach_san" class="form-control mb-3" value="{{ $tour->tieu_chuan_khach_san }}">

                <label>Mô tả</label>

                <textarea name="mo_ta" rows="4" class="form-control mb-3">{{ $tour->mo_ta }}</textarea>

                <label>Tổng quan lịch trình</label>

                <textarea name="tong_quan_lich_trinh" rows="4" class="form-control mb-3">{{ $tour->tong_quan_lich_trinh }}</textarea>

                <label>Dịch vụ bao gồm</label>

                <textarea name="dich_vu_bao_gom" rows="4" class="form-control mb-3">{{ $tour->dich_vu_bao_gom }}</textarea>

                <label>Dịch vụ không bao gồm</label>

                <textarea name="dich_vu_khong_bao_gom" rows="4" class="form-control mb-3">{{ $tour->dich_vu_khong_bao_gom }}</textarea>

                <label>Trạng thái</label>

                <select name="trang_thai" class="form-control mb-4">

                    <option value="active" {{ $tour->trang_thai=='active'?'selected':'' }}>
                        Hoạt động
                    </option>

                    <option value="inactive" {{ $tour->trang_thai=='inactive'?'selected':'' }}>
                        Ngừng hoạt động
                    </option>

                </select>

                <button class="btn btn-primary">

                    Cập nhật Tour

                </button>

            </form>

        </div>

    </div>

</div>

@endsection
