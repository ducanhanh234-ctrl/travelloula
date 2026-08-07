@extends('layouts.app')

@section('title', 'Tour đã đặt - Travelloula')

@section('content')

<div class="booked-tour-page">
    <div class="booked-tour-container">

        <section class="booked-tour-hero">
            <div>
                <span class="booked-tour-kicker">
                    <i class="fa-solid fa-suitcase-rolling"></i>
                    Hành trình của bạn
                </span>

                <h1>Tour đã đặt</h1>

                <p>
                    Theo dõi lịch khởi hành, trạng thái đơn hàng và các khoản thanh toán
                    của những chuyến đi bạn đã đăng ký.
                </p>
            </div>

            <div class="booked-tour-summary">
                <span>Tổng đơn</span>
                <strong>{{ $datTours->count() }}</strong>
                <small>đơn đặt tour</small>
            </div>
        </section>

        @if(session('success'))
            <div class="booking-alert booking-alert-success">
                <i class="fa-solid fa-circle-check"></i>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        @if(session('error'))
            <div class="booking-alert booking-alert-error">
                <i class="fa-solid fa-circle-exclamation"></i>
                <span>{{ session('error') }}</span>
            </div>
        @endif

        <div class="booked-tour-list">
            @forelse($datTours as $booking)

                @php
                    $statusConfig = match($booking->trang_thai) {
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
                        default => [
                            'label' => 'Đã hủy',
                            'class' => 'status-cancelled',
                            'icon' => 'fa-circle-xmark',
                        ],
                    };
                @endphp

                <article class="booked-tour-card">

                    <header class="booked-tour-card-head">
                        <div class="booking-code">
                            <span>Mã đặt tour</span>
                            <strong>{{ $booking->ma_dat_tour }}</strong>
                        </div>

                        <span class="booking-status {{ $statusConfig['class'] }}">
                            <i class="fa-solid {{ $statusConfig['icon'] }}"></i>
                            {{ $statusConfig['label'] }}
                        </span>
                    </header>

                    <div class="booked-tour-card-body">
                        <div class="booked-tour-image">
                            @if($booking->tour->anh_dai_dien)
                                <img
                                    src="{{ asset($booking->tour->anh_dai_dien) }}"
                                    alt="{{ $booking->tour->ten_tour }}"
                                >
                            @else
                                <img
                                    src="https://placehold.co/800x520?text=Travelloula"
                                    alt="{{ $booking->tour->ten_tour }}"
                                >
                            @endif

                            <div class="image-overlay-label">
                                <i class="fa-solid fa-plane-departure"></i>
                                Travelloula
                            </div>
                        </div>

                        <div class="booked-tour-info">
                            <div class="tour-name-row">
                                <div>
                                    <span class="tour-mini-label">Chuyến đi của bạn</span>
                                    <h2>{{ $booking->tour->ten_tour }}</h2>
                                </div>
                            </div>

                            <div class="booking-info-grid">
                                <div class="booking-info-item">
                                    <span class="info-icon">
                                        <i class="fa-regular fa-calendar-days"></i>
                                    </span>

                                    <div>
                                        <small>Khởi hành</small>
                                        <strong>
                                            {{ optional($booking->lichKhoiHanh)->ngay_khoi_hanh ?? 'Đang cập nhật' }}
                                        </strong>
                                    </div>
                                </div>

                                <div class="booking-info-item">
                                    <span class="info-icon">
                                        <i class="fa-regular fa-user"></i>
                                    </span>

                                    <div>
                                        <small>Người đặt</small>
                                        <strong>{{ $booking->nguoiDung->name }}</strong>
                                    </div>
                                </div>

                                <div class="booking-info-item">
                                    <span class="info-icon">
                                        <i class="fa-solid fa-phone"></i>
                                    </span>

                                    <div>
                                        <small>Số điện thoại</small>
                                        <strong>{{ $booking->nguoiDung->phone ?: 'Chưa cập nhật' }}</strong>
                                    </div>
                                </div>

                                <div class="booking-info-item">
                                    <span class="info-icon">
                                        <i class="fa-regular fa-envelope"></i>
                                    </span>

                                    <div>
                                        <small>Email</small>
                                        <strong>{{ $booking->nguoiDung->email }}</strong>
                                    </div>
                                </div>
                            </div>

                            <div class="passenger-summary">
                                <div class="passenger-summary-icon">
                                    <i class="fa-solid fa-users"></i>
                                </div>

                                <div>
                                    <span>Số lượng hành khách</span>

                                    <div class="passenger-counts">
                                        <strong>{{ $booking->so_nguoi_lon }} người lớn</strong>
                                        <i></i>
                                        <strong>{{ $booking->so_tre_em }} trẻ em</strong>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <footer class="booked-tour-card-footer">
                        <div class="booking-payment">
                            <span>Tổng giá trị đơn</span>
                            <strong class="booking-total">
                                {{ number_format($booking->tong_tien, 0, ',', '.') }}đ
                            </strong>

                            <div class="paid-amount">
                                <i class="fa-solid fa-circle-check"></i>
                                Đã thanh toán:
                                <strong>
                                    {{ number_format($booking->so_tien_da_thanh_toan, 0, ',', '.') }}đ
                                </strong>
                            </div>
                        </div>

                        <div class="booking-actions">
                            <a
                                href="{{ route('tour_da_dat.show', $booking->id) }}"
                                class="booking-action booking-action-detail"
                            >
                                <i class="fa-regular fa-eye"></i>
                                Chi tiết
                            </a>

                            @if(
                                $booking->so_tien_da_thanh_toan == 0
                                &&
                                $booking->trang_thai == 'cho_xac_nhan'
                            )
                                <span class="booking-action booking-action-payment">
                                    <i class="fa-solid fa-credit-card"></i>
                                    Thanh toán đặt cọc
                                </span>
                            @endif

                            @if(
                                $booking->so_tien_da_thanh_toan > 0
                                &&
                                $booking->so_tien_con_lai > 0
                            )
                                <span class="booking-action booking-action-payment">
                                    <i class="fa-solid fa-wallet"></i>
                                    Thanh toán phần còn lại
                                </span>
                            @endif

                            <form
                                action="{{ route('tour_da_dat.destroy', $booking->id) }}"
                                method="POST"
                                class="cancel-booking-form"
                                onsubmit="return confirm('Bạn có chắc chắn muốn hủy tour?')"
                            >
                                @csrf
                                @method('DELETE')

                                <button type="submit" class="booking-action booking-action-cancel">
                                    <i class="fa-regular fa-trash-can"></i>
                                    Hủy tour
                                </button>
                            </form>
                        </div>
                    </footer>

                </article>

            @empty
                <div class="booked-tour-empty">
                    <div class="empty-icon">
                        <i class="fa-solid fa-suitcase"></i>
                    </div>

                    <h2>Bạn chưa đặt tour nào</h2>

                    <p>
                        Những chuyến đi bạn đặt tại Travelloula sẽ được hiển thị và
                        quản lý tại đây.
                    </p>

                    <a href="{{ route('Client.danh_sach_tour.index') }}">
                        <i class="fa-solid fa-compass"></i>
                        Khám phá tour
                    </a>
                </div>
            @endforelse
        </div>

    </div>
</div>

<style>
:root{
    --bt-primary:#2563eb;
    --bt-primary-dark:#1d4ed8;
    --bt-primary-light:#3b82f6;
    --bt-primary-soft:#eff6ff;
    --bt-cyan:#38bdf8;
    --bt-text:#0f172a;
    --bt-text-soft:#334155;
    --bt-muted:#64748b;
    --bt-line:#dbe5f1;
    --bt-white:#ffffff;
    --bt-green:#059669;
    --bt-red:#dc2626;
    --bt-orange:#d97706;
}

.booked-tour-page{
    min-height:100vh;
    padding:clamp(44px,5vw,82px) 0 clamp(70px,6vw,110px);
    color:var(--bt-text);
    background:
        radial-gradient(circle at 7% 2%,rgba(37,99,235,.10),transparent 28%),
        radial-gradient(circle at 94% 8%,rgba(56,189,248,.08),transparent 25%),
        linear-gradient(180deg,#ffffff 0%,#f8fbff 42%,#f3f8ff 100%);
}

.booked-tour-container{
    width:min(1440px,calc(100% - 40px));
    margin:0 auto;
}

/* HERO */
.booked-tour-hero{
    position:relative;
    overflow:hidden;
    min-height:230px;
    margin-bottom:34px;
    padding:clamp(30px,4vw,52px);
    border:1px solid #dbeafe;
    border-radius:32px;
    display:flex;
    align-items:center;
    justify-content:space-between;
    gap:28px;
    background:
        radial-gradient(circle at 12% 18%,rgba(59,130,246,.14),transparent 30%),
        linear-gradient(135deg,#ffffff 0%,#f5f9ff 65%,#eef7ff 100%);
    box-shadow:
        0 24px 64px rgba(37,99,235,.10),
        inset 0 1px 0 rgba(255,255,255,.95);
}

.booked-tour-hero::after{
    content:"";
    position:absolute;
    width:260px;
    height:260px;
    right:-80px;
    top:-120px;
    border-radius:50%;
    background:rgba(56,189,248,.10);
    pointer-events:none;
}

.booked-tour-kicker{
    position:relative;
    z-index:1;
    display:inline-flex;
    align-items:center;
    gap:8px;
    margin-bottom:14px;
    padding:8px 13px;
    border:1px solid #bfdbfe;
    border-radius:999px;
    color:var(--bt-primary);
    background:#ffffff;
    font-size:12px;
    font-weight:900;
    letter-spacing:.35px;
}

.booked-tour-hero h1{
    position:relative;
    z-index:1;
    margin:0;
    color:var(--bt-text);
    font-size:clamp(34px,4vw,54px);
    line-height:1.05;
    font-weight:1000;
    letter-spacing:-1.6px;
}

.booked-tour-hero p{
    position:relative;
    z-index:1;
    max-width:760px;
    margin:15px 0 0;
    color:var(--bt-muted);
    font-size:16px;
    line-height:1.75;
    font-weight:600;
}

.booked-tour-summary{
    position:relative;
    z-index:1;
    min-width:170px;
    padding:24px;
    border:1px solid rgba(255,255,255,.88);
    border-radius:24px;
    text-align:center;
    background:rgba(255,255,255,.82);
    backdrop-filter:blur(12px);
    box-shadow:0 16px 38px rgba(37,99,235,.10);
}

.booked-tour-summary span,
.booked-tour-summary small{
    display:block;
    color:var(--bt-muted);
    font-size:12px;
    font-weight:800;
}

.booked-tour-summary strong{
    display:block;
    margin:5px 0;
    color:var(--bt-primary);
    font-size:42px;
    line-height:1;
    font-weight:1000;
}

/* ALERT */
.booking-alert{
    margin-bottom:22px;
    padding:15px 17px;
    border-radius:16px;
    display:flex;
    align-items:center;
    gap:10px;
    font-size:14px;
    font-weight:800;
}

.booking-alert-success{
    color:#047857;
    background:#ecfdf5;
    border:1px solid #a7f3d0;
}

.booking-alert-error{
    color:#b91c1c;
    background:#fef2f2;
    border:1px solid #fecaca;
}

/* LIST */
.booked-tour-list{
    display:grid;
    gap:26px;
}

/* CARD */
.booked-tour-card{
    overflow:hidden;
    border:1px solid #dce7f3;
    border-radius:28px;
    background:#ffffff;
    box-shadow:
        0 20px 54px rgba(15,23,42,.08),
        0 4px 14px rgba(37,99,235,.04);
    transition:transform .25s ease,box-shadow .25s ease,border-color .25s ease;
}

.booked-tour-card:hover{
    transform:translateY(-4px);
    border-color:#bfdbfe;
    box-shadow:
        0 28px 68px rgba(15,23,42,.12),
        0 8px 20px rgba(37,99,235,.06);
}

.booked-tour-card-head{
    min-height:66px;
    padding:15px 22px;
    border-bottom:1px solid #e5edf6;
    display:flex;
    align-items:center;
    justify-content:space-between;
    gap:16px;
    background:
        linear-gradient(135deg,#ffffff,#f8fbff);
}

.booking-code{
    display:flex;
    align-items:center;
    gap:10px;
    flex-wrap:wrap;
}

.booking-code span{
    color:var(--bt-muted);
    font-size:13px;
    font-weight:750;
}

.booking-code strong{
    padding:7px 11px;
    border:1px solid #bfdbfe;
    border-radius:10px;
    color:var(--bt-primary-dark);
    background:#eff6ff;
    font-size:14px;
    font-weight:1000;
    letter-spacing:.25px;
}

.booking-status{
    min-height:34px;
    padding:0 12px;
    border-radius:999px;
    display:inline-flex;
    align-items:center;
    justify-content:center;
    gap:7px;
    white-space:nowrap;
    font-size:12px;
    font-weight:900;
}

.status-waiting{
    color:#a16207;
    background:#fefce8;
    border:1px solid #fde68a;
}

.status-confirmed{
    color:#0369a1;
    background:#f0f9ff;
    border:1px solid #bae6fd;
}

.status-paid{
    color:#047857;
    background:#ecfdf5;
    border:1px solid #a7f3d0;
}

.status-cancelled{
    color:#b91c1c;
    background:#fef2f2;
    border:1px solid #fecaca;
}

/* BODY */
.booked-tour-card-body{
    padding:24px;
    display:grid;
    grid-template-columns:minmax(280px,34%) minmax(0,1fr);
    gap:28px;
}

.booked-tour-image{
    position:relative;
    min-height:260px;
    overflow:hidden;
    border-radius:20px;
    background:#eff6ff;
}

.booked-tour-image img{
    width:100%;
    height:100%;
    min-height:260px;
    display:block;
    object-fit:cover;
    transition:transform .35s ease;
}

.booked-tour-card:hover .booked-tour-image img{
    transform:scale(1.035);
}

.booked-tour-image::after{
    content:"";
    position:absolute;
    inset:0;
    background:linear-gradient(180deg,transparent 55%,rgba(15,23,42,.38));
    pointer-events:none;
}

.image-overlay-label{
    position:absolute;
    z-index:2;
    left:14px;
    bottom:14px;
    padding:8px 12px;
    border:1px solid rgba(255,255,255,.50);
    border-radius:999px;
    display:inline-flex;
    align-items:center;
    gap:7px;
    color:#ffffff;
    background:rgba(15,23,42,.50);
    backdrop-filter:blur(8px);
    font-size:11px;
    font-weight:900;
}

.booked-tour-info{
    min-width:0;
    display:flex;
    flex-direction:column;
}

.tour-mini-label{
    display:block;
    margin-bottom:6px;
    color:var(--bt-primary);
    font-size:11px;
    font-weight:900;
    letter-spacing:.8px;
    text-transform:uppercase;
}

.tour-name-row h2{
    margin:0;
    color:var(--bt-text);
    font-size:clamp(23px,2vw,31px);
    line-height:1.3;
    font-weight:1000;
    letter-spacing:-.65px;
}

.booking-info-grid{
    display:grid;
    grid-template-columns:repeat(2,minmax(0,1fr));
    gap:12px;
    margin-top:22px;
}

.booking-info-item{
    min-width:0;
    padding:14px;
    border:1px solid #e4ecf5;
    border-radius:16px;
    display:flex;
    align-items:center;
    gap:12px;
    background:linear-gradient(135deg,#ffffff,#f8fbff);
}

.info-icon{
    width:42px;
    height:42px;
    flex:0 0 42px;
    border-radius:13px;
    display:grid;
    place-items:center;
    color:var(--bt-primary);
    background:#eff6ff;
    font-size:16px;
}

.booking-info-item div{
    min-width:0;
}

.booking-info-item small{
    display:block;
    margin-bottom:3px;
    color:#94a3b8;
    font-size:11px;
    font-weight:800;
    text-transform:uppercase;
    letter-spacing:.35px;
}

.booking-info-item strong{
    display:block;
    overflow:hidden;
    color:#334155;
    font-size:14px;
    line-height:1.4;
    font-weight:850;
    text-overflow:ellipsis;
    white-space:nowrap;
}

.passenger-summary{
    margin-top:auto;
    padding:15px 17px;
    border:1px solid #dbeafe;
    border-radius:17px;
    display:flex;
    align-items:center;
    gap:13px;
    background:linear-gradient(135deg,#eff6ff,#ffffff);
}

.passenger-summary-icon{
    width:44px;
    height:44px;
    flex:0 0 44px;
    border-radius:14px;
    display:grid;
    place-items:center;
    color:#ffffff;
    background:linear-gradient(135deg,#60a5fa,#2563eb);
    box-shadow:0 9px 20px rgba(37,99,235,.18);
}

.passenger-summary span{
    display:block;
    margin-bottom:4px;
    color:var(--bt-muted);
    font-size:12px;
    font-weight:750;
}

.passenger-counts{
    display:flex;
    align-items:center;
    gap:9px;
    color:#1e3a8a;
    font-size:13px;
}

.passenger-counts i{
    width:4px;
    height:4px;
    border-radius:50%;
    background:#93c5fd;
}

/* FOOTER */
.booked-tour-card-footer{
    padding:20px 22px;
    border-top:1px solid #e5edf6;
    display:flex;
    align-items:center;
    justify-content:space-between;
    gap:24px;
    background:#fbfdff;
}

.booking-payment span{
    display:block;
    margin-bottom:3px;
    color:var(--bt-muted);
    font-size:12px;
    font-weight:800;
}

.booking-total{
    display:block;
    color:#ef4444;
    font-size:27px;
    line-height:1.2;
    font-weight:1000;
    letter-spacing:-.45px;
}

.paid-amount{
    margin-top:5px;
    display:flex;
    align-items:center;
    gap:6px;
    color:#047857;
    font-size:12px;
    font-weight:750;
}

.paid-amount strong{
    font-weight:900;
}

.booking-actions{
    display:flex;
    align-items:center;
    justify-content:flex-end;
    gap:9px;
    flex-wrap:wrap;
}

.cancel-booking-form{
    margin:0;
}

.booking-action{
    min-height:44px;
    padding:0 15px;
    border-radius:13px;
    display:inline-flex;
    align-items:center;
    justify-content:center;
    gap:7px;
    white-space:nowrap;
    text-decoration:none !important;
    font-family:inherit;
    font-size:13px;
    font-weight:900;
    transition:transform .2s ease,box-shadow .2s ease,background .2s ease,border-color .2s ease;
}

.booking-action-detail{
    color:var(--bt-primary);
    border:1px solid #93c5fd;
    background:#ffffff;
}

.booking-action-detail:hover{
    color:#ffffff;
    border-color:var(--bt-primary);
    background:var(--bt-primary);
    transform:translateY(-2px);
    box-shadow:0 10px 22px rgba(37,99,235,.16);
}

.booking-action-payment{
    color:#ffffff;
    border:1px solid transparent;
    background:linear-gradient(135deg,#3b82f6,#2563eb);
    box-shadow:0 10px 22px rgba(37,99,235,.18);
    cursor:default;
}

.booking-action-cancel{
    border:1px solid #fecaca;
    color:#dc2626;
    background:#ffffff;
    cursor:pointer;
}

.booking-action-cancel:hover{
    color:#ffffff;
    border-color:#dc2626;
    background:#dc2626;
    transform:translateY(-2px);
    box-shadow:0 10px 22px rgba(220,38,38,.15);
}

/* EMPTY */
.booked-tour-empty{
    padding:70px 24px;
    border:1px dashed #bfdbfe;
    border-radius:28px;
    text-align:center;
    background:#ffffff;
    box-shadow:0 18px 48px rgba(37,99,235,.07);
}

.empty-icon{
    width:78px;
    height:78px;
    margin:0 auto 18px;
    border-radius:24px;
    display:grid;
    place-items:center;
    color:var(--bt-primary);
    background:#eff6ff;
    font-size:31px;
}

.booked-tour-empty h2{
    margin:0 0 9px;
    color:var(--bt-text);
    font-size:27px;
    font-weight:1000;
}

.booked-tour-empty p{
    max-width:600px;
    margin:0 auto 22px;
    color:var(--bt-muted);
    line-height:1.7;
}

.booked-tour-empty a{
    min-height:46px;
    padding:0 18px;
    border-radius:13px;
    display:inline-flex;
    align-items:center;
    justify-content:center;
    gap:8px;
    color:#ffffff;
    background:linear-gradient(135deg,#3b82f6,#2563eb);
    text-decoration:none;
    font-weight:900;
    box-shadow:0 12px 26px rgba(37,99,235,.20);
}

/* RESPONSIVE */
@media(max-width:992px){
    .booked-tour-card-body{
        grid-template-columns:1fr;
    }

    .booked-tour-image{
        min-height:300px;
    }

    .booked-tour-image img{
        min-height:300px;
    }

    .booked-tour-card-footer{
        align-items:flex-start;
        flex-direction:column;
    }

    .booking-actions{
        width:100%;
        justify-content:flex-start;
    }
}

@media(max-width:768px){
    .booked-tour-page{
        padding-top:28px;
    }

    .booked-tour-container{
        width:calc(100% - 20px);
    }

    .booked-tour-hero{
        align-items:flex-start;
        flex-direction:column;
        border-radius:24px;
    }

    .booked-tour-summary{
        width:100%;
        min-width:0;
        display:flex;
        align-items:center;
        justify-content:center;
        gap:8px;
        padding:15px;
    }

    .booked-tour-summary span,
    .booked-tour-summary small,
    .booked-tour-summary strong{
        display:inline;
        margin:0;
    }

    .booked-tour-summary strong{
        font-size:28px;
    }

    .booked-tour-card{
        border-radius:22px;
    }

    .booked-tour-card-head{
        align-items:flex-start;
        flex-direction:column;
    }

    .booked-tour-card-body{
        padding:17px;
        gap:20px;
    }

    .booked-tour-image,
    .booked-tour-image img{
        min-height:220px;
    }

    .booking-info-grid{
        grid-template-columns:1fr;
    }

    .booked-tour-card-footer{
        padding:17px;
    }

    .booking-actions{
        display:grid;
        grid-template-columns:1fr 1fr;
    }

    .booking-action,
    .cancel-booking-form,
    .cancel-booking-form .booking-action{
        width:100%;
    }
}

@media(max-width:520px){
    .booked-tour-container{
        width:calc(100% - 14px);
    }

    .booked-tour-hero{
        padding:25px 18px;
    }

    .booked-tour-hero h1{
        font-size:34px;
    }

    .booked-tour-card-head{
        padding:14px 15px;
    }

    .booking-code{
        align-items:flex-start;
        flex-direction:column;
        gap:5px;
    }

    .booked-tour-image,
    .booked-tour-image img{
        min-height:190px;
    }

    .tour-name-row h2{
        font-size:22px;
    }

    .passenger-summary{
        align-items:flex-start;
    }

    .passenger-counts{
        align-items:flex-start;
        flex-direction:column;
        gap:3px;
    }

    .passenger-counts i{
        display:none;
    }

    .booking-actions{
        grid-template-columns:1fr;
    }

    .booking-total{
        font-size:24px;
    }
}
</style>

@endsection