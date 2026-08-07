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
                                <img src="{{ asset($tour->anh_dai_dien) }}" alt="{{ $tour->ten_tour }}" class="img-fluid h-100 w-100 tour-img">
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

        <label
            class="card border-0 shadow-sm p-3 h-100 schedule-card transition-all m-0"
            style="cursor: {{ in_array($lich->trang_thai, ['closed', 'full']) ? 'not-allowed' : 'pointer' }};"
        >

            <div class="d-flex align-items-start">

                <input
                    class="form-check-input custom-radio mt-1"
                    type="radio"
                    name="lich_khoi_hanh_id"
                    value="{{ $lich->id }}"
                    required
                    @checked(old('lich_khoi_hanh_id') == $lich->id)
                    {{ in_array($lich->trang_thai, ['closed', 'full']) ? 'disabled' : '' }}
                >

                <div class="ml-4 w-100">

                    <div class="d-flex justify-content-between align-items-center mb-1">

                        <strong
                            class="schedule-date"
                            style="font-size: 1.15rem; color: #0f172a;"
                        >
                            {{ \Carbon\Carbon::parse($lich->ngay_khoi_hanh)->format('d/m/Y') }}
                        </strong>

                        <span class="badge badge-pill
                            {{ $lich->trang_thai == 'available' ? 'badge-success-soft' : '' }}
                            {{ $lich->trang_thai == 'closed' ? 'badge-secondary-soft' : '' }}
                            {{ $lich->trang_thai == 'full' ? 'badge-danger-soft' : '' }}"
                        >
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
                        mb-2"
                    >
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
:root{
    --primary:#2563eb;
    --primary-dark:#1d4ed8;
    --primary-light:#3b82f6;
    --primary-soft:#eff6ff;
    --primary-pale:#f8fbff;
    --cyan:#38bdf8;
    --text:#0f172a;
    --text-soft:#334155;
    --muted:#64748b;
    --line:#dbe5f1;
    --line-soft:#e8eef6;
    --white:#fff;
    --success:#059669;
    --success-soft:#ecfdf5;
    --danger:#dc2626;
    --danger-soft:#fef2f2;
    --shadow-sm:0 10px 28px rgba(15,23,42,.07);
    --shadow:0 18px 48px rgba(37,99,235,.10);
    --shadow-lg:0 28px 80px rgba(15,23,42,.15);
    --radius:18px;
    --radius-lg:26px;
}

html,body{
    width:100%;
    max-width:100%;
    overflow-x:hidden;
}

body{
    color:var(--text);
    background:#f8fbff;
}

.page-bg{
    position:relative;
    min-height:100vh;
    padding-top:clamp(46px,5vw,78px)!important;
    padding-bottom:clamp(60px,6vw,100px)!important;
    background:
        radial-gradient(circle at 8% 3%,rgba(37,99,235,.10),transparent 30%),
        radial-gradient(circle at 92% 8%,rgba(56,189,248,.10),transparent 26%),
        linear-gradient(180deg,#fff 0%,#f8fbff 42%,#f3f8ff 100%);
}

.page-bg::before{
    content:"";
    position:absolute;
    inset:0;
    pointer-events:none;
    background-image:
        linear-gradient(rgba(37,99,235,.025) 1px,transparent 1px),
        linear-gradient(90deg,rgba(37,99,235,.025) 1px,transparent 1px);
    background-size:34px 34px;
    mask-image:linear-gradient(to bottom,rgba(0,0,0,.45),transparent 55%);
}

.page-bg>.container{
    position:relative;
    z-index:1;
    width:min(1380px,calc(100% - 32px));
    max-width:1380px;
    padding-left:0;
    padding-right:0;
}

.page-bg .col-xl-9.col-lg-10.mx-auto{
    flex:0 0 100%;
    width:100%;
    max-width:1180px;
}

/* HEADER */
.page-bg .mb-4.text-center{
    position:relative;
    overflow:hidden;
    margin-bottom:34px!important;
    padding:30px 24px 28px;
    border:1px solid #dbeafe;
    border-radius:var(--radius-lg);
    background:
        radial-gradient(circle at 12% 20%,rgba(59,130,246,.13),transparent 30%),
        linear-gradient(135deg,#fff,#f5f9ff);
    box-shadow:var(--shadow);
}

.page-bg .mb-4.text-center::after{
    content:"";
    position:absolute;
    width:180px;
    height:180px;
    right:-65px;
    top:-85px;
    border-radius:50%;
    background:rgba(56,189,248,.10);
}

.page-bg .mb-4.text-center h2{
    position:relative;
    z-index:1;
    margin:0 0 8px!important;
    color:var(--text)!important;
    font-size:clamp(29px,3vw,42px);
    line-height:1.18;
    font-weight:900!important;
    letter-spacing:-1px;
}

.page-bg .mb-4.text-center h2 i{
    display:inline-flex;
    align-items:center;
    justify-content:center;
    width:50px;
    height:50px;
    margin-right:12px!important;
    border-radius:16px;
    color:#fff!important;
    background:linear-gradient(135deg,var(--primary-light),var(--primary));
    box-shadow:0 12px 26px rgba(37,99,235,.24);
    vertical-align:middle;
    font-size:21px;
}

.page-bg .mb-4.text-center p{
    position:relative;
    z-index:1;
    max-width:720px;
    margin:0 auto!important;
    color:var(--muted)!important;
    font-size:15px!important;
    line-height:1.7;
    font-weight:600;
}

.primary-text{color:var(--primary)!important}
.rounded-custom{border-radius:var(--radius)!important}

/* ALERT */
.page-bg .alert-danger{
    border:1px solid #fecaca!important;
    border-radius:16px!important;
    color:#991b1b;
    background:#fff7f7;
    box-shadow:0 12px 28px rgba(220,38,38,.08)!important;
    font-weight:700;
}

/* SECTION TITLE */
.section-title{
    position:relative;
    display:flex;
    align-items:center;
    margin:0 0 15px!important;
    padding-left:18px;
    border-left:0;
    color:var(--text)!important;
    font-size:18px;
    line-height:1.4;
    font-weight:900!important;
    letter-spacing:-.25px;
}
.section-title::before{
    content:"";
    position:absolute;
    left:0;
    top:2px;
    bottom:2px;
    width:5px;
    border-radius:999px;
    background:linear-gradient(180deg,var(--primary-light),var(--primary));
    box-shadow:0 4px 12px rgba(37,99,235,.22);
}

/* TOUR INFO */
.tour-info-card{
    overflow:hidden;
    border:1px solid #dbeafe!important;
    border-radius:24px!important;
    background:#fff;
    box-shadow:var(--shadow)!important;
}
.tour-info-card .row{min-height:245px}
.tour-img{
    width:100%;
    height:100%;
    min-height:245px;
    border-radius:0;
    object-fit:cover;
    display:block;
}
.tour-info-card .col-md-8{
    position:relative;
    padding:34px 38px!important;
    background:
        radial-gradient(circle at 100% 0,rgba(37,99,235,.08),transparent 35%),
        linear-gradient(180deg,#fff,#fbfdff);
}
.tour-info-card h4:first-child{
    color:var(--text);
    font-size:clamp(23px,2vw,30px);
    line-height:1.35;
    font-weight:900!important;
    letter-spacing:-.5px;
}
.tour-info-card .text-muted{
    color:var(--muted)!important;
    font-weight:600;
}
.tour-info-card h4.primary-text{
    margin-top:18px!important;
    padding-top:18px;
    border-top:1px dashed #dbe5f1;
    font-size:27px;
    color:var(--primary-dark)!important;
}

/* CONTENT CARDS */
.page-bg .card.border-0.shadow-sm.p-4,
.page-bg .card.border-0.shadow-sm.p-4.mb-5{
    border:1px solid var(--line-soft)!important;
    border-radius:22px!important;
    background:rgba(255,255,255,.97);
    box-shadow:var(--shadow-sm)!important;
}

/* SCHEDULE */
.schedule-card{
    position:relative;
    overflow:hidden;
    min-height:132px;
    border:1.5px solid #dbe5f1!important;
    border-radius:18px!important;
    background:linear-gradient(135deg,#fff,#fbfdff);
    box-shadow:0 10px 26px rgba(15,23,42,.065)!important;
    transition:.22s ease;
}
.schedule-card::before{
    content:"";
    position:absolute;
    left:0;
    top:0;
    bottom:0;
    width:4px;
    background:#dbeafe;
}
.schedule-card:hover{
    transform:translateY(-3px);
    border-color:#93c5fd!important;
    box-shadow:0 16px 36px rgba(37,99,235,.12)!important;
}
.schedule-card:has(input[type="radio"]:checked){
    border-color:var(--primary)!important;
    background:linear-gradient(135deg,#eff6ff,#fff);
    box-shadow:0 18px 38px rgba(37,99,235,.16)!important;
}
.schedule-card:has(input[type="radio"]:checked)::before{
    background:linear-gradient(180deg,var(--primary-light),var(--primary));
}
.schedule-disabled{opacity:.68}
.schedule-disabled .schedule-card{
    background:#f8fafc;
    box-shadow:none!important;
}
.schedule-disabled .schedule-card:hover{
    transform:none;
    border-color:#e2e8f0!important;
    box-shadow:none!important;
}
.custom-radio{
    width:20px;
    height:20px;
    margin-top:4px!important;
    accent-color:var(--primary);
}
.schedule-date{
    color:var(--text)!important;
    font-size:17px!important;
    font-weight:900!important;
}
.schedule-card .border-top{border-color:#e6edf7!important}
.badge{
    border-radius:999px;
    letter-spacing:.1px;
}
.badge-success-soft,.badge-secondary-soft,.badge-danger-soft{
    padding:7px 11px;
    border:1px solid transparent;
    font-size:11px;
    line-height:1;
    font-weight:900;
}
.badge-success-soft{
    color:#047857;
    background:var(--success-soft);
    border-color:#a7f3d0;
}
.badge-secondary-soft{
    color:#475569;
    background:#f1f5f9;
    border-color:#e2e8f0;
}
.badge-danger-soft{
    color:#b91c1c;
    background:var(--danger-soft);
    border-color:#fecaca;
}

/* INPUT */
.page-bg label{color:#475569}
.input-custom,
.page-bg .form-control,
.page-bg .custom-select{
    min-height:50px;
    border:1px solid #d7e2ef;
    border-radius:13px;
    color:var(--text);
    background:#fff!important;
    padding:.72rem .95rem;
    font-size:14px;
    font-weight:650;
    box-shadow:none;
    transition:.2s ease;
}
.page-bg .form-control[readonly]{
    color:#475569;
    background:#f8fafc!important;
    border-color:#e2e8f0;
}
.input-custom:focus,
.page-bg .form-control:focus,
.page-bg .custom-select:focus{
    border-color:#60a5fa;
    background:#fff!important;
    box-shadow:0 0 0 4px rgba(37,99,235,.10);
    outline:none;
}
.page-bg .input-group-text{
    min-width:50px;
    justify-content:center;
    border-color:#d7e2ef;
    border-radius:13px 0 0 13px;
    color:var(--primary);
    background:#eff6ff!important;
}
.page-bg .input-group .form-control{
    border-radius:0 13px 13px 0;
}
.page-bg .is-invalid{
    border-color:#ef4444!important;
    box-shadow:0 0 0 4px rgba(239,68,68,.08)!important;
}
.js-error{font-weight:700}

/* IMPORT EXCEL */
.page-bg label .btn-outline-primary{
    min-height:40px;
    padding:0 16px;
    display:inline-flex;
    align-items:center;
    justify-content:center;
    border:1px solid #93c5fd;
    border-radius:12px;
    color:var(--primary);
    background:#fff;
    font-weight:900;
    box-shadow:0 8px 18px rgba(37,99,235,.07);
}
.page-bg label .btn-outline-primary:hover{
    color:#fff;
    border-color:var(--primary);
    background:var(--primary);
    transform:translateY(-1px);
}

/* PASSENGER */
.passenger-accordion-card{
    overflow:hidden;
    border:1px solid #dbe5f1;
    border-radius:18px!important;
    background:#fff;
    box-shadow:0 10px 28px rgba(15,23,42,.06)!important;
    transition:.22s ease;
}
.passenger-accordion-card:hover{
    border-color:#bfdbfe;
    box-shadow:0 16px 34px rgba(37,99,235,.10)!important;
}
.passenger-accordion-header{
    min-height:68px;
    padding:16px 20px;
    color:var(--text);
    background:linear-gradient(135deg,#fff,#f8fbff);
    cursor:pointer;
}
.passenger-accordion-header:hover{background:#f1f7ff}
.passenger-accordion-header .badge-primary{
    background:linear-gradient(135deg,#3b82f6,#2563eb);
}
.passenger-accordion-header .badge-info{
    background:linear-gradient(135deg,#38bdf8,#0ea5e9);
}
.accordion-icon{
    color:var(--primary);
    transition:transform .25s ease,color .25s ease;
}
.passenger-accordion-header.collapsed .accordion-icon{
    color:#94a3b8;
    transform:rotate(-90deg);
}
.passenger-body{
    padding:22px;
    border-top:1px solid #e6edf7;
    background:#fbfdff;
}

/* COMMITMENT */
#chk_commitment + .custom-control-label{
    line-height:1.7;
    color:#334155!important;
}
.custom-control-input:checked~.custom-control-label::before{
    border-color:var(--primary);
    background-color:var(--primary);
}

/* CTA */
.btn-checkout{
    min-height:58px;
    border:0!important;
    border-radius:16px!important;
    color:#fff;
    background:linear-gradient(135deg,#3b82f6 0%,#2563eb 58%,#1d4ed8 100%)!important;
    box-shadow:0 14px 30px rgba(37,99,235,.24)!important;
    transition:.22s ease;
}
.btn-checkout:hover,.btn-checkout:focus{
    color:#fff;
    transform:translateY(-2px);
    box-shadow:0 18px 38px rgba(37,99,235,.30)!important;
}

/* SUMMARY MODAL */
#summaryModal .modal-dialog{max-width:1000px}
#summaryModal .modal-content{
    overflow:hidden;
    border:1px solid #dbeafe!important;
    border-radius:24px!important;
    background:#fff;
    box-shadow:var(--shadow-lg)!important;
}
#summaryModal .modal-header{
    position:relative;
    padding:22px 28px!important;
    border-bottom:1px solid #dbeafe!important;
    background:
        radial-gradient(circle at 10% 0,rgba(37,99,235,.10),transparent 32%),
        linear-gradient(135deg,#fff,#f4f8ff)!important;
}
#summaryModal .modal-title{
    color:var(--text)!important;
    font-size:23px;
    font-weight:900!important;
}
#summaryModal .close{
    position:absolute;
    right:18px;
    top:50%;
    width:40px;
    height:40px;
    margin:0;
    padding:0;
    transform:translateY(-50%);
    border-radius:50%;
    color:#64748b;
    background:#fff;
    opacity:1;
    box-shadow:0 6px 16px rgba(15,23,42,.08);
}
#summaryModal .modal-body{
    padding:24px!important;
    background:#f8fbff!important;
}
#summaryModal .modal-footer{
    padding:18px 24px!important;
    border-top:1px solid #e2e8f0!important;
    background:#fff!important;
}
#summaryModal .btn-secondary,
#summaryModal .btn-success{
    min-height:46px;
    border-radius:13px!important;
    font-weight:900!important;
}
#summaryModal .btn-secondary{
    border:1px solid #cbd5e1;
    color:#475569;
    background:#fff;
}
#summaryModal .btn-success{
    border:0;
    color:#fff;
    background:linear-gradient(135deg,#10b981,#059669);
    box-shadow:0 12px 24px rgba(5,150,105,.20)!important;
}

/* GENERATED SUMMARY */
.summary-section-box{
    margin-bottom:14px;
    padding:18px;
    border:1px solid #dfe8f3;
    border-radius:17px;
    background:#fff;
    box-shadow:0 8px 22px rgba(15,23,42,.045);
}
.summary-section-box h5,.summary-section-box h6{
    margin-bottom:12px;
    color:var(--text);
    font-weight:900;
}
.summary-section-box p{
    margin-bottom:6px;
    color:#475569;
    line-height:1.6;
}
.summary-section-title{
    margin-bottom:12px;
    padding-bottom:9px;
    border-bottom:1px dashed #dbe5f1;
    color:var(--primary);
    font-size:12px;
    font-weight:900;
    letter-spacing:.75px;
    text-transform:uppercase;
}
.summary-section-box .table{margin-bottom:0;background:#fff}
.summary-section-box .table thead th{
    border-color:#dbe5f1;
    color:#334155;
    background:#eff6ff;
    font-size:12px;
    font-weight:900;
    white-space:nowrap;
}
.summary-section-box .table td{
    border-color:#e5edf6;
    color:#475569;
    font-size:13px;
    vertical-align:middle;
}
.summary-section-box.bg-dark{
    border:0!important;
    color:#fff!important;
    background:linear-gradient(135deg,#0f172a,#1e3a8a)!important;
    box-shadow:0 16px 34px rgba(15,23,42,.20);
}
.summary-section-box.bg-dark span,
.summary-section-box.bg-dark strong{color:#fff}
.summary-section-box.bg-dark hr{border-color:rgba(255,255,255,.18)}

.page-bg .mb-5{margin-bottom:34px!important}

@media(min-width:1600px){
    .page-bg .col-xl-9.col-lg-10.mx-auto{max-width:1260px}
    .tour-info-card .row{min-height:270px}
}

@media(max-width:991px){
    .page-bg{padding-top:42px!important}
    .page-bg>.container{width:calc(100% - 26px)}
    .page-bg .col-xl-9.col-lg-10.mx-auto{max-width:100%}
    .tour-info-card .col-md-8{padding:26px 28px!important}
}

@media(max-width:767px){
    .page-bg{
        padding-top:28px!important;
        padding-bottom:60px!important;
    }
    .page-bg>.container{width:calc(100% - 20px)}
    .page-bg .mb-4.text-center{
        padding:24px 18px;
        border-radius:20px;
    }
    .page-bg .mb-4.text-center h2{font-size:28px}
    .page-bg .mb-4.text-center h2 i{
        width:44px;
        height:44px;
        border-radius:14px;
    }
    .tour-info-card{border-radius:20px!important}
    .tour-info-card .row{min-height:0}
    .tour-img{
        min-height:220px;
        max-height:260px;
    }
    .tour-info-card .col-md-8{padding:22px 20px!important}
    .tour-info-card h4:first-child{font-size:22px}
    .schedule-card{min-height:0}
    .page-bg .card.border-0.shadow-sm.p-4,
    .page-bg .card.border-0.shadow-sm.p-4.mb-5{
        padding:20px!important;
        border-radius:18px!important;
    }
    .passenger-body{padding:18px}
    #summaryModal .modal-dialog{margin:10px}
    #summaryModal .modal-header{padding:18px 52px 18px 18px!important}
    #summaryModal .modal-title{
        text-align:left!important;
        font-size:19px;
    }
    #summaryModal .modal-body{padding:15px!important}
    #summaryModal .modal-footer{
        gap:10px;
        flex-direction:column-reverse;
        align-items:stretch!important;
    }
    #summaryModal .modal-footer .btn{
        width:100%;
        margin:0!important;
    }
    .summary-section-box{overflow-x:auto}
}

@media(max-width:520px){
    .page-bg>.container{width:calc(100% - 14px)}
    .page-bg .mb-4.text-center h2{
        display:flex;
        flex-direction:column;
        align-items:center;
        gap:10px;
    }
    .page-bg .mb-4.text-center h2 i{margin-right:0!important}
    .section-title{font-size:17px}
    .schedule-card{padding:14px!important}
    .schedule-card .ml-4{margin-left:14px!important}
    .schedule-card .d-flex.justify-content-between{
        gap:8px;
        align-items:flex-start!important;
        flex-direction:column;
    }
    .tour-info-card h4.primary-text{font-size:24px}
    .passenger-accordion-header{padding:14px 15px}
    .passenger-body{padding:15px}
    .btn-checkout{
        min-height:54px;
        font-size:14px;
    }
}

/* =========================================================
   TINH CHỈNH GIAO DIỆN ĐẶT TOUR - PREMIUM BLUE / WHITE
   ========================================================= */

/* Tổng thể gọn, sáng và cân đối hơn */
#bookingForm{
    counter-reset:booking-step;
}

.page-bg{
    padding-top:44px !important;
    background:
        radial-gradient(circle at 12% 0%,rgba(59,130,246,.10),transparent 28%),
        radial-gradient(circle at 90% 8%,rgba(14,165,233,.07),transparent 24%),
        linear-gradient(180deg,#f8fbff 0%,#ffffff 48%,#f7fbff 100%) !important;
}

.page-bg > .container{
    width:min(1320px,calc(100% - 36px)) !important;
    max-width:1320px !important;
}

.page-bg .col-xl-9.col-lg-10.mx-auto{
    max-width:1180px !important;
}

/* Tiêu đề đầu trang */
.page-bg .mb-4.text-center{
    margin-bottom:38px !important;
    padding:32px 28px !important;
    border:1px solid #dbeafe !important;
    border-radius:28px !important;
    background:
        linear-gradient(120deg,rgba(239,246,255,.95),rgba(255,255,255,.98) 48%,rgba(240,249,255,.92)) !important;
    box-shadow:
        0 18px 46px rgba(37,99,235,.09),
        inset 0 1px 0 rgba(255,255,255,.95) !important;
}

.page-bg .mb-4.text-center h2{
    font-size:clamp(30px,3vw,43px) !important;
    letter-spacing:-1.1px !important;
}

.page-bg .mb-4.text-center p{
    color:#64748b !important;
    font-size:15px !important;
}

/* Card thông tin tour */
.tour-info-card{
    margin-bottom:42px !important;
    border:1px solid #dbeafe !important;
    border-radius:26px !important;
    box-shadow:
        0 22px 54px rgba(37,99,235,.10),
        0 4px 14px rgba(15,23,42,.04) !important;
}

.tour-info-card .row{
    min-height:238px !important;
}

.tour-img{
    min-height:238px !important;
}

.tour-info-card .col-md-8{
    padding:32px 38px !important;
}

.tour-info-card h4:first-child{
    margin-bottom:18px !important;
    font-size:clamp(23px,2vw,29px) !important;
}

.tour-info-card .d-flex.align-items-center{
    min-height:34px;
    margin-bottom:6px !important;
    color:#53657d !important;
    font-size:15px;
}

.tour-info-card .d-flex.align-items-center i{
    width:34px !important;
    height:34px;
    margin-right:10px !important;
    border-radius:10px;
    display:inline-flex;
    align-items:center;
    justify-content:center;
    background:#eff6ff;
}

.tour-info-card .d-flex.align-items-center .text-danger{
    color:#ef4444 !important;
    background:#fff1f2;
}

.tour-info-card h4.primary-text{
    margin-top:18px !important;
    padding-top:20px !important;
    border-top:1px dashed #cbdcf1 !important;
    color:#1d4ed8 !important;
    font-size:30px !important;
}

/* Tiêu đề từng bước */
.section-title{
    counter-increment:booking-step;
    display:flex !important;
    align-items:center !important;
    gap:11px !important;
    min-height:36px;
    margin:0 0 17px !important;
    padding:0 !important;
    border:0 !important;
    color:#0f172a !important;
    font-size:21px !important;
    font-weight:900 !important;
    letter-spacing:-.45px;
}

/* Nhãn bước mới: nhẹ, sang, không còn cảm giác như một nút bấm */
.section-title::before{
    content:"BƯỚC " counter(booking-step) !important;
    position:static !important;
    width:auto !important;
    height:30px !important;
    flex:0 0 auto !important;
    padding:0 10px !important;
    border:1px solid #bfdbfe !important;
    border-radius:999px !important;
    display:inline-flex !important;
    align-items:center;
    justify-content:center;
    color:#2563eb !important;
    background:linear-gradient(180deg,#ffffff,#eff6ff) !important;
    box-shadow:none !important;
    font-size:10px !important;
    line-height:1 !important;
    font-weight:1000 !important;
    letter-spacing:.7px !important;
    white-space:nowrap;
}

.section-title::after{
    content:"";
    height:1px;
    flex:1;
    margin-left:6px;
    background:linear-gradient(90deg,#cfe0f8 0%,rgba(207,224,248,.25) 70%,transparent 100%);
}

/* Khu vực lịch khởi hành */
.section-title + .mb-5.row{
    margin-left:-7px !important;
    margin-right:-7px !important;
    margin-bottom:42px !important;
}

.section-title + .mb-5.row > [class*="col-md-6"]{
    padding-left:7px !important;
    padding-right:7px !important;
}

/* Khi chỉ có một lịch thì card dùng toàn bộ bề ngang */
.section-title + .mb-5.row > [class*="col-md-6"]:only-child{
    flex:0 0 100% !important;
    max-width:100% !important;
}

/* Tối đa 2 cột, nhưng mỗi card không bị quá dài */
.schedule-card{
    min-height:146px !important;
    padding:20px 22px !important;
    border:1px solid #d9e5f5 !important;
    border-radius:20px !important;
    background:
        radial-gradient(circle at 100% 0,rgba(59,130,246,.05),transparent 32%),
        #ffffff !important;
    box-shadow:0 12px 30px rgba(15,23,42,.06) !important;
}

.schedule-card::before{
    width:5px !important;
    background:#dbeafe !important;
}

.schedule-card:hover{
    transform:translateY(-3px) !important;
    border-color:#93c5fd !important;
    box-shadow:0 18px 38px rgba(37,99,235,.12) !important;
}

.schedule-card:has(input[type="radio"]:checked){
    border-color:#3b82f6 !important;
    background:
        linear-gradient(135deg,#eff6ff 0%,#ffffff 72%) !important;
    box-shadow:
        0 18px 42px rgba(37,99,235,.15),
        inset 0 0 0 1px rgba(59,130,246,.08) !important;
}

.schedule-card:has(input[type="radio"]:checked)::before{
    background:linear-gradient(180deg,#3b82f6,#2563eb) !important;
}

.custom-radio{
    width:22px !important;
    height:22px !important;
    margin-top:1px !important;
    accent-color:#2563eb !important;
}

.schedule-card .ml-4{
    margin-left:18px !important;
}

.schedule-date{
    font-size:18px !important;
    color:#0f172a !important;
    letter-spacing:-.2px;
}

.schedule-card small{
    font-size:13px;
    font-weight:700;
}

.schedule-card .badge{
    padding:8px 13px !important;
    font-size:11px !important;
    font-weight:900 !important;
}

.schedule-card .text-right{
    padding-top:13px !important;
    margin-top:12px !important;
}

.schedule-card .text-right .primary-text{
    color:#1d4ed8 !important;
    font-size:18px;
    font-weight:900 !important;
}

/* Các khối form */
.page-bg .card.border-0.shadow-sm.p-4,
.page-bg .card.border-0.shadow-sm.p-4.mb-5{
    margin-bottom:42px !important;
    padding:26px !important;
    border:1px solid #e0e9f4 !important;
    border-radius:22px !important;
    background:#ffffff !important;
    box-shadow:
        0 14px 36px rgba(15,23,42,.065),
        inset 0 1px 0 rgba(255,255,255,.95) !important;
}

.page-bg .card .row{
    margin-left:-9px;
    margin-right:-9px;
}

.page-bg .card .row > [class*="col-"]{
    padding-left:9px;
    padding-right:9px;
}

/* Label và input */
.page-bg label.font-weight-bold.small.text-muted{
    margin-bottom:8px;
    color:#475569 !important;
    font-size:12px;
    letter-spacing:.25px;
    text-transform:uppercase;
}

.input-custom,
.page-bg .form-control,
.page-bg .custom-select{
    min-height:52px !important;
    border:1px solid #d7e2ef !important;
    border-radius:14px !important;
    background:#ffffff !important;
    color:#0f172a !important;
    font-size:14px !important;
    font-weight:650 !important;
    box-shadow:inset 0 1px 2px rgba(15,23,42,.02) !important;
}

.page-bg .form-control[readonly]{
    color:#52637a !important;
    background:#f8fafc !important;
}

.input-custom:focus,
.page-bg .form-control:focus,
.page-bg .custom-select:focus{
    border-color:#60a5fa !important;
    box-shadow:0 0 0 4px rgba(37,99,235,.10) !important;
}

.page-bg .input-group-text{
    min-width:52px !important;
    border-color:#d7e2ef !important;
    border-radius:14px 0 0 14px !important;
    color:#2563eb !important;
    background:linear-gradient(180deg,#eff6ff,#f8fbff) !important;
}

/* Import Excel */
.page-bg .d-flex.flex-wrap.align-items-center.justify-content-between{
    margin-bottom:14px !important;
    padding:14px 16px;
    border:1px dashed #bfdbfe;
    border-radius:16px;
    background:#f8fbff;
}

.page-bg .d-flex.flex-wrap.align-items-center.justify-content-between small{
    color:#64748b !important;
    font-size:13px;
}

.page-bg label .btn-outline-primary{
    min-height:42px !important;
    padding:0 17px !important;
    border-radius:12px !important;
    border-color:#93c5fd !important;
    background:#ffffff !important;
    color:#2563eb !important;
}

.page-bg label .btn-outline-primary:hover{
    color:#fff !important;
    background:#2563eb !important;
}

/* Accordion hành khách */
.passenger-accordion-card{
    margin-bottom:14px !important;
    border:1px solid #dce7f3 !important;
    border-radius:19px !important;
    box-shadow:0 10px 26px rgba(15,23,42,.055) !important;
}

.passenger-accordion-header{
    min-height:72px !important;
    padding:17px 20px !important;
    background:linear-gradient(135deg,#ffffff,#f8fbff) !important;
}

.passenger-accordion-header:hover{
    background:#f2f7ff !important;
}

.passenger-body{
    padding:24px 22px !important;
    border-top:1px solid #e5edf6 !important;
    background:#fbfdff !important;
}

/* Cam kết */
#chk_commitment + .custom-control-label{
    max-width:880px;
    color:#334155 !important;
    font-size:14px !important;
    line-height:1.75 !important;
}

#chk_commitment + .custom-control-label::before,
#chk_commitment + .custom-control-label::after{
    top:.16rem;
}

/* Nút tiếp tục */
.btn-checkout{
    min-height:60px !important;
    border-radius:16px !important;
    font-size:15px !important;
    letter-spacing:.1px;
    background:linear-gradient(135deg,#3b82f6,#2563eb 58%,#1d4ed8) !important;
    box-shadow:0 16px 34px rgba(37,99,235,.24) !important;
}

.btn-checkout:hover{
    transform:translateY(-2px) !important;
    box-shadow:0 20px 42px rgba(37,99,235,.30) !important;
}

/* Modal */
#summaryModal .modal-content{
    border-radius:26px !important;
}

#summaryModal .modal-header{
    padding:24px 28px !important;
}

#summaryModal .modal-title{
    font-size:22px !important;
}

#summaryModal .modal-body{
    padding:26px !important;
}

.summary-section-box{
    border-radius:18px !important;
    border-color:#dce7f3 !important;
    box-shadow:0 9px 24px rgba(15,23,42,.05) !important;
}

.summary-section-box.bg-dark{
    background:linear-gradient(135deg,#0f172a 0%,#1e3a8a 100%) !important;
}

/* Desktop: nếu có nhiều lịch giữ 2 cột cân đối */
@media(min-width:768px){
    .section-title + .mb-5.row > [class*="col-md-6"]{
        flex:0 0 50%;
        max-width:50%;
    }

    .section-title + .mb-5.row > [class*="col-md-6"]:only-child{
        flex:0 0 100% !important;
        max-width:100% !important;
    }
}

/* Tablet */
@media(max-width:991px){
    .page-bg > .container{
        width:calc(100% - 26px) !important;
    }

    .tour-info-card .col-md-8{
        padding:26px 28px !important;
    }

    .section-title{
        font-size:19px !important;
    }
}

/* Mobile */
@media(max-width:767px){
    .page-bg{
        padding-top:24px !important;
    }

    .page-bg > .container{
        width:calc(100% - 18px) !important;
    }

    .page-bg .mb-4.text-center{
        padding:24px 18px !important;
        border-radius:22px !important;
    }

    .tour-info-card{
        border-radius:20px !important;
    }

    .tour-info-card .row{
        min-height:0 !important;
    }

    .tour-img{
        min-height:220px !important;
        max-height:250px !important;
    }

    .tour-info-card .col-md-8{
        padding:22px 20px !important;
    }

    .section-title{
        gap:9px !important;
        font-size:18px !important;
    }

    .section-title::before{
        width:auto !important;
        height:28px !important;
        flex:0 0 auto !important;
        padding:0 9px !important;
        border-radius:999px !important;
        font-size:9px !important;
    }

    .section-title::after{
        margin-left:3px;
    }

    .section-title + .mb-5.row > [class*="col-md-6"]{
        flex:0 0 100% !important;
        max-width:100% !important;
    }

    .schedule-card{
        min-height:0 !important;
        padding:17px !important;
    }

    .page-bg .card.border-0.shadow-sm.p-4,
    .page-bg .card.border-0.shadow-sm.p-4.mb-5{
        padding:20px !important;
        border-radius:19px !important;
    }

    .passenger-body{
        padding:18px 16px !important;
    }

    .btn-checkout{
        min-height:56px !important;
        font-size:14px !important;
    }
}

/* Mobile nhỏ */
@media(max-width:480px){
    .page-bg > .container{
        width:calc(100% - 14px) !important;
    }

    .tour-info-card h4.primary-text{
        font-size:25px !important;
    }

    .schedule-card .d-flex.justify-content-between.align-items-center{
        align-items:flex-start !important;
        gap:8px;
        flex-direction:column;
    }

    .schedule-card .badge{
        align-self:flex-start;
    }

    .page-bg .d-flex.flex-wrap.align-items-center.justify-content-between{
        align-items:flex-start !important;
        gap:12px;
        flex-direction:column;
    }
}


/* =========================================================
   RADIO CHỌN LỊCH KHỞI HÀNH - KIỂU HIỆN ĐẠI
   ========================================================= */
.schedule-card .custom-radio,
.schedule-card input[type="radio"].custom-radio{
    -webkit-appearance:none !important;
    appearance:none !important;
    position:relative !important;
    top:0 !important;
    left:0 !important;
    width:24px !important;
    height:24px !important;
    min-width:24px !important;
    min-height:24px !important;
    flex:0 0 24px !important;
    margin:0 !important;
    margin-top:1px !important;
    border:2px solid #bfdbfe !important;
    border-radius:50% !important;
    outline:none !important;
    background:#ffffff !important;
    box-shadow:
        0 3px 10px rgba(15,23,42,.08),
        inset 0 0 0 0 #ffffff !important;
    cursor:pointer !important;
    transition:
        border-color .18s ease,
        box-shadow .18s ease,
        transform .18s ease,
        background .18s ease !important;
}

.schedule-card .custom-radio:hover,
.schedule-card input[type="radio"].custom-radio:hover{
    border-color:#60a5fa !important;
    transform:scale(1.06);
    box-shadow:
        0 0 0 4px rgba(37,99,235,.08),
        0 4px 12px rgba(15,23,42,.09) !important;
}

.schedule-card .custom-radio:focus-visible,
.schedule-card input[type="radio"].custom-radio:focus-visible{
    border-color:#2563eb !important;
    box-shadow:
        0 0 0 4px rgba(37,99,235,.14),
        0 4px 12px rgba(15,23,42,.08) !important;
}

.schedule-card .custom-radio:checked,
.schedule-card input[type="radio"].custom-radio:checked{
    border-color:#2563eb !important;
    background:
        radial-gradient(
            circle at center,
            #2563eb 0 5px,
            #ffffff 5.5px 100%
        ) !important;
    box-shadow:
        0 0 0 4px rgba(37,99,235,.10),
        0 5px 14px rgba(37,99,235,.16) !important;
}

.schedule-card .custom-radio:disabled,
.schedule-card input[type="radio"].custom-radio:disabled{
    border-color:#cbd5e1 !important;
    background:#f1f5f9 !important;
    box-shadow:none !important;
    cursor:not-allowed !important;
    transform:none !important;
}

/* Căn lại hàng chứa radio để radio không dính vào mép card */
.schedule-card > .d-flex.align-items-start{
    gap:16px !important;
    align-items:flex-start !important;
}

.schedule-card > .d-flex.align-items-start > .ml-4{
    margin-left:0 !important;
    flex:1;
    min-width:0;
}

/* Khi lịch được chọn, làm radio và card đồng bộ */
.schedule-card:has(.custom-radio:checked){
    border-color:#60a5fa !important;
}

.schedule-card:has(.custom-radio:checked)::before{
    width:5px !important;
    background:linear-gradient(180deg,#60a5fa,#2563eb) !important;
}

@media(max-width:520px){
    .schedule-card .custom-radio,
    .schedule-card input[type="radio"].custom-radio{
        width:22px !important;
        height:22px !important;
        min-width:22px !important;
        min-height:22px !important;
        flex-basis:22px !important;
    }

    .schedule-card > .d-flex.align-items-start{
        gap:12px !important;
    }
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
document.addEventListener('DOMContentLoaded', function () {


   const priceAdult = {{ $priceAdult }};
const priceChild = {{ $priceChild }};
const tourTitle = {!! $tourTitleJs !!};

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
            elInputDepositPercent.value = selectedDeposit?.value || '100';
        }
    }

    /* =========================================================
       6. TẠO FORM HÀNH KHÁCH
    ========================================================= */

    function getPassengerFormTemplate(index, label, typeValue, isOpen) {

        const collapseClass = isOpen ? 'show' : '';
        const headerClass = isOpen ? '' : 'collapsed';

        const badgeBg =
            typeValue === 'adult'
                ? 'badge-primary'
                : 'badge-info';

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
                passengerIndex,
                'Hành khách',
                'adult',
                isOpen
            );

            passengerIndex++;
        }

        /* Trẻ em */

        for (let i = 0; i < children; i++) {

            const isOpen = passengerIndex === 0;

            formsHTML += getPassengerFormTemplate(
                passengerIndex,
                'Hành khách',
                'child',
                isOpen
            );

            passengerIndex++;
        }

        accordionContainer.innerHTML = formsHTML;
    }

    if (excelFile) {
        excelFile.addEventListener('change', function () {
            const file = this.files[0];
            if (!file) return;

            const formData = new FormData();
            formData.append('file', file);

            fetch('{{ route('Client.import_hanh_khach') }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: formData
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

document.querySelectorAll('.js-error').forEach(function (element) {
    element.remove();
});

document.querySelectorAll('.is-invalid').forEach(function (element) {
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
    parseInt(adultInput?.value);

if (
    !adultInput ||
    isNaN(adults) ||
    adults < 1 ||
    !Number.isInteger(adults)
) {

    return showError(
        adultInput,
        'Số người lớn phải là số nguyên và ít nhất 1 người.'
    );
}


/* =========================================================
   5. SỐ TRẺ EM
   nullable|integer|min:0
========================================================= */

const childInput =
    document.getElementById('qty_child');

const children =
    childInput.value === ''
        ? 0
        : parseInt(childInput.value);

if (
    isNaN(children) ||
    children < 0 ||
    !Number.isInteger(children)
) {

    return showError(
        childInput,
        'Số trẻ em phải là số nguyên từ 0 trở lên.'
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
    let i = 0;
    i < passengerCards.length;
    i++
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
        nameInput?.value.trim() || '';

    if (!name) {

        openPassenger(card);

        return showError(
            nameInput,
            `Hành khách #${i + 1}: Vui lòng nhập họ và tên.`
        );
    }

    if (name.length < 2) {

        openPassenger(card);

        return showError(
            nameInput,
            `Hành khách #${i + 1}: Họ tên phải có ít nhất 2 ký tự.`
        );
    }

    if (name.length > 100) {

        openPassenger(card);

        return showError(
            nameInput,
            `Hành khách #${i + 1}: Họ tên không được vượt quá 100 ký tự.`
        );
    }


    /* =====================================================
       GIỚI TÍNH
       required|in:Nam,Nữ
    ===================================================== */

    const genderInput =
        card.querySelector('.pass-gender');

    const gender =
        genderInput?.value || '';

    if (
        gender !== 'Nam' &&
        gender !== 'Nữ'
    ) {

        openPassenger(card);

        return showError(
            genderInput,
            `Hành khách #${i + 1}: Vui lòng chọn giới tính Nam hoặc Nữ.`
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
dobInput?.value || '';

/* Bắt buộc nhập ngày sinh */

if (!dob) {


openPassenger(card);

return showError(
    dobInput,
    `Hành khách #${i + 1}: Vui lòng nhập ngày sinh.`
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
    dobInput,
    `Hành khách #${i + 1}: Ngày sinh không hợp lệ.`
);


}

/* Không cho ngày sinh hôm nay hoặc tương lai */

if (dobDate >= today) {


openPassenger(card);

return showError(
    dobInput,
    `Hành khách #${i + 1}: Ngày sinh phải trước ngày hôm nay.`
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
card.querySelector('.pass-type')?.value || '';

/* NGƯỜI LỚN */

if (passengerType === 'adult') {


if (age < 12) {

    openPassenger(card);

    return showError(
        dobInput,
        `Hành khách #${i + 1}: Người lớn phải từ 12 tuổi trở lên. Tuổi hiện tại: ${age} tuổi.`
    );
}


}

/* TRẺ EM */

if (passengerType === 'child') {


if (age < 2 || age > 11) {

    openPassenger(card);

    return showError(
        dobInput,
        `Hành khách #${i + 1}: Trẻ em phải từ 2 đến 11 tuổi. Tuổi hiện tại: ${age} tuổi.`
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
        nationInput?.value.trim() || '';

    if (!nation) {

        openPassenger(card);

        return showError(
            nationInput,
            `Hành khách #${i + 1}: Vui lòng nhập quốc tịch.`
        );
    }

    if (nation.length > 100) {

        openPassenger(card);

        return showError(
            nationInput,
            `Hành khách #${i + 1}: Quốc tịch không được vượt quá 100 ký tự.`
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
        docTypeInput?.value || '';

    const validDocTypes = [
        'CCCD',
        'Hộ chiếu',
        'Giấy khai sinh'
    ];

    if (
        !validDocTypes.includes(docType)
    ) {

        openPassenger(card);

        return showError(
            docTypeInput,
            `Hành khách #${i + 1}: Vui lòng chọn loại giấy tờ hợp lệ.`
        );
    }


    /* =====================================================
       SỐ GIẤY TỜ
       required|string|max:30
    ===================================================== */

    const docIdInput =
        card.querySelector('.pass-doc-id');

    const docId =
        docIdInput?.value.trim() || '';

    if (!docId) {

        openPassenger(card);

        return showError(
            docIdInput,
            `Hành khách #${i + 1}: Vui lòng nhập số giấy tờ.`
        );
    }

    if (docId.length > 30) {

        openPassenger(card);

        return showError(
            docIdInput,
            `Hành khách #${i + 1}: Số giấy tờ không được vượt quá 30 ký tự.`
        );
    }

    if (docType === 'CCCD') {
        const cccdRegex = /^\d{12}$/;

        if (!cccdRegex.test(docId)) {
            openPassenger(card);

            return showError(
                docIdInput,
                `Hành khách #${i + 1}: CCCD phải gồm đúng 12 chữ số.`
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
        phoneInput?.value.trim() || '';

    if (phone) {

        const phoneRegex =
            /^(0|\+84)[0-9]{9,10}$/;

        if (!phoneRegex.test(phone)) {

            openPassenger(card);

            return showError(
                phoneInput,
                `Hành khách #${i + 1}: Số điện thoại không đúng định dạng.`
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
        noteInput?.value.trim() || '';

    if (note.length > 500) {

        openPassenger(card);

        return showError(
            noteInput,
            `Hành khách #${i + 1}: Yêu cầu đặc biệt không được vượt quá 500 ký tự.`
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

setTimeout(function () {

    card.scrollIntoView({
        behavior: 'smooth',
        block: 'center'
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

        radio.addEventListener('change', function () {

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

    btnPreviewBooking.addEventListener('click', function (event) {

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
            'click',
            function () {

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
        'change',
        updateBookingDetails
    );

    elQtyChild.addEventListener(
        'change',
        updateBookingDetails
    );

    elQtyAdult.addEventListener(
        'input',
        updateBookingDetails
    );

    elQtyChild.addEventListener(
        'input',
        updateBookingDetails
    );

    /* =========================================================
       13. KHỞI TẠO
    ========================================================= */

    updateBookingDetails();

    console.log('Booking JavaScript đã khởi tạo thành công.');

});
</script>

@endsection