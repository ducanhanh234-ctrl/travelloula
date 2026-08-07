@extends('layouts.app')

@section('title','Chi tiết đặt tour')

@section('content')

@php
    $bookingStatus = match($datTour->trang_thai) {
        'cho_xac_nhan' => [
            'label' => 'Chờ xác nhận',
            'class' => 'status-waiting',
            'icon' => 'fa-clock',
        ],
        'da_xac_nhan' => [
            'label' => 'Đã xác nhận',
            'class' => 'status-confirmed',
            'icon' => 'fa-circle-check',
        ],
        'da_thanh_toan' => [
            'label' => 'Đã thanh toán',
            'class' => 'status-paid',
            'icon' => 'fa-wallet',
        ],
        'da_huy' => [
            'label' => 'Đã hủy',
            'class' => 'status-cancelled',
            'icon' => 'fa-circle-xmark',
        ],
        default => [
            'label' => $datTour->trang_thai,
            'class' => 'status-default',
            'icon' => 'fa-circle-info',
        ],
    };
@endphp

<div class="booking-detail-page">
    <div class="booking-detail-container">

        <div class="booking-topbar">
            <a href="{{ route('tour_da_dat.index') }}" class="back-button">
                <i class="fa-solid fa-arrow-left"></i>
                Quay lại tour đã đặt
            </a>

            <span class="booking-code-top">
                <span>Mã đơn</span>
                <strong>{{ $datTour->ma_dat_tour }}</strong>
            </span>
        </div>

        <section class="booking-detail-hero">
            <div class="hero-copy">
                <span class="hero-kicker">
                    <i class="fa-solid fa-file-invoice"></i>
                    Thông tin đơn hàng
                </span>

                <h1>Chi tiết đặt tour</h1>

                <p>
                    Theo dõi thông tin chuyến đi, trạng thái thanh toán và danh sách
                    hành khách trong đơn đặt tour của bạn.
                </p>
            </div>

            <div class="hero-status {{ $bookingStatus['class'] }}">
                <i class="fa-solid {{ $bookingStatus['icon'] }}"></i>

                <div>
                    <span>Trạng thái hiện tại</span>
                    <strong>{{ $bookingStatus['label'] }}</strong>
                </div>
            </div>
        </section>

        <div class="booking-detail-grid">

            {{-- THÔNG TIN ĐƠN TOUR --}}
            <section class="detail-panel booking-main-panel">
                <div class="panel-heading">
                    <div class="panel-icon">
                        <i class="fa-solid fa-plane-departure"></i>
                    </div>

                    <div>
                        <span>Thông tin chuyến đi</span>
                        <h2>{{ $datTour->tour->ten_tour }}</h2>
                    </div>
                </div>

                <div class="booking-info-list">

                    <div class="booking-info-row">
                        <div class="info-label">
                            <i class="fa-solid fa-hashtag"></i>
                            <span>Mã đặt tour</span>
                        </div>

                        <strong class="booking-code-value">
                            {{ $datTour->ma_dat_tour }}
                        </strong>
                    </div>

                    <div class="booking-info-row">
                        <div class="info-label">
                            <i class="fa-regular fa-calendar-days"></i>
                            <span>Ngày khởi hành</span>
                        </div>

                        <strong>
                            {{ \Carbon\Carbon::parse($datTour->lichKhoiHanh->ngay_khoi_hanh)->format('d/m/Y') }}
                        </strong>
                    </div>

                    <div class="booking-info-row">
                        <div class="info-label">
                            <i class="fa-solid fa-flag-checkered"></i>
                            <span>Ngày kết thúc</span>
                        </div>

                        <strong>
                            {{ \Carbon\Carbon::parse($datTour->lichKhoiHanh->ngay_ket_thuc)->format('d/m/Y') }}
                        </strong>
                    </div>

                    <div class="booking-info-row">
                        <div class="info-label">
                            <i class="fa-solid fa-user"></i>
                            <span>Người lớn</span>
                        </div>

                        <strong>{{ $datTour->so_nguoi_lon }} người</strong>
                    </div>

                    <div class="booking-info-row">
                        <div class="info-label">
                            <i class="fa-solid fa-child-reaching"></i>
                            <span>Trẻ em</span>
                        </div>

                        <strong>{{ $datTour->so_tre_em }} người</strong>
                    </div>

                </div>

                <div class="booking-total-box">
                    <div>
                        <span>Tổng giá trị đơn</span>
                        <small>Giá trị toàn bộ chuyến đi</small>
                    </div>

                    <strong>
                        {{ number_format($datTour->tong_tien, 0, ',', '.') }}đ
                    </strong>
                </div>
            </section>

            {{-- THÔNG TIN THANH TOÁN --}}
            <section class="detail-panel payment-panel">
                <div class="panel-heading">
                    <div class="panel-icon payment-icon">
                        <i class="fa-solid fa-credit-card"></i>
                    </div>

                    <div>
                        <span>Giao dịch</span>
                        <h2>Thông tin thanh toán</h2>
                    </div>
                </div>

                @if($datTour->thanhToans && $datTour->thanhToans->count())
                    <div class="payment-list">
                        @foreach($datTour->thanhToans as $index => $thanhToan)
                            @php
                                $paymentStatus = match($thanhToan->trang_thai) {
                                    'cho_thanh_toan' => [
                                        'label' => 'Chờ thanh toán',
                                        'class' => 'payment-waiting',
                                        'icon' => 'fa-clock',
                                    ],
                                    'da_xac_nhan' => [
                                        'label' => 'Đã xác nhận',
                                        'class' => 'payment-confirmed',
                                        'icon' => 'fa-circle-check',
                                    ],
                                    'da_thanh_toan' => [
                                        'label' => 'Đã thanh toán',
                                        'class' => 'payment-paid',
                                        'icon' => 'fa-wallet',
                                    ],
                                    'da_huy' => [
                                        'label' => 'Đã hủy',
                                        'class' => 'payment-cancelled',
                                        'icon' => 'fa-circle-xmark',
                                    ],
                                    'dat_coc' => [
                                        'label' => 'Đặt cọc',
                                        'class' => 'payment-deposit',
                                        'icon' => 'fa-coins',
                                    ],
                                    default => [
                                        'label' => $thanhToan->trang_thai,
                                        'class' => 'payment-default',
                                        'icon' => 'fa-circle-info',
                                    ],
                                };
                            @endphp

                            <div class="payment-item">
                                <div class="payment-item-index">
                                    {{ $index + 1 }}
                                </div>

                                <div class="payment-item-info">
                                    <span>Giao dịch #{{ $index + 1 }}</span>
                                    <strong>Thanh toán tour</strong>
                                </div>

                                <span class="payment-status {{ $paymentStatus['class'] }}">
                                    <i class="fa-solid {{ $paymentStatus['icon'] }}"></i>
                                    {{ $paymentStatus['label'] }}
                                </span>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="payment-empty">
                        <div>
                            <i class="fa-regular fa-credit-card"></i>
                        </div>

                        <h3>Chưa có thông tin thanh toán</h3>

                        <p>
                            Khi phát sinh giao dịch, trạng thái thanh toán sẽ được
                            hiển thị tại khu vực này.
                        </p>
                    </div>
                @endif
            </section>
        </div>

        {{-- DANH SÁCH HÀNH KHÁCH --}}
        <section class="detail-panel passenger-panel">
            <div class="passenger-panel-head">
                <div class="panel-heading">
                    <div class="panel-icon passenger-icon">
                        <i class="fa-solid fa-users"></i>
                    </div>

                    <div>
                        <span>Hành khách</span>
                        <h2>Danh sách khách</h2>
                    </div>
                </div>

                <span class="passenger-total-badge">
                    {{ $datTour->khachHangs->count() }} hành khách
                </span>
            </div>

            @if($datTour->khachHangs->count())
                <div class="passenger-table-wrap">
                    <table class="passenger-table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Họ và tên</th>
                                <th>Ngày sinh</th>
                                <th>Giới tính</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach($datTour->khachHangs as $index => $khach)
                                <tr>
                                    <td>
                                        <span class="passenger-number">
                                            {{ $index + 1 }}
                                        </span>
                                    </td>

                                    <td>
                                        <div class="passenger-name">
                                            <span class="passenger-avatar">
                                                {{ mb_strtoupper(mb_substr($khach->ho_ten ?? 'K', 0, 1)) }}
                                            </span>

                                            <strong>{{ $khach->ho_ten }}</strong>
                                        </div>
                                    </td>

                                    <td>
                                        {{ $khach->ngay_sinh }}
                                    </td>

                                    <td>
                                        <span class="gender-badge">
                                            {{ $khach->gioi_tinh }}
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="passenger-empty">
                    <i class="fa-regular fa-user"></i>
                    <span>Không có danh sách khách.</span>
                </div>
            @endif
        </section>

        @if($datTour->trang_thai != 'da_thanh_toan')
            <section class="danger-zone">
                <div>
                    <span>Quản lý đơn</span>
                    <h3>Bạn cần hủy chuyến đi?</h3>
                    <p>
                        Hãy kiểm tra lại thông tin và chính sách hủy tour trước khi
                        thực hiện thao tác này.
                    </p>
                </div>

                <form
                    action="{{ route('tour_da_dat.destroy', $datTour->id) }}"
                    method="POST"
                    onsubmit="return confirm('Bạn có chắc chắn muốn hủy tour?')"
                >
                    @csrf
                    @method('DELETE')

                    <button type="submit" class="cancel-tour-button">
                        <i class="fa-regular fa-trash-can"></i>
                        Hủy tour
                    </button>
                </form>
            </section>
        @endif

    </div>
</div>

<style>
:root{
    --bd-primary:#2563eb;
    --bd-primary-dark:#1d4ed8;
    --bd-primary-light:#3b82f6;
    --bd-primary-soft:#eff6ff;
    --bd-cyan:#38bdf8;
    --bd-text:#0f172a;
    --bd-text-soft:#334155;
    --bd-muted:#64748b;
    --bd-line:#dbe5f1;
    --bd-white:#ffffff;
    --bd-green:#059669;
    --bd-red:#dc2626;
    --bd-orange:#d97706;
}

.booking-detail-page{
    min-height:100vh;
    padding:clamp(38px,5vw,76px) 0 clamp(70px,6vw,110px);
    color:var(--bd-text);
    background:
        radial-gradient(circle at 7% 2%,rgba(37,99,235,.10),transparent 27%),
        radial-gradient(circle at 94% 7%,rgba(56,189,248,.08),transparent 24%),
        linear-gradient(180deg,#ffffff 0%,#f8fbff 45%,#f3f8ff 100%);
}

.booking-detail-container{
    width:min(1440px,calc(100% - 40px));
    margin:0 auto;
}

/* TOP BAR */
.booking-topbar{
    margin-bottom:18px;
    display:flex;
    align-items:center;
    justify-content:space-between;
    gap:18px;
}

.back-button{
    min-height:44px;
    padding:0 15px;
    border:1px solid #d7e2ef;
    border-radius:13px;
    display:inline-flex;
    align-items:center;
    justify-content:center;
    gap:8px;
    color:#334155;
    background:#ffffff;
    text-decoration:none;
    font-size:13px;
    font-weight:900;
    box-shadow:0 8px 20px rgba(15,23,42,.06);
    transition:.2s ease;
}

.back-button:hover{
    color:#ffffff;
    border-color:var(--bd-primary);
    background:var(--bd-primary);
    transform:translateY(-2px);
    box-shadow:0 11px 24px rgba(37,99,235,.17);
}

.booking-code-top{
    display:flex;
    align-items:center;
    gap:8px;
    color:var(--bd-muted);
    font-size:12px;
    font-weight:800;
}

.booking-code-top strong{
    padding:7px 10px;
    border:1px solid #bfdbfe;
    border-radius:10px;
    color:var(--bd-primary-dark);
    background:#eff6ff;
    font-size:13px;
    font-weight:1000;
}

/* HERO */
.booking-detail-hero{
    position:relative;
    overflow:hidden;
    min-height:230px;
    margin-bottom:28px;
    padding:clamp(30px,4vw,50px);
    border:1px solid #dbeafe;
    border-radius:30px;
    display:flex;
    align-items:center;
    justify-content:space-between;
    gap:30px;
    background:
        radial-gradient(circle at 10% 15%,rgba(59,130,246,.14),transparent 30%),
        linear-gradient(135deg,#ffffff 0%,#f5f9ff 66%,#eef7ff 100%);
    box-shadow:
        0 22px 58px rgba(37,99,235,.10),
        inset 0 1px 0 rgba(255,255,255,.94);
}

.booking-detail-hero::after{
    content:"";
    position:absolute;
    width:260px;
    height:260px;
    right:-80px;
    top:-110px;
    border-radius:50%;
    background:rgba(56,189,248,.10);
    pointer-events:none;
}

.hero-copy{
    position:relative;
    z-index:1;
}

.hero-kicker{
    display:inline-flex;
    align-items:center;
    gap:8px;
    margin-bottom:14px;
    padding:8px 13px;
    border:1px solid #bfdbfe;
    border-radius:999px;
    color:var(--bd-primary);
    background:#ffffff;
    font-size:12px;
    font-weight:900;
}

.booking-detail-hero h1{
    margin:0;
    color:var(--bd-text);
    font-size:clamp(34px,4vw,54px);
    line-height:1.04;
    font-weight:1000;
    letter-spacing:-1.6px;
}

.booking-detail-hero p{
    max-width:760px;
    margin:15px 0 0;
    color:var(--bd-muted);
    font-size:16px;
    line-height:1.75;
    font-weight:600;
}

.hero-status{
    position:relative;
    z-index:1;
    min-width:220px;
    padding:20px;
    border-radius:22px;
    display:flex;
    align-items:center;
    gap:13px;
    box-shadow:0 14px 32px rgba(15,23,42,.07);
}

.hero-status > i{
    width:46px;
    height:46px;
    flex:0 0 46px;
    border-radius:15px;
    display:grid;
    place-items:center;
    background:rgba(255,255,255,.75);
    font-size:18px;
}

.hero-status span{
    display:block;
    margin-bottom:3px;
    font-size:11px;
    font-weight:800;
    opacity:.72;
    text-transform:uppercase;
    letter-spacing:.4px;
}

.hero-status strong{
    display:block;
    font-size:15px;
    font-weight:1000;
}

.status-waiting{
    color:#a16207;
    border:1px solid #fde68a;
    background:#fefce8;
}

.status-confirmed{
    color:#0369a1;
    border:1px solid #bae6fd;
    background:#f0f9ff;
}

.status-paid{
    color:#047857;
    border:1px solid #a7f3d0;
    background:#ecfdf5;
}

.status-cancelled{
    color:#b91c1c;
    border:1px solid #fecaca;
    background:#fef2f2;
}

.status-default{
    color:#475569;
    border:1px solid #e2e8f0;
    background:#f8fafc;
}

/* GRID */
.booking-detail-grid{
    display:grid;
    grid-template-columns:minmax(0,1.15fr) minmax(380px,.85fr);
    gap:24px;
    align-items:stretch;
}

/* PANEL */
.detail-panel{
    border:1px solid #dde7f2;
    border-radius:25px;
    background:#ffffff;
    box-shadow:
        0 18px 48px rgba(15,23,42,.075),
        0 4px 12px rgba(37,99,235,.035);
}

.booking-main-panel,
.payment-panel{
    padding:25px;
}

.panel-heading{
    display:flex;
    align-items:center;
    gap:13px;
}

.panel-icon{
    width:48px;
    height:48px;
    flex:0 0 48px;
    border-radius:15px;
    display:grid;
    place-items:center;
    color:#ffffff;
    background:linear-gradient(135deg,#60a5fa,#2563eb);
    box-shadow:0 10px 22px rgba(37,99,235,.20);
    font-size:18px;
}

.panel-icon.payment-icon{
    background:linear-gradient(135deg,#38bdf8,#2563eb);
}

.panel-icon.passenger-icon{
    background:linear-gradient(135deg,#818cf8,#2563eb);
}

.panel-heading span{
    display:block;
    margin-bottom:3px;
    color:var(--bd-primary);
    font-size:10px;
    font-weight:900;
    text-transform:uppercase;
    letter-spacing:.8px;
}

.panel-heading h2{
    margin:0;
    color:var(--bd-text);
    font-size:21px;
    line-height:1.3;
    font-weight:1000;
    letter-spacing:-.45px;
}

/* INFO LIST */
.booking-info-list{
    margin-top:22px;
    overflow:hidden;
    border:1px solid #e4ecf5;
    border-radius:18px;
}

.booking-info-row{
    min-height:58px;
    padding:13px 16px;
    border-bottom:1px solid #e8eef6;
    display:flex;
    align-items:center;
    justify-content:space-between;
    gap:20px;
    background:#ffffff;
}

.booking-info-row:last-child{
    border-bottom:0;
}

.booking-info-row:nth-child(even){
    background:#fbfdff;
}

.info-label{
    min-width:0;
    display:flex;
    align-items:center;
    gap:10px;
    color:#64748b;
    font-size:13px;
    font-weight:750;
}

.info-label i{
    width:31px;
    height:31px;
    flex:0 0 31px;
    border-radius:10px;
    display:grid;
    place-items:center;
    color:var(--bd-primary);
    background:#eff6ff;
    font-size:12px;
}

.booking-info-row > strong{
    color:#334155;
    font-size:14px;
    line-height:1.45;
    font-weight:900;
    text-align:right;
}

.booking-code-value{
    padding:6px 9px;
    border-radius:9px;
    color:var(--bd-primary-dark) !important;
    background:#eff6ff;
}

.booking-total-box{
    margin-top:18px;
    padding:17px 18px;
    border:1px solid #dbeafe;
    border-radius:18px;
    display:flex;
    align-items:center;
    justify-content:space-between;
    gap:20px;
    background:linear-gradient(135deg,#eff6ff,#ffffff);
}

.booking-total-box span{
    display:block;
    color:#334155;
    font-size:13px;
    font-weight:900;
}

.booking-total-box small{
    display:block;
    margin-top:3px;
    color:#94a3b8;
    font-size:11px;
    font-weight:700;
}

.booking-total-box > strong{
    color:#ef4444;
    font-size:27px;
    line-height:1.1;
    font-weight:1000;
    letter-spacing:-.5px;
}

/* PAYMENT */
.payment-list{
    margin-top:22px;
    display:grid;
    gap:11px;
}

.payment-item{
    padding:13px;
    border:1px solid #e3ebf5;
    border-radius:16px;
    display:grid;
    grid-template-columns:auto minmax(0,1fr) auto;
    align-items:center;
    gap:11px;
    background:linear-gradient(135deg,#ffffff,#f8fbff);
}

.payment-item-index{
    width:36px;
    height:36px;
    border-radius:12px;
    display:grid;
    place-items:center;
    color:#2563eb;
    background:#eff6ff;
    font-size:12px;
    font-weight:1000;
}

.payment-item-info span{
    display:block;
    margin-bottom:2px;
    color:#94a3b8;
    font-size:10px;
    font-weight:800;
    text-transform:uppercase;
    letter-spacing:.35px;
}

.payment-item-info strong{
    color:#334155;
    font-size:13px;
    font-weight:900;
}

.payment-status{
    min-height:31px;
    padding:0 10px;
    border:1px solid transparent;
    border-radius:999px;
    display:inline-flex;
    align-items:center;
    justify-content:center;
    gap:6px;
    white-space:nowrap;
    font-size:10px;
    font-weight:900;
}

.payment-waiting{
    color:#a16207;
    background:#fefce8;
    border-color:#fde68a;
}

.payment-confirmed{
    color:#0369a1;
    background:#f0f9ff;
    border-color:#bae6fd;
}

.payment-paid,
.payment-deposit{
    color:#047857;
    background:#ecfdf5;
    border-color:#a7f3d0;
}

.payment-cancelled{
    color:#b91c1c;
    background:#fef2f2;
    border-color:#fecaca;
}

.payment-default{
    color:#475569;
    background:#f8fafc;
    border-color:#e2e8f0;
}

.payment-empty{
    margin-top:22px;
    padding:40px 20px;
    border:1px dashed #bfdbfe;
    border-radius:19px;
    text-align:center;
    background:#f8fbff;
}

.payment-empty > div{
    width:58px;
    height:58px;
    margin:0 auto 13px;
    border-radius:18px;
    display:grid;
    place-items:center;
    color:#2563eb;
    background:#eff6ff;
    font-size:22px;
}

.payment-empty h3{
    margin:0 0 6px;
    color:#334155;
    font-size:16px;
    font-weight:1000;
}

.payment-empty p{
    max-width:390px;
    margin:0 auto;
    color:#64748b;
    font-size:12px;
    line-height:1.65;
}

/* PASSENGER PANEL */
.passenger-panel{
    margin-top:24px;
    padding:25px;
}

.passenger-panel-head{
    margin-bottom:21px;
    display:flex;
    align-items:center;
    justify-content:space-between;
    gap:20px;
}

.passenger-total-badge{
    min-height:34px;
    padding:0 12px;
    border:1px solid #bfdbfe;
    border-radius:999px;
    display:inline-flex;
    align-items:center;
    color:#2563eb;
    background:#eff6ff;
    font-size:11px;
    font-weight:900;
}

.passenger-table-wrap{
    overflow-x:auto;
    border:1px solid #e2eaf4;
    border-radius:18px;
}

.passenger-table{
    width:100%;
    margin:0;
    border-collapse:collapse;
}

.passenger-table th{
    padding:13px 15px;
    border-bottom:1px solid #dbe5f1;
    color:#475569;
    background:#f1f6ff;
    font-size:11px;
    font-weight:900;
    text-transform:uppercase;
    letter-spacing:.35px;
    text-align:left;
    white-space:nowrap;
}

.passenger-table td{
    padding:14px 15px;
    border-bottom:1px solid #edf2f7;
    color:#475569;
    font-size:13px;
    vertical-align:middle;
}

.passenger-table tbody tr:last-child td{
    border-bottom:0;
}

.passenger-table tbody tr:hover{
    background:#fbfdff;
}

.passenger-number{
    width:31px;
    height:31px;
    border-radius:10px;
    display:grid;
    place-items:center;
    color:#2563eb;
    background:#eff6ff;
    font-size:11px;
    font-weight:1000;
}

.passenger-name{
    display:flex;
    align-items:center;
    gap:10px;
}

.passenger-avatar{
    width:35px;
    height:35px;
    flex:0 0 35px;
    border-radius:50%;
    display:grid;
    place-items:center;
    color:#ffffff;
    background:linear-gradient(135deg,#60a5fa,#2563eb);
    font-size:12px;
    font-weight:1000;
}

.passenger-name strong{
    color:#334155;
    font-size:13px;
    font-weight:900;
}

.gender-badge{
    min-height:29px;
    padding:0 10px;
    border:1px solid #dbeafe;
    border-radius:999px;
    display:inline-flex;
    align-items:center;
    color:#2563eb;
    background:#f8fbff;
    font-size:10px;
    font-weight:900;
}

.passenger-empty{
    padding:36px 20px;
    border:1px dashed #bfdbfe;
    border-radius:18px;
    display:flex;
    align-items:center;
    justify-content:center;
    gap:9px;
    color:#64748b;
    background:#f8fbff;
    font-size:13px;
    font-weight:800;
}

/* DANGER */
.danger-zone{
    margin-top:24px;
    padding:20px 22px;
    border:1px solid #fecaca;
    border-radius:22px;
    display:flex;
    align-items:center;
    justify-content:space-between;
    gap:24px;
    background:linear-gradient(135deg,#fffafa,#ffffff);
    box-shadow:0 12px 30px rgba(220,38,38,.045);
}

.danger-zone span{
    display:block;
    margin-bottom:3px;
    color:#dc2626;
    font-size:10px;
    font-weight:900;
    text-transform:uppercase;
    letter-spacing:.7px;
}

.danger-zone h3{
    margin:0 0 4px;
    color:#7f1d1d;
    font-size:17px;
    font-weight:1000;
}

.danger-zone p{
    margin:0;
    color:#64748b;
    font-size:12px;
    line-height:1.6;
}

.cancel-tour-button{
    min-height:44px;
    padding:0 16px;
    border:1px solid #fecaca;
    border-radius:13px;
    display:inline-flex;
    align-items:center;
    justify-content:center;
    gap:8px;
    white-space:nowrap;
    color:#dc2626;
    background:#ffffff;
    font-family:inherit;
    font-size:12px;
    font-weight:900;
    cursor:pointer;
    transition:.2s ease;
}

.cancel-tour-button:hover{
    color:#ffffff;
    border-color:#dc2626;
    background:#dc2626;
    transform:translateY(-2px);
    box-shadow:0 10px 22px rgba(220,38,38,.16);
}

/* RESPONSIVE */
@media(max-width:1050px){
    .booking-detail-grid{
        grid-template-columns:1fr;
    }

    .payment-panel{
        min-height:0;
    }
}

@media(max-width:768px){
    .booking-detail-page{
        padding-top:26px;
    }

    .booking-detail-container{
        width:calc(100% - 20px);
    }

    .booking-topbar{
        align-items:flex-start;
        flex-direction:column;
    }

    .booking-detail-hero{
        align-items:flex-start;
        flex-direction:column;
        border-radius:24px;
    }

    .hero-status{
        width:100%;
        min-width:0;
    }

    .booking-main-panel,
    .payment-panel,
    .passenger-panel{
        padding:19px;
        border-radius:21px;
    }

    .booking-info-row{
        align-items:flex-start;
        flex-direction:column;
        gap:8px;
    }

    .booking-info-row > strong{
        width:100%;
        padding-left:41px;
        text-align:left;
    }

    .booking-total-box{
        align-items:flex-start;
        flex-direction:column;
    }

    .payment-item{
        grid-template-columns:auto minmax(0,1fr);
    }

    .payment-status{
        grid-column:2;
        justify-self:start;
    }

    .passenger-panel-head{
        align-items:flex-start;
        flex-direction:column;
    }

    .danger-zone{
        align-items:flex-start;
        flex-direction:column;
    }

    .danger-zone form,
    .cancel-tour-button{
        width:100%;
    }
}

@media(max-width:520px){
    .booking-detail-container{
        width:calc(100% - 14px);
    }

    .booking-detail-hero{
        padding:25px 18px;
    }

    .booking-detail-hero h1{
        font-size:34px;
    }

    .panel-heading{
        align-items:flex-start;
    }

    .panel-icon{
        width:43px;
        height:43px;
        flex-basis:43px;
        border-radius:13px;
    }

    .panel-heading h2{
        font-size:19px;
    }

    .booking-total-box > strong{
        font-size:24px;
    }

    .passenger-table{
        min-width:640px;
    }
}
</style>

@endsection