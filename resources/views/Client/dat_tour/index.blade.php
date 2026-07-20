@extends('layouts.app')

@section('content')
<div class="container-fluid py-5 bg-light">
    <div class="container">
        <!-- FORM BAO NGOÀI -->
        <form id="bookingForm" method="POST" action="{{ route('store_dat_tour') }}">
            @csrf
            @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
            @endif

            <div class="row">
                <!-- LEFT - Thông tin chính -->
                <div class="col-lg-7">
                    <div class="mb-5">
                        <h2 class="font-weight-bold text-dark mb-2">
                            <i class="fa fa-plane mr-3 text-primary"></i>Đặt Tour
                        </h2>
                        <p class="text-muted" style="font-size: 1.25rem;">
                            Vui lòng kiểm tra thông tin trước khi thanh toán
                        </p>
                    </div>

                    <!-- Thông tin Tour -->
                    <h4 class="font-weight-bold mb-3 text-dark">
                        <i class="fa fa-info-circle mr-2"></i>Thông tin Tour
                    </h4>
                    <input type="hidden" name="tour_id" value="{{ $tour->id }}">
                    <input type="hidden" name="trang_thai" value="cho_thanh_toan">
                    <input type="hidden" name="so_tien_da_thanh_toan" value="0">
                    
                    <div class="card border-0 shadow-sm mb-5">
                        <div class="row no-gutters">
                            <div class="col-md-4">
                                <img src="{{ asset('storage/'.$tour->anh_dai_dien) }}" class="img-fluid h-100 w-100 rounded-left" style="min-height: 220px; object-fit: cover;" alt="{{ $tour->ten_tour }}">
                            </div>
                            <div class="col-md-8 p-4">
                                <h4 class="font-weight-bold">{{ $tour->ten_tour }}</h4>
                                <p class="mb-2 text-muted">
                                    <i class="fa fa-location-dot text-danger"></i>
                                    {{ $tour->dia_diem_khoi_hanh }}
                                </p>
                                <p class="mb-3">
                                    <i class="fa fa-clock text-primary"></i>
                                    {{ $tour->thoi_luong }}
                                </p>
                                <h4 class="text-primary font-weight-bold mb-0">
                                    {{ number_format($tour->gia_nguoi_lon) }}đ <small class="text-muted" style="font-size: 0.875rem;">/người lớn</small>
                                </h4>
                            </div>
                        </div>
                    </div>

                    <!-- Lịch khởi hành -->
                    <h4 class="font-weight-bold mb-3 text-dark">
                        <i class="fa fa-calendar-alt mr-2"></i>Lịch khởi hành
                    </h4>
                    <div class="mb-5">
                        @foreach($lichKhoiHanhs as $lich)
                        <label class="card border mb-3 p-4 cursor-pointer hover-shadow transition-all" style="cursor: pointer;">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="d-flex align-items-center">
                                    <input class="form-check-input mt-0 mr-3 shadow-none" type="radio" name="lich_khoi_hanh_id" value="{{ $lich->id }}" required @checked(old('lich_khoi_hanh_id') == $lich->id)>
                                    <div>
                                        <strong style="font-size: 1.25rem;">
                                            {{ \Carbon\Carbon::parse($lich->ngay_khoi_hanh)->format('d/m/Y') }}
                                        </strong>
<span class="badge
{{ $lich->trang_thai == 'available' ? 'badge-success' : '' }}
{{ $lich->trang_thai == 'closed' ? 'badge-secondary' : '' }}
{{ $lich->trang_thai == 'full' ? 'badge-danger' : '' }}">
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
                                        <br>
                                        <small class="{{$lich->trang_thai == 'full'?'text-danger':'text-success'}}">
                                            <i class="fa fa-users mr-1"></i>
                                            <strong>{{ $lich->so_cho_da_dat }}/{{$lich->so_cho}}</strong> chỗ
                                        </small>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <h5 class="text-primary font-weight-bold mb-0">
                                        {{ number_format($lich->tour->gia_nguoi_lon) }}đ
                                    </h5>
                                </div>
                            </div>
                        </label>
                        @endforeach
                    </div>

                    <!-- Thông tin người đặt -->
                    <h4 class="font-weight-bold mb-3 text-dark">
                        <i class="fa fa-user mr-2"></i>Thông tin người liên hệ (Người đặt)
                    </h4>
                    <div class="card border-0 shadow-sm p-4 mb-5">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="font-weight-bold small text-muted">Họ và tên</label>
                                <input type="text" class="form-control form-control-lg bg-light" value="{{ auth()->user()->name }}" readonly>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="font-weight-bold small text-muted">Email</label>
                                <input type="email" class="form-control form-control-lg bg-light" value="{{ auth()->user()->email }}" readonly>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="font-weight-bold small text-muted">Số điện thoại</label>
                                <input type="tel" name="nguoi_dat_phone" class="form-control form-control-lg bg-light" value="{{ auth()->user()->phone ?? '' }}" readonly>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="font-weight-bold small text-muted">Địa Chỉ</label>
                                <input type="text" class="form-control form-control-lg bg-light" value="{{ auth()->user()->address ?? '' }}" readonly>
                            </div>
                        </div>
                    </div>

                    <!-- Số lượng hành khách -->
                    <h4 class="font-weight-bold mb-3 text-dark">
                        <i class="fa fa-users mr-2"></i>Số lượng hành khách
                    </h4>
                    <div class="card border-0 shadow-sm p-4 mb-5">
                        <div class="row text-center">
                            <div class="col-md-4 mb-3">
                                <label class="font-weight-bold small text-muted">Người lớn (&gt;12 tuổi)</label>
                                <input type="number" id="qty_adult" name="so_nguoi_lon" class="form-control form-control-lg text-center" value="1" min="1" required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="font-weight-bold small text-muted">Trẻ em (2-11 tuổi)</label>
                                <input type="number" id="qty_child" name="so_tre_em" class="form-control form-control-lg text-center" value="0" min="0">
                            </div>
                            
                        </div>
                    </div>

                    <!-- Danh sách form hành khách -->
                    <h4 class="font-weight-bold mb-3 text-dark">
                        <i class="fa fa-id-card mr-2"></i>Thông tin hành khách chi tiết
                    </h4>
                    <!-- Vùng chứa các form sẽ được render bằng JS -->
                    <div id="passengers-container"></div>
                </div>

                <!-- RIGHT - Order Summary -->
                <div class="col-lg-5 order-summary-container">
                    <div class="order-summary-sticky">
                        <div class="card border-0 shadow-lg">
                            <div class="card-body p-5">
                                <h3 class="font-weight-bold mb-4">Tóm tắt đơn hàng</h3>

                                <div class="bg-light p-4 mb-4" style="border-radius: 0.5rem;">
                                    <small class="text-muted">Tour đã chọn</small>
                                    <h2 class="font-weight-bold text-primary my-3">
                                        {{ $tour->ten_tour }}
                                    </h2>
                                </div>

                                <!-- Bảng giá chi tiết động -->
                                <div class="d-flex justify-content-between py-2 border-bottom">
                                    <span class="text-muted">Người lớn (<span id="txt_adult_count">1</span>)</span>
                                    <strong id="txt_adult_total">{{ number_format($tour->gia_nguoi_lon) }}đ</strong>
                                </div>
                                <div class="d-flex justify-content-between py-2 border-bottom">
                                    <span class="text-muted">Trẻ em (<span id="txt_child_count">0</span>)</span>
                                    <strong id="txt_child_total">{{ number_format($tour->gia_tre_em) }}đ</strong>
                                </div>
                                <div class="d-flex justify-content-between py-2">
                                    <span class="text-muted">Thuế & Phí</span>
                                    <strong class="text-success">Miễn phí</strong>
                                </div>

                                <hr class="my-4">

                                <div class="d-flex justify-content-between align-items-end">
                                    <h5 class="mb-0">Tổng thanh toán</h5>
                                    <div class="text-right">
                                        <!-- Tổng tiền được cập nhật bởi JS -->
                                        <h3 class="font-weight-bold text-danger mb-0" id="txt_grand_total">
                                            {{ number_format($tour->gia_nguoi_lon) }}đ
                                        </h3>
                                        <input type="hidden" name="tong_tien" id="input_grand_total" value="{{ $tour->gia_nguoi_lon }}">
                                        <small class="text-muted">Đã bao gồm VAT</small>
                                    </div>
                                </div>

                                <!-- Payment Method -->
                                <div class="mt-4">
                                    <label class="font-weight-bold small text-muted">Phương thức thanh toán</label>
                                    <select name="phuong_thuc_thanh_toan" class="custom-select custom-select-lg">
                                        <option value="Chuyen khoan">Chuyển khoản ngân hàng</option>
                                        <option value="VNPAY">Thanh toán VNPay</option>
                                    </select>
                                </div>

                                <button type="submit" class="btn btn-success btn-lg w-100 mt-4 py-3 font-weight-bold shadow-sm" style="font-size: 1.25rem;">
                                    <i class="fa fa-lock mr-2"></i>
                                    Xác nhận & Thanh toán
                                </button>

                                <p class="text-center text-muted small mt-4 mb-0">
                                    Bằng việc thanh toán, bạn đồng ý với
                                    <a href="#" style="text-decoration: underline;">Điều khoản dịch vụ</a> của Travelloula.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form> <!-- END FORM -->
    </div>
</div>

<style>
    .hover-shadow:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1) !important;
        transition: all 0.3s ease;
    }

    .cursor-pointer:hover {
        background-color: #f8f9fa;
    }

    /* Tái cấu trúc class Sticky cho phù hợp với BS4 */
    .order-summary-container {
        position: relative;
    }

    .order-summary-sticky {
        position: -webkit-sticky;
        position: sticky;
        top: 30px;
        z-index: 990;
    }

    .passenger-card {
        background-color: #fff;
        border: 1px solid #dee2e6;
        border-radius: 0.5rem;
        padding: 1.5rem;
        margin-bottom: 1.5rem;
    }
</style>
@endsection

@section('scripts')
<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Đã sửa lỗi render dấu ngoặc nhọn lồng nhau của Blade trong JS
        const priceAdult = {{ $tour->gia_nguoi_lon ?? 0 }};
        const priceChild = {{ $tour->gia_tre_em ?? 0 }};
       

        // DOM elements form inputs
        const elQtyAdult = document.getElementById('qty_adult');
        const elQtyChild = document.getElementById('qty_child');
       

        // DOM elements for Order Summary
        const elTxtAdultCount = document.getElementById('txt_adult_count');
        const elTxtChildCount = document.getElementById('txt_child_count');
       

        const elTxtAdultTotal = document.getElementById('txt_adult_total');
        const elTxtChildTotal = document.getElementById('txt_child_total');
        

        const elTxtGrandTotal = document.getElementById('txt_grand_total');
        const elInputGrandTotal = document.getElementById('input_grand_total');

        const passengersContainer = document.getElementById('passengers-container');

        // Hàm format tiền tệ (VNĐ)
        function formatVND(amount) {
            return new Intl.NumberFormat('vi-VN').format(amount) + 'đ';
        }

        // Đã cập nhật template chuẩn Bootstrap 4 (Thêm mb-3 chống dính cột)
        function getPassengerFormTemplate(index, label, typeValue) {
            return `
                <div class="passenger-card shadow-sm">
                    <h5 class="font-weight-bold mb-3 border-bottom pb-2">${label} #${index + 1}</h5>
                    <input type="hidden" name="hanh_khach[${index}][loai_hanh_khach]" value="${typeValue}">
                    <div class="row">
                        <div class="col-md-5 mb-3">
                            <label class="text-muted small font-weight-bold">Họ tên <span class="text-danger">*</span></label>
                            <input type="text" name="hanh_khach[${index}][ho_ten]" class="form-control" required>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="text-muted small font-weight-bold">Giới tính</label>
                            <select name="hanh_khach[${index}][gioi_tinh]" class="custom-select">
                                <option value="Nam">Nam</option>
                                <option value="Nữ">Nữ</option>
                            </select>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="text-muted small font-weight-bold">Ngày sinh</label>
                            <input type="date" name="hanh_khach[${index}][ngay_sinh]" class="form-control">
                        </div>

                        <div class="col-md-4 mb-3">
                            <label class="text-muted small font-weight-bold">Quốc tịch</label>
                            <input type="text" name="hanh_khach[${index}][quoc_tich]" class="form-control" value="Việt Nam">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="text-muted small font-weight-bold">Loại giấy tờ <span class="text-danger">*</span></label>
                            <select name="hanh_khach[${index}][loai_giay_to]" class="custom-select" required>
                                <option value="CCCD">CCCD</option>
                                <option value="Hộ chiếu">Hộ chiếu</option>
                                <option value="Giấy khai sinh">Giấy khai sinh</option>
                            </select>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="text-muted small font-weight-bold">Số giấy tờ</label>
                            <input type="text" name="hanh_khach[${index}][so_giay_to]" class="form-control">
                        </div>

                        <div class="col-md-4 mb-3">
                            <label class="text-muted small font-weight-bold">Số điện thoại</label>
                            <input type="tel" name="hanh_khach[${index}][so_dien_thoai]" class="form-control">
                        </div>
                        
                        <div class="col-md-12 mb-3">
                            <label class="text-muted small font-weight-bold">Yêu cầu đặc biệt</label>
                            <textarea name="hanh_khach[${index}][yeu_cau_dac_biet]" class="form-control" rows="2" placeholder="Ăn chay, dị ứng, yêu cầu khác..."></textarea>
                        </div>
                    </div>
                </div>
            `;
        }

        function updateBookingDetails() {
            let adults = parseInt(elQtyAdult.value) || 0;
            let children = parseInt(elQtyChild.value) || 0;
            

            if (adults < 1) {
                adults = 1;
                elQtyAdult.value = 1;
            }

            elTxtAdultCount.textContent = adults;
            elTxtChildCount.textContent = children;
          

            let totalAdult = adults * priceAdult;
            let totalChild = children * priceChild;
            
            let grandTotal = totalAdult + totalChild ;

            elTxtAdultTotal.textContent = formatVND(totalAdult);
            elTxtChildTotal.textContent = formatVND(totalChild);
           

            elTxtGrandTotal.textContent = formatVND(grandTotal);
            elInputGrandTotal.value = grandTotal;

            let formsHTML = '';
            let passengerIndex = 0;

            for (let i = 0; i < adults; i++) {
                formsHTML += getPassengerFormTemplate(passengerIndex, 'Người lớn', 'adult');
                passengerIndex++;
            }
            for (let i = 0; i < children; i++) {
                formsHTML += getPassengerFormTemplate(passengerIndex, 'Trẻ em', 'child');
                passengerIndex++;
            }
            

            passengersContainer.innerHTML = formsHTML;
        }

        elQtyAdult.addEventListener('input', updateBookingDetails);
        elQtyChild.addEventListener('input', updateBookingDetails);
       

        updateBookingDetails();
    });
</script>
@endsection