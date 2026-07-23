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
                                <img src="{{ asset('storage/'.$tour->anh_dai_dien) }}" class="img-fluid h-100 w-100 tour-img" alt="{{ $tour->ten_tour }}">
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
                        <div class="col-md-6 mb-3">
                            <label class="card border-0 shadow-sm p-3 h-100 schedule-card transition-all m-0" style="cursor: pointer;">
                                <div class="d-flex align-items-start">
                                    <input class="form-check-input custom-radio mt-1" type="radio" name="lich_khoi_hanh_id" value="{{ $lich->id }}" required @checked(old('lich_khoi_hanh_id') == $lich->id)>
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
                                                    @case('available') Mở bán @break
                                                    @case('closed') Đã đóng @break
                                                    @case('full') Đã đầy @break
                                                    @default Không xác định
                                                @endswitch
                                            </span>
                                        </div>
                                        <small class="d-block {{ $lich->trang_thai == 'full' ? 'text-danger' : 'text-success' }} mb-2">
                                            <i class="fa fa-users mr-1"></i> Còn <strong>{{ $lich->so_cho - $lich->so_cho_da_dat }}</strong> / {{ $lich->so_cho }} chỗ
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
    @media(max-width: 768px){
        .tour-img { border-radius: 12px 12px 0 0; }
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
        box-shadow: 0 10px 20px rgba(0,0,0,0.05) !important;
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

    .badge-success-soft { background: #dcfce7; color: #166534; padding: 6px 12px; font-weight: 600;}
    .badge-secondary-soft { background: #f1f5f9; color: #475569; padding: 6px 12px; font-weight: 600;}
    .badge-danger-soft { background: #fee2e2; color: #991b1b; padding: 6px 12px; font-weight: 600;}

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
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const priceAdult = {{ $tour->gia_nguoi_lon ?? 0 }};
        const priceChild = {{ $tour->gia_tre_em ?? 0 }};
        const tourTitle = "{{ $tour->ten_tour }}";
        
        const elQtyAdult = document.getElementById('qty_adult');
        const elQtyChild = document.getElementById('qty_child');
        const elInputGrandTotal = document.getElementById('input_grand_total');
        const accordionContainer = document.getElementById('passengers-accordion');
        
        // Điều khiển Form & Modal
        const bookingForm = document.getElementById('bookingForm');
        const btnPreviewBooking = document.getElementById('btnPreviewBooking');
        const chkCommitment = document.getElementById('chk_commitment');
        const summaryModalContent = document.getElementById('summaryModalContent');
        const btnFinalSubmit = document.getElementById('btnFinalSubmit');

        function formatVND(amount) {
            return new Intl.NumberFormat('vi-VN').format(amount) + 'đ';
        }

        function syncPaymentMethod() {
            const paymentMethodSelect = document.getElementById('paymentMethodSelect');
            const paymentMethodInput = document.getElementById('input_payment_method');

            if (paymentMethodSelect && paymentMethodInput) {
                paymentMethodInput.value = paymentMethodSelect.value || '';
            }
        }

        // Tạo layout dạng Accordion nhập liệu
        function getPassengerFormTemplate(index, label, typeValue, isOpen) {
            const collapseClass = isOpen ? 'show' : '';
            const headerClass = isOpen ? '' : 'collapsed';
            const badgeBg = typeValue === 'adult' ? 'badge-primary' : 'badge-info';

            return `
                <div class="passenger-accordion-card mb-3 shadow-sm">
                    <div class="passenger-accordion-header d-flex justify-content-between align-items-center ${headerClass}" 
                         data-toggle="collapse" 
                         data-target="#collapsePassenger${index}" 
                         aria-expanded="${isOpen}" 
                         aria-controls="collapsePassenger${index}">
                        
                        <div class="d-flex align-items-center">
                            <i class="fa ${typeValue === 'adult' ? 'fa-user' : 'fa-child'} mr-3" style="font-size: 1.2rem; color: var(--primary);"></i>
                            <h6 class="mb-0 font-weight-bold text-dark">
                                ${label} #${index + 1}
                            </h6>
                            <span class="badge ${badgeBg} ml-2 p-1 px-2 text-white" style="font-size: 0.7rem;">${typeValue === 'adult' ? 'Người lớn' : 'Trẻ em'}</span>
                        </div>
                        <i class="fa fa-chevron-down accordion-icon"></i>
                    </div>

                    <div id="collapsePassenger${index}" class="collapse ${collapseClass}" data-parent="#passengers-accordion">
                        <div class="passenger-body">
                            <input type="hidden" name="hanh_khach[${index}][loai_hanh_khach]" value="${typeValue}" class="pass-type">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="text-muted small font-weight-bold">Họ và tên <span class="text-danger">*</span></label>
                                    <input type="text" name="hanh_khach[${index}][ho_ten]" class="form-control input-custom bg-white pass-name" placeholder="VD: NGUYEN VAN A" required>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label class="text-muted small font-weight-bold">Giới tính</label>
                                    <select name="hanh_khach[${index}][gioi_tinh]" class="custom-select input-custom bg-white pass-gender">
                                        <option value="Nam">Nam</option>
                                        <option value="Nữ">Nữ</option>
                                    </select>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label class="text-muted small font-weight-bold">Ngày sinh</label>
                                    <input type="date" name="hanh_khach[${index}][ngay_sinh]" class="form-control input-custom bg-white pass-dob">
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label class="text-muted small font-weight-bold">Quốc tịch</label>
                                    <input type="text" name="hanh_khach[${index}][quoc_tich]" class="form-control input-custom bg-white pass-nation" value="Việt Nam">
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="text-muted small font-weight-bold">Giấy tờ tùy thân <span class="text-danger">*</span></label>
                                    <select name="hanh_khach[${index}][loai_giay_to]" class="custom-select input-custom bg-white pass-doc-type" required>
                                        <option value="CCCD">Căn cước công dân</option>
                                        <option value="Hộ chiếu">Hộ chiếu</option>
                                        <option value="Giấy khai sinh">Giấy khai sinh (Trẻ em)</option>
                                    </select>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="text-muted small font-weight-bold">Số giấy tờ <span class="text-danger">*</span></label>
                                    <input type="text" name="hanh_khach[${index}][so_giay_to]" class="form-control input-custom bg-white pass-doc-id" placeholder="Nhập số số định danh..." required>
                                </div>

                                <div class="col-md-5 mb-3 mb-md-0">
                                    <label class="text-muted small font-weight-bold">Số điện thoại</label>
                                    <input type="tel" name="hanh_khach[${index}][so_dien_thoai]" class="form-control input-custom bg-white pass-phone" placeholder="SĐT liên hệ...">
                                </div>
                                <div class="col-md-7">
                                    <label class="text-muted small font-weight-bold">Yêu cầu đặc biệt</label>
                                    <input type="text" name="hanh_khach[${index}][yeu_cau_dac_biet]" class="form-control input-custom bg-white pass-note" placeholder="Ăn chay, dị ứng, hỗ trợ y tế...">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            `;
        }

        // Cập nhật số lượng và tính toán số tiền cơ bản
        function updateBookingDetails() {
            let adults = parseInt(elQtyAdult.value) || 0;
            let children = parseInt(elQtyChild.value) || 0;
            
            if (adults < 1) {
                adults = 1;
                elQtyAdult.value = 1;
            }

            let totalAdult = adults * priceAdult;
            let totalChild = children * priceChild;
            let grandTotal = totalAdult + totalChild;
            elInputGrandTotal.value = grandTotal;

            // Render lại số lượng Accordion hành khách
            let formsHTML = '';
            let passengerIndex = 0;

            for (let i = 0; i < adults; i++) {
                let isOpen = (passengerIndex === 0);
                formsHTML += getPassengerFormTemplate(passengerIndex, 'Hành khách', 'adult', isOpen);
                passengerIndex++;
            }
            for (let i = 0; i < children; i++) {
                let isOpen = (passengerIndex === 0);
                formsHTML += getPassengerFormTemplate(passengerIndex, 'Hành khách', 'child', isOpen);
                passengerIndex++;
            }
            
            accordionContainer.innerHTML = formsHTML;
        }

        // PHẦN LỚN NHẤT: Thu thập thông tin từ form và xuất ra mã HTML Tóm tắt gửi đơn hàng
        function generateSummaryScript() {
            // 1. Tìm lịch khởi hành được chọn
            const selectedRadio = document.querySelector('input[name="lich_khoi_hanh_id"]:checked');
            let dateText = "Chưa chọn lịch";
            if(selectedRadio) {
                const cardParent = selectedRadio.closest('.schedule-card');
                dateText = cardParent.querySelector('.schedule-date').textContent.trim();
            }

            // 2. Lấy thông tin liên hệ
            const contactName = document.getElementById('contact_name').value;
            const contactEmail = document.getElementById('contact_email').value;
            const contactPhone = document.getElementById('contact_phone').value;
            const contactAddress = document.getElementById('contact_address').value;

            // 3. Tính toán chi phí thực tế hiển thị
            const adults = parseInt(elQtyAdult.value) || 1;
            const children = parseInt(elQtyChild.value) || 0;
            const totalAdultPrice = adults * priceAdult;
            const totalChildPrice = children * priceChild;
            const finalTotal = totalAdultPrice + totalChildPrice;

            // 4. Thu thập danh sách chi tiết các hành khách đã điền
            let passengersHTML = '';
            const passCards = document.querySelectorAll('#passengers-accordion .passenger-accordion-card');
            
            passCards.forEach((card, index) => {
                const name = card.querySelector('.pass-name').value || '(Chưa nhập)';
                const type = card.querySelector('.pass-type').value === 'adult' ? 'Người lớn' : 'Trẻ em';
                const gender = card.querySelector('.pass-gender').value;
                const dob = card.querySelector('.pass-dob').value || '(Trưa nhập)';
                const docType = card.querySelector('.pass-doc-type').value;
                const docId = card.querySelector('.pass-doc-id').value || '(Chưa nhập)';
                
                passengersHTML += `
                    <tr>
                        <td class="font-weight-bold">#${index + 1}</td>
                        <td><strong>${name.toUpperCase()}</strong></td>
                        <td><span class="badge ${type === 'Người lớn' ? 'badge-primary' : 'badge-info'}">${type}</span></td>
                        <td>${gender}</td>
                        <td>${dob}</td>
                        <td><small class="text-muted">${docType}:</small> ${docId}</td>
                    </tr>
                `;
            });

            // 5. Khởi dựng chuỗi HTML cấu trúc Tóm tắt cho Modal
            let summaryHTML = `
                <!-- KHỐI 1: TOUR & LỊCH KHỞI HÀNH -->
                <div class="summary-section-box shadow-sm">
                    <div class="summary-section-title"><i class="fa fa-map-marked-alt mr-2 text-primary"></i>Thông tin chuyến đi</div>
                    <h5 class="font-weight-bold text-dark mb-2">${tourTitle}</h5>
                    <p class="mb-0 text-muted">
                        <i class="fa fa-calendar-alt mr-2 text-danger"></i>Ngày khởi hành: <strong class="text-dark">${dateText}</strong>
                    </p>
                </div>

                <!-- KHỐI 2: NGƯỜI LIÊN HỆ -->
                <div class="summary-section-box shadow-sm">
                    <div class="summary-section-title"><i class="fa fa-id-card mr-2 text-primary"></i>Người liên hệ đại diện</div>
                    <div class="row text-dark">
                        <div class="col-sm-6 mb-2"><strong>Họ tên:</strong> ${contactName}</div>
                        <div class="col-sm-6 mb-2"><strong>Số điện thoại:</strong> ${contactPhone}</div>
                        <div class="col-sm-6"><strong>Email:</strong> ${contactEmail}</div>
                        <div class="col-sm-6"><strong>Địa chỉ:</strong> ${contactAddress}</div>
                    </div>
                </div>

                <!-- KHỐI 3: DANH SÁCH HÀNH KHÁCH CHI TIẾT -->
                <div class="summary-section-box shadow-sm">
                    <div class="summary-section-title"><i class="fa fa-users mr-2 text-primary"></i>Danh sách đoàn khách</div>
                    <div class="table-responsive">
                        <table class="table table-sm table-hover mb-0" style="font-size: 0.9rem;">
                            <thead class="thead-light">
                                <tr>
                                    <th>STT</th>
                                    <th>Họ và Tên</th>
                                    <th>Loại</th>
                                    <th>Phái</th>
                                    <th>Ngày sinh</th>
                                    <th>Giấy tờ thân</th>
                                </tr>
                            </thead>
                            <tbody>
                                ${passengersHTML}
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- KHỐI 4: PHƯƠNG THỨC THANH TOÁN (Người dùng chọn trực tiếp tại đây) -->
                <div class="summary-section-box shadow-sm border border-primary bg-white">
                    <div class="summary-section-title text-primary"><i class="fa fa-credit-card mr-2"></i>Chọn phương thức thanh toán</div>
                    <div class="form-group mb-0">
                        <select id="paymentMethodSelect" class="custom-select custom-select-lg font-weight-bold text-dark" style="font-size: 1.05rem; border: 2px solid var(--primary);">
                            <option value="CHUYEN_KHOAN">Chuyển khoản ngân hàng trực tiếp</option>
                            <option value="VNPAY">Thanh toán trực tuyến bằng cổng VNPAY</option>
                        </select>
                        <small class="form-text text-muted mt-2">
                            * Hệ thống sẽ tự động chuyển hướng hoặc cung cấp thông tin tài khoản đích sau khi quý khách xác nhận.
                        </small>
                    </div>
                </div>

                <!-- KHỐI 5: TÍNH TOÁN BẢNG GIÁ VÀ TỔNG TIỀN -->
                <div class="summary-section-box shadow-sm bg-dark text-white border-0">
                    <div class="summary-section-title text-light border-secondary"><i class="fa fa-calculator mr-2"></i>Bảng kê chi phí</div>
                    <div class="d-flex justify-content-between mb-2">
                        <span>Người lớn: ${adults} x ${formatVND(priceAdult)}</span>
                        <strong>${formatVND(totalAdultPrice)}</strong>
                    </div>
                    ${children > 0 ? `
                    <div class="d-flex justify-content-between mb-2">
                        <span>Trẻ em: ${children} x ${formatVND(priceChild)}</span>
                        <strong>${formatVND(totalChildPrice)}</strong>
                    </div>` : ''}
                    <div class="d-flex justify-content-between mb-3 text-success">
                        <span>Thuế giá trị gia tăng & phí dịch vụ</span>
                        <strong>Miễn phí</strong>
                    </div>
                    <hr class="border-secondary my-2">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0 font-weight-bold text-warning">TỔNG CỘNG THANH TOÁN:</h5>
                        <h3 class="mb-0 font-weight-bold text-white">${formatVND(finalTotal)}</h3>
                    </div>
                </div>
            `;

            summaryModalContent.innerHTML = summaryHTML;
            syncPaymentMethod();

            const paymentMethodSelect = document.getElementById('paymentMethodSelect');
            if (paymentMethodSelect) {
                paymentMethodSelect.addEventListener('change', syncPaymentMethod);
            }
        }

        // BẮT SỰ KIỆN: Khi người dùng bấm nút Xem tóm tắt
        btnPreviewBooking.addEventListener('click', function() {
            // Kiểm tra tính hợp lệ cơ bản của toàn bộ form qua HTML5 Validation (yêu cầu required, radio checked, v.v...)
            if (bookingForm.reportValidity()) {
                // Nếu hợp lệ, biên dịch dữ liệu sang giao diện tóm tắt và mở Modal lên
                generateSummaryScript();
                $('#summaryModal').modal('show');
            }
        });

        // BẮT SỰ KIỆN: Nút submit thật nằm trong Modal xác nhận cuối cùng
        btnFinalSubmit.addEventListener('click', function() {
            syncPaymentMethod();
            btnFinalSubmit.disabled = true;
            btnFinalSubmit.innerHTML = `<i class="fa fa-spinner fa-spin mr-2"></i>Đang xử lý đơn đặt...`;
            bookingForm.submit(); // Thực hiện gửi toàn bộ form dữ liệu về Route Laravel
        });

        elQtyAdult.addEventListener('change', updateBookingDetails);
        elQtyChild.addEventListener('change', updateBookingDetails);
        
        // Khởi chạy dữ liệu mặc định lần đầu khi load trang
        updateBookingDetails();
    });
</script>
@endsection