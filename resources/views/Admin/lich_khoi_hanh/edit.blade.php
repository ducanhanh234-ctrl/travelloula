@extends('layouts.admin')

@section('title', 'Cập nhật lịch khởi hành')

@section('content')

    <div class="container-fluid">

        <div class="row justify-content-center">
            <div class="col-lg-8">

                <div class="card shadow border-0">

                    <div class="card-header bg-warning text-dark">
                        <h4 class="mb-0">
                            <i class="fas fa-edit me-2"></i>
                            Cập nhật lịch khởi hành
                        </h4>
                    </div>

                    <div class="card-body">

                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form method="POST" action="{{ route('Admin.lich-khoi-hanh.update', $item->id) }}">

                            @csrf
                            @method('PUT')

                            {{-- TOUR --}}
                            <div class="mb-3">
                                <label class="form-label fw-bold">
                                    Tour
                                </label>

                                <select name="tour_id" class="form-select">

                                    @foreach ($tours as $tour)
                                        <option value="{{ $tour->id }}"
                                            {{ $item->tour_id == $tour->id ? 'selected' : '' }}>
                                            {{ $tour->ten_tour }}
                                        </option>
                                    @endforeach

                                </select>
                            </div>

                            {{-- NGÀY KHỞI HÀNH --}}
                            <div class="mb-3">
                                <label class="form-label fw-bold">
                                    Ngày khởi hành
                                </label>

                                <input type="date" name="ngay_khoi_hanh" value="{{ $item->ngay_khoi_hanh }}"
                                    class="form-control">
                            </div>

                            {{-- SỐ CHỖ --}}
                            <div class="mb-3">
                                <label class="form-label fw-bold">
                                    Số chỗ
                                </label>

                                <input type="number" name="so_cho" value="{{ $item->so_cho }}" class="form-control">
                            </div>

                            <div class="row">

                                {{-- GIÁ NGƯỜI LỚN --}}
                                <div class="col-md-6">
                                    <div class="mb-3">

                                        <label class="form-label fw-bold">
                                            Giá người lớn
                                        </label>

                                        <input type="number" name="gia_nguoi_lon" value="{{ $item->gia_nguoi_lon }}"
                                            class="form-control">

                                    </div>
                                </div>

                                {{-- GIÁ TRẺ EM --}}
                                <div class="col-md-6">
                                    <div class="mb-3">

                                        <label class="form-label fw-bold">
                                            Giá trẻ em
                                        </label>

                                        <input type="number" name="gia_tre_em" value="{{ $item->gia_tre_em }}"
                                            class="form-control">

                                    </div>
                                </div>

                            </div>

                            {{-- TRẠNG THÁI --}}
                            <div class="mb-4">

                                <label class="form-label fw-bold">
                                    Trạng thái
                                </label>

                                <select name="trang_thai" class="form-select">

                                    <option value="available" {{ $item->trang_thai == 'available' ? 'selected' : '' }}>
                                        Mở bán
                                    </option>

                                    <option value="cancelled" {{ $item->trang_thai == 'cancelled' ? 'selected' : '' }}>
                                        Đã hủy
                                    </option>

                                </select>

                            </div>

                            <div class="d-flex gap-2">

                                <button type="submit" class="btn btn-warning">

                                    <i class="fas fa-save me-1"></i>
                                    Cập nhật

                                </button>

                                <a href="{{ route('Admin.lich-khoi-hanh.index') }}" class="btn btn-secondary">

                                    Quay lại

                                </a>

                            </div>

                        </form>

                    </div>

                </div>

            </div>
        </div>

    </div>

@endsection
