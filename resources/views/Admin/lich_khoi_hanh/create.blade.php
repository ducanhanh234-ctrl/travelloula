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

                        <form
                            method="POST"
                            action="{{ route('Admin.lich-khoi-hanh.store') }}"
                        >
                            @csrf

                            {{-- TOUR --}}
                            <div class="mb-3">
                                <label
                                    for="tour_id"
                                    class="form-label fw-bold"
                                >
                                    Tour
                                </label>

                                <select
                                    name="tour_id"
                                    id="tour_id"
                                    class="form-select select2 @error('tour_id') is-invalid @enderror"
                                    required
                                >
                                    <option value="">
                                        -- Chọn tour --
                                    </option>

                                    @foreach ($tours as $tour)
                                        <option
                                            value="{{ $tour->id }}"
                                            data-thoi-luong="{{ $tour->thoi_luong ?? 0 }}"
                                            data-so-cho="{{ $tour->so_khach_toi_da ?? 0 }}"
                                            data-gia-nguoi-lon="{{ $tour->gia_nguoi_lon ?? 0 }}"
                                            data-gia-tre-em="{{ $tour->gia_tre_em ?? 0 }}"
                                            data-gia-em-be="{{ $tour->gia_em_be ?? 0 }}"
                                            {{ old('tour_id') == $tour->id ? 'selected' : '' }}
                                        >
                                            {{ $tour->ten_tour }}
                                        </option>
                                    @endforeach
                                </select>

                                @error('tour_id')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            {{-- LOẠI MÙA --}}
                            <div class="mb-3">
                                <label
                                    for="loai_mua"
                                    class="form-label fw-bold"
                                >
                                    Loại mùa
                                </label>

                                <select
                                    name="loai_mua"
                                    id="loai_mua"
                                    class="form-select @error('loai_mua') is-invalid @enderror"
                                    required
                                >
                                    <option value="">
                                        -- Chọn loại mùa --
                                    </option>

                                    <option
                                        value="thuong"
                                        {{ old('loai_mua') === 'thuong' ? 'selected' : '' }}
                                    >
                                        Mùa thường
                                    </option>

                                    <option
                                        value="cao_diem"
                                        {{ old('loai_mua') === 'cao_diem' ? 'selected' : '' }}
                                    >
                                        Mùa cao điểm
                                    </option>
                                </select>

                                @error('loai_mua')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            {{-- THỜI LƯỢNG --}}
                            <div class="mb-3">
                                <span class="badge bg-info text-dark px-3 py-2">
                                    Thời lượng:
                                    <span id="hien_thi_thoi_luong">
                                        Chưa chọn tour
                                    </span>
                                </span>
                            </div>

                            {{-- NGÀY KHỞI HÀNH --}}
                            <div class="mb-3">
                                <label
                                    for="ngay_khoi_hanh"
                                    class="form-label fw-bold"
                                >
                                    Ngày khởi hành
                                </label>

                                <input
                                    type="date"
                                    name="ngay_khoi_hanh"
                                    id="ngay_khoi_hanh"
                                    class="form-control @error('ngay_khoi_hanh') is-invalid @enderror"
                                    value="{{ old('ngay_khoi_hanh') }}"
                                    min="{{ now()->format('Y-m-d') }}"
                                    required
                                >

                                @error('ngay_khoi_hanh')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            {{-- NGÀY KẾT THÚC --}}
                            <div class="mb-3">
                                <label
                                    for="ngay_ket_thuc"
                                    class="form-label fw-bold"
                                >
                                    Ngày kết thúc
                                </label>

                                <input
                                    type="date"
                                    name="ngay_ket_thuc"
                                    id="ngay_ket_thuc"
                                    class="form-control @error('ngay_ket_thuc') is-invalid @enderror"
                                    value="{{ old('ngay_ket_thuc') }}"
                                    readonly
                                    required
                                >

                                @error('ngay_ket_thuc')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            {{-- SỐ CHỖ --}}
                            <div class="mb-3">
                                <label
                                    for="so_cho"
                                    class="form-label fw-bold"
                                >
                                    Số chỗ
                                </label>

                                <input
                                    type="number"
                                    id="so_cho"
                                    name="so_cho"
                                    class="form-control @error('so_cho') is-invalid @enderror"
                                    value="{{ old('so_cho') }}"
                                    min="1"
                                    placeholder="Ví dụ: 30"
                                    required
                                >

                                @error('so_cho')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="row">
                                {{-- GIÁ NGƯỜI LỚN --}}
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label
                                            for="gia_nguoi_lon"
                                            class="form-label fw-bold"
                                        >
                                            Giá người lớn
                                        </label>

                                        <input
                                            type="number"
                                            id="gia_nguoi_lon"
                                            name="gia_nguoi_lon"
                                            class="form-control @error('gia_nguoi_lon') is-invalid @enderror"
                                            value="{{ old('gia_nguoi_lon') }}"
                                            min="0"
                                            placeholder="VNĐ"
                                            readonly
                                            required
                                        >

                                        @error('gia_nguoi_lon')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>

                                {{-- GIÁ TRẺ EM --}}
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label
                                            for="gia_tre_em"
                                            class="form-label fw-bold"
                                        >
                                            Giá trẻ em
                                        </label>

                                        <input
                                            type="number"
                                            id="gia_tre_em"
                                            name="gia_tre_em"
                                            class="form-control @error('gia_tre_em') is-invalid @enderror"
                                            value="{{ old('gia_tre_em') }}"
                                            min="0"
                                            placeholder="VNĐ"
                                            readonly
                                            required
                                        >

                                        @error('gia_tre_em')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>

                                {{-- GIÁ EM BÉ --}}
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label
                                            for="gia_em_be"
                                            class="form-label fw-bold"
                                        >
                                            Giá em bé
                                        </label>

                                        <input
                                            type="number"
                                            id="gia_em_be"
                                            name="gia_em_be"
                                            class="form-control @error('gia_em_be') is-invalid @enderror"
                                            value="{{ old('gia_em_be') }}"
                                            min="0"
                                            placeholder="VNĐ"
                                            readonly
                                            required
                                        >

                                        @error('gia_em_be')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex gap-2">
                                <button
                                    type="submit"
                                    class="btn btn-primary"
                                >
                                    <i class="fas fa-save me-1"></i>
                                    Lưu lịch
                                </button>

                                <a
                                    href="{{ route('Admin.lich-khoi-hanh.index') }}"
                                    class="btn btn-secondary"
                                >
                                    <i class="fas fa-arrow-left me-1"></i>
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

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const tourSelect =
                document.getElementById('tour_id');

            const ngayKhoiHanhInput =
                document.getElementById('ngay_khoi_hanh');

            const ngayKetThucInput =
                document.getElementById('ngay_ket_thuc');

            const hienThiThoiLuong =
                document.getElementById('hien_thi_thoi_luong');

            const soChoInput =
                document.getElementById('so_cho');

            const giaNguoiLonInput =
                document.getElementById('gia_nguoi_lon');

            const giaTreEmInput =
                document.getElementById('gia_tre_em');

            const giaEmBeInput =
                document.getElementById('gia_em_be');

            const oldSoCho = @json(old('so_cho'));
            const oldGiaNguoiLon = @json(old('gia_nguoi_lon'));
            const oldGiaTreEm = @json(old('gia_tre_em'));
            const oldGiaEmBe = @json(old('gia_em_be'));

            function layOptionDangChon() {
                if (
                    !tourSelect ||
                    tourSelect.selectedIndex < 0 ||
                    !tourSelect.value
                ) {
                    return null;
                }

                return tourSelect.options[tourSelect.selectedIndex];
            }

            function chuyenThanhSo(value) {
                const number = Number(value);

                return Number.isFinite(number)
                    ? number
                    : 0;
            }

            function dinhDangNgay(date) {
                const year = date.getFullYear();

                const month = String(
                    date.getMonth() + 1
                ).padStart(2, '0');

                const day = String(
                    date.getDate()
                ).padStart(2, '0');

                return `${year}-${month}-${day}`;
            }

            function capNhatNgayKetThuc() {
                const selectedOption =
                    layOptionDangChon();

                if (
                    !selectedOption ||
                    !ngayKhoiHanhInput ||
                    !ngayKetThucInput ||
                    !ngayKhoiHanhInput.value
                ) {
                    if (ngayKetThucInput) {
                        ngayKetThucInput.value = '';
                    }

                    return;
                }

                const thoiLuong = parseInt(
                    selectedOption.dataset.thoiLuong || '0',
                    10
                );

                if (thoiLuong <= 0) {
                    ngayKetThucInput.value = '';
                    return;
                }

                const ngayKhoiHanh = new Date(
                    `${ngayKhoiHanhInput.value}T00:00:00`
                );

                /*
                 * Ví dụ tour 3 ngày:
                 * ngày khởi hành được tính là ngày đầu tiên,
                 * nên ngày kết thúc cộng thêm 2 ngày.
                 */
                ngayKhoiHanh.setDate(
                    ngayKhoiHanh.getDate() + thoiLuong - 1
                );

                ngayKetThucInput.value =
                    dinhDangNgay(ngayKhoiHanh);
            }

            function capNhatThongTinTour(
                giuDuLieuCu = false
            ) {
                const selectedOption =
                    layOptionDangChon();

                if (!selectedOption) {
                    hienThiThoiLuong.textContent =
                        'Chưa chọn tour';

                    if (!giuDuLieuCu) {
                        soChoInput.value = '';
                        giaNguoiLonInput.value = '';
                        giaTreEmInput.value = '';
                        giaEmBeInput.value = '';
                        ngayKetThucInput.value = '';
                    }

                    return;
                }

                const thoiLuong = parseInt(
                    selectedOption.dataset.thoiLuong || '0',
                    10
                );

                const soCho = chuyenThanhSo(
                    selectedOption.dataset.soCho
                );

                const giaNguoiLon = chuyenThanhSo(
                    selectedOption.dataset.giaNguoiLon
                );

                const giaTreEm = chuyenThanhSo(
                    selectedOption.dataset.giaTreEm
                );

                const giaEmBe = chuyenThanhSo(
                    selectedOption.dataset.giaEmBe
                );

                hienThiThoiLuong.textContent =
                    thoiLuong > 0
                        ? `${thoiLuong} ngày`
                        : 'Chưa xác định';

                if (!giuDuLieuCu || !soChoInput.value) {
                    soChoInput.value = soCho;
                }

                if (!giuDuLieuCu || !giaNguoiLonInput.value) {
                    giaNguoiLonInput.value = giaNguoiLon;
                }

                if (!giuDuLieuCu || !giaTreEmInput.value) {
                    giaTreEmInput.value = giaTreEm;
                }

                if (!giuDuLieuCu || !giaEmBeInput.value) {
                    giaEmBeInput.value = giaEmBe;
                }

                capNhatNgayKetThuc();
            }

            if (tourSelect) {
                tourSelect.addEventListener(
                    'change',
                    function () {
                        capNhatThongTinTour(false);
                    }
                );

                /*
                 * Nếu trang đang dùng Select2 thì sự kiện này
                 * giúp cập nhật dữ liệu khi chọn lại Tour.
                 */
                if (window.jQuery) {
                    window.jQuery(tourSelect).on(
                        'select2:select select2:clear',
                        function () {
                            capNhatThongTinTour(false);
                        }
                    );
                }
            }

            if (ngayKhoiHanhInput) {
                ngayKhoiHanhInput.addEventListener(
                    'change',
                    capNhatNgayKetThuc
                );

                ngayKhoiHanhInput.addEventListener(
                    'input',
                    capNhatNgayKetThuc
                );
            }

            /*
             * Khôi phục dữ liệu cũ nếu validate thất bại.
             */
            if (oldSoCho !== null) {
                soChoInput.value = oldSoCho;
            }

            if (oldGiaNguoiLon !== null) {
                giaNguoiLonInput.value = oldGiaNguoiLon;
            }

            if (oldGiaTreEm !== null) {
                giaTreEmInput.value = oldGiaTreEm;
            }

            if (oldGiaEmBe !== null) {
                giaEmBeInput.value = oldGiaEmBe;
            }

            capNhatThongTinTour(true);
        });
    </script>
@endpush

