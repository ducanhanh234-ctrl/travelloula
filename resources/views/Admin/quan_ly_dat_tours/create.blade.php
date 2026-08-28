@extends('layouts.admin')
@section('content')
    <div class="container-fluid">
        @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="fw-bold">
                    Thêm đặt tour thủ công
                </h2>
                <p class="text-muted">
                    Tạo booking mới cho khách hàng
                </p>
            </div>
            <a href="{{ route('Admin.quan_ly_dat_tour.index') }}" class="btn btn-warning">
                Quay lại
            </a>
        </div>
        <form id="bookingForm" method="POST" action="{{ route('Admin.dat_tours.store') }}">
            @csrf

            @if(session('error'))
                <div class="alert alert-danger">
                    <i class="fas fa-exclamation-circle me-2"></i>
                    {{ session('error') }}
                </div>
            @endif
            <!-- Thông tin tour -->
            <div class="card mb-4">
                <div class="card-header fw-bold">
                    Thông tin tour
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label">
                            Tour *
                        </label>
                        <select class="form-select" name="tour_id" id="tour_id" required>
                            <option value="">
                                -- Chọn tour --
                            </option>
                            @foreach($tours as $tour)
                                <option value="{{ $tour->id }}"
                                    {{-- data-status="{{ $tour->trang_thai }}" --}}
                                    data-category="{{ $tour->danh_muc_id }}"
                                    {{ old('tour_id') == $tour->id ? 'selected' : '' }}
                                    data-destination="{{ $tour->diem_den }}"
                                    data-adult="{{ $tour->gia_nguoi_lon }}"
                                    data-child="{{ $tour->gia_tre_em }}"
                                    data-duration="{{ $tour->lichTrinh->count() ?: 1 }}"
                                    {{-- @disabled($tour->trang_thai !== 'dang_mo_ban') --}}
                                >

                                    {{ $tour->ten_tour }}
{{--
                                    @if($tour->trang_thai === 'active')
                                        (Đang hoạt động - Không thể đặt)
                                    @elseif($tour->trang_thai !== 'dang_mo_ban')
                                        (Không thể đặt)
                                    @endif --}}

                                    | {{ $tour->lichTrinh->count() }}N{{ max($tour->lichTrinh->count() - 1, 0) }}Đ
                                    | {{ number_format($tour->gia_nguoi_lon, 0, ',', '.') }}đ

                                </option>
                            @endforeach
                        </select>
                        <small id="tour-status-error" class="text-danger"></small>

                        <div class="row mt-3">
                            <div class="col-md-6">
                                <label>Giá người lớn</label>
                                <input type="text" id="adult_price" name="adult_price" class="form-control" value="{{ old('adult_price') }}" readonly>
                            </div>

                            <div class="col-md-6">
                                <label>Giá trẻ em</label>
                                <input type="text" id="child_price" name="child_price" class="form-control" value="{{ old('child_price') }}"  readonly>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Lịch khởi hành *</label>
                        <select class="form-select" id="lich_khoi_hanh_id" name="lich_khoi_hanh_id" required>
                            <option value="">
                                -- Chọn lịch khởi hành --
                            </option>
                        </select>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <label>Ngày khởi hành</label>

                            <input type="text" id="ngay_bat_dau" class="form-control" readonly>
                        </div>

                        <div class="col-md-6">
                            <label>Ngày kết thúc</label>

                            <input type="text" id="ngay_ket_thuc" class="form-control" readonly>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Thông tin người đặt -->
            <div class="card mb-4">
                <div class="card-header fw-bold">
                    Thông tin người đặt
                </div>

                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label">
                            Loại khách hàng
                        </label>

                    <select class="form-select" id="booking_type" name="booking_type">
                        <option value="user" {{ old('booking_type', 'user') == 'user' ? 'selected' : '' }}>
                            Khách có tài khoản
                        </option>

                        <option value="guest" {{ old('booking_type') == 'guest' ? 'selected' : '' }}>
                            Khách vãng lai
                        </option>
                    </select>
                </div>

                    <!-- Khách có tài khoản -->
                    <div id="user-section">
                        <div class="mb-3">
                            <label class="form-label">
                                Chọn khách hàng
                            </label>
                            <select class="form-select" name="nguoi_dung_id">
                                <option value="">
                                    -- Chọn khách hàng --
                                </option>
                                @foreach($users as $u)
                                    <option value="{{ $u->id }}" {{ old('nguoi_dung_id') == $u->id ? 'selected' : '' }}>
                                        {{ $u->name }} - {{ $u->email }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <!-- Khách vãng lai -->
                    <div id="guest-section" style="display:none;">
                        <div class="row">
                            <div class="col-md-4">
                                <label>
                                    Tên người đặt
                                </label>
                                <input type="text" name="ten_nguoi_dat" class="form-control">
                            </div>
                            <div class="col-md-4">
                                <label>
                                    Số điện thoại
                                </label>
                                <input type="text" name="so_dien_thoai" class="form-control">
                            </div>
                            <div class="col-md-4">
                                <label>
                                    Email
                                </label>
                                <input type="email" name="email" class="form-control">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Thông tin đoàn -->
            <div class="card mb-4">
                <div class="card-header fw-bold">
                    Thông tin đoàn
                </div>

                <div class="card-body">
                    <div class="row g-3">

                        <!-- Người lớn -->
                        <div class="col-md-4">
                            <div class="border rounded p-3 bg-light">
                                <div class="text-muted small mb-1">
                                    Người lớn
                                </div>

                                <div class="fs-4 fw-bold text-primary">
                                    <span id="adult_count_display">0</span>
                                    <span class="fs-6 fw-normal text-muted">người</span>
                                </div>
                            </div>
                        </div>

                        <!-- Trẻ em -->
                        <div class="col-md-4">
                            <div class="border rounded p-3 bg-light">
                                <div class="text-muted small mb-1">
                                    Trẻ em
                                </div>

                                <div class="fs-4 fw-bold text-success">
                                    <span id="child_count_display">0</span>
                                    <span class="fs-6 fw-normal text-muted">người</span>
                                </div>
                            </div>
                        </div>

                        <!-- Tổng -->
                        <div class="col-md-4">
                            <div class="border rounded p-3 bg-light">
                                <div class="text-muted small mb-1">
                                    Tổng hành khách
                                </div>

                                <div class="fs-4 fw-bold text-dark">
                                    <span id="total_count_display">0</span>
                                    <span class="fs-6 fw-normal text-muted">người</span>
                                </div>
                            </div>
                        </div>

                    </div>

                    <!-- Input ẩn để vẫn gửi dữ liệu lên Controller -->
                    <input type="hidden" name="so_nguoi_lon" id="adult_count" value="0">
                    <input type="hidden" name="so_tre_em" id="child_count" value="0">
                </div>
            </div>

            <!-- Hành khách -->
            <div class="card mb-4">
                <!-- Header -->
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span class="fw-bold">
                        Thông tin hành khách
                    </span>

                    <div class="d-flex align-items-center gap-2">
                       <button type="button" class="btn btn-primary" id="add-passenger">
                            <i class="fas fa-user-plus me-1"></i>
                            Thêm hành khách
                        </button>

                        <!-- Hiện / ẩn -->
                        <button class="btn btn-sm btn-outline-primary" type="button" data-bs-toggle="collapse"
                            data-bs-target="#passengerCollapse">
                            <i class="fas fa-users me-1"></i>
                            Hiện/Ẩn danh sách
                        </button>

                        <!-- Excel -->
                        <input type="file" id="excelFile" accept=".xlsx,.xls,.csv" class="form-control form-control-sm"
                            style="width:250px;">

                    </div>
                </div>

                <!-- Body -->
                <div class="card-body">
                    <div id="passenger-summary" class="alert alert-info">
                        Tổng số hành khách: 1
                    </div>

                    <div class="collapse show" id="passengerCollapse">
                        <div id="passenger-container"></div>
                    </div>
                </div>

            </div>

            <!-- Thanh toán -->
            <div class="card mb-4">
                <div class="card-header fw-bold">
                    <i class="fas fa-credit-card me-2"></i>
                    Thanh toán
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <!-- Trạng thái -->
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">
                                Trạng thái thanh toán
                            </label>
                            <select name="trang_thai" class="form-select">
                                <option value="cho_xac_nhan">
                                    Chờ xác nhận
                                </option>
                                <option value="da_xac_nhan">
                                    Đã xác nhận
                                </option>
                                <option value="da_thanh_toan">
                                    Đã thanh toán
                                </option>
                                <option value="da_huy">
                                    Đã hủy
                                </option>
                            </select>
                        </div>
                        <!-- Phương thức -->
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">
                                Phương thức thanh toán
                            </label>
                            <select name="phuong_thuc_thanh_toan" class="form-select">
                                <option value="">
                                    -- Chọn phương thức --
                                </option>
                                <option value="Tien mat">
                                    💵 Tiền mặt
                                </option>
                                <option value="Chuyen khoan">
                                    🏦 Chuyển khoản
                                </option>
                                <option value="VNPay">
                                    💳 VNPay
                                </option>
                            </select>

                            @error('phuong_thuc_thanh_toan')
                                <small class="text-danger">
                                    {{ $message }}
                                </small>
                            @enderror
                        </div>
                        <!-- Tổng tiền -->
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">
                                Tổng tiền
                            </label>
                            <div class="input-group">
                                <input type="number" id="tong_tien" name="tong_tien" class="form-control" value="0"
                                    readonly>
                                <span class="input-group-text">
                                    VNĐ
                                </span>
                            </div>
                        </div>
                        <!-- Tiền đã thanh toán -->
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">
                                Số tiền đã thanh toán
                            </label>
                            <div class="input-group">
                                <input type="number" name="so_tien_da_thanh_toan" class="form-control" value="0">
                                <span class="input-group-text">
                                    VNĐ
                                </span>

                            </div>
                        </div>
                    </div>
                    <!-- Chi tiết thanh toán -->
                    <div class="mt-4">
                        <div id="payment_detail">
                            <div class="alert alert-secondary mb-0">
                                <i class="fas fa-info-circle me-2"></i>
                                Chưa có dữ liệu thanh toán
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </div>

    {{-- Ghi chú --}}
    <div class="card mb-4">
        <div class="card-header fw-bold">
            Ghi chú
        </div>

        <div class="card-body">
            <textarea name="ghi_chu" rows="4" class="form-control" placeholder="Yêu cầu đặc biệt của khách..."></textarea>
        </div>
    </div>

    {{-- end --}}
    <div class="text-end mb-4">
        <a href="{{ route('Admin.quan_ly_dat_tour.index') }}" class="btn btn-danger">
            Hủy
        </a>
        {{-- <div id="debug"></div> --}}
        <button type="submit" class="btn btn-primary">
            Lưu đặt tour
        </button>
    </div>
    </form>
    </div>

    @section('scripts')
        <script>
            let passengerIndex = 0;
            const validationErrors = @json($errors->toArray());
            const oldPassengers = @json(old('hanh_khach', []));
            const oldLichKhoiHanhId = @json(old('lich_khoi_hanh_id'));
        function createPassenger(index) {
    return `
        <div class="card mb-3 passenger-item">

            <div class="card-header d-flex justify-content-between align-items-center">
                <b>Hành khách #${index + 1}</b>

                <button
                    type="button"
                    class="btn btn-sm btn-outline-danger"
                    onclick="removePassenger(this)"
                    title="Xóa hành khách">
                    <i class="fas fa-trash"></i>
                </button>
            </div>

            <div class="card-body">

                <input
                    type="hidden"
                    name="hanh_khach[${index}][loai_hanh_khach]"
                    value=""
                >

                <!-- Hàng 1 -->
                <div class="row">

                    <div class="col-md-6">
                        <label>Họ tên *</label>

                        <input
                            type="text"
                            class="form-control"
                            name="hanh_khach[${index}][ho_ten]"
                            required
                        >

                        <small
                            class="text-danger validation-error"
                            data-error="hanh_khach.${index}.ho_ten">
                        </small>
                    </div>

                    <div class="col-md-3">
                        <label>Giới tính</label>

                        <select
                            class="form-select"
                            name="hanh_khach[${index}][gioi_tinh]"
                        >
                            <option value="Nam">Nam</option>
                            <option value="Nữ">Nữ</option>
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label>Ngày sinh</label>

                        <input
                            type="date"
                            class="form-control passenger-birth"
                            name="hanh_khach[${index}][ngay_sinh]"
                            data-index="${index}"
                        >

                        <small
                            class="text-danger validation-error"
                            data-error="hanh_khach.${index}.ngay_sinh">
                        </small>
                    </div>

                </div>

                <!-- Hàng 2 -->
                <div class="row mt-3">

                    <div class="col-md-4">
                        <label>Quốc tịch</label>

                        <input
                            type="text"
                            class="form-control"
                            name="hanh_khach[${index}][quoc_tich]"
                            value="Việt Nam"
                        >
                    </div>

                    <div class="col-md-3">
                        <label>
                            Loại giấy tờ <span class="text-danger">*</span>
                        </label>

                        <select
                            class="form-select"
                            name="hanh_khach[${index}][loai_giay_to]"
                            required
                        >
                            <option value="CCCD">CCCD</option>
                            <option value="Hộ chiếu">Hộ chiếu</option>
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label>Số giấy tờ</label>

                        <input type="text" class="form-control" name="hanh_khach[${index}][so_giay_to]">
                        <small class="text-danger validation-error" data-error="hanh_khach.${index}.so_giay_to"></small>
                    </div>
                    <div class="col-md-4">
                        <label>Số điện thoại</label>

                        <input type="text" class="form-control" name="hanh_khach[${index}][so_dien_thoai]">
                        <small class="text-danger validation-error" data-error="hanh_khach.${index}.so_dien_thoai"></small>
                    </div>
                </div>

                <!-- Hàng 3 -->
                <div class="row mt-3">

                    <div class="col-md-12">
                        <label>Yêu cầu đặc biệt</label>

                        <textarea
                            class="form-control"
                            rows="2"
                            name="hanh_khach[${index}][yeu_cau_dac_biet]"
                            placeholder="Ăn chay, dị ứng, yêu cầu khác..."
                        ></textarea>
                    </div>

                </div>

            </div>
        </div>
    `;
}

    function hienThiLoiValidation() {
    Object.keys(validationErrors).forEach(key => {
        const errorElement = document.querySelector(
            `[data-error="${key}"]`
        );

        if (errorElement) {
            errorElement.textContent = validationErrors[key][0];
        }
    });
}

    function capNhatLoaiHanhKhach(input) {
        const ngaySinh = input.value;
            if (!ngaySinh) return;
        const tuoi = tinhTuoi(ngaySinh);
        const index = input.dataset.index;
        const loaiInput = document.querySelector(`[name="hanh_khach[${index}][loai_hanh_khach]"]`);
            if (tuoi <= 12) {
                loaiInput.value = 'child';
            } else {
                loaiInput.value = 'adult';
            }
        updatePassengerCount();
    }

    document.addEventListener('change', function (e) {
        if (e.target.classList.contains('passenger-birth')) {
            capNhatLoaiHanhKhach(e.target);
        }
    });

    function capNhatThongTinDoan() {
    let nguoiLon = 0;
    let treEm = 0;

    document.querySelectorAll('.passenger-birth').forEach(input => {
        if (!input.value) return;

        const tuoi = tinhTuoi(input.value);

        if (tuoi <= 12) {
            treEm++;
        } else {
            nguoiLon++;
        }
    });

    document.getElementById('adult_count').value = nguoiLon;
    document.getElementById('child_count').value = treEm;

    updatePrice();
}

            function removePassenger(button) {
                button.closest('.card').remove();
                updatePassengerCount();
            }

            function addPassenger() {
                const container = document.getElementById('passenger-container');
                const html = createPassenger(passengerIndex);
                    container.insertAdjacentHTML('beforeend', html);
                    passengerIndex++;
                        updatePassengerCount();
            }

            document.getElementById('add-passenger').addEventListener('click', function () {
                addPassenger();
            });

            // function updatePassengerCount() {
            //     const adults = document.querySelectorAll(
            //         '[name$="[loai_hanh_khach]"][value="adult"]'
            //     ).length;

            //     const children = document.querySelectorAll(
            //         '[name$="[loai_hanh_khach]"][value="child"]'
            //     ).length;

            //     const total = adults + children;

            //     // Cập nhật input hidden
            //     document.getElementById('adult_count').value = adults;
            //     document.getElementById('child_count').value = children;

            //     // Cập nhật phần Thông tin đoàn
            //     document.getElementById('adult_count_display').textContent = adults;
            //     document.getElementById('child_count_display').textContent = children;
            //     document.getElementById('total_count_display').textContent = total;

            //     // Cập nhật tổng tiền
            //     updatePrice();
            // }

            function updatePassengerCount() {
                let adults = 0;
                let children = 0;

                document.querySelectorAll('.passenger-birth').forEach(input => {
                    if (!input.value) return;

                    const tuoi = tinhTuoi(input.value);

                 if (tuoi <= 12) {
                        children++;
                    } else {
                        adults++;
                    }
             });

                const total = adults + children;

                document.getElementById('adult_count').value = adults;
                document.getElementById('child_count').value = children;

                document.getElementById('adult_count_display').textContent = adults;
                document.getElementById('child_count_display').textContent = children;
                document.getElementById('total_count_display').textContent = total;

                updatePrice();
            }

    document.addEventListener('DOMContentLoaded', function () {
        if (oldPassengers.length > 0) {
            const container = document.getElementById('passenger-container');

        oldPassengers.forEach((khach) => {
            const index = passengerIndex++;

            container.insertAdjacentHTML('beforeend',createPassenger(index));
            document.querySelector(`[name="hanh_khach[${index}][ho_ten]"]`).value = khach.ho_ten || '';
            document.querySelector(
                `[name="hanh_khach[${index}][gioi_tinh]"]`
            ).value = khach.gioi_tinh || 'Nam';

            document.querySelector(
                `[name="hanh_khach[${index}][ngay_sinh]"]`
            ).value = khach.ngay_sinh || '';

            document.querySelector(
                `[name="hanh_khach[${index}][quoc_tich]"]`
            ).value = khach.quoc_tich || 'Việt Nam';

            document.querySelector(
                `[name="hanh_khach[${index}][loai_giay_to]"]`
            ).value = khach.loai_giay_to || 'CCCD';

            document.querySelector(
                `[name="hanh_khach[${index}][so_giay_to]"]`
            ).value = khach.so_giay_to || '';

            document.querySelector(
                `[name="hanh_khach[${index}][so_dien_thoai]"]`
            ).value = khach.so_dien_thoai || '';

            document.querySelector(
                `[name="hanh_khach[${index}][yeu_cau_dac_biet]"]`
            ).value = khach.yeu_cau_dac_biet || '';

            capNhatLoaiHanhKhach(
                document.querySelector(
                    `[name="hanh_khach[${index}][ngay_sinh]"]`
                )
            );
        });

        updatePassengerCount();
         hienThiLoiValidation();
    }
         // Khôi phục giá sau khi validate lỗi
    const oldAdultPrice = @json(old('adult_price'));
const oldChildPrice = @json(old('child_price'));

if (oldAdultPrice) {
    document.getElementById('adult_price').value = oldAdultPrice;
}

if (oldChildPrice) {
    document.getElementById('child_price').value = oldChildPrice;
}
});
        </script>



        <script>
            document
                .getElementById('booking_type')
                .addEventListener('change', function () {
                    let type = this.value;
                    document.getElementById('user-section')
                        .style.display =
                        type === 'user'
                            ? 'block'
                            : 'none';
                    document.getElementById('guest-section')
                        .style.display =
                        type === 'guest'
                            ? 'block'
                            : 'none';
                });
        </script>

        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
        <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

        <script>
            let soNgayTour = 1;

            // chọn ngày
            flatpickr("#lich_khoi_hanh", {
                dateFormat: "d/m/Y",
                minDate: "today",
                onChange: function (selectedDates) {
                    if (selectedDates.length) {
                        tinhNgayKetThuc();
                    }
                }
            });

            // tính ngày kết thúc
            function tinhNgayKetThuc() {
                let input = document.getElementById('lich_khoi_hanh');
                if (!input._flatpickr.selectedDates.length) {
                    return;
                }
                let ngayBatDau = input._flatpickr.selectedDates[0];
                let ngayKetThuc = new Date(
                    ngayBatDau.getFullYear(),
                    ngayBatDau.getMonth(),
                    ngayBatDau.getDate()
                );
                ngayKetThuc.setDate(
                    ngayKetThuc.getDate() + soNgayTour - 1
                );
                let d = String(
                    ngayKetThuc.getDate()
                ).padStart(2, '0');

                let m = String(
                    ngayKetThuc.getMonth() + 1
                ).padStart(2, '0');

                let y = ngayKetThuc.getFullYear();

                document.getElementById('ngay_ket_thuc').value =
                    `${d}/${m}/${y}`;
            }

            // đổi tour
            document.getElementById('tour_id')
                .addEventListener('change', function () {
                    let option = this.options[this.selectedIndex];
                    let tourStatusError = document.getElementById('tour-status-error');

                    if (this.value && option.dataset.status === 'active') {
                        tourStatusError.textContent = 'Tour đang hoạt động - Không thể đặt tour.';
                    } else {
                    tourStatusError.textContent = '';
                    }
                    soNgayTour = Number(option.dataset.duration);
                    console.log(
                        "Số ngày:",
                        soNgayTour
                    );

                    // nếu đã chọn ngày thì tính lại
                    tinhNgayKetThuc();
                });
        </script>

        <script>
            let giaNguoiLon = 0;
            let giaTreEm = 0;
            function formatMoney(number) {
                return new Intl.NumberFormat('vi-VN').format(number);
            }
            function updatePrice() {
                let adult =
                    parseInt(document.getElementById('adult_count').value) || 0;
                let child =
                    parseInt(document.getElementById('child_count').value) || 0;

                let tienNguoiLon = adult * giaNguoiLon;
                let tienTreEm = child * giaTreEm;
                let tongTien = tienNguoiLon + tienTreEm;

                document.getElementById('tong_tien').value = tongTien;
                document.getElementById('payment_detail').innerHTML = `

                                                                                                                                                                                                                                                                                                                                <div class="payment-box">
                                                                                                                                                                                                                                                                                                                                <div class="payment-title">
                                                                                                                                                                                                                                                                                                                                    💳 Chi tiết thanh toán
                                                                                                                                                                                                                                                                                                                                </div>

                                                                                                                                                                                                                                                                                                                                <div class="payment-item">
                                                                                                                                                                                                                                                                                                                                    <div>
                                                                                                                                                                                                                                                                                                                                        <b>Người lớn</b>
                                                                                                                                                                                                                                                                                                                                        <small>${adult} khách × ${formatMoney(giaNguoiLon)} VNĐ</small>
                                                                                                                                                                                                                                                                                                                                    </div>

                                                                                                                                                                                                                                                                                                                                    <strong>
                                                                                                                                                                                                                                                                                                                                        ${formatMoney(tienNguoiLon)} VNĐ
                                                                                                                                                                                                                                                                                                                                    </strong>
                                                                                                                                                                                                                                                                                                                                </div>

                                                                                                                                                                                                                                                                                                                                <div class="payment-item">
                                                                                                                                                                                                                                                                                                                                    <div>
                                                                                                                                                                                                                                                                                                                                        <b>Trẻ em</b>
                                                                                                                                                                                                                                                                                                                                        <small>${child} khách × ${formatMoney(giaTreEm)} VNĐ</small>
                                                                                                                                                                                                                                                                                                                                    </div>

                                                                                                                                                                                                                                                                                                                                    <strong>
                                                                                                                                                                                                                                                                                                                                        ${formatMoney(tienTreEm)} VNĐ
                                                                                                                                                                                                                                                                                                                                    </strong>
                                                                                                                                                                                                                                                                                                                                </div>

                                                                                                                                                                                                                                                                                                                             <div class="payment-total">
                                                                                                                                                                                                                                                                                                                                <span>
                                                                                                                                                                                                                                                                                                                                    Tổng thanh toán
                                                                                                                                                                                                                                                                                                                                </span>
                                                                                                                                                                                                                                                                                                                                <b>
                                                                                                                                                                                                                                                                                                                                    ${formatMoney(tongTien)} VNĐ
                                                                                                                                                                                                                                                                                                                                            </b>
                                                                                                                                                                                                                                                                                                                                        </div>
                                                                                                                                                                                                                                                                                                                                    </div>
                                                                                                                                                                                                                                                                                                                                `;
            }

            document.addEventListener('DOMContentLoaded', function () {
                const tourSelect =
                    document.getElementById('tour_id');
                tourSelect.addEventListener('change', function () {
                    console.log('change chạy');
                    let option =
                        this.options[this.selectedIndex];

                    giaNguoiLon =
                        Number(option.dataset.adult || 0);

                    giaTreEm =
                        Number(option.dataset.child || 0);

                    document.getElementById('adult_price').value =
                        formatMoney(giaNguoiLon) + ' VNĐ';

                    document.getElementById('child_price').value =
                        formatMoney(giaTreEm) + ' VNĐ';
                    updatePrice();
                });

                document.getElementById('adult_count')
                    .addEventListener('input', updatePrice);
                document.getElementById('child_count')
                    .addEventListener('input', updatePrice);
            });

            function formatDate(dateString) {
                const date = new Date(dateString);

                const day = String(date.getDate()).padStart(2, '0');
                const month = String(date.getMonth() + 1).padStart(2, '0');
                const year = date.getFullYear();

                return `${day}/${month}/${year}`;
            }

            const tourSelect = document.getElementById('tour_id');
            const lichSelect = document.getElementById('lich_khoi_hanh_id');

            $('#tour_id').on('change', function () {
                console.log('change chạy');

                let option = this.options[this.selectedIndex];

                giaNguoiLon = Number(option.dataset.adult || 0);
                giaTreEm = Number(option.dataset.child || 0);

                console.log(option.dataset);
                console.log(giaNguoiLon);
                console.log(giaTreEm);


                $('#adult_price').val(formatMoney(giaNguoiLon) + ' VNĐ');
                $('#child_price').val(formatMoney(giaTreEm) + ' VNĐ');

                updatePrice();
                let tourId = this.value;
                lichSelect.innerHTML =
                    '<option value="">-- Chọn lịch khởi hành --</option>';

                document.getElementById('ngay_bat_dau').value = '';
                document.getElementById('ngay_ket_thuc').value = '';
                if (!tourId) return;
                fetch('/Admin/tour/' + tourId + '/lich-khoi-hanh')
                    .then(res => {
                        if (!res.ok) {
                            throw new Error("Không lấy được lịch khởi hành");
                        }
                        return res.json();
                    })
                    .then(data => {
                        console.log("Dữ liệu từ Laravel:", data);
                        if (data.length === 0) {
                            let option = document.createElement('option');
                            option.text = 'Không có lịch khởi hành';
                            option.disabled = true;
                            lichSelect.appendChild(option);
                            return;
                        }

                       data.forEach(function (item) {
                        let option = document.createElement('option');

                        option.value = item.id;
                        option.dataset.start = formatDate(item.ngay_khoi_hanh);
                        option.dataset.end = formatDate(item.ngay_ket_thuc);

                    if (item.trang_thai !== 'available') {
                        option.disabled = true;
                        option.style.color = "red";

                        if (item.trang_thai === 'running') {
                            option.text =
                                `${formatDate(item.ngay_khoi_hanh)} (Đang hoạt động - Không thể đặt)`;
                        } else {
                         option.text =
                                `${formatDate(item.ngay_khoi_hanh)} (${item.trang_thai_hien_thi || 'Không thể đặt'})`;
                        }
                    } else {
                     option.text =
                            `${formatDate(item.ngay_khoi_hanh)} (Đã đặt: ${item.so_cho_da_dat} | Còn: ${item.so_cho_con_lai})`;
                    }
                        lichSelect.appendChild(option);
                    });

                    // KHÔI PHỤC LỊCH CŨ
                    if (oldLichKhoiHanhId) {
                     lichSelect.value = oldLichKhoiHanhId;
                     lichSelect.dispatchEvent(new Event('change'));
                    }
                    })

                    .catch(error => { console.error(error); alert("Không lấy được lịch khởi hành.");
                });
            });

            const oldTourId = @json(old('tour_id'));

            if (oldTourId) {
                tourSelect.value = oldTourId;
                tourSelect.dispatchEvent(new Event('change'));
            }

            lichSelect.addEventListener('change', function () {
                let option = this.options[this.selectedIndex];
                document.getElementById('ngay_bat_dau').value =
                    option.dataset.start || '';

                document.getElementById('ngay_ket_thuc').value =
                    option.dataset.end || '';

                if (!this.value) return;

                fetch('/Admin/lich-khoi-hanh/' + this.value + '/gia')
                    .then(res => res.json())
                    .then(data => {

                        giaNguoiLon = Number(data.gia_nguoi_lon);
                        giaTreEm = Number(data.gia_tre_em);

                        $('#adult_price').val(formatMoney(giaNguoiLon) + ' VNĐ');
                        $('#child_price').val(formatMoney(giaTreEm) + ' VNĐ');

                        updatePrice();
                    })
                    .catch(err => console.error(err));
            });
        </script>

        <script>
            document.addEventListener('DOMContentLoaded', function () {
                $('#tour_id').select2({
                    placeholder: '🔍 Nhập tên tour để tìm kiếm...',
                    width: '100%',
                    allowClear: true
                });
            });
        </script>

        {{-- Import danh sách hành khách từ file Excel --}}
        <script>
            function excelDateToDate(value) {
                console.log("Ngày nhận vào:", value);
                if (!value) return '';
                // Nếu Excel trả về dạng ngày tháng: 01/01/2019
                if (typeof value === 'string' && value.includes('/')) {
                    let parts = value.split('/');
                    return `${parts[2]}-${parts[1].padStart(2, '0')}-${parts[0].padStart(2, '0')}`;
                }


                // Nếu Excel trả về số serial
                let date = new Date((value - 25569) * 86400 * 1000);
                console.log(value, "=>", date);
                let year = date.getUTCFullYear();
                let month = String(date.getUTCMonth() + 1).padStart(2, '0');
                let day = String(date.getUTCDate()).padStart(2, '0');

                return `${year}-${month}-${day}`;
            }
            document.getElementById('excelFile').addEventListener('change', function () {

                let file = this.files[0];
                console.log("Tên file đang import:", file.name);
                if (!file) return;

                let formData = new FormData();
                formData.append('file', file);

                fetch("{{ route('Admin.import_hanh_khach') }}", {
                    method: "POST",
                    headers: {
                        "X-CSRF-TOKEN": "{{ csrf_token() }}"
                    },
                    body: formData
                })
                    // .then(res => res.json())
                    .then(async res => {
                        const text = await res.text();

                        console.log("HTTP status:", res.status);
                        console.log("Response từ Laravel:", text);

                        if (!res.ok) {
                            throw new Error(text);
                        }

                        return JSON.parse(text);
                    })
                    .then(data => {
                        console.log(data);
                        let adult = 0;
                        let child = 0;

                        data.forEach(item => {
                            const ngaySinh = item.ngay_sinh ? excelDateToDate(item.ngay_sinh) : '';
                            if (!ngaySinh) return;
                            const tuoi = tinhTuoi(ngaySinh);
                            if (tuoi <= 12) {
                                child++;
                            } else {
                                adult++;
                            }
                        });

                        document.getElementById('adult_count').value = adult;
                        document.getElementById('child_count').value = child;

                        document.getElementById('adult_count_display').textContent = adult;
                        document.getElementById('child_count_display').textContent = child;
                        document.getElementById('total_count_display').textContent = adult + child;

                        // Tạo lại form theo đúng số lượng
                        // generatePassengers();
                        console.log('Số form trước khi import:', document.querySelectorAll('.passenger-item').length);
                        console.log('Số người trong Excel:', data.length);
                        passengerIndex = 0;
                        document.getElementById('passenger-container').innerHTML = '';
                        data.forEach(() => {
                            const index = passengerIndex++;

                            document.getElementById('passenger-container')
                                .insertAdjacentHTML('beforeend', createPassenger(index));
                        });
                        console.log('Số form sau khi tạo:', document.querySelectorAll('.passenger-item').length);
                        updatePrice();
                        // Đổ dữ liệu từ Excel vào từng form hành khách
                        let adultIndex = 0;
                        let childIndex = adult;

                        data.forEach(item => {

                            const ngaySinh = item.ngay_sinh ? excelDateToDate(item.ngay_sinh) : '';
                            const tuoi = tinhTuoi(ngaySinh);

                            let index;

                            if (tuoi <= 12) {
                                index = childIndex++;
                            } else {
                                index = adultIndex++;
                            }

                            document.querySelector(`[name="hanh_khach[${index}][ho_ten]"]`).value =
                                item.ho_ten || '';

                            document.querySelector(`[name="hanh_khach[${index}][gioi_tinh]"]`).value =
                                item.gioi_tinh || 'Nam';

                            document.querySelector(`[name="hanh_khach[${index}][ngay_sinh]"]`).value =
                                ngaySinh;

                            document.querySelector(`[name="hanh_khach[${index}][quoc_tich]"]`).value =
                                item.quoc_tich || 'Việt Nam';

                            document.querySelector(`[name="hanh_khach[${index}][loai_giay_to]"]`).value =
                                item.loai_giay_to || 'CCCD';

                            document.querySelector(`[name="hanh_khach[${index}][so_giay_to]"]`).value =
                                item.so_giay_to || '';

                            document.querySelector(`[name="hanh_khach[${index}][so_dien_thoai]"]`).value =
                                item.so_dien_thoai || '';

                            document.querySelector(`[name="hanh_khach[${index}][yeu_cau_dac_biet]"]`).value =
                                item.yeu_cau_dac_biet || '';
                        });
                    })
                    .catch(err => {
                        console.error(err);
                        alert("Import thất bại");
                    });

            });

            function tinhTuoi(ngaySinh) {
                const birth = new Date(ngaySinh);
                const today = new Date();
                let age = today.getFullYear() - birth.getFullYear();

                const m = today.getMonth() - birth.getMonth();

                if (m < 0 || (m === 0 && today.getDate() < birth.getDate())) {
                    age--;
                }
                return age;
            }

            function capNhatLoaiHanhKhach(input) {
                const ngaySinh = input.value;
                    if (!ngaySinh) return;
                const tuoi = tinhTuoi(ngaySinh);
                const index = input.dataset.index;
                const loaiInput = document.querySelector(
                    `[name="hanh_khach[${index}][loai_hanh_khach]"]`
                );
                    if (tuoi <= 12) {
                        loaiInput.value = 'child';
                    } else {
                        loaiInput.value = 'adult';
                    }
                updatePassengerCount();
            }
        </script>

        <style>
            .payment-box {
                background: white;
                border: 1px solid #e5e7eb;
                border-radius: 15px;
                padding: 20px;
            }

            .payment-title {
                font-size: 18px;
                font-weight: 700;
                margin-bottom: 15px;
            }

            .payment-item {
                display: flex;
                justify-content: space-between;
                align-items: center;
                padding: 12px 0;
                border-bottom: 1px dashed #ddd;
            }

            .payment-item small {
                display: block;
                color: #777;
                margin-top: 3px;

            }

            .payment-item strong {
                font-size: 15px;
            }

            .payment-total {
                margin-top: 20px;
                padding-top: 15px;
                border-top: 2px solid #eee;
                display: flex;
                justify-content: space-between;
                align-items: center;
                font-size: 18px;
            }

            .payment-total b {
                color: #dc3545;
                font-size: 22px;
            }
        </style>
    @endsection
@endsection
