@extends('Layouts.admin')

@section('title', 'Sửa lịch trình')

@section('content')
    <div class="container-fluid">

        <div class="card">
            <div class="card-header">
                <h3>Sửa lịch trình tour</h3>
            </div>

            <div class="card-body">

                <form action="{{ route('Admin.lich_trinh_tours.update', ['lich_trinh_tour' => $lichTrinh->id]) }}"
                    method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label>Tour</label>

                        <input type="text" class="form-control" value="{{ $lichTrinh->tour->ten_tour }}" readonly>

                        <input type="hidden" name="tour_id" value="{{ $lichTrinh->tour_id }}">
                    </div>

                    <div class="mb-3">
                        <label>Ngày thứ</label>
                        <input type="number" name="ngay_thu" class="form-control"
                            value="{{ old('ngay_thu', $lichTrinh->ngay_thu) }}">
                    </div>

                    <div class="mb-3">
                        <label>Tiêu đề</label>
                        <input type="text" name="tieu_de" class="form-control"
                            value="{{ old('tieu_de', $lichTrinh->tieu_de) }}">
                    </div>

                    <div class="mb-3">
                        <label>Địa điểm</label>
                        <input type="text" name="dia_diem" class="form-control"
                            value="{{ old('dia_diem', $lichTrinh->dia_diem) }}">
                    </div>

                    <div class="mb-3">
                        <label>Hoạt động</label>
                        <textarea name="hoat_dong" rows="5" class="form-control">{{ old('hoat_dong', $lichTrinh->hoat_dong) }}</textarea>
                    </div>

                    <div class="mb-3">
                        <label>Bữa ăn</label>
                        <input type="text" name="bua_an" class="form-control"
                            value="{{ old('bua_an', $lichTrinh->bua_an) }}">
                    </div>

                    <div class="mb-3">
                        <label>Thông tin khách sạn</label>
                        <input type="text" name="thong_tin_khach_san" class="form-control"
                            value="{{ old('thong_tin_khach_san', $lichTrinh->thong_tin_khach_san) }}">
                    </div>

                    <button type="submit" class="btn btn-primary">
                        Cập nhật
                    </button>

                    <a href="{{ route('Admin.lich_trinh_tours.index') }}" class="btn btn-secondary">
                        Quay lại
                    </a>

                </form>

            </div>
        </div>

    </div>
@endsection
