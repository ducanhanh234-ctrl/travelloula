@extends('layouts.admin')

@section('content')
    <div class="card">

        <div class="card-header">
            Thêm Tour
        </div>

        <div class="card-body">

            <form action="{{ route('Admin.tours.store') }}" method="POST" enctype="multipart/form-data">

                @csrf
                {{-- @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif --}}

                <div class="mb-3">
                    <label>Tên Tour</label>

                    <input type="text" name="ten_tour" class="form-control @error('ten_tour') is-invalid @enderror"
                        value="{{ old('ten_tour') }}">

                    @error('ten_tour')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label>Danh mục</label>

                    <select name="danh_muc_id" class="form-control @error('danh_muc_id') is-invalid @enderror">

                        <option value="">Chọn danh mục</option>

                        @foreach ($danhMucs as $item)
                            <option value="{{ $item->id }}" {{ old('danh_muc_id') == $item->id ? 'selected' : '' }}>
                                {{ $item->ten_danh_muc }}
                            </option>
                        @endforeach

                    </select>

                    @error('danh_muc_id')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">

                        <label>Ảnh đại diện</label>

                        <input type="file" name="anh_dai_dien"
                            class="form-control @error('anh_dai_dien') is-invalid @enderror">

                        @error('anh_dai_dien')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror

                    </div>
                    <div class="col-md-6 mb-3">
                        <label>Ảnh chi tiết</label>

                        <input type="file" name="hinh_anh[]" class="form-control" multiple>

                        <small class="text-muted">
                            Có thể chọn nhiều ảnh.
                        </small>
                    </div>
                </div>

                <div class="row">

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Giá tour (Giá niêm yết)</label>

                        <input type="number" name="gia_tour" class="form-control @error('gia_tour') is-invalid @enderror"
                            value="{{ old('gia_tour') }}">

                        @error('gia_tour')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Giá người lớn</label>

                        <input type="number" name="gia_nguoi_lon"
                            class="form-control @error('gia_nguoi_lon') is-invalid @enderror"
                            value="{{ old('gia_nguoi_lon', $tour->gia_nguoi_lon ?? '') }}">
                        @error('gia_nguoi_lon')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                </div>

                <div class="row">

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Giá trẻ em</label>

                        <input type="number" name="gia_tre_em"
                            class="form-control @error('gia_tre_em') is-invalid @enderror"
                            value="{{ old('gia_tre_em', $tour->gia_tre_em ?? '') }}">
                        @error('gia_tre_em')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    {{-- <div class="col-md-6 mb-3">
                        <label class="form-label">Giá em bé</label>

                        <input type="number" name="gia_em_be" class="form-control"
                            value="{{ old('gia_em_be', $tour->gia_em_be ?? '') }}">
                    </div> --}}

                </div>
                

                <div class="mb-3">

                    <label>Thời lượng</label>

                    <div class="row">

                        <div class="col-md-6">
                            <label class="form-label">Số ngày</label>

                            <select name="so_ngay" class="form-select @error('so_ngay') is-invalid @enderror">
                                <option value="">-- Chọn số ngày --</option>

                                @for ($i = 1; $i <= 30; $i++)
                                    <option value="{{ $i }}" {{ old('so_ngay') == $i ? 'selected' : '' }}>
                                        {{ $i }} ngày
                                    </option>
                                @endfor
                            </select>

                            @error('so_ngay')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Số đêm</label>

                            <select name="so_dem" class="form-select @error('so_dem') is-invalid @enderror">
                                <option value="">-- Chọn số đêm --</option>

                                @for ($i = 0; $i <= 29; $i++)
                                    <option value="{{ $i }}" {{ old('so_dem') == $i ? 'selected' : '' }}>
                                        {{ $i }} đêm
                                    </option>
                                @endfor
                            </select>

                            @error('so_dem')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                    </div>

                </div>

                <div class="mb-3">
                    <label>Điểm khởi hành</label>

                    <input type="text" name="dia_diem_khoi_hanh" value="{{ old('dia_diem_khoi_hanh') }}"
                        class="form-control @error('dia_diem_khoi_hanh') is-invalid @enderror">

                    @error('dia_diem_khoi_hanh')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label>Điểm đến</label>

                    <input type="text" name="diem_den" value="{{ old('diem_den') }}"
                        class="form-control @error('diem_den') is-invalid @enderror">

                    @error('diem_den')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label>Số khách tối đa</label>

                    <input type="number" name="so_khach_toi_da" value="{{ old('so_khach_toi_da') }}"
                        class="form-control @error('so_khach_toi_da') is-invalid @enderror">

                    @error('so_khach_toi_da')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                {{-- <div class="mb-3">

                    <label>Phương tiện</label>

                    <input type="text" name="phuong_tien" class="form-control">

                </div> --}}

                <div class="mb-3">

                    <label>Tiêu chuẩn khách sạn</label>

                    <input type="text" name="tieu_chuan_khach_san"
                        value="{{ old('tieu_chuan_khach_san') }} class="form-control
                        @error('tieu_chuan_khach_san') is-invalid @enderror">
                    @error('tieu_chuan_khach_san')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="mb-3">

                    <label>Mô tả</label>

                    <textarea name="mo_ta" value="{{ old('mo_ta') }} class="form-control @error('mo_ta') is-invalid @enderror"
                        rows="5"></textarea>
                    @error('mo_ta')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="mb-3">

                    <label>Tổng quan lịch trình</label>

                    <textarea name="tong_quan_lich_trinh" value="{{ old('tong_quan_lich_trinh') }} class="form-control
                        @error('tong_quan_lich_trinh') is-invalid @enderror" rows="5"></textarea>
                    @error('tong_quan_lich_trinh')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="mb-3">

                    <label>Dịch vụ bao gồm</label>

                    <textarea name="dich_vu_bao_gom" value="{{ old('dich_vu_bao_gom') }} class="form-control
                        @error('dich_vu_bao_gom') is-invalid @enderror" rows="5"></textarea>
                    @error('dich_vu_bao_gom')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="mb-3">

                    <label>Dịch vụ không bao gồm</label>

                    <textarea name="dich_vu_khong_bao_gom" value="{{ old('dich_vu_khong_bao_gom') }} class="form-control
                        @error('dich_vu_khong_bao_gom') is-invalid @enderror" rows="5"></textarea>
                    @error('dich_vu_khong_bao_gom')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
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

