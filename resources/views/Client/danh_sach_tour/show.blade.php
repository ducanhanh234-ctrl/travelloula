@extends('layouts.app')

@section('title', $tour->ten_tour . ' - Travelloula')

@section('content')

@php
$fallbackImage = 'https://images.unsplash.com/photo-1507525428034-b723cf961d3e?auto=format&fit=crop&w=1400&q=80';

$mainImage = $fallbackImage;

if (!empty($tour->anh_dai_dien)) {
if (\Illuminate\Support\Str::startsWith($tour->anh_dai_dien, ['http://', 'https://'])) {
$mainImage = $tour->anh_dai_dien;
} else {
$mainImage = asset($tour->anh_dai_dien);
}
}

$giaNguoiLon = ($tour->gia_nguoi_lon ?? 0) > 0 ? $tour->gia_nguoi_lon : $tour->gia_tour;
$giaTreEm = $tour->gia_tre_em ?? 0;
$giaEmBe = $tour->gia_em_be ?? 0;

$lichGanNhat = $lichGanNhat ?? $tour->lichKhoiHanhTours
->where('trang_thai', 'available')
->sortBy('ngay_khoi_hanh')
->first();

$soSaoTrungBinh = $soSaoTrungBinh ?? $tour->danhGia->avg('so_sao');
$soLuotDat = $soLuotDat ?? $tour->datTours()->count();
@endphp

<section class="tour-detail-page">
    <div class="tour-detail-container">

        <div class="breadcrumb">
            <a href="{{ route('Client.trang_chu.index') }}">Trang chủ</a>
            <span>/</span>
            <a href="{{ route('Client.danh_sach_tour.index') }}">Tour</a>
            <span>/</span>
            <strong>{{ $tour->ten_tour }}</strong>
        </div>

        <div class="tour-title-box">
            <span>{{ $tour->danhMuc->ten_danh_muc ?? 'Tour du lịch' }}</span>
            <h1>{{ $tour->ten_tour }}</h1>

            <div class="tour-title-meta">
                <div>
                    <i class="fa-solid fa-location-dot"></i>
                    {{ $tour->diem_den ?? 'Đang cập nhật' }}
                </div>

                <div>
                    <i class="fa-regular fa-clock"></i>
                    {{ $tour->thoi_luong ?? 'Đang cập nhật' }}
                </div>

                <div>
                    <i class="fa-solid fa-star"></i>
                    {{ $soSaoTrungBinh ? number_format($soSaoTrungBinh, 1) : 'Chưa có' }} đánh giá
                </div>

                <div>
                    <i class="fa-solid fa-bag-shopping"></i>
                    {{ $soLuotDat }} lượt đặt
                </div>
            </div>
        </div>

        <div class="detail-top-grid">
            <div class="detail-left">
                <div class="main-image">
                    <img src="{{ $mainImage }}" alt="{{ $tour->ten_tour }}" onerror="this.onerror=null;this.src='{{ $fallbackImage }}';">

                    <button type="button" class="zoom-btn">
                        <i class="fa-solid fa-up-right-and-down-left-from-center"></i>
                    </button>
                </div>

                <div class="gallery-thumbs">
                    <img src="{{ $mainImage }}" alt="{{ $tour->ten_tour }}" onerror="this.onerror=null;this.src='{{ $fallbackImage }}';">

                    @foreach($tour->hinhAnhTours->take(6) as $image)
                    @php
                    $galleryImage = null;

                    if (!empty($image->duong_dan_anh)) {
                    if (\Illuminate\Support\Str::startsWith($image->duong_dan_anh, ['http://', 'https://'])) {
                    $galleryImage = $image->duong_dan_anh;
                    } else {
                    $galleryImage = asset($image->duong_dan_anh);
                    }
                    }
                    @endphp

                    @if($galleryImage)
                    <img src="{{ $galleryImage }}" alt="{{ $tour->ten_tour }}" onerror="this.style.display='none';">
                    @endif
                    @endforeach
                </div>
            </div>

            <aside class="booking-card" id="dat-tour">
                <div class="booking-info-grid">
                    <div>
                        <i class="fa-solid fa-ticket"></i>
                        <span>Mã tour</span>
                        <strong>TOUR-{{ $tour->id }}</strong>
                    </div>

                    <div>
                        <i class="fa-regular fa-clock"></i>
                        <span>Thời lượng</span>
                        <strong>{{ $tour->thoi_luong ?? 'Đang cập nhật' }}</strong>
                    </div>

                    <div>
                        <i class="fa-solid fa-location-dot"></i>
                        <span>Điểm đến</span>
                        <strong>{{ $tour->diem_den ?? 'Đang cập nhật' }}</strong>
                    </div>

                    <div>
                        <i class="fa-solid fa-plane-departure"></i>
                        <span>Xuất phát</span>
                        <strong>{{ $tour->dia_diem_khoi_hanh ?? 'Đang cập nhật' }}</strong>
                    </div>

                    <div>
                        <i class="fa-solid fa-users"></i>
                        <span>Số khách tối đa</span>
                        <strong>{{ $tour->so_khach_toi_da ?? 0 }} khách</strong>
                    </div>

                    <div>
                        <i class="fa-solid fa-car"></i>
                        <span>Phương tiện</span>
                        <strong>{{ $tour->phuong_tien ?? 'Đang cập nhật' }}</strong>
                    </div>

                    <div>
                        <i class="fa-solid fa-hotel"></i>
                        <span>Khách sạn</span>
                        <strong>{{ $tour->tieu_chuan_khach_san ?? 'Đang cập nhật' }}</strong>
                    </div>

                    <div>
                        <i class="fa-solid fa-layer-group"></i>
                        <span>Loại tour</span>
                        <strong>{{ $tour->danhMuc->ten_danh_muc ?? 'Tour du lịch' }}</strong>
                    </div>
                </div>

                <div class="price-box">
                    <span>Giá chỉ từ</span>
                    <strong>{{ number_format($tour->gia_tour ?? 0, 0, ',', '.') }} đ</strong>
                </div>

                <div class="price-detail">
                    <p>
                        <span>Người lớn</span>
                        <strong>{{ number_format($giaNguoiLon, 0, ',', '.') }} đ</strong>
                    </p>

                    <p>
                        <span>Trẻ em</span>
                        <strong>{{ number_format($giaTreEm, 0, ',', '.') }} đ</strong>
                    </p>

                    <p>
                        <span>Em bé</span>
                        <strong>{{ number_format($giaEmBe, 0, ',', '.') }} đ</strong>
                    </p>
                </div>

                @if($lichGanNhat)
                <div class="nearest-date">
                    <i class="fa-regular fa-calendar-days"></i>
                    <div>
                        <span>Khởi hành gần nhất</span>
                        <strong>
                            {{ \Carbon\Carbon::parse($lichGanNhat->ngay_khoi_hanh)->format('d/m/Y') }}
                            @if($lichGanNhat->ngay_ket_thuc)
                            - {{ \Carbon\Carbon::parse($lichGanNhat->ngay_ket_thuc)->format('d/m/Y') }}
                            @endif
                        </strong>
                        <small>Còn {{ $lichGanNhat->so_cho_con_lai }} chỗ</small>
                    </div>
                </div>
                @endif

                @if($tour->lichKhoiHanhTours->count())
                <div class="schedule-mini">
                    <h3>Lịch khởi hành</h3>

                    @foreach($tour->lichKhoiHanhTours->sortBy('ngay_khoi_hanh')->take(4) as $lich)
                    <div class="schedule-mini-item">
                        <span>
                            {{ \Carbon\Carbon::parse($lich->ngay_khoi_hanh)->format('d/m/Y') }}
                        </span>

                        <strong>Còn {{ $lich->so_cho_con_lai }} chỗ</strong>
                    </div>
                    @endforeach
                </div>
                @endif

                <div class="booking-actions">
                    <a href="{{route('create_dat_tour', $tour->id)}}" class="book-btn">
                        <i class="fa-solid fa-calendar-check"></i>
                        Đặt tour
                    </a>

                    <a href="tel:0965634066" class="consult-btn">
                        Tư vấn
                    </a>
                </div>

                <div class="contact-line">
                    Liên hệ:
                    <strong>0965634066</strong>
                    <span>-</span>
                    <strong>event@travelloula.vn</strong>
                </div>
            </aside>
        </div>

        <div class="overview-card">
            <h2>Khám phá {{ $tour->ten_tour }}</h2>

            <p>
                {!! nl2br(e($tour->mo_ta ?? 'Thông tin tour đang được cập nhật.')) !!}
            </p>

            @if($tour->tong_quan_lich_trinh)
            <div class="highlight-box">
                <h3>Điểm nhấn chương trình</h3>
                <p>{!! nl2br(e($tour->tong_quan_lich_trinh)) !!}</p>
            </div>
            @endif
        </div>

        @if($tour->lichTrinhTours->count())
        <section class="schedule-section">
            <div class="schedule-left">
                <h2>Lịch trình <span>TOUR</span></h2>

                <div class="day-list">
                    @foreach($tour->lichTrinhTours->sortBy('ngay_thu') as $lt)
                    <a href="#ngay-{{ $lt->ngay_thu }}" class="day-item">
                        <span>Ngày {{ str_pad($lt->ngay_thu, 2, '0', STR_PAD_LEFT) }}</span>
                        <strong>{{ $lt->tieu_de }}</strong>
                    </a>
                    @endforeach
                </div>
            </div>

            <div class="schedule-right">
                <h2>Chi tiết <span>LỊCH TRÌNH TOUR</span></h2>

                <div class="timeline-detail">
                    @foreach($tour->lichTrinhTours->sortBy('ngay_thu') as $lt)
                    <article class="timeline-block" id="ngay-{{ $lt->ngay_thu }}">
                        <div class="timeline-dot"></div>

                        <div class="timeline-text">
                            <h3>
                                NGÀY {{ $lt->ngay_thu }}:
                                {{ $lt->tieu_de }}
                            </h3>

                            @if($lt->dia_diem)
                            <p>
                                <strong>Địa điểm:</strong>
                                {{ $lt->dia_diem }}
                            </p>
                            @endif

                            @if($lt->hoat_dong)
                            <p>{!! nl2br(e($lt->hoat_dong)) !!}</p>
                            @endif

                            @if($lt->bua_an)
                            <p>
                                <strong>Bữa ăn:</strong>
                                {{ $lt->bua_an }}
                            </p>
                            @endif

                            @if($lt->thong_tin_khach_san)
                            <p>
                                <strong>Khách sạn:</strong>
                                {{ $lt->thong_tin_khach_san }}
                            </p>
                            @endif
                        </div>
                    </article>
                    @endforeach
                </div>

                <a href="#booking-form" class="center-book-btn">
                    ĐẶT TOUR NGAY
                </a>
            </div>
        </section>
        @endif

        <section class="rules-section">
            <h2>Quy định <span>DỊCH VỤ</span></h2>

            <div class="accordion-box">
                <details open>
                    <summary>
                        <span class="status-icon green">
                            <i class="fa-solid fa-check"></i>
                        </span>
                        GIÁ TOUR TRỌN GÓI
                    </summary>

                    <div class="accordion-content">
                        <div class="price-table-wrap">
                            <table>
                                <thead>
                                    <tr>
                                        <th>Ngày khởi hành</th>
                                        <th>Người lớn</th>
                                        <th>Trẻ em</th>
                                        <th>Em bé</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @forelse($tour->lichKhoiHanhTours->sortBy('ngay_khoi_hanh')->take(6) as $lich)
                                    <tr>
                                        <td>{{ \Carbon\Carbon::parse($lich->ngay_khoi_hanh)->format('d/m/Y') }}</td>
                                        <td>{{ number_format($giaNguoiLon, 0, ',', '.') }} VND</td>
                                        <td>{{ number_format($giaTreEm, 0, ',', '.') }} VND</td>
                                        <td>{{ number_format($giaEmBe, 0, ',', '.') }} VND</td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td>Đang cập nhật</td>
                                        <td>{{ number_format($giaNguoiLon, 0, ',', '.') }} VND</td>
                                        <td>{{ number_format($giaTreEm, 0, ',', '.') }} VND</td>
                                        <td>{{ number_format($giaEmBe, 0, ',', '.') }} VND</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </details>

                <details open>
                    <summary>
                        <span class="status-icon green">
                            <i class="fa-solid fa-check"></i>
                        </span>
                        GIÁ TOUR BAO GỒM
                    </summary>

                    <div class="accordion-content">
                        @if($tour->dich_vu_bao_gom)
                        <p>{!! nl2br(e($tour->dich_vu_bao_gom)) !!}</p>
                        @else
                        <ul>
                            <li>Xe đưa đón theo chương trình.</li>
                            <li>Khách sạn theo tiêu chuẩn tour.</li>
                            <li>Các bữa ăn theo lịch trình.</li>
                            <li>Vé tham quan theo chương trình.</li>
                            <li>Hướng dẫn viên theo đoàn.</li>
                            <li>Bảo hiểm du lịch theo chương trình.</li>
                        </ul>
                        @endif
                    </div>
                </details>

                <details open>
                    <summary>
                        <span class="status-icon red">
                            <i class="fa-solid fa-xmark"></i>
                        </span>
                        GIÁ TOUR KHÔNG BAO GỒM
                    </summary>

                    <div class="accordion-content">
                        @if($tour->dich_vu_khong_bao_gom)
                        <p>{!! nl2br(e($tour->dich_vu_khong_bao_gom)) !!}</p>
                        @else
                        <ul>
                            <li>Chi phí cá nhân ngoài chương trình.</li>
                            <li>Đồ uống trong các bữa ăn.</li>
                            <li>Phụ thu phòng đơn nếu có.</li>
                            <li>VAT và các chi phí phát sinh khác.</li>
                        </ul>
                        @endif
                    </div>
                </details>

                <details open>
                    <summary>
                        <span class="status-icon yellow">
                            <i class="fa-solid fa-exclamation"></i>
                        </span>
                        LƯU Ý ĐĂNG KÝ TOUR
                    </summary>

                    <div class="accordion-content">
                        <ul>
                            <li>Quý khách vui lòng đọc kỹ chương trình tour trước khi đăng ký.</li>
                            <li>Lịch khởi hành có thể thay đổi tùy tình hình thực tế.</li>
                            <li>Giá tour có thể thay đổi theo thời điểm đặt dịch vụ.</li>
                            <li>Mọi thay đổi cần được thống nhất với nhân viên tư vấn.</li>
                        </ul>
                    </div>
                </details>
            </div>
        </section>

        <section class="booking-form-section" id="booking-form">
            <h2>Đặt tour <span>NGAY</span></h2>

            <div class="booking-form-card">
                <div>
                    <h3>{{ $tour->ten_tour }}</h3>
                    <p>Vui lòng liên hệ tư vấn viên để được hỗ trợ đặt tour nhanh nhất.</p>
                </div>

                <a href="tel:0965634066">
                    <i class="fa-solid fa-phone"></i>
                    Gọi tư vấn
                </a>
            </div>
        </section>

    </div>
</section>

<style>
    :root {
        --primary: #0757d8;
        --pink: #ff2f6d;
        --pink-dark: #e91f5c;
        --orange: #ff5a1f;
        --text: #0b1226;
        --muted: #64748b;
        --line: #e5e7eb;
        --soft: #f8fbff;
        --shadow: 0 24px 70px rgba(15, 23, 42, .10);
    }

    * {
        box-sizing: border-box;
    }

    html {
        scroll-behavior: smooth;
    }

    .tour-detail-page {
        padding: 46px 0 80px;
        background: #fff;
        color: var(--text);
    }

    .tour-detail-container {
        width: min(1660px, calc(100% - 48px));
        margin: 0 auto;
    }

    .breadcrumb {
        display: flex;
        align-items: center;
        gap: 10px;
        flex-wrap: wrap;
        margin-bottom: 20px;
        color: #64748b;
        font-size: 14px;
    }

    .breadcrumb a {
        color: var(--primary);
        font-weight: 800;
        text-decoration: none;
    }

    .breadcrumb strong {
        color: #0f172a;
    }

    .tour-title-box {
        margin-bottom: 20px;
    }

    .tour-title-box span {
        display: inline-flex;
        padding: 8px 16px;
        border-radius: 999px;
        background: #eff6ff;
        color: var(--primary);
        font-weight: 900;
        margin-bottom: 12px;
    }

    .tour-title-box h1 {
        margin: 0;
        color: #111827;
        font-size: clamp(30px, 3vw, 44px);
        line-height: 1.15;
        font-weight: 1000;
        letter-spacing: -1px;
        text-transform: uppercase;
    }

    .tour-title-meta {
        display: flex;
        flex-wrap: wrap;
        gap: 12px;
        margin-top: 14px;
    }

    .tour-title-meta div {
        display: flex;
        align-items: center;
        gap: 7px;
        padding: 9px 13px;
        border-radius: 999px;
        background: #f8fafc;
        border: 1px solid #e5e7eb;
        color: #475569;
        font-weight: 800;
        font-size: 14px;
    }

    .tour-title-meta i {
        color: var(--primary);
    }

    .detail-top-grid {
        display: grid;
        grid-template-columns: 1.45fr 1fr;
        gap: 30px;
        align-items: start;
    }

    .main-image {
        height: 560px;
        border-radius: 16px;
        overflow: hidden;
        position: relative;
        background: #e5e7eb;
        box-shadow: 0 16px 42px rgba(15, 23, 42, .13);
    }

    .main-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
    }

    .zoom-btn {
        position: absolute;
        top: 22px;
        right: 22px;
        width: 42px;
        height: 42px;
        border-radius: 12px;
        border: 0;
        display: grid;
        place-items: center;
        color: var(--primary);
        background: rgba(255, 255, 255, .94);
        box-shadow: 0 10px 24px rgba(15, 23, 42, .18);
        cursor: pointer;
    }

    .gallery-thumbs {
        margin-top: -40px;
        position: relative;
        z-index: 3;
        display: flex;
        justify-content: center;
        gap: 10px;
        padding: 0 18px;
    }

    .gallery-thumbs img {
        width: 64px;
        height: 48px;
        object-fit: cover;
        border-radius: 8px;
        border: 3px solid rgba(255, 255, 255, .92);
        box-shadow: 0 8px 18px rgba(15, 23, 42, .18);
    }

    .booking-card {
        background: #fff;
        border: 1px solid #edf0f5;
        border-radius: 18px;
        padding: 28px;
        box-shadow: 0 18px 54px rgba(15, 23, 42, .08);
        position: sticky;
        top: 100px;
    }

    .booking-info-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 0;
        border-bottom: 1px solid #edf0f5;
    }

    .booking-info-grid div {
        padding: 16px 12px;
        display: grid;
        grid-template-columns: 28px 1fr;
        column-gap: 10px;
        align-items: center;
        border-bottom: 1px solid #edf0f5;
    }

    .booking-info-grid i {
        grid-row: span 2;
        color: var(--pink);
        font-size: 22px;
    }

    .booking-info-grid span {
        color: #334155;
        font-size: 15px;
    }

    .booking-info-grid strong {
        color: #071126;
        font-size: 15px;
        font-weight: 1000;
    }

    .price-box {
        padding: 26px 0 14px;
    }

    .price-box span {
        display: block;
        color: #64748b;
        font-weight: 800;
        margin-bottom: 8px;
    }

    .price-box strong {
        display: block;
        color: var(--pink);
        font-size: 40px;
        line-height: 1.1;
        font-weight: 1000;
        letter-spacing: -1px;
    }

    .price-detail {
        padding: 16px;
        border-radius: 16px;
        background: #fff7ed;
        border: 1px solid #fed7aa;
        margin-bottom: 18px;
    }

    .price-detail p {
        display: flex;
        justify-content: space-between;
        gap: 12px;
        margin: 0 0 8px;
        color: #475569;
    }

    .price-detail p:last-child {
        margin-bottom: 0;
    }

    .price-detail strong {
        color: #0f172a;
    }

    .nearest-date {
        display: flex;
        gap: 12px;
        padding: 15px;
        border-radius: 16px;
        background: #f8fbff;
        border: 1px solid #dbeafe;
        margin-bottom: 18px;
    }

    .nearest-date i {
        color: var(--primary);
        font-size: 24px;
        margin-top: 4px;
    }

    .nearest-date span {
        display: block;
        color: #64748b;
        font-size: 13px;
        font-weight: 800;
    }

    .nearest-date strong {
        display: block;
        color: #0f172a;
        font-size: 16px;
        margin: 3px 0;
    }

    .nearest-date small {
        color: var(--pink);
        font-weight: 900;
    }

    .schedule-mini {
        margin-bottom: 18px;
    }

    .schedule-mini h3 {
        margin: 0 0 12px;
        font-size: 18px;
    }

    .schedule-mini-item {
        display: flex;
        justify-content: space-between;
        gap: 12px;
        padding: 12px 14px;
        border-radius: 12px;
        background: #f8fbff;
        border: 1px solid #dbeafe;
        margin-bottom: 8px;
    }

    .schedule-mini-item span {
        color: #0f172a;
        font-weight: 850;
    }

    .schedule-mini-item strong {
        color: var(--pink);
        font-size: 14px;
    }

    .booking-actions {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 14px;
        margin-top: 16px;
    }

    .booking-actions a {
        height: 58px;
        border-radius: 999px;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        font-weight: 1000;
        text-decoration: none;
        transition: .25s ease;
    }

    .book-btn {
        background: var(--pink);
        color: #fff;
        box-shadow: 0 14px 30px rgba(255, 47, 109, .22);
    }

    .book-btn:hover {
        background: var(--pink-dark);
        color: #fff;
        transform: translateY(-2px);
    }

    .consult-btn {
        border: 1.6px solid var(--pink);
        color: var(--pink);
        background: #fff;
    }

    .consult-btn:hover {
        background: #fff1f5;
    }

    .contact-line {
        text-align: center;
        margin-top: 18px;
        color: #0f172a;
        font-size: 15px;
    }

    .contact-line strong {
        font-weight: 1000;
    }

    .overview-card {
        margin-top: 46px;
        padding: 28px;
        border: 1px solid #e8ebf0;
        border-radius: 16px;
        background: #fff;
        box-shadow: 0 12px 34px rgba(15, 23, 42, .05);
    }

    .overview-card h2,
    .rules-section h2,
    .booking-form-section h2 {
        margin: 0 0 20px;
        color: #111827;
        font-size: 32px;
        font-weight: 1000;
        letter-spacing: -.6px;
    }

    .overview-card p {
        color: #111827;
        font-size: 18px;
        line-height: 1.8;
    }

    .highlight-box {
        margin-top: 24px;
    }

    .highlight-box h3 {
        font-size: 20px;
        margin-bottom: 12px;
    }

    .schedule-section {
        margin-top: 48px;
        display: grid;
        grid-template-columns: 460px 1fr;
        gap: 46px;
        align-items: start;
    }

    .schedule-left {
        position: sticky;
        top: 100px;
    }

    .schedule-left h2,
    .schedule-right h2,
    .rules-section h2,
    .booking-form-section h2 {
        font-size: 34px;
        line-height: 1.2;
        margin: 0 0 26px;
        font-weight: 1000;
        color: #18181b;
    }

    .schedule-left h2 span,
    .schedule-right h2 span,
    .rules-section h2 span,
    .booking-form-section h2 span {
        color: var(--pink);
    }

    .day-list {
        border-left: 2px dashed var(--pink);
        margin-left: 10px;
        padding-left: 24px;
    }

    .day-item {
        position: relative;
        display: block;
        padding-bottom: 28px;
        text-decoration: none;
    }

    .day-item::before {
        content: "";
        position: absolute;
        left: -35px;
        top: 4px;
        width: 18px;
        height: 18px;
        border-radius: 50%;
        background: #fff;
        border: 3px solid var(--pink);
    }

    .day-item span {
        display: inline-flex;
        padding: 10px 18px;
        border-radius: 7px;
        background: var(--pink);
        color: #fff;
        font-weight: 1000;
        margin-bottom: 14px;
    }

    .day-item strong {
        display: block;
        color: #2b2f38;
        font-size: 16px;
        line-height: 1.5;
    }

    .timeline-detail {
        border-left: 2px dashed var(--pink);
        padding-left: 24px;
    }

    .timeline-block {
        position: relative;
        padding-bottom: 54px;
    }

    .timeline-dot {
        position: absolute;
        left: -35px;
        top: 3px;
        width: 18px;
        height: 18px;
        border-radius: 50%;
        background: #fff;
        border: 3px solid var(--pink);
    }

    .timeline-text h3 {
        margin: 0 0 20px;
        color: var(--pink);
        font-size: 28px;
        line-height: 1.25;
        font-weight: 1000;
        text-transform: uppercase;
    }

    .timeline-text p {
        color: #111827;
        font-size: 17px;
        line-height: 1.85;
        margin: 0 0 16px;
    }

    .center-book-btn {
        width: min(320px, 100%);
        height: 58px;
        margin: 0 auto;
        border-radius: 999px;
        background: var(--pink);
        color: #fff;
        font-weight: 1000;
        display: flex;
        align-items: center;
        justify-content: center;
        text-decoration: none;
        box-shadow: 0 16px 34px rgba(255, 47, 109, .23);
    }

    .rules-section {
        margin-top: 58px;
    }

    .accordion-box {
        border: 1px solid #e5e7eb;
        border-radius: 16px;
        overflow: hidden;
        background: #fff;
    }

    .accordion-box details {
        border-bottom: 1px solid #e5e7eb;
    }

    .accordion-box details:last-child {
        border-bottom: 0;
    }

    .accordion-box summary {
        min-height: 72px;
        padding: 0 28px;
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 16px;
        color: #111827;
        font-size: 21px;
        font-weight: 850;
        list-style: none;
    }

    .accordion-box summary::-webkit-details-marker {
        display: none;
    }

    .accordion-box summary::after {
        content: "\f107";
        font-family: "Font Awesome 6 Free";
        font-weight: 900;
        margin-left: auto;
        color: #94a3b8;
    }

    .status-icon {
        width: 28px;
        height: 28px;
        border-radius: 50%;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        color: #fff;
        font-size: 14px;
        flex: 0 0 auto;
    }

    .status-icon.green {
        background: #52c41a;
    }

    .status-icon.red {
        background: #ff4d4f;
    }

    .status-icon.yellow {
        background: #f59e0b;
    }

    .accordion-content {
        padding: 24px 68px 32px;
        border-top: 1px solid #e5e7eb;
    }

    .accordion-content p,
    .accordion-content li {
        color: #111827;
        font-size: 17px;
        line-height: 1.8;
    }

    .price-table-wrap {
        overflow-x: auto;
    }

    .price-table-wrap table {
        width: 100%;
        border-collapse: collapse;
        min-width: 720px;
    }

    .price-table-wrap th,
    .price-table-wrap td {
        padding: 18px 20px;
        border: 1px solid #e5e7eb;
        text-align: left;
        font-size: 16px;
    }

    .price-table-wrap th {
        background: #f8fafc;
        font-weight: 1000;
    }

    .booking-form-section {
        margin-top: 56px;
    }

    .booking-form-card {
        padding: 28px;
        border-radius: 20px;
        background: linear-gradient(135deg, #fff1f5, #ffffff);
        border: 1px solid #ffd1df;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 20px;
    }

    .booking-form-card h3 {
        margin: 0 0 8px;
        font-size: 24px;
    }

    .booking-form-card p {
        margin: 0;
        color: #64748b;
    }

    .booking-form-card a {
        height: 54px;
        padding: 0 28px;
        border-radius: 999px;
        background: var(--pink);
        color: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        font-weight: 1000;
        text-decoration: none;
        white-space: nowrap;
    }

    @media(max-width:1200px) {
        .detail-top-grid {
            grid-template-columns: 1fr;
        }

        .booking-card {
            position: static;
        }

        .schedule-section {
            grid-template-columns: 1fr;
        }

        .schedule-left {
            position: static;
        }
    }

    @media(max-width:768px) {
        .tour-detail-container {
            width: calc(100% - 24px);
        }

        .main-image {
            height: 320px;
        }

        .gallery-thumbs {
            justify-content: flex-start;
            overflow-x: auto;
            padding-bottom: 8px;
        }

        .booking-info-grid {
            grid-template-columns: 1fr;
        }

        .booking-actions {
            grid-template-columns: 1fr;
        }

        .overview-card {
            padding: 22px;
        }

        .overview-card h2,
        .rules-section h2,
        .booking-form-section h2,
        .schedule-left h2,
        .schedule-right h2 {
            font-size: 28px;
        }

        .timeline-text h3 {
            font-size: 23px;
        }

        .accordion-box summary {
            padding: 0 18px;
            font-size: 18px;
        }

        .accordion-content {
            padding: 20px 24px 28px;
        }

        .booking-form-card {
            flex-direction: column;
            align-items: flex-start;
        }

        .booking-form-card a {
            width: 100%;
        }
    }

    @media(max-width:480px) {
        .tour-title-box h1 {
            font-size: 28px;
        }

        .price-box strong {
            font-size: 32px;
        }

        .main-image {
            height: 260px;
        }

        .schedule-left h2,
        .schedule-right h2,
        .rules-section h2 {
            font-size: 25px;
        }
    }

</style>

@endsection
