@extends('layouts.admin')

@section('title','Cập nhật phân công')

@section('breadcrumb')

<li class="breadcrumb-item">
    <a href="{{ route('Admin.phan-cong.index') }}">
        Quản lý phân công
    </a>
</li>

<li class="breadcrumb-item active">
    Cập nhật phân công
</li>

@endsection

@section('content')

<div class="fade-in">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <h3 class="fw-bold">
                Cập nhật phân công
            </h3>

            <p class="text-muted mb-0">
                Chỉnh sửa hướng dẫn viên và phương tiện
            </p>

        </div>

        <a href="{{ route('Admin.phan-cong.index') }}" class="btn btn-secondary">

            <i class="fas fa-arrow-left"></i>

            Quay lại

        </a>

    </div>


    <div class="card shadow-sm">

        <div class="card-body">

            <form action="{{ route('Admin.phan-cong.update',$phanCong->id) }}" method="POST">

                @csrf
                @method('PUT')

                <div class="row">

                    {{-- Lịch khởi hành --}}
                    <div class="col-md-6 mb-3">

                        <label class="form-label fw-semibold">
                            Lịch khởi hành
                        </label>

                        <input type="text" class="form-control" value="MKH {{ $phanCong->lichKhoiHanh->id }} - {{ \Carbon\Carbon::parse($phanCong->lichKhoiHanh->ngay_khoi_hanh)->format('d/m/Y') }}" readonly>

                        <input type="hidden" name="lich_khoi_hanh_id" value="{{ $phanCong->lich_khoi_hanh_id }}">

                    </div>

                    {{-- HDV --}}
                    <div class="col-md-6 mb-3">

                        <label class="form-label fw-semibold">

                            Hướng dẫn viên

                        </label>

                        <select name="hdv_id" class="form-select @error('hdv_id') is-invalid @enderror">

                            @foreach($huongDanViens as $hdv)

                            <option value="{{ $hdv->id }}" {{ old('hdv_id',$phanCong->hdv_id)==$hdv->id?'selected':'' }}>

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


                    {{-- Xe --}}
                    <div class="col-md-6 mb-3">

                        <label class="form-label fw-semibold">

                            Phương tiện

                        </label>

                        <select name="phuong_tien_id" class="form-select @error('phuong_tien_id') is-invalid @enderror">

                            @foreach($phuongTiens as $xe)

                            <option value="{{ $xe->id }}" {{ old('phuong_tien_id',$phanCong->phuong_tien_id)==$xe->id?'selected':'' }}>

                                {{ $xe->bien_so_xe }} -- {{$xe->loai_phuong_tien}}

                            </option>

                            @endforeach

                        </select>

                        @error('phuong_tien_id')

                        <div class="invalid-feedback">

                            {{ $message }}

                        </div>

                        @enderror

                    </div>


                    {{-- Ghi chú --}}
                    <div class="col-md-12 mb-3">

                        <label class="form-label fw-semibold">

                            Ghi chú

                        </label>

                        <textarea rows="4" name="ghi_chu" class="form-control">{{ old('ghi_chu',$phanCong->ghi_chu) }}</textarea>

                    </div>

                </div>


                <div class="text-end">

                    <button class="btn btn-primary">

                        <i class="fas fa-save me-1"></i>

                        Cập nhật

                    </button>

                </div>

            </form>

        </div>

    </div>

</div>

@endsection
