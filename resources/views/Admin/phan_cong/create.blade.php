@extends('layouts.admin')

@section('title','Thêm phân công')

@section('breadcrumb')
<li class="breadcrumb-item">
    <a href="{{ route('Admin.phan-cong.index') }}">
        Quản lý phân công
    </a>
</li>

<li class="breadcrumb-item active">
    Thêm phân công
</li>
@endsection

@section('content')

<div class="fade-in">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <h3 class="fw-bold mb-1">
                Thêm phân công
            </h3>

            <p class="text-muted mb-0">
                Phân công hướng dẫn viên và phương tiện cho lịch khởi hành
            </p>

        </div>

        <a href="{{ route('Admin.phan-cong.index') }}" class="btn btn-secondary">

            <i class="fas fa-arrow-left"></i>

            Quay lại

        </a>

    </div>


    <div class="card shadow-sm">

        <div class="card-header">

            <i class="fas fa-plus-circle me-2"></i>

            Thông tin phân công

        </div>

        <div class="card-body">

            <form action="{{ route('Admin.phan-cong.store') }}" method="POST">

                @csrf

                <div class="row">

                    {{-- Lịch khởi hành --}}
                    <div class="col-md-6 mb-3">

                        <label class="form-label">
                            Lịch khởi hành
                        </label>

                        <select name="lich_khoi_hanh_id" class="form-select @error('lich_khoi_hanh_id') is-invalid @enderror">

                            <option value="">
                                -- Chọn lịch khởi hành --
                            </option>

                            @foreach($lichKhoiHanhs as $lich)

                            <option value="{{ $lich->id }}" {{ old('lich_khoi_hanh_id')==$lich->id?'selected':'' }}>

                                MKH {{ $lich->id }}
                                -
                                {{ date('d/m/Y', strtotime($lich->ngay_khoi_hanh)) }}
                                -
                                {{ date('d/m/Y', strtotime($lich->ngay_ket_thuc)) }}
                                -
                                {{ $lich->tour->so_khach_toi_da }} chỗ

                            </option>

                            @endforeach

                        </select>

                        @error('lich_khoi_hanh_id')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror

                    </div>


                    {{-- HDV --}}
                    <div class="col-md-6 mb-3">

                        <label class="form-label">
                            Hướng dẫn viên
                        </label>

                        <select name="hdv_id" class="form-select @error('hdv_id') is-invalid @enderror">

                            <option value="">
                                -- Chọn HDV --
                            </option>

                            @foreach($huongDanViens as $hdv)

                            <option value="{{ $hdv->id }}" {{ old('hdv_id')==$hdv->id?'selected':'' }}>

                                {{ $hdv->ho_ten }}

                            </option>

                            @endforeach

                        </select>

                        @error('hdv_id')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror

                    </div>


                    {{-- Phương tiện --}}
                    <div class="col-md-6 mb-3">

                        <label class="form-label">
                            Phương tiện
                        </label>

                        <select name="phuong_tien_id" class="form-select @error('phuong_tien_id') is-invalid @enderror">

                            <option value="">
                                -- Chọn phương tiện --
                            </option>

                            @foreach($phuongTiens as $xe)

                            <option value="{{ $xe->id }}" {{ old('phuong_tien_id')==$xe->id?'selected':'' }}>

                                {{ $xe->bien_so_xe }} -- {{ $xe->loai_phuong_tien }}

                            </option>

                            @endforeach

                        </select>

                        @error('phuong_tien_id')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror

                    </div>


                    {{-- Ngày phân công --}}
                    <div class="col-md-12 mb-3">
                        <label for="">Ghi Chú: </label>
                        <textarea name="ghi_chu" class="form-control @error('ghi_chu') is-invalid @enderror" rows="3">{{ old('ghi_chu') }}</textarea>
                        @error('ghi_chu')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                </div>


                <div class="mt-3 d-flex justify-content-end gap-2">

                    <a href="{{ route('Admin.phan-cong.index') }}" class="btn btn-secondary">

                        Hủy

                    </a>

                    <button class="btn btn-primary">

                        <i class="fas fa-save me-1"></i>

                        Lưu phân công

                    </button>

                </div>

            </form>

        </div>

    </div>

</div>

@endsection
