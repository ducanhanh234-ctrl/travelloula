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
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            @csrf
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
                                <option value="{{ $tour->id }}" data-adult="{{ $tour->gia_nguoi_lon }}"
                                    data-child="{{ $tour->gia_tre_em }}" data-baby="{{ $tour->gia_em_be }}"
                                    data-duration="{{ $tour->lichTrinh->count() ?: 1 }}">
                                    {{ $tour->ten_tour }}
                                    - {{ $tour->lichTrinh->count() }}
                                </option>
                            @endforeach
                        </select>

                        <div class="row mt-3">
                            <div class="col-md-4">
                                <label>Giá người lớn</label>
                                <input type="text" id="adult_price" class="form-control" readonly>
                            </div>

                            <div class="col-md-4">
                                <label>Giá trẻ em</label>
                                <input type="text" id="child_price" class="form-control" readonly>
                            </div>

                            <div class="col-md-4">
                                <label>Giá em bé</label>
                                <input type="text" id="baby_price" class="form-control" readonly>
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
                            <option value="user">
                                Khách có tài khoản
                            </option>
                            <option value="guest">
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
                                    <option value="{{ $u->id }}">
                                        {{ $u->name }}
                                        -
                                        {{ $u->email }}
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
                    <div class="row">
                        <div class="col-md-4">
                            <label>Số người lớn</label>
                            <input type="number" name="so_nguoi_lon" id="adult_count"
                                class="form-control @error('so_nguoi_lon') is-invalid @enderror"
                                value="{{ old('so_nguoi_lon', 1) }}" min="0">
                            @error('so_nguoi_lon')
                                <div class="text-danger mt-2 fw-bold">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="col-md-4">
                            <label>Số trẻ em</label>
                            <input type="number" name="so_tre_em" id="child_count" class="form-control"
                                value="{{ old('so_tre_em', 0) }}" min="0">
                        </div>

                        <div class="col-md-4">
                            <label>Số em bé</label>
                            <input type="number" name="so_em_be" id="baby_count" class="form-control"
                                value="{{ old('so_em_be', 0) }}" min="0">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Hành khách -->
            <div class="card mb-4">
                <div class="card-header fw-bold">
                    Thông tin hành khách
                </div>
                <div class="card-body">
                    <div id="passenger-summary" class="alert alert-info">
                        Tổng số hành khách: 1
                    </div>
                    <div id="passenger-container"></div>
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
        <div id="debug"></div>
        <button type="submit" class="btn btn-primary">
            Lưu đặt tour
        </button>
    </div>
    </form>
    </div>

    <script>
        function createPassenger(type, index) {

            let loai = 'adult';

            if (type === 'Trẻ em') {
                loai = 'child';
            }
            else if (type === 'Em bé') {
                loai = 'baby';
            }
            return `

                        <div class="card mb-3">
                            <div class="card-header">
                                <b>${type} #${index + 1}</b>
                            </div>

                            <div class="card-body">
                                <input
                                    type="hidden"
                                    name="hanh_khach[${index}][loai_hanh_khach]"
                                    value="${loai}">

                                <div class="row">
                                    <div class="col-md-6">
                                        <label>
                                            Họ tên *
                                        </label>

                                        <input
                                            type="text"
                                            class="form-control"
                                            name="hanh_khach[${index}][ho_ten]"
                                            required>
                                    </div>

                                    <div class="col-md-3">
                                        <label>
                                            Giới tính
                                        </label>

                                        <select
                                            class="form-select"
                                            name="hanh_khach[${index}][gioi_tinh]">

                                            <option value="Nam">
                                                Nam
                                            </option>

                                            <option value="Nữ">
                                                Nữ
                                            </option>
                                        </select>
                                    </div>

                                    <div class="col-md-3">
                                        <label>
                                            Ngày sinh
                                        </label>

                                        <input
                                            type="date"
                                            class="form-control"
                                            name="hanh_khach[${index}][ngay_sinh]">
                                    </div>
                                </div>

                                <div class="row mt-3">
                                    <div class="col-md-4">
                                        <label>
                                            Quốc tịch
                                        </label>

                                        <input
                                            type="text"
                                            class="form-control"
                                            name="hanh_khach[${index}][quoc_tich]"
                                            value="Việt Nam">
                                    </div>

                                    <div class="col-md-3">
                                        <label>
                                            Loại giấy tờ <span class="text-danger">*</span>
                                        </label>

                                        <select
                                            class="form-select"
                                            name="hanh_khach[${index}][loai_giay_to]" required>
                                            <option value="CCCD">CCCD</option>
                                            <option value="Hộ chiếu">Hộ chiếu</option>
                                        </select>
                                    </div>

                                    <div class="col-md-4">
                                        <label>
                                            Số giấy tờ
                                        </label>

                                        <input
                                            type="text"
                                            class="form-control"
                                            name="hanh_khach[${index}][so_giay_to]">
                                    </div>

                                    <div class="col-md-4">
                                        <label>
                                            Số điện thoại
                                        </label>

                                        <input
                                            type="text"
                                            class="form-control"
                                            name="hanh_khach[${index}][so_dien_thoai]">
                                    </div>
                                </div>

                                <div class="row mt-3">
                                    <div class="col-md-12">
                                        <label>
                                            Yêu cầu đặc biệt
                                        </label>

                                        <textarea
                                            class="form-control"
                                            rows="2"
                                            name="hanh_khach[${index}][yeu_cau_dac_biet]"
                                            placeholder="Ăn chay, dị ứng, yêu cầu khác..."></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    `;
        }

        function generatePassengers() {
            let adult =
                parseInt(document.getElementById('adult_count').value) || 0;

            let child =
                parseInt(document.getElementById('child_count').value) || 0;

            let baby =
                parseInt(document.getElementById('baby_count').value) || 0;

            let total = adult + child + baby;
            document.getElementById('passenger-summary').innerHTML =
                `Tổng số hành khách: <b>${total}</b>`;
            let html = '';
            let index = 0;
            for (let i = 0; i < adult; i++) {
                html += createPassenger('Người lớn', index++);
            }
            for (let i = 0; i < child; i++) {
                html += createPassenger('Trẻ em', index++);
            }
            for (let i = 0; i < baby; i++) {
                html += createPassenger('Em bé', index++);
            }

            document.getElementById('passenger-container').innerHTML = html;
            document.getElementById('debug').innerText =
                document.querySelectorAll('[name^="hanh_khach"]').length;
        }

        document.addEventListener('DOMContentLoaded', function () {
            generatePassengers();
            document
                .getElementById('adult_count')
                .addEventListener('input', generatePassengers);
            document
                .getElementById('child_count')
                .addEventListener('input', generatePassengers);
            document
                .getElementById('baby_count')
                .addEventListener('input', generatePassengers);
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
        let giaEmBe = 0;
        function formatMoney(number) {
            return new Intl.NumberFormat('vi-VN').format(number);
        }
        function updatePrice() {
            let adult =
                parseInt(document.getElementById('adult_count').value) || 0;
            let child =
                parseInt(document.getElementById('child_count').value) || 0;
            let baby =
                parseInt(document.getElementById('baby_count').value) || 0;
            let tienNguoiLon = adult * giaNguoiLon;
            let tienTreEm = child * giaTreEm;
            let tienEmBe = baby * giaEmBe;
            let tongTien =
                tienNguoiLon +
                tienTreEm +
                tienEmBe;

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

                                                                                                <div class="payment-item">
                                                                                                    <div>
                                                                                                        <b>Em bé</b>
                                                                                                        <small>${baby} bé × ${formatMoney(giaEmBe)} VNĐ</small>
                                                                                                    </div>

                                                                                                    <strong>
                                                                                                        ${formatMoney(tienEmBe)} VNĐ
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
                let option =
                    this.options[this.selectedIndex];

                giaNguoiLon =
                    Number(option.dataset.adult || 0);

                giaTreEm =
                    Number(option.dataset.child || 0);

                giaEmBe =
                    Number(option.dataset.baby || 0);

                document.getElementById('adult_price').value =
                    formatMoney(giaNguoiLon) + ' VNĐ';

                document.getElementById('child_price').value =
                    formatMoney(giaTreEm) + ' VNĐ';

                document.getElementById('baby_price').value =
                    formatMoney(giaEmBe) + ' VNĐ';
                updatePrice();
            });

            document.getElementById('adult_count')
                .addEventListener('input', updatePrice);
            document.getElementById('child_count')
                .addEventListener('input', updatePrice);
            document.getElementById('baby_count')
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

        tourSelect.addEventListener('change', function () {

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
                    console.log(data);
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

                        if (item.is_full) {
                            option.text =
                                `${formatDate(item.ngay_khoi_hanh)} (Đã đặt: ${item.so_cho_da_dat} | Hết chỗ)`;
                            option.disabled = true;
                            option.style.color = "red";
                        } else {
                            option.text =
                                `${formatDate(item.ngay_khoi_hanh)} (Đã đặt: ${item.so_cho_da_dat} | Còn: ${item.so_cho_con_lai})`;
                        }
                        lichSelect.appendChild(option);
                    });
                })

                .catch(error => {
                    console.error(error);
                    alert("Không lấy được lịch khởi hành.");
                });
        });

        lichSelect.addEventListener('change', function () {
            let option = this.options[this.selectedIndex];
            document.getElementById('ngay_bat_dau').value =
                option.dataset.start || '';

            document.getElementById('ngay_ket_thuc').value =
                option.dataset.end || '';
        });

        //validate loại giấy tờ
        // document.addEventListener('change', function (e) {
        //     if (!e.target.name.includes('[loai_giay_to]')) return;

        //     const card = e.target.closest('.card');
        //     const input = card.querySelector('input[name*="[so_giay_to]"]');

        //     if (e.target.value === 'CCCD') {
        //         input.placeholder = 'Nhập 12 số CCCD';
        //         input.maxLength = 12;
        //         input.pattern = '\\d{12}';
        //     } else {
        //         input.placeholder = 'Nhập số hộ chiếu';
        //         input.removeAttribute('maxLength');
        //         input.removeAttribute('pattern');
        //     }

        //     input.value = '';
        // });

        // document.addEventListener('input', function (e) {
        //     if (!e.target.name.includes('[so_giay_to]')) return;
        //     const card = e.target.closest('.card');
        //     const loai = card.querySelector('select[name*="[loai_giay_to]"]').value;
        //     if (loai === 'CCCD') {
        //         // Chỉ cho nhập số
        //         e.target.value = e.target.value.replace(/\D/g, '');
        //     } else {
        //         // Hộ chiếu: chỉ cho chữ và số
        //         e.target.value = e.target.value.replace(/[^a-zA-Z0-9]/g, '').toUpperCase();
        //     }
        // });
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
