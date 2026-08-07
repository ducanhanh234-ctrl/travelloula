@extends('layouts.app')

@section('content')
<div class="container-fluid py-5 page-bg">
    <div class="container">
        <!-- FORM BAO NGOÀI -->
        <form id="bookingForm" method="POST" action="{{ route('store_dat_tour') }}">
            @csrf
            @if (session('error'))
            <div class="alert alert-danger shadow-sm border-0 rounded mb-4">
                <i class="fa fa-exclamation-triangle mr-2"></i>{{ session('error') }}
            </div>
            @endif

            <!-- ĐƯA FORM RA GIỮA VỚI col-lg-9 mx-auto -->
            <div class="row">
                <div class="col-xl-9 col-lg-10 mx-auto">

                    <div class="mb-4 text-center">
                        <h2 class="font-weight-bold text-dark mb-2">
                            <i class="fa fa-plane-departure mr-2 primary-text"></i>Thông Tin Đặt Tour
                        </h2>
                        <p class="text-muted" style="font-size: 1.1rem;">
                            Vui lòng điền đầy đủ và kiểm tra kỹ thông tin hành khách
                        </p>
                    </div>

                    <!-- Thông tin Tour -->
                    <h5 class="font-weight-bold mb-3 text-dark section-title">Thông tin Tour</h5>
                    <input type="hidden" name="tour_id" value="{{ $tour->id }}">
                    <input type="hidden" name="trang_thai" value="cho_thanh_toan">
                    <input type="hidden" name="so_tien_da_thanh_toan" value="0">

                    <div class="card border-0 shadow-sm mb-5 tour-info-card">
                        <div class="row no-gutters">
                            <div class="col-md-4">
                                <img src="{{ asset($tour->anh_dai_dien) }}" alt="{{ $tour->ten_tour }}" class="img-fluid h-100 w-100 tour-img" class="img-fluid h-100 w-100 tour-img" alt="{{ $tour->ten_tour }}">
                            </div>
                            <div class="col-md-8 p-4 d-flex flex-column justify-content-center">
                                <h4 class="font-weight-bold mb-3">{{ $tour->ten_tour }}</h4>
                                <div class="d-flex align-items-center mb-2 text-muted">
                                    <i class="fa fa-location-dot text-danger mr-2" style="width: 20px; text-align: center;"></i>
                                    Khởi hành từ: <strong>&nbsp;{{ $tour->dia_diem_khoi_hanh }}</strong>
                                </div>
                                <div class="d-flex align-items-center mb-3 text-muted">
                                    <i class="fa fa-clock primary-text mr-2" style="width: 20px; text-align: center;"></i>
                                    Thời lượng: <strong>&nbsp;{{ $tour->thoi_luong }}</strong>
                                </div>
                                <h4 class="primary-text font-weight-bold mb-0 mt-auto">
                                    {{ number_format($tour->gia_nguoi_lon) }}đ <small class="text-muted" style="font-size: 0.9rem; font-weight: normal;">/ người lớn</small>
                                </h4>
                            </div>
                        </div>
                    </div>

                    <!-- Lịch khởi hành -->
                    <h5 class="font-weight-bold mb-3 text-dark section-title">Chọn lịch khởi hành</h5>
                    <div class="mb-5 row">
                        @foreach($lichKhoiHanhs as $lich)
                        <div class="col-md-6 mb-3
        {{ in_array($lich->trang_thai, ['closed', 'full']) ? 'schedule-disabled' : '' }}">

                            <label class="card border-0 shadow-sm p-3 h-100 schedule-card transition-all m-0" style="cursor: {{ in_array($lich->trang_thai, ['closed', 'full']) ? 'not-allowed' : 'pointer' }};">

                                <div class="d-flex align-items-start">

                                    <input class="form-check-input custom-radio mt-1" type="radio" name="lich_khoi_hanh_id" value="{{ $lich->id }}" required @checked(old('lich_khoi_hanh_id')==$lich->id)
                                    {{ in_array($lich->trang_thai, ['closed', 'full']) ? 'disabled' : '' }}
                                    >

                                    <div class="ml-4 w-100">

                                        <div class="d-flex justify-content-between align-items-center mb-1">

                                            <strong class="schedule-date" style="font-size: 1.15rem; color: #0f172a;">
                                                {{ \Carbon\Carbon::parse($lich->ngay_khoi_hanh)->format('d/m/Y') }}
                                            </strong>

                                            <span class="badge badge-pill
                            {{ $lich->trang_thai == 'available' ? 'badge-success-soft' : '' }}
                            {{ $lich->trang_thai == 'closed' ? 'badge-secondary-soft' : '' }}
                            {{ $lich->trang_thai == 'full' ? 'badge-danger-soft' : '' }}">
                                                @switch($lich->trang_thai)
                                                @case('available')
                                                Mở bán
                                                @break

                                                @case('closed')
                                                Đã đóng
                                                @break

                                                @case('full')
                                                Đã đầy
                                                @break

                                                @default
                                                Không xác định
                                                @endswitch
                                            </span>

                                        </div>

                                        <small class="d-block
                        {{ $lich->trang_thai == 'full' ? 'text-danger' : 'text-success' }}
                        mb-2">
                                            <i class="fa fa-users mr-1"></i>

                                            Còn
                                            <strong>
                                                {{ $lich->so_cho - $lich->so_cho_da_dat }}
                                            </strong>

                                            /
                                            {{ $lich->so_cho }}
                                            chỗ
                                        </small>

                                        <div class="text-right border-top pt-2 mt-2">

                                            <span class="primary-text font-weight-bold">
                                                {{ number_format($lich->tour->gia_nguoi_lon) }}đ
                                            </span>

                                        </div>

                                    </div>
                                </div>

                            </label>
                        </div>
                        @endforeach
                    </div>

                    <!-- Thông tin người đặt -->
                    <h5 class="font-weight-bold mb-3 text-dark section-title">Thông tin người liên hệ</h5>
                    <div class="card border-0 shadow-sm p-4 mb-5 rounded-custom">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="font-weight-bold small text-muted">Họ và tên</label>
                                <input type="text" id="contact_name" class="form-control bg-light input-custom" value="{{ auth()->user()->name }}" readonly>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="font-weight-bold small text-muted">Email</label>
                                <input type="email" id="contact_email" class="form-control bg-light input-custom" value="{{ auth()->user()->email }}" readonly>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="font-weight-bold small text-muted">Số điện thoại</label>
                                <input type="tel" id="contact_phone" name="nguoi_dat_phone" class="form-control bg-light input-custom" value="{{ auth()->user()->phone ?? '' }}" readonly>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="font-weight-bold small text-muted">Địa Chỉ</label>
                                <input type="text" id="contact_address" class="form-control bg-light input-custom" value="{{ auth()->user()->address ?? '' }}" readonly>
                            </div>
                        </div>
                    </div>

                    <!-- Số lượng hành khách -->
                    <h5 class="font-weight-bold mb-3 text-dark section-title">Số lượng hành khách</h5>
                    <div class="card border-0 shadow-sm p-4 mb-5 rounded-custom">
                        <div class="row">
                            <div class="col-md-6 mb-3 mb-md-0">
                                <label class="font-weight-bold small text-muted">Người lớn (&gt;12 tuổi)</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-white"><i class="fa fa-user primary-text"></i></span>
                                    </div>
                                    <input type="number" id="qty_adult" name="so_nguoi_lon" class="form-control input-custom font-weight-bold" value="1" min="1" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="font-weight-bold small text-muted">Trẻ em (2-11 tuổi)</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-white"><i class="fa fa-child primary-text"></i></span>
                                    </div>
                                    <input type="number" id="qty_child" name="so_tre_em" class="form-control input-custom font-weight-bold" value="0" min="0">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Danh sách form chi tiết hành khách -->
                    <h5 class="font-weight-bold mb-3 text-dark section-title">Thông tin chi tiết từng hành khách</h5>
                    <div class="d-flex flex-wrap align-items-center justify-content-between gap-2 mb-3">
                        <small class="text-muted">Bạn có thể import danh sách hành khách từ file Excel để tự động điền thông tin.</small>
                        <label class="d-flex align-items-center gap-2 mb-0">
                            <span class="btn btn-outline-primary btn-sm mb-0">Import Excel</span>
                            <input type="file" id="excelFile" accept=".xlsx,.xls,.csv" class="d-none">
                        </label>
                    </div>
                    <div id="passengers-accordion" class="mb-5"></div>

                    <!-- Ô TÍCH CAM ĐOAN & NÚT TIẾP TỤC Ở CUỐI TRANG -->
                    <div class="card border-0 shadow-sm p-4 mb-5 rounded-custom text-center bg-white border">
                        <div class="custom-control custom-checkbox mb-4 d-inline-block text-left">
                            <input type="checkbox" class="custom-control-input" id="chk_commitment" required>
                            <label class="custom-control-label text-dark font-weight-medium" for="chk_commitment" style="cursor: pointer; font-size: 1rem;">
                                Tôi xin cam đoan toàn bộ thông tin hành khách đã nhập ở trên là chính xác và hoàn toàn chịu trách nhiệm nếu có sai sót xảy ra.
                            </label>
                        </div>

                        <div class="row justify-content-center">
                            <div class="col-md-6">
                                <!-- Nút này chuyển từ submit sang kích hoạt xử lý JS kiểm tra thông tin -->
                                <button type="button" id="btnPreviewBooking" class="btn btn-primary btn-block py-3 font-weight-bold rounded-custom shadow-sm btn-checkout">
                                    Tiếp tục & Xem tóm tắt đơn hàng <i class="fa fa-arrow-right ml-2"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- ẨN INPUT TỔNG TIỀN ĐỂ SUBMIT VỀ BACKEND -->
                    <input type="hidden" name="tong_tien" id="input_grand_total" value="{{ $tour->gia_nguoi_lon }}">
                    <input type="hidden" name="phuong_thuc_thanh_toan" id="input_payment_method" value="">
                    <input type="hidden" name="phan_tram_thanh_toan" id="phanTramHidden" value="100">
                </div>
            </div>
        </form>
    </div>
</div>

<!-- BOOTSTRAP MODAL: XUẤT HIỆN KHI BẤM XEM TÓM TẮT -->
<div class="modal fade" id="summaryModal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="summaryModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content border-0 shadow-lg rounded-custom">
            <div class="modal-header bg-light border-bottom p-4">
                <h4 class="modal-title font-weight-bold text-center w-100 text-dark" id="summaryModalLabel">
                    <i class="fa fa-file-invoice primary-text mr-2"></i>Xác Nhận & Thanh Toán Đơn Hàng
                </h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body p-4 bg-light">
                <!-- Nội dung tóm tắt sẽ được kết xuất động qua Javascript ở đây -->
                <div id="summaryModalContent"></div>
            </div>
            <div class="modal-footer bg-white border-top p-4 d-flex justify-content-between align-items-center">
                <button type="button" class="btn btn-secondary px-4 py-2 font-weight-bold rounded-custom" data-dismiss="modal">
                    Quay lại sửa thông tin
                </button>
                <button type="button" id="btnFinalSubmit" class="btn btn-success px-5 py-2 font-weight-bold rounded-custom shadow-sm">
                    Xác nhận đặt tour ngay <i class="fa fa-check ml-2"></i>
                </button>
            </div>
        </div>
    </div>
</div>

<style>
    :root {
        --primary: #0757d8;
        --primary-light: #e6effb;
        --bg: #f8fbff;
        --text: #0f172a;
    }

    .page-bg {
        background-color: var(--bg);
    }

    .primary-text {
        color: var(--primary) !important;
    }

    .rounded-custom {
        border-radius: 12px !important;
    }

    .input-custom {
        border-radius: 8px;
        border: 1px solid #cbd5e1;
        padding: 0.6rem 1rem;
        height: auto;
    }

    .input-custom:focus {
        box-shadow: 0 0 0 0.2rem rgba(7, 87, 216, 0.15);
        border-color: var(--primary);
    }

    .section-title {
        border-left: 4px solid var(--primary);
        padding-left: 12px;
        color: var(--text);
    }

    .tour-img {
        border-radius: 12px 0 0 12px;
        object-fit: cover;
        min-height: 200px;
    }

    @media(max-width: 768px) {
        .tour-img {
            border-radius: 12px 12px 0 0;
        }
    }

    .tour-info-card {
        border-radius: 12px;
    }

    .schedule-card {
        border: 2px solid transparent !important;
        border-radius: 12px !important;
        background: #fff;
    }

    .schedule-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.05) !important;
    }

    .schedule-card:has(input[type="radio"]:checked) {
        border-color: var(--primary) !important;
        background-color: var(--primary-light);
    }

    .custom-radio {
        width: 1.25rem;
        height: 1.25rem;
        accent-color: var(--primary);
    }

    .badge-success-soft {
        background: #dcfce7;
        color: #166534;
        padding: 6px 12px;
        font-weight: 600;
    }

    .badge-secondary-soft {
        background: #f1f5f9;
        color: #475569;
        padding: 6px 12px;
        font-weight: 600;
    }

    .badge-danger-soft {
        background: #fee2e2;
        color: #991b1b;
        padding: 6px 12px;
        font-weight: 600;
    }

    .passenger-accordion-card {
        border: 1px solid #e2e8f0;
        border-radius: 12px !important;
        overflow: hidden;
        background: #fff;
    }

    .passenger-accordion-header {
        background-color: #fff;
        padding: 1rem 1.25rem;
        cursor: pointer;
        transition: background 0.2s;
    }

    .passenger-accordion-header:hover {
        background-color: #f8fafc;
    }

    .accordion-icon {
        transition: transform 0.3s ease;
        color: var(--primary);
    }

    .passenger-accordion-header.collapsed .accordion-icon {
        transform: rotate(-90deg);
        color: #94a3b8;
    }

    .passenger-body {
        background-color: #fafbfc;
        padding: 1.5rem;
        border-top: 1px solid #e2e8f0;
    }

    .btn-checkout {
        background-color: var(--primary);
        border-color: var(--primary);
        transition: all 0.3s;
    }

    .btn-checkout:hover {
        background-color: #0546b5;
        box-shadow: 0 8px 15px rgba(7, 87, 216, 0.2);
    }

    /* Phong cách riêng cho khu vực Modal tóm tắt */
    .summary-section-box {
        background-color: #fff;
        border-radius: 10px;
        padding: 1.25rem;
        margin-bottom: 1rem;
        border: 1px solid #e2e8f0;
    }

    .summary-section-title {
        font-size: 0.95rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: #64748b;
        font-weight: 700;
        margin-bottom: 0.75rem;
        border-bottom: 1px dashed #e2e8f0;
        padding-bottom: 0.5rem;
    }

</style>
@endsection

@section('scripts')
@php
$priceAdult = (float) ($tour->gia_nguoi_lon ?? 0);
$priceChild = (float) ($tour->gia_tre_em ?? 0);
$tourTitleJs = json_encode($tour->ten_tour ?? '', JSON_UNESCAPED_UNICODE);
@endphp
<script>
    document.addEventListener('DOMContentLoaded', function() {


        const priceAdult = {
            {
                $priceAdult
            }
        };
        const priceChild = {
            {
                $priceChild
            }
        };
        const tourTitle = {
            !!$tourTitleJs!!
        };

        /* =========================================================
           2. LẤY ELEMENT
        ========================================================= */

        const bookingForm = document.getElementById('bookingForm');
        const btnPreviewBooking = document.getElementById('btnPreviewBooking');
        const btnFinalSubmit = document.getElementById('btnFinalSubmit');

        const chkCommitment = document.getElementById('chk_commitment');

        const elQtyAdult = document.getElementById('qty_adult');
        const elQtyChild = document.getElementById('qty_child');

        const elInputGrandTotal = document.getElementById('input_grand_total');
        const elInputPaymentMethod = document.getElementById('input_payment_method');
        const elInputDepositPercent = document.getElementById('input_phan_tram_thanh_toan');

        const accordionContainer = document.getElementById('passengers-accordion');
        const summaryModalContent = document.getElementById('summaryModalContent');
        const excelFile = document.getElementById('excelFile');

        /* =========================================================
           3. KIỂM TRA ELEMENT
           Nếu thiếu element thì báo lỗi để dễ debug
        ========================================================= */

        if (!bookingForm) {
            console.error('Không tìm thấy #bookingForm');
            return;
        }

        if (!btnPreviewBooking) {
            console.error('Không tìm thấy #btnPreviewBooking');
            return;
        }

        if (!accordionContainer) {
            console.error('Không tìm thấy #passengers-accordion');
            return;
        }

        /* =========================================================
           4. FORMAT TIỀN
        ========================================================= */

        function formatVND(amount) {
            return new Intl.NumberFormat('vi-VN').format(amount) + 'đ';
        }

        function excelDateToDate(value) {
            if (!value) return '';

            if (typeof value === 'string' && value.includes('/')) {
                const parts = value.split('/');
                return `${parts[2]}-${parts[1].padStart(2, '0')}-${parts[0].padStart(2, '0')}`;
            }

            const date = new Date((value - 25569) * 86400 * 1000);
            const year = date.getUTCFullYear();
            const month = String(date.getUTCMonth() + 1).padStart(2, '0');
            const day = String(date.getUTCDate()).padStart(2, '0');

            return `${year}-${month}-${day}`;
        }

        function tinhTuoi(ngaySinh) {
            if (!ngaySinh) {
                return 0;
            }

            const birth = new Date(ngaySinh);
            const today = new Date();
            let age = today.getFullYear() - birth.getFullYear();

            const monthDiff = today.getMonth() - birth.getMonth();

            if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < birth.getDate())) {
                age--;
            }

            return age;
        }

        /* =========================================================
           5. ĐỒNG BỘ PHƯƠNG THỨC THANH TOÁN
        ========================================================= */

        function syncPaymentMethod() {

            const paymentMethodSelect =
                document.getElementById('paymentMethodSelect');

            if (paymentMethodSelect && elInputPaymentMethod) {
                elInputPaymentMethod.value =
                    paymentMethodSelect.value || '';
            }
        }

        function syncDepositSelection() {
            const selectedDeposit = document.querySelector(
                '#summaryModalContent input[name="phan_tram_modal"]:checked'
            );

            if (elInputDepositPercent) {
                elInputDepositPercent.value = selectedDeposit ? .value || '100';
            }
        }

        /* =========================================================
           6. TẠO FORM HÀNH KHÁCH
        ========================================================= */

        function getPassengerFormTemplate(index, label, typeValue, isOpen) {

            const collapseClass = isOpen ? 'show' : '';
            const headerClass = isOpen ? '' : 'collapsed';

            const badgeBg =
                typeValue === 'adult' ?
                'badge-primary' :
                'badge-info';

            return `
            <div class="passenger-accordion-card mb-3 shadow-sm">

                <div
                    class="passenger-accordion-header d-flex justify-content-between align-items-center ${headerClass}"
                    data-toggle="collapse"
                    data-target="#collapsePassenger${index}"
                    aria-expanded="${isOpen}"
                    aria-controls="collapsePassenger${index}"
                >

                    <div class="d-flex align-items-center">

                        <i
                            class="fa ${typeValue === 'adult' ? 'fa-user' : 'fa-child'} mr-3"
                            style="font-size:1.2rem;color:var(--primary);"
                        ></i>

                        <h6 class="mb-0 font-weight-bold text-dark">
                            ${label} #${index + 1}
                        </h6>

                        <span
                            class="badge ${badgeBg} ml-2 p-1 px-2 text-white"
                            style="font-size:0.7rem;"
                        >
                            ${typeValue === 'adult' ? 'Người lớn' : 'Trẻ em'}
                        </span>

                    </div>

                    <i class="fa fa-chevron-down accordion-icon"></i>

                </div>

                <div
                    id="collapsePassenger${index}"
                    class="collapse ${collapseClass}"
                    data-parent="#passengers-accordion"
                >

                    <div class="passenger-body">

                        <input
                            type="hidden"
                            name="hanh_khach[${index}][loai_hanh_khach]"
                            value="${typeValue}"
                            class="pass-type"
                        >

                        <div class="row">

                            <div class="col-md-6 mb-3">
                                <label class="text-muted small font-weight-bold">
                                    Họ và tên
                                    <span class="text-danger">*</span>
                                </label>

                                <input
                                    type="text"
                                    name="hanh_khach[${index}][ho_ten]"
                                    class="form-control input-custom bg-white pass-name"
                                    placeholder="VD: NGUYEN VAN A"
                                    required
                                >
                            </div>

                            <div class="col-md-3 mb-3">
                                <label class="text-muted small font-weight-bold">
                                    Giới tính
                                </label>

                                <select
                                    name="hanh_khach[${index}][gioi_tinh]"
                                    class="custom-select input-custom bg-white pass-gender"
                                >
                                    <option value="Nam">Nam</option>
                                    <option value="Nữ">Nữ</option>
                                </select>
                            </div>

                            <div class="col-md-3 mb-3">
                                <label class="text-muted small font-weight-bold">
                                    Ngày sinh
                                </label>

                                <input
                                    type="date"
                                    name="hanh_khach[${index}][ngay_sinh]"
                                    class="form-control input-custom bg-white pass-dob"
                                >
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="text-muted small font-weight-bold">
                                    Quốc tịch
                                </label>

                                <input
                                    type="text"
                                    name="hanh_khach[${index}][quoc_tich]"
                                    class="form-control input-custom bg-white pass-nation"
                                    value="Việt Nam"
                                >
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="text-muted small font-weight-bold">
                                    Giấy tờ tùy thân
                                    <span class="text-danger">*</span>
                                </label>

                                <select
                                    name="hanh_khach[${index}][loai_giay_to]"
                                    class="custom-select input-custom bg-white pass-doc-type"
                                    required
                                >
                                    <option value="CCCD">
                                        Căn cước công dân
                                    </option>

                                    <option value="Hộ chiếu">
                                        Hộ chiếu
                                    </option>

                                    <option value="Giấy khai sinh">
                                        Giấy khai sinh (Trẻ em)
                                    </option>
                                </select>
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="text-muted small font-weight-bold">
                                    Số giấy tờ
                                    <span class="text-danger">*</span>
                                </label>

                                <input
                                    type="text"
                                    name="hanh_khach[${index}][so_giay_to]"
                                    class="form-control input-custom bg-white pass-doc-id"
                                    placeholder="Nhập số định danh (12 chữ số cho CCCD)"
                                    required
                                >
                            </div>

                            <div class="col-md-5 mb-3 mb-md-0">
                                <label class="text-muted small font-weight-bold">
                                    Số điện thoại
                                </label>

                                <input
                                    type="tel"
                                    name="hanh_khach[${index}][so_dien_thoai]"
                                    class="form-control input-custom bg-white pass-phone"
                                    placeholder="SĐT liên hệ..."
                                >
                            </div>

                            <div class="col-md-7">
                                <label class="text-muted small font-weight-bold">
                                    Yêu cầu đặc biệt
                                </label>

                                <input
                                    type="text"
                                    name="hanh_khach[${index}][yeu_cau_dac_biet]"
                                    class="form-control input-custom bg-white pass-note"
                                    placeholder="Ăn chay, dị ứng, hỗ trợ..."
                                >
                            </div>

                        </div>

                    </div>

                </div>

            </div>
        `;
        }

        /* =========================================================
           7. CẬP NHẬT SỐ LƯỢNG HÀNH KHÁCH
        ========================================================= */

        function updateBookingDetails() {

            let adults = parseInt(elQtyAdult.value) || 0;
            let children = parseInt(elQtyChild.value) || 0;

            if (adults < 1) {
                adults = 1;
                elQtyAdult.value = 1;
            }

            if (children < 0) {
                children = 0;
                elQtyChild.value = 0;
            }

            const totalAdult = adults * priceAdult;
            const totalChild = children * priceChild;

            const grandTotal = totalAdult + totalChild;

            elInputGrandTotal.value = grandTotal;

            let formsHTML = '';
            let passengerIndex = 0;

            /* Người lớn */

            for (let i = 0; i < adults; i++) {

                const isOpen = passengerIndex === 0;

                formsHTML += getPassengerFormTemplate(
                    passengerIndex
                    , 'Hành khách'
                    , 'adult'
                    , isOpen
                );

                passengerIndex++;
            }

            /* Trẻ em */

            for (let i = 0; i < children; i++) {

                const isOpen = passengerIndex === 0;

                formsHTML += getPassengerFormTemplate(
                    passengerIndex
                    , 'Hành khách'
                    , 'child'
                    , isOpen
                );

                passengerIndex++;
            }

            accordionContainer.innerHTML = formsHTML;
        }

        if (excelFile) {
            excelFile.addEventListener('change', function() {
                const file = this.files[0];
                if (!file) return;

                const formData = new FormData();
                formData.append('file', file);

                fetch('{{ route('
                        Client.import_hanh_khach ') }}', {
                            method: 'POST'
                            , headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            }
                            , body: formData
                        })
                    .then((res) => res.json())
                    .then((data) => {
                        let adult = 0;
                        let child = 0;

                        data.forEach((item) => {
                            const ngaySinh = item.ngay_sinh ? excelDateToDate(item.ngay_sinh) : '';
                            if (!ngaySinh) return;

                            const tuoi = tinhTuoi(ngaySinh);
                            if (tuoi <= 12) {
                                child++;
                            } else {
                                adult++;
                            }
                        });

                        elQtyAdult.value = adult || 1;
                        elQtyChild.value = child || 0;
                        updateBookingDetails();

                        let adultIndex = 0;
                        let childIndex = adult || 0;

                        data.forEach((item) => {
                            const ngaySinh = item.ngay_sinh ? excelDateToDate(item.ngay_sinh) : '';
                            const tuoi = tinhTuoi(ngaySinh);
                            let index = 0;

                            if (tuoi <= 12) {
                                index = childIndex++;
                            } else {
                                index = adultIndex++;
                            }

                            const hoTenInput = document.querySelector(`[name="hanh_khach[${index}][ho_ten]"]`);
                            const genderInput = document.querySelector(`[name="hanh_khach[${index}][gioi_tinh]"]`);
                            const dobInput = document.querySelector(`[name="hanh_khach[${index}][ngay_sinh]"]`);
                            const nationInput = document.querySelector(`[name="hanh_khach[${index}][quoc_tich]"]`);
                            const docTypeInput = document.querySelector(`[name="hanh_khach[${index}][loai_giay_to]"]`);
                            const docIdInput = document.querySelector(`[name="hanh_khach[${index}][so_giay_to]"]`);
                            const phoneInput = document.querySelector(`[name="hanh_khach[${index}][so_dien_thoai]"]`);
                            const noteInput = document.querySelector(`[name="hanh_khach[${index}][yeu_cau_dac_biet]"]`);

                            if (hoTenInput) hoTenInput.value = item.ho_ten || '';
                            if (genderInput) genderInput.value = item.gioi_tinh || 'Nam';
                            if (dobInput) dobInput.value = ngaySinh;
                            if (nationInput) nationInput.value = item.quoc_tich || 'Việt Nam';
                            if (docTypeInput) docTypeInput.value = item.loai_giay_to || 'CCCD';
                            if (docIdInput) docIdInput.value = item.so_giay_to || '';
                            if (phoneInput) phoneInput.value = item.so_dien_thoai || '';
                            if (noteInput) noteInput.value = item.yeu_cau_dac_biet || '';
                        });
                    })
                    .catch((err) => {
                        console.error(err);
                        alert('Import thất bại. Vui lòng thử lại với file Excel phù hợp.');
                    });
            });
        }

        /* =========================================================
           8. VALIDATE FORM TRƯỚC KHI MỞ MODAL
        ========================================================= */

        function validateBookingForm() {


            /* =========================================================
               1. XÓA CÁC LỖI CŨ
            ========================================================= */

            document.querySelectorAll('.js-error').forEach(function(element) {
                element.remove();
            });

            document.querySelectorAll('.is-invalid').forEach(function(element) {
                element.classList.remove('is-invalid');
            });


            /* =========================================================
               HÀM HIỂN THỊ LỖI
            ========================================================= */

            function showError(input, message) {

                if (!input) {
                    return false;
                }

                input.classList.add('is-invalid');

                const error = document.createElement('div');

                error.className = 'js-error text-danger small mt-1';

                error.innerHTML =
                    '<i class="fa fa-exclamation-circle mr-1"></i>' +
                    message;

                /*
                 * Chèn lỗi ngay sau input
                 */

                input.parentNode.appendChild(error);

                return false;
            }


            /* =========================================================
               2. TOUR ID
            ========================================================= */

            const tourId =
                document.querySelector('input[name="tour_id"]');

            if (!tourId || !tourId.value) {

                alert('Không xác định được tour.');

                return false;
            }


            /* =========================================================
               3. LỊCH KHỞI HÀNH
            ========================================================= */

            const selectedSchedule =
                document.querySelector(
                    'input[name="lich_khoi_hanh_id"]:checked'
                );

            if (!selectedSchedule) {

                alert('Vui lòng chọn lịch khởi hành.');

                const firstSchedule =
                    document.querySelector(
                        'input[name="lich_khoi_hanh_id"]'
                    );

                if (firstSchedule) {
                    firstSchedule.focus();
                }

                return false;
            }


            /* =========================================================
               4. SỐ NGƯỜI LỚN
               required|integer|min:1
            ========================================================= */

            const adultInput =
                document.getElementById('qty_adult');

            const adults =
                parseInt(adultInput ? .value);

            if (
                !adultInput ||
                isNaN(adults) ||
                adults < 1 ||
                !Number.isInteger(adults)
            ) {

                return showError(
                    adultInput
                    , 'Số người lớn phải là số nguyên và ít nhất 1 người.'
                );
            }


            /* =========================================================
               5. SỐ TRẺ EM
               nullable|integer|min:0
            ========================================================= */

            const childInput =
                document.getElementById('qty_child');

            const children =
                childInput.value === '' ?
                0 :
                parseInt(childInput.value);

            if (
                isNaN(children) ||
                children < 0 ||
                !Number.isInteger(children)
            ) {

                return showError(
                    childInput
                    , 'Số trẻ em phải là số nguyên từ 0 trở lên.'
                );
            }


            /* =========================================================
               6. CHECKBOX CAM KẾT
            ========================================================= */

            if (
                chkCommitment &&
                !chkCommitment.checked
            ) {

                alert(
                    'Vui lòng xác nhận thông tin hành khách là chính xác.'
                );

                chkCommitment.focus();

                return false;
            }


            /* =========================================================
               7. LẤY DANH SÁCH HÀNH KHÁCH
            ========================================================= */

            const passengerCards =
                document.querySelectorAll(
                    '#passengers-accordion .passenger-accordion-card'
                );

            const expectedPassengers =
                adults + children;


            if (
                passengerCards.length !== expectedPassengers
            ) {

                alert(
                    'Số lượng hành khách chưa khớp với số người lớn và trẻ em.'
                );

                return false;
            }


            /* =========================================================
               8. KIỂM TRA TỪNG HÀNH KHÁCH
            ========================================================= */

            for (
                let i = 0; i < passengerCards.length; i++
            ) {

                const card =
                    passengerCards[i];


                /* =====================================================
                   HỌ TÊN
                   required|string|min:2|max:100
                ===================================================== */

                const nameInput =
                    card.querySelector('.pass-name');

                const name =
                    nameInput ? .value.trim() || '';

                if (!name) {

                    openPassenger(card);

                    return showError(
                        nameInput
                        , `Hành khách #${i + 1}: Vui lòng nhập họ và tên.`
                    );
                }

                if (name.length < 2) {

                    openPassenger(card);

                    return showError(
                        nameInput
                        , `Hành khách #${i + 1}: Họ tên phải có ít nhất 2 ký tự.`
                    );
                }

                if (name.length > 100) {

                    openPassenger(card);

                    return showError(
                        nameInput
                        , `Hành khách #${i + 1}: Họ tên không được vượt quá 100 ký tự.`
                    );
                }


                /* =====================================================
                   GIỚI TÍNH
                   required|in:Nam,Nữ
                ===================================================== */

                const genderInput =
                    card.querySelector('.pass-gender');

                const gender =
                    genderInput ? .value || '';

                if (
                    gender !== 'Nam' &&
                    gender !== 'Nữ'
                ) {

                    openPassenger(card);

                    return showError(
                        genderInput
                        , `Hành khách #${i + 1}: Vui lòng chọn giới tính Nam hoặc Nữ.`
                    );
                }


                /* =====================================================
NGÀY SINH

* Người lớn: từ 12 tuổi trở lên
* Trẻ em: từ 2 đến 11 tuổi
  ===================================================== */

                const dobInput =
                    card.querySelector('.pass-dob');

                const dob =
                    dobInput ? .value || '';

                /* Bắt buộc nhập ngày sinh */

                if (!dob) {


                    openPassenger(card);

                    return showError(
                        dobInput
                        , `Hành khách #${i + 1}: Vui lòng nhập ngày sinh.`
                    );


                }

                /* Kiểm tra ngày sinh hợp lệ */

                const dobDate =
                    new Date(dob + 'T00:00:00');

                const today =
                    new Date();

                today.setHours(0, 0, 0, 0);

                if (isNaN(dobDate.getTime())) {


                    openPassenger(card);

                    return showError(
                        dobInput
                        , `Hành khách #${i + 1}: Ngày sinh không hợp lệ.`
                    );


                }

                /* Không cho ngày sinh hôm nay hoặc tương lai */

                if (dobDate >= today) {


                    openPassenger(card);

                    return showError(
                        dobInput
                        , `Hành khách #${i + 1}: Ngày sinh phải trước ngày hôm nay.`
                    );


                }

                /* =====================================================
                TÍNH TUỔI CHÍNH XÁC
                ===================================================== */

                let age =
                    today.getFullYear() -
                    dobDate.getFullYear();

                const monthDiff =
                    today.getMonth() -
                    dobDate.getMonth();

                const dayDiff =
                    today.getDate() -
                    dobDate.getDate();

                /*

                * Nếu chưa đến sinh nhật năm nay
                * thì trừ 1 tuổi
                  */

                if (
                    monthDiff < 0 ||
                    (monthDiff === 0 && dayDiff < 0)
                ) {
                    age--;
                }

                /* =====================================================
                KIỂM TRA THEO LOẠI HÀNH KHÁCH
                ===================================================== */

                const passengerType =
                    card.querySelector('.pass-type') ? .value || '';

                /* NGƯỜI LỚN */

                if (passengerType === 'adult') {


                    if (age < 12) {

                        openPassenger(card);

                        return showError(
                            dobInput
                            , `Hành khách #${i + 1}: Người lớn phải từ 12 tuổi trở lên. Tuổi hiện tại: ${age} tuổi.`
                        );
                    }


                }

                /* TRẺ EM */

                if (passengerType === 'child') {


                    if (age < 2 || age > 11) {

                        openPassenger(card);

                        return showError(
                            dobInput
                            , `Hành khách #${i + 1}: Trẻ em phải từ 2 đến 11 tuổi. Tuổi hiện tại: ${age} tuổi.`
                        );
                    }


                }



                /* =====================================================
                   QUỐC TỊCH
                   required|string|max:100
                ===================================================== */

                const nationInput =
                    card.querySelector('.pass-nation');

                const nation =
                    nationInput ? .value.trim() || '';

                if (!nation) {

                    openPassenger(card);

                    return showError(
                        nationInput
                        , `Hành khách #${i + 1}: Vui lòng nhập quốc tịch.`
                    );
                }

                if (nation.length > 100) {

                    openPassenger(card);

                    return showError(
                        nationInput
                        , `Hành khách #${i + 1}: Quốc tịch không được vượt quá 100 ký tự.`
                    );
                }


                /* =====================================================
                   LOẠI HÀNH KHÁCH
                   required|in:adult,child
                ===================================================== */



                if (
                    passengerType !== 'adult' &&
                    passengerType !== 'child'
                ) {

                    alert(
                        `Hành khách #${i + 1}: Loại hành khách không hợp lệ.`
                    );

                    return false;
                }


                /* =====================================================
                   LOẠI GIẤY TỜ
                   required|in:CCCD,Hộ chiếu,Giấy khai sinh
                ===================================================== */

                const docTypeInput =
                    card.querySelector('.pass-doc-type');

                const docType =
                    docTypeInput ? .value || '';

                const validDocTypes = [
                    'CCCD'
                    , 'Hộ chiếu'
                    , 'Giấy khai sinh'
                ];

                if (
                    !validDocTypes.includes(docType)
                ) {

                    openPassenger(card);

                    return showError(
                        docTypeInput
                        , `Hành khách #${i + 1}: Vui lòng chọn loại giấy tờ hợp lệ.`
                    );
                }


                /* =====================================================
                   SỐ GIẤY TỜ
                   required|string|max:30
                ===================================================== */

                const docIdInput =
                    card.querySelector('.pass-doc-id');

                const docId =
                    docIdInput ? .value.trim() || '';

                if (!docId) {

                    openPassenger(card);

                    return showError(
                        docIdInput
                        , `Hành khách #${i + 1}: Vui lòng nhập số giấy tờ.`
                    );
                }

                if (docId.length > 30) {

                    openPassenger(card);

                    return showError(
                        docIdInput
                        , `Hành khách #${i + 1}: Số giấy tờ không được vượt quá 30 ký tự.`
                    );
                }

                if (docType === 'CCCD') {
                    const cccdRegex = /^\d{12}$/;

                    if (!cccdRegex.test(docId)) {
                        openPassenger(card);

                        return showError(
                            docIdInput
                            , `Hành khách #${i + 1}: CCCD phải gồm đúng 12 chữ số.`
                        );
                    }
                }


                /* =====================================================
                   SỐ ĐIỆN THOẠI
                   nullable|regex:/^(0|\+84)[0-9]{9,10}$/
                ===================================================== */

                const phoneInput =
                    card.querySelector('.pass-phone');

                const phone =
                    phoneInput ? .value.trim() || '';

                if (phone) {

                    const phoneRegex =
                        /^(0|\+84)[0-9]{9,10}$/;

                    if (!phoneRegex.test(phone)) {

                        openPassenger(card);

                        return showError(
                            phoneInput
                            , `Hành khách #${i + 1}: Số điện thoại không đúng định dạng.`
                        );
                    }
                }


                /* =====================================================
                   YÊU CẦU ĐẶC BIỆT
                   nullable|max:500
                ===================================================== */

                const noteInput =
                    card.querySelector('.pass-note');

                const note =
                    noteInput ? .value.trim() || '';

                if (note.length > 500) {

                    openPassenger(card);

                    return showError(
                        noteInput
                        , `Hành khách #${i + 1}: Yêu cầu đặc biệt không được vượt quá 500 ký tự.`
                    );
                }
            }


            /* =========================================================
               9. TẤT CẢ HỢP LỆ
            ========================================================= */

            return true;


        }

        /* =============================================================
        HÀM MỞ ACCORDION HÀNH KHÁCH KHI CÓ LỖI
        ============================================================= */

        function openPassenger(card) {


            if (!card) {
                return;
            }

            const collapse =
                card.querySelector('.collapse');

            if (
                collapse &&
                typeof $ !== 'undefined' &&
                typeof $.fn.collapse !== 'undefined'
            ) {

                $(collapse).collapse('show');
            }

            /*
             * Cuộn đến hành khách đang lỗi
             */

            setTimeout(function() {

                card.scrollIntoView({
                    behavior: 'smooth'
                    , block: 'center'
                });

            }, 100);


        }


        /* =========================================================
           9. TẠO TÓM TẮT ĐƠN HÀNG
        ========================================================= */

        function generateSummary() {

            const selectedRadio = document.querySelector(
                'input[name="lich_khoi_hanh_id"]:checked'
            );

            let dateText = 'Chưa chọn lịch';

            if (selectedRadio) {

                const card = selectedRadio.closest('.schedule-card');

                if (card) {
                    dateText = card.querySelector('.schedule-date').innerText.trim();
                }
            }

            const contactName = document.getElementById('contact_name').value;
            const contactEmail = document.getElementById('contact_email').value;
            const contactPhone = document.getElementById('contact_phone').value;
            const contactAddress = document.getElementById('contact_address').value;

            const adults = parseInt(elQtyAdult.value) || 0;
            const children = parseInt(elQtyChild.value) || 0;

            const totalAdultPrice = adults * priceAdult;
            const totalChildPrice = children * priceChild;
            const finalTotal = totalAdultPrice + totalChildPrice;

            let passengersHTML = '';

            document.querySelectorAll(
                '#passengers-accordion .passenger-accordion-card'
            ).forEach((card, index) => {

                passengersHTML += `
        <tr>
            <td>${index+1}</td>
            <td>${card.querySelector('.pass-name').value}</td>
            <td>${card.querySelector('.pass-type').value=='adult'?'Người lớn':'Trẻ em'}</td>
            <td>${card.querySelector('.pass-gender').value}</td>
            <td>${card.querySelector('.pass-dob').value}</td>
            <td>
                ${card.querySelector('.pass-doc-type').value}
                :
                ${card.querySelector('.pass-doc-id').value}
            </td>
        </tr>`;
            });

            summaryModalContent.innerHTML = `

<div class="summary-section-box">

<h5>${tourTitle}</h5>

<p>
Ngày khởi hành :
<b>${dateText}</b>
</p>

</div>


<div class="summary-section-box">

<h6>Thông tin liên hệ</h6>

<p><b>${contactName}</b></p>

<p>${contactPhone}</p>

<p>${contactEmail}</p>

<p>${contactAddress}</p>

</div>


<div class="summary-section-box">

<h6>Danh sách hành khách</h6>

<table class="table table-bordered">

<thead>

<tr>

<th>STT</th>

<th>Họ tên</th>

<th>Loại</th>

<th>Giới tính</th>

<th>Ngày sinh</th>

<th>Giấy tờ</th>

</tr>

</thead>

<tbody>

${passengersHTML}

</tbody>

</table>

</div>


<div class="summary-section-box">

<label class="font-weight-bold">

Phương thức thanh toán

</label>

<select
id="paymentMethodSelect"
class="form-control mb-3">

<option value="VNPAY">

VNPAY

</option>

</select>

<label class="font-weight-bold">

Hình thức thanh toán

</label>

<div>

<label>

<input
type="radio"
name="phan_tram_modal"
value="100"
checked>

Thanh toán 100%

</label>

</div>

<div>

<label>

<input
type="radio"
name="phan_tram_modal"
value="50">

Đặt cọc 50%

</label>

</div>

<div>

<label>

<input
type="radio"
name="phan_tram_modal"
value="30">

Đặt cọc 30%

</label>

</div>

</div>


<div class="summary-section-box bg-dark text-white">

<div class="d-flex justify-content-between">

<span>Tổng giá tour</span>

<strong>${formatVND(finalTotal)}</strong>

</div>

<hr>

<div class="d-flex justify-content-between">

<span>Thanh toán ngay</span>

<strong id="payNow">${formatVND(finalTotal)}</strong>

</div>

<div class="d-flex justify-content-between mt-2">

<span>Còn lại</span>

<strong id="remainMoney">0đ</strong>

</div>

</div>
`;

            syncPaymentMethod();

            document
                .getElementById('paymentMethodSelect')
                .addEventListener('change', syncPaymentMethod);

            const radios = document.querySelectorAll(
                'input[name="phan_tram_modal"]'
            );

            radios.forEach(radio => {

                radio.addEventListener('change', function() {

                    const percent = parseInt(this.value);

                    const payNow = finalTotal * percent / 100;

                    const remain = finalTotal - payNow;

                    document.getElementById('payNow').innerHTML =
                        formatVND(payNow);

                    document.getElementById('remainMoney').innerHTML =
                        formatVND(remain);

                    // Đồng bộ sang form để submit
                    let hidden = document.getElementById('phanTramHidden');

                    if (!hidden) {

                        hidden = document.createElement('input');

                        hidden.type = 'hidden';

                        hidden.name = 'phan_tram_thanh_toan';

                        hidden.id = 'phanTramHidden';

                        bookingForm.appendChild(hidden);
                    }

                    hidden.value = percent;

                });

            });

            document.getElementById('phanTramHidden').value = 100;
        }

        /* =========================================================
           10. NÚT "TIẾP TỤC & XEM TÓM TẮT"
        ========================================================= */

        btnPreviewBooking.addEventListener('click', function(event) {

            event.preventDefault();

            console.log('Đã bấm nút xem tóm tắt');

            /*
             * Validate TOÀN BỘ FORM trước
             */

            if (!validateBookingForm()) {

                console.log('Validation thất bại');

                return;
            }

            console.log('Validation thành công');

            /*
             * Tạo tóm tắt
             */

            generateSummary();

            /*
             * Mở Bootstrap Modal
             */

            if (typeof $ !== 'undefined' &&
                typeof $.fn.modal !== 'undefined') {

                $('#summaryModal').modal('show');

            } else {

                console.error(
                    'Bootstrap Modal chưa được load.'
                );

                alert(
                    'Không thể mở cửa sổ tóm tắt. Vui lòng kiểm tra Bootstrap JS.'
                );
            }
        });

        /* =========================================================
           11. NÚT XÁC NHẬN ĐẶT TOUR
        ========================================================= */

        if (btnFinalSubmit) {

            btnFinalSubmit.addEventListener(
                'click'
                , function() {

                    /*
                     * Kiểm tra lại validation một lần nữa
                     */

                    if (!validateBookingForm()) {
                        return;
                    }

                    /*
                     * Kiểm tra phương thức thanh toán
                     */

                    syncPaymentMethod();

                    if (!elInputPaymentMethod.value) {

                        alert(
                            'Vui lòng chọn phương thức thanh toán.'
                        );

                        return;
                    }

                    /*
                     * Khóa nút tránh click nhiều lần
                     */

                    btnFinalSubmit.disabled = true;

                    btnFinalSubmit.innerHTML =
                        '<i class="fa fa-spinner fa-spin mr-2"></i>' +
                        'Đang xử lý đơn đặt...';

                    /*
                     * Submit form về Laravel
                     */

                    bookingForm.submit();
                }
            );
        }

        /* =========================================================
           12. THAY ĐỔI SỐ LƯỢNG
        ========================================================= */

        elQtyAdult.addEventListener(
            'change'
            , updateBookingDetails
        );

        elQtyChild.addEventListener(
            'change'
            , updateBookingDetails
        );

        elQtyAdult.addEventListener(
            'input'
            , updateBookingDetails
        );

        elQtyChild.addEventListener(
            'input'
            , updateBookingDetails
        );

        /* =========================================================
           13. KHỞI TẠO
        ========================================================= */

        updateBookingDetails();

        console.log('Booking JavaScript đã khởi tạo thành công.');

    });

</script>

@endsection
