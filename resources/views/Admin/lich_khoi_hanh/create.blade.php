@extends('layouts.admin')

@section('title', 'Thêm lịch khởi hành')

@section('content')

    <div class="container-fluid">

        <div class="row justify-content-center">
            <div class="col-lg-8">

                <div class="card shadow border-0">

                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0">
                            <i class="fas fa-plane-departure me-2"></i>
                            Thêm lịch khởi hành
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

                        <form method="POST" action="{{ route('Admin.lich-khoi-hanh.store') }}">

                            @csrf

                            {{-- TOUR --}}
                            <div class="mb-3">
                                <label class="form-label fw-bold">
                                    Tour
                                </label>

                                <select name="tour_id" id="tour_id" class="form-select">

                                    @foreach ($tours as $tour)
                                        <option value="{{ $tour->id }}" data-thoi-luong="{{ $tour->thoi_luong }}">

                                            {{ $tour->ten_tour }}

                                        </option>
                                    @endforeach

                                </select>
                            </div>
                            <div class="mt-2">

                                <span class="badge bg-info text-dark">

                                    Thời lượng:
                                    <span id="hien_thi_thoi_luong"></span>

                                </span>

                            </div>

                            {{-- NGÀY KHỞI HÀNH --}}
                            <div class="mb-3">
                                <label class="form-label fw-bold">
                                    Ngày khởi hành
                                </label>

                                <input type="date" name="ngay_khoi_hanh" id="ngay_khoi_hanh" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">
                                    Ngày kết thúc
                                </label>

                                <input type="date" name="ngay_ket_thuc" id="ngay_ket_thuc" class="form-control" readonly>
                            </div>

                            {{-- SỐ CHỖ --}}
                            <div class="mb-3">
                                <label class="form-label fw-bold">
                                    Số chỗ
                                </label>

                                <input type="number" name="so_cho" class="form-control" placeholder="Ví dụ: 30">
                            </div>

                            <div class="row">

                                {{-- GIÁ NGƯỜI LỚN --}}
                                <div class="col-md-6">
                                    <div class="mb-3">

                                        <label class="form-label fw-bold">
                                            Giá người lớn
                                        </label>

                                        <input type="number" name="gia_nguoi_lon" class="form-control" placeholder="VNĐ">

                                    </div>
                                </div>

                                {{-- GIÁ TRẺ EM --}}
                                <div class="col-md-6">
                                    <div class="mb-3">

                                        <label class="form-label fw-bold">
                                            Giá trẻ em
                                        </label>

                                        <input type="number" name="gia_tre_em" class="form-control" placeholder="VNĐ">

                                    </div>
                                </div>

                            </div>

                            {{-- TRẠNG THÁI --}}
                            {{-- <div class="mb-4">

                                <label class="form-label fw-bold">
                                    Trạng thái
                                </label>

                                <select name="trang_thai" class="form-select">

                                    <option value="available">
                                        Mở bán
                                    </option>

                                    <option value="closed">
                                        Đóng bán
                                    </option>

                                </select>

                            </div> --}}

                            <div class="d-flex gap-2">

                                <button type="submit" class="btn btn-primary">

                                    <i class="fas fa-save me-1"></i>
                                    Lưu lịch

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

    <script>
        function capNhatThongTinTour() {
            const tourSelect = document.getElementById('tour_id');

            const option =
                tourSelect.options[tourSelect.selectedIndex];

            const thoiLuong =
                option.dataset.thoiLuong;

            document.getElementById('hien_thi_thoi_luong')
                .innerText = thoiLuong;

            tinhNgayKetThuc();
        }

        function tinhNgayKetThuc() {
            const tourSelect =
                document.getElementById('tour_id');

            const ngayKhoiHanh =
                document.getElementById('ngay_khoi_hanh');

            const ngayKetThuc =
                document.getElementById('ngay_ket_thuc');

            if (!ngayKhoiHanh.value)
                return;

            const option =
                tourSelect.options[tourSelect.selectedIndex];

            const thoiLuong =
                option.dataset.thoiLuong;

            const match =
                thoiLuong.match(/(\d+)/);

            if (!match)
                return;

            const soNgay =
                parseInt(match[1]);

            const date =
                new Date(ngayKhoiHanh.value);

            date.setDate(
                date.getDate() + soNgay - 1
            );

            const year =
                date.getFullYear();

            const month =
                String(date.getMonth() + 1)
                .padStart(2, '0');

            const day =
                String(date.getDate())
                .padStart(2, '0');

            ngayKetThuc.value =
                `${year}-${month}-${day}`;
        }

        document
            .getElementById('tour_id')
            .addEventListener(
                'change',
                capNhatThongTinTour
            );

        document
            .getElementById('ngay_khoi_hanh')
            .addEventListener(
                'change',
                tinhNgayKetThuc
            );

        capNhatThongTinTour();
    </script>

@endsection
