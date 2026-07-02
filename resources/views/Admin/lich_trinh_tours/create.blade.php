@extends('Layouts.admin')

@section('title', 'Thêm lịch trình')

@section('content')

    <div class="container-fluid">

        <h3>Thêm lịch trình tour</h3>

        <form action="{{ route('Admin.lich_trinh_tours.store') }}" method="POST">

            @csrf

            <input type="hidden" name="tour_id" value="{{ $tour->id }}">

            <div class="mb-3">
                <label>Ngày thứ</label>

                <input type="number" name="ngay_thu" class="form-control">
            </div>

            <div class="mb-3">
                <label>Tiêu đề</label>

                <input type="text" name="tieu_de" class="form-control">
            </div>

            <div class="mb-3">
                <label>Địa điểm</label>

                <input type="text" name="dia_diem" class="form-control">
            </div>

            <div class="mb-3">
                <label>Hoạt động</label>

                <textarea name="hoat_dong" class="form-control"></textarea>
            </div>

            <button type="submit" class="btn btn-success">

                Lưu

            </button>

        </form>



    </div>

@endsection
