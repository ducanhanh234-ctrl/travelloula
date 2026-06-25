@extends('layouts/admin_pro')

@section('title', 'Cập Nhật Tour')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">

    <div>
        <h4 class="mb-1">Cập Nhật Tour</h4>
        <p class="text-muted mb-0">
            Cập nhật thông tin tour du lịch trong hệ thống
        </p>
    </div>

    <a href="{{ route('Admin.tours.index') }}" class="btn btn-outline-secondary">

        <i class="bx bx-arrow-back"></i>
        Quay lại

    </a>

</div>

<form action="{{ route('Admin.tours.update', $tour->id) }}" method="POST" enctype="multipart/form-data">

    @csrf
    @method('PUT')

    <div class="row">

        {{-- Cột trái --}}
        <div class="col-lg-8">

            <div class="card mb-4">

                <div class="card-header">
                    <h5 class="mb-0">
                        Thông tin cơ bản
                    </h5>
                </div>

                <div class="card-body">

                    <div class="mb-3">
                        <label class="form-label">
                            Tên Tour
                        </label>

                        <input type="text" name="ten_tour" class="form-control" value="{{ old('ten_tour', $tour->ten_tour) }}">
                    </div>

                    <div class="row">

                        <div class="col-md-6 mb-3">
                            <label class="form-label">
                                Danh mục
                            </label>

                            <select name="danh_muc_id" class="form-select">

                                <option value="">
                                    Chọn danh mục
                                </option>

                                @foreach($danhMucs as $item)
                                <option value="{{ $item->id }}" {{ old('danh_muc_id', $tour->danh_muc_id) == $item->id ? 'selected' : '' }}>
                                    {{ $item->ten_danh_muc }}
                                </option>
                                @endforeach

                            </select>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">
                                Giá Tour
                            </label>

                            <input type="number" name="gia_tour" class="form-control" value="{{ old('gia_tour', $tour->gia_tour) }}">
                        </div>

                    </div>

                    <div class="row">

                        <div class="col-md-6 mb-3">
                            <label class="form-label">
                                Thời lượng
                            </label>

                            <input type="text" name="thoi_luong" class="form-control" value="{{ old('thoi_luong', $tour->thoi_luong) }}">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">
                                Số khách tối đa
                            </label>

                            <input type="number" name="so_khach_toi_da" class="form-control" value="{{ old('so_khach_toi_da', $tour->so_khach_toi_da) }}">
                        </div>

                    </div>

                    <div class="row">

                        <div class="col-md-6 mb-3">
                            <label class="form-label">
                                Điểm khởi hành
                            </label>

                            <input type="text" name="dia_diem_khoi_hanh" class="form-control" value="{{ old('dia_diem_khoi_hanh', $tour->dia_diem_khoi_hanh) }}">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">
                                Điểm đến
                            </label>

                            <input type="text" name="diem_den" class="form-control" value="{{ old('diem_den', $tour->diem_den) }}">
                        </div>

                    </div>

                    <div class="row">

                        <div class="col-md-6 mb-3">
                            <label class="form-label">
                                Phương tiện
                            </label>

                            <input type="text" name="phuong_tien" class="form-control" value="{{ old('phuong_tien', $tour->phuong_tien) }}">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">
                                Tiêu chuẩn khách sạn
                            </label>

                            <input type="text" name="tieu_chuan_khach_san" class="form-control" value="{{ old('tieu_chuan_khach_san', $tour->tieu_chuan_khach_san) }}">
                        </div>

                    </div>

                </div>

            </div>

            {{-- Nội dung tour --}}
            <div class="card">

                <div class="card-header">
                    <h5 class="mb-0">
                        Nội dung Tour
                    </h5>
                </div>

                <div class="card-body">

                    <div class="mb-3">
                        <label class="form-label">
                            Mô tả
                        </label>

                        <textarea name="mo_ta" rows="5" class="form-control">{{ old('mo_ta', $tour->mo_ta) }}</textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">
                            Tổng quan lịch trình
                        </label>

                        <textarea name="tong_quan_lich_trinh" rows="5" class="form-control">{{ old('tong_quan_lich_trinh', $tour->tong_quan_lich_trinh) }}</textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">
                            Dịch vụ bao gồm
                        </label>

                        <textarea name="dich_vu_bao_gom" rows="5" class="form-control">{{ old('dich_vu_bao_gom', $tour->dich_vu_bao_gom) }}</textarea>
                    </div>

                    <div>
                        <label class="form-label">
                            Dịch vụ không bao gồm
                        </label>

                        <textarea name="dich_vu_khong_bao_gom" rows="5" class="form-control">{{ old('dich_vu_khong_bao_gom', $tour->dich_vu_khong_bao_gom) }}</textarea>
                    </div>

                </div>

            </div>

        </div>

        {{-- Cột phải --}}
        <div class="col-lg-4">

            <div class="card mb-4">

                <div class="card-header">
                    <h5 class="mb-0">
                        Ảnh đại diện
                    </h5>
                </div>

                <div class="card-body">
                    <img src="{{asset('storage/'.$tour->anh_dai_dien)}}" alt="" class="img-fluid mb-3" width="100%">
                    <input type="file" name="anh_dai_dien" class="form-control">

                </div>

            </div>

            <div class="card">

                <div class="card-header">
                    <h5 class="mb-0">
                        Cài đặt
                    </h5>
                </div>

                <div class="card-body">

                    <div class="mb-3">

                        <label class="form-label">
                            Trạng thái
                        </label>

                        <select name="trang_thai" class="form-select">

                            <option value="active">
                                Hoạt động
                            </option>

                            <option value="inactive">
                                Ngừng hoạt động
                            </option>

                        </select>

                    </div>

                    <button class="btn btn-primary w-100">

                        <i class="bx bx-save"></i>
                        Cập nhật Tour

                    </button>

                </div>

            </div>

        </div>

    </div>

</form>

@endsection
