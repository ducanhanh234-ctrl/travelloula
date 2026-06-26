@extends('layouts.admin')

@section('content')
    <div class="card">

        <div class="card-header">
            Thêm Tour
        </div>

        <div class="card-body">

            <form action="{{ route('Admin.tours.store') }}" method="POST" enctype="multipart/form-data">

                @csrf

                <div class="mb-3">
                    <label>Tên Tour</label>

                    <input type="text" name="ten_tour" class="form-control">
                </div>

                <div class="mb-3">
                    <label>Danh mục</label>

                    <select name="danh_muc_id" class="form-control">

                        <option value="">
                            Chọn danh mục
                        </option>

                        @foreach ($danhMucs as $item)
                            <option value="{{ $item->id }}">
                                {{ $item->ten_danh_muc }}
                            </option>
                        @endforeach

                    </select>

                </div>

                <div class="mb-3">

                    <label>Ảnh đại diện</label>

                    <input type="file" name="anh_dai_dien" class="form-control">

                </div>

                <div class="mb-3">

                    <label>Giá Tour</label>

                    <input type="number" name="gia_tour" class="form-control">

                </div>

                <div class="mb-3">

                    <label>Thời lượng</label>

                    <div class="row">

                        <div class="col-md-6">
                            <label class="form-label">Số ngày</label>

                            <select name="so_ngay" class="form-select" required>

                                <option value="">-- Chọn số ngày --</option>

                                @for ($i = 1; $i <= 30; $i++)
                                    <option value="{{ $i }}">
                                        {{ $i }} ngày
                                    </option>
                                @endfor

                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Số đêm</label>

                            <select name="so_dem" class="form-select" required>

                                <option value="">-- Chọn số đêm --</option>

                                @for ($i = 0; $i <= 29; $i++)
                                    <option value="{{ $i }}">
                                        {{ $i }} đêm
                                    </option>
                                @endfor

                            </select>
                        </div>

                    </div>

                </div>

                <div class="mb-3">

                    <label>Điểm khởi hành</label>

                    <input type="text" name="dia_diem_khoi_hanh" class="form-control">

                </div>

                <div class="mb-3">

                    <label>Điểm đến</label>

                    <input type="text" name="diem_den" class="form-control">

                </div>

                <div class="mb-3">

                    <label>Số khách tối đa</label>

                    <input type="number" name="so_khach_toi_da" class="form-control">

                </div>

                <div class="mb-3">

                    <label>Phương tiện</label>

                    <input type="text" name="phuong_tien" class="form-control">

                </div>

                <div class="mb-3">

                    <label>Tiêu chuẩn khách sạn</label>

                    <input type="text" name="tieu_chuan_khach_san" class="form-control">

                </div>

                <div class="mb-3">

                    <label>Mô tả</label>

                    <textarea name="mo_ta" class="form-control" rows="5"></textarea>

                </div>

                <div class="mb-3">

                    <label>Tổng quan lịch trình</label>

                    <textarea name="tong_quan_lich_trinh" class="form-control" rows="5"></textarea>

                </div>

                <div class="mb-3">

                    <label>Dịch vụ bao gồm</label>

                    <textarea name="dich_vu_bao_gom" class="form-control" rows="5"></textarea>

                </div>

                <div class="mb-3">

                    <label>Dịch vụ không bao gồm</label>

                    <textarea name="dich_vu_khong_bao_gom" class="form-control" rows="5"></textarea>

                </div>

                <div class="mb-3">

                    <label>Trạng thái</label>

                    <select name="trang_thai" class="form-control">

                        <option value="active">
                            Hoạt động
                        </option>

                        <option value="inactive">
                            Ngừng hoạt động
                        </option>

                    </select>

                </div>

                <button class="btn btn-success">

                    Lưu Tour

                </button>

            </form>

        </div>

    </div>
@endsection
