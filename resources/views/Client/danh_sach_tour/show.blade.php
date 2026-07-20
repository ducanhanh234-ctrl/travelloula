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
    $tongDanhGia = $tongDanhGia ?? $tour->danhGia->count();
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
                    @if($tongDanhGia > 0)
                        {{ number_format($soSaoTrungBinh, 1) }}/5
                        ({{ $tongDanhGia }} đánh giá)
                    @else
                        Chưa có đánh giá
                    @endif
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
                    <img src="{{ $mainImage }}"
                         alt="{{ $tour->ten_tour }}"
                         onerror="this.onerror=null;this.src='{{ $fallbackImage }}';">

                    <button type="button" class="zoom-btn">
                        <i class="fa-solid fa-up-right-and-down-left-from-center"></i>
                    </button>
                </div>

                <div class="gallery-thumbs">
                    <img src="{{ $mainImage }}"
                         alt="{{ $tour->ten_tour }}"
                         onerror="this.onerror=null;this.src='{{ $fallbackImage }}';">

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
                            <img src="{{ $galleryImage }}"
                                 alt="{{ $tour->ten_tour }}"
                                 onerror="this.style.display='none';">
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
                    <a href="#booking-form" class="book-btn">
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


        <section class="review-section" id="danh-gia">
            <div class="review-section-head">
                <div>
                    <span class="review-kicker">TRẢI NGHIỆM KHÁCH HÀNG</span>
                    <h2>Đánh giá <span>TOUR</span></h2>
                    <p>
                        Chỉ những đánh giá đã được quản trị viên duyệt mới hiển thị công khai.
                    </p>
                </div>

                <div class="review-score-box">
                    <strong>{{ $tongDanhGia > 0 ? number_format($soSaoTrungBinh, 1) : '0.0' }}</strong>
                    <div>
                        <div class="review-score-stars">
                            @for($star = 1; $star <= 5; $star++)
                                <i class="fa-solid fa-star {{ $star <= round($soSaoTrungBinh) ? 'active' : '' }}"></i>
                            @endfor
                        </div>
                        <span>{{ $tongDanhGia }} đánh giá đã duyệt</span>
                    </div>
                </div>
            </div>

            @if(session('success'))
                <div class="review-alert review-alert-success">
                    <i class="fa-solid fa-circle-check"></i>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            @if(session('error'))
                <div class="review-alert review-alert-error">
                    <i class="fa-solid fa-circle-exclamation"></i>
                    <span>{{ session('error') }}</span>
                </div>
            @endif

            @if($errors->any())
                <div class="review-alert review-alert-error">
                    <i class="fa-solid fa-circle-exclamation"></i>
                    <div>
                        @foreach($errors->all() as $error)
                            <div>{{ $error }}</div>
                        @endforeach
                    </div>
                </div>
            @endif

            <div class="review-grid">
                <div class="review-form-card">
                    <h3>Gửi đánh giá của bạn</h3>
                    <p class="review-form-description">
                        Đánh giá sẽ được chuyển đến quản trị viên xét duyệt trước khi hiển thị.
                    </p>

                    @auth
                        <form
                            action="{{ route('Client.danh_gia.store', ['tour' => $tour->id]) }}"
                            method="POST"
                            class="review-form"
                        >
                            @csrf

                            <div class="review-field">
                                <label>Chọn số sao <span>*</span></label>

                                <div class="star-rating-input">
                                    @for($star = 5; $star >= 1; $star--)
                                        <input
                                            type="radio"
                                            name="so_sao"
                                            id="review-star-{{ $star }}"
                                            value="{{ $star }}"
                                            required
                                            {{ (int) old('so_sao') === $star ? 'checked' : '' }}
                                        >

                                        <label
                                            for="review-star-{{ $star }}"
                                            title="{{ $star }} sao"
                                        >
                                            <i class="fa-solid fa-star"></i>
                                        </label>
                                    @endfor
                                </div>
                            </div>

                            <div class="review-field">
                                <label for="tieu_de">Tiêu đề</label>
                                <input
                                    type="text"
                                    name="tieu_de"
                                    id="tieu_de"
                                    value="{{ old('tieu_de') }}"
                                    maxlength="255"
                                    placeholder="Ví dụ: Chuyến đi rất tuyệt vời"
                                >
                            </div>

                            <div class="review-field">
                                <label for="noi_dung_danh_gia">
                                    Nội dung đánh giá <span>*</span>
                                </label>

                                <textarea
                                    name="noi_dung_danh_gia"
                                    id="noi_dung_danh_gia"
                                    rows="6"
                                    minlength="5"
                                    maxlength="2000"
                                    placeholder="Hãy chia sẻ trải nghiệm của bạn về tour..."
                                    required
                                >{{ old('noi_dung_danh_gia') }}</textarea>
                            </div>

                            <button type="submit" class="review-submit-btn">
                                <i class="fa-solid fa-paper-plane"></i>
                                Gửi đánh giá
                            </button>
                        </form>
                    @else
                        <div class="review-login-box">
                            <i class="fa-solid fa-user-lock"></i>
                            <div>
                                <strong>Bạn cần đăng nhập</strong>
                                <p>Đăng nhập để gửi đánh giá cho tour đã đặt.</p>
                            </div>

                            <a href="{{ route('login') }}">
                                Đăng nhập
                            </a>
                        </div>
                    @endauth
                </div>

                <div class="review-list-card">
                    <div class="review-list-head">
                        <h3>Đánh giá đã duyệt</h3>
                        <span>{{ $tongDanhGia }} đánh giá</span>
                    </div>

                    <div class="review-list">
                        @forelse($tour->danhGia as $danhGia)
                            <article class="review-item">
                                <div class="review-item-top">
                                    <div class="review-user">
                                        <div class="review-avatar">
                                            {{ mb_strtoupper(mb_substr($danhGia->khachHangDatTour->ho_ten ?? $danhGia->user->name ?? 'K', 0, 1)) }}
                                        </div>

                                        <div>
                                            <strong>
                                                {{ $danhGia->khachHangDatTour->ho_ten ?? $danhGia->user->name ?? 'Khách hàng' }}
                                            </strong>

                                            <div class="review-stars">
                                                @for($star = 1; $star <= 5; $star++)
                                                    <i class="fa-solid fa-star {{ $star <= $danhGia->so_sao ? 'active' : '' }}"></i>
                                                @endfor
                                            </div>
                                        </div>
                                    </div>

                                    <time>
                                        {{ optional($danhGia->thoi_gian_danh_gia)->format('d/m/Y') }}
                                    </time>
                                </div>

                                @if($danhGia->tieu_de)
                                    <h4>{{ $danhGia->tieu_de }}</h4>
                                @endif

                                <p>{{ $danhGia->noi_dung_danh_gia }}</p>

                                <span class="review-approved-badge">
                                    <i class="fa-solid fa-shield-check"></i>
                                    Đã được duyệt
                                </span>
                            </article>
                        @empty
                            <div class="review-empty">
                                <i class="fa-regular fa-comment-dots"></i>
                                <strong>Chưa có đánh giá nào</strong>
                                <p>Hãy là người đầu tiên chia sẻ trải nghiệm về tour này.</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </section>

    </div>
</section>

<style>
:root{
    --primary:#0757d8;
    --pink:#ff2f6d;
    --pink-dark:#e91f5c;
    --orange:#ff5a1f;
    --text:#0b1226;
    --muted:#64748b;
    --line:#e5e7eb;
    --soft:#f8fbff;
    --shadow:0 24px 70px rgba(15,23,42,.10);
}

*{
    box-sizing:border-box;
}

html{
    scroll-behavior:smooth;
}

.tour-detail-page{
    padding:46px 0 80px;
    background:#fff;
    color:var(--text);
}

.tour-detail-container{
    width:min(1660px, calc(100% - 48px));
    margin:0 auto;
}

.breadcrumb{
    display:flex;
    align-items:center;
    gap:10px;
    flex-wrap:wrap;
    margin-bottom:20px;
    color:#64748b;
    font-size:14px;
}

.breadcrumb a{
    color:var(--primary);
    font-weight:800;
    text-decoration:none;
}

.breadcrumb strong{
    color:#0f172a;
}

.tour-title-box{
    margin-bottom:20px;
}

.tour-title-box span{
    display:inline-flex;
    padding:8px 16px;
    border-radius:999px;
    background:#eff6ff;
    color:var(--primary);
    font-weight:900;
    margin-bottom:12px;
}

.tour-title-box h1{
    margin:0;
    color:#111827;
    font-size:clamp(30px,3vw,44px);
    line-height:1.15;
    font-weight:1000;
    letter-spacing:-1px;
    text-transform:uppercase;
}

.tour-title-meta{
    display:flex;
    flex-wrap:wrap;
    gap:12px;
    margin-top:14px;
}

.tour-title-meta div{
    display:flex;
    align-items:center;
    gap:7px;
    padding:9px 13px;
    border-radius:999px;
    background:#f8fafc;
    border:1px solid #e5e7eb;
    color:#475569;
    font-weight:800;
    font-size:14px;
}

.tour-title-meta i{
    color:var(--primary);
}

.detail-top-grid{
    display:grid;
    grid-template-columns:1.45fr 1fr;
    gap:30px;
    align-items:start;
}

.main-image{
    height:560px;
    border-radius:16px;
    overflow:hidden;
    position:relative;
    background:#e5e7eb;
    box-shadow:0 16px 42px rgba(15,23,42,.13);
}

.main-image img{
    width:100%;
    height:100%;
    object-fit:cover;
    display:block;
}

.zoom-btn{
    position:absolute;
    top:22px;
    right:22px;
    width:42px;
    height:42px;
    border-radius:12px;
    border:0;
    display:grid;
    place-items:center;
    color:var(--primary);
    background:rgba(255,255,255,.94);
    box-shadow:0 10px 24px rgba(15,23,42,.18);
    cursor:pointer;
}

.gallery-thumbs{
    margin-top:-40px;
    position:relative;
    z-index:3;
    display:flex;
    justify-content:center;
    gap:10px;
    padding:0 18px;
}

.gallery-thumbs img{
    width:64px;
    height:48px;
    object-fit:cover;
    border-radius:8px;
    border:3px solid rgba(255,255,255,.92);
    box-shadow:0 8px 18px rgba(15,23,42,.18);
}

.booking-card{
    background:#fff;
    border:1px solid #edf0f5;
    border-radius:18px;
    padding:28px;
    box-shadow:0 18px 54px rgba(15,23,42,.08);
    position:sticky;
    top:100px;
}

.booking-info-grid{
    display:grid;
    grid-template-columns:1fr 1fr;
    gap:0;
    border-bottom:1px solid #edf0f5;
}

.booking-info-grid div{
    padding:16px 12px;
    display:grid;
    grid-template-columns:28px 1fr;
    column-gap:10px;
    align-items:center;
    border-bottom:1px solid #edf0f5;
}

.booking-info-grid i{
    grid-row:span 2;
    color:var(--pink);
    font-size:22px;
}

.booking-info-grid span{
    color:#334155;
    font-size:15px;
}

.booking-info-grid strong{
    color:#071126;
    font-size:15px;
    font-weight:1000;
}

.price-box{
    padding:26px 0 14px;
}

.price-box span{
    display:block;
    color:#64748b;
    font-weight:800;
    margin-bottom:8px;
}

.price-box strong{
    display:block;
    color:var(--pink);
    font-size:40px;
    line-height:1.1;
    font-weight:1000;
    letter-spacing:-1px;
}

.price-detail{
    padding:16px;
    border-radius:16px;
    background:#fff7ed;
    border:1px solid #fed7aa;
    margin-bottom:18px;
}

.price-detail p{
    display:flex;
    justify-content:space-between;
    gap:12px;
    margin:0 0 8px;
    color:#475569;
}

.price-detail p:last-child{
    margin-bottom:0;
}

.price-detail strong{
    color:#0f172a;
}

.nearest-date{
    display:flex;
    gap:12px;
    padding:15px;
    border-radius:16px;
    background:#f8fbff;
    border:1px solid #dbeafe;
    margin-bottom:18px;
}

.nearest-date i{
    color:var(--primary);
    font-size:24px;
    margin-top:4px;
}

.nearest-date span{
    display:block;
    color:#64748b;
    font-size:13px;
    font-weight:800;
}

.nearest-date strong{
    display:block;
    color:#0f172a;
    font-size:16px;
    margin:3px 0;
}

.nearest-date small{
    color:var(--pink);
    font-weight:900;
}

.schedule-mini{
    margin-bottom:18px;
}

.schedule-mini h3{
    margin:0 0 12px;
    font-size:18px;
}

.schedule-mini-item{
    display:flex;
    justify-content:space-between;
    gap:12px;
    padding:12px 14px;
    border-radius:12px;
    background:#f8fbff;
    border:1px solid #dbeafe;
    margin-bottom:8px;
}

.schedule-mini-item span{
    color:#0f172a;
    font-weight:850;
}

.schedule-mini-item strong{
    color:var(--pink);
    font-size:14px;
}

.booking-actions{
    display:grid;
    grid-template-columns:1fr 1fr;
    gap:14px;
    margin-top:16px;
}

.booking-actions a{
    height:58px;
    border-radius:999px;
    display:flex;
    align-items:center;
    justify-content:center;
    gap:8px;
    font-weight:1000;
    text-decoration:none;
    transition:.25s ease;
}

.book-btn{
    background:var(--pink);
    color:#fff;
    box-shadow:0 14px 30px rgba(255,47,109,.22);
}

.book-btn:hover{
    background:var(--pink-dark);
    color:#fff;
    transform:translateY(-2px);
}

.consult-btn{
    border:1.6px solid var(--pink);
    color:var(--pink);
    background:#fff;
}

.consult-btn:hover{
    background:#fff1f5;
}

.contact-line{
    text-align:center;
    margin-top:18px;
    color:#0f172a;
    font-size:15px;
}

.contact-line strong{
    font-weight:1000;
}

.overview-card{
    margin-top:46px;
    padding:28px;
    border:1px solid #e8ebf0;
    border-radius:16px;
    background:#fff;
    box-shadow:0 12px 34px rgba(15,23,42,.05);
}

.overview-card h2,
.rules-section h2,
.booking-form-section h2{
    margin:0 0 20px;
    color:#111827;
    font-size:32px;
    font-weight:1000;
    letter-spacing:-.6px;
}

.overview-card p{
    color:#111827;
    font-size:18px;
    line-height:1.8;
}

.highlight-box{
    margin-top:24px;
}

.highlight-box h3{
    font-size:20px;
    margin-bottom:12px;
}

.schedule-section{
    margin-top:48px;
    display:grid;
    grid-template-columns:460px 1fr;
    gap:46px;
    align-items:start;
}

.schedule-left{
    position:sticky;
    top:100px;
}

.schedule-left h2,
.schedule-right h2,
.rules-section h2,
.booking-form-section h2{
    font-size:34px;
    line-height:1.2;
    margin:0 0 26px;
    font-weight:1000;
    color:#18181b;
}

.schedule-left h2 span,
.schedule-right h2 span,
.rules-section h2 span,
.booking-form-section h2 span{
    color:var(--pink);
}

.day-list{
    border-left:2px dashed var(--pink);
    margin-left:10px;
    padding-left:24px;
}

.day-item{
    position:relative;
    display:block;
    padding-bottom:28px;
    text-decoration:none;
}

.day-item::before{
    content:"";
    position:absolute;
    left:-35px;
    top:4px;
    width:18px;
    height:18px;
    border-radius:50%;
    background:#fff;
    border:3px solid var(--pink);
}

.day-item span{
    display:inline-flex;
    padding:10px 18px;
    border-radius:7px;
    background:var(--pink);
    color:#fff;
    font-weight:1000;
    margin-bottom:14px;
}

.day-item strong{
    display:block;
    color:#2b2f38;
    font-size:16px;
    line-height:1.5;
}

.timeline-detail{
    border-left:2px dashed var(--pink);
    padding-left:24px;
}

.timeline-block{
    position:relative;
    padding-bottom:54px;
}

.timeline-dot{
    position:absolute;
    left:-35px;
    top:3px;
    width:18px;
    height:18px;
    border-radius:50%;
    background:#fff;
    border:3px solid var(--pink);
}

.timeline-text h3{
    margin:0 0 20px;
    color:var(--pink);
    font-size:28px;
    line-height:1.25;
    font-weight:1000;
    text-transform:uppercase;
}

.timeline-text p{
    color:#111827;
    font-size:17px;
    line-height:1.85;
    margin:0 0 16px;
}

.center-book-btn{
    width:min(320px,100%);
    height:58px;
    margin:0 auto;
    border-radius:999px;
    background:var(--pink);
    color:#fff;
    font-weight:1000;
    display:flex;
    align-items:center;
    justify-content:center;
    text-decoration:none;
    box-shadow:0 16px 34px rgba(255,47,109,.23);
}

.rules-section{
    margin-top:58px;
}

.accordion-box{
    border:1px solid #e5e7eb;
    border-radius:16px;
    overflow:hidden;
    background:#fff;
}

.accordion-box details{
    border-bottom:1px solid #e5e7eb;
}

.accordion-box details:last-child{
    border-bottom:0;
}

.accordion-box summary{
    min-height:72px;
    padding:0 28px;
    cursor:pointer;
    display:flex;
    align-items:center;
    gap:16px;
    color:#111827;
    font-size:21px;
    font-weight:850;
    list-style:none;
}

.accordion-box summary::-webkit-details-marker{
    display:none;
}

.accordion-box summary::after{
    content:"\f107";
    font-family:"Font Awesome 6 Free";
    font-weight:900;
    margin-left:auto;
    color:#94a3b8;
}

.status-icon{
    width:28px;
    height:28px;
    border-radius:50%;
    display:inline-flex;
    align-items:center;
    justify-content:center;
    color:#fff;
    font-size:14px;
    flex:0 0 auto;
}

.status-icon.green{
    background:#52c41a;
}

.status-icon.red{
    background:#ff4d4f;
}

.status-icon.yellow{
    background:#f59e0b;
}

.accordion-content{
    padding:24px 68px 32px;
    border-top:1px solid #e5e7eb;
}

.accordion-content p,
.accordion-content li{
    color:#111827;
    font-size:17px;
    line-height:1.8;
}

.price-table-wrap{
    overflow-x:auto;
}

.price-table-wrap table{
    width:100%;
    border-collapse:collapse;
    min-width:720px;
}

.price-table-wrap th,
.price-table-wrap td{
    padding:18px 20px;
    border:1px solid #e5e7eb;
    text-align:left;
    font-size:16px;
}

.price-table-wrap th{
    background:#f8fafc;
    font-weight:1000;
}

.booking-form-section{
    margin-top:56px;
}

.booking-form-card{
    padding:28px;
    border-radius:20px;
    background:linear-gradient(135deg,#fff1f5,#ffffff);
    border:1px solid #ffd1df;
    display:flex;
    align-items:center;
    justify-content:space-between;
    gap:20px;
}

.booking-form-card h3{
    margin:0 0 8px;
    font-size:24px;
}

.booking-form-card p{
    margin:0;
    color:#64748b;
}

.booking-form-card a{
    height:54px;
    padding:0 28px;
    border-radius:999px;
    background:var(--pink);
    color:#fff;
    display:flex;
    align-items:center;
    justify-content:center;
    gap:8px;
    font-weight:1000;
    text-decoration:none;
    white-space:nowrap;
}



.review-section{
    margin-top:56px;
    padding:34px;
    border:1px solid #dbe5f1;
    border-radius:24px;
    background:linear-gradient(180deg,#ffffff 0%,#f8fbff 100%);
    box-shadow:0 18px 54px rgba(7,87,216,.08);
}

.review-section-head{
    display:flex;
    align-items:center;
    justify-content:space-between;
    gap:28px;
    margin-bottom:28px;
}

.review-kicker{
    display:inline-flex;
    align-items:center;
    gap:7px;
    margin-bottom:10px;
    color:var(--primary);
    font-size:12px;
    font-weight:900;
    letter-spacing:1.2px;
    text-transform:uppercase;
}

.review-kicker::before{
    content:"";
    width:26px;
    height:3px;
    border-radius:999px;
    background:var(--primary);
}

.review-section h2{
    margin:0;
    color:#0f172a;
    font-size:34px;
    line-height:1.2;
    font-weight:900;
    letter-spacing:-.5px;
}

.review-section h2 span{
    color:var(--primary);
}

.review-section-head p{
    margin:9px 0 0;
    max-width:680px;
    color:#64748b;
    font-size:15px;
    line-height:1.7;
}

.review-score-box{
    min-width:280px;
    padding:18px 20px;
    display:flex;
    align-items:center;
    gap:16px;
    border-radius:18px;
    background:#eff6ff;
    border:1px solid #bfdbfe;
    box-shadow:0 10px 26px rgba(7,87,216,.08);
}

.review-score-box > strong{
    color:var(--primary);
    font-size:44px;
    line-height:1;
    font-weight:900;
}

.review-score-box span{
    display:block;
    margin-top:5px;
    color:#475569;
    font-size:13px;
    font-weight:800;
}

.review-score-stars,
.review-stars{
    display:flex;
    gap:4px;
}

.review-score-stars i,
.review-stars i{
    color:#cbd5e1;
}

.review-score-stars i.active,
.review-stars i.active{
    color:#f59e0b;
}

.review-alert{
    display:flex;
    align-items:flex-start;
    gap:10px;
    margin-bottom:18px;
    padding:14px 16px;
    border-radius:14px;
    font-weight:800;
    line-height:1.6;
}

.review-alert-success{
    color:#047857;
    background:#ecfdf5;
    border:1px solid #a7f3d0;
}

.review-error{
    display:block;
    margin-top:7px;
    color:#dc2626;
    font-size:12px;
    font-weight:700;
}

.review-alert-error{
    color:#b91c1c;
    background:#fef2f2;
    border:1px solid #fecaca;
}

.review-grid{
    display:grid;
    grid-template-columns:minmax(0,.9fr) minmax(0,1.1fr);
    gap:24px;
    align-items:start;
}

.review-form-card,
.review-list-card{
    padding:26px;
    border:1px solid #dbe5f1;
    border-radius:20px;
    background:#fff;
    box-shadow:0 12px 32px rgba(15,23,42,.05);
}

.review-form-card{
    background:linear-gradient(180deg,#ffffff 0%,#f8fbff 100%);
}

.review-form-card h3,
.review-list-head h3{
    margin:0;
    color:#0f172a;
    font-size:22px;
    font-weight:900;
    letter-spacing:-.2px;
}

.review-form-description{
    margin:8px 0 22px;
    color:#64748b;
    font-size:14px;
    line-height:1.7;
}

.review-field{
    margin-bottom:18px;
}

.review-field > label{
    display:block;
    margin-bottom:8px;
    color:#0f172a;
    font-size:14px;
    font-weight:800;
}

.review-field > label span{
    color:#dc2626;
}

.review-field input[type="text"],
.review-field textarea{
    width:100%;
    border:1px solid #cbd5e1;
    border-radius:12px;
    padding:13px 14px;
    color:#0f172a;
    background:#fff;
    font-family:inherit;
    font-size:15px;
    outline:none;
    transition:.2s ease;
}

.review-field input[type="text"]::placeholder,
.review-field textarea::placeholder{
    color:#94a3b8;
}

.review-field input[type="text"]:focus,
.review-field textarea:focus{
    border-color:var(--primary);
    box-shadow:0 0 0 4px rgba(7,87,216,.10);
}

.review-field textarea{
    min-height:138px;
    resize:vertical;
}

.star-rating-input{
    display:inline-flex;
    flex-direction:row-reverse;
    gap:8px;
    padding:4px 0;
}

.star-rating-input input{
    position:absolute;
    opacity:0;
    pointer-events:none;
}

.star-rating-input label{
    color:#cbd5e1;
    font-size:29px;
    cursor:pointer;
    transition:.18s ease;
}

.star-rating-input label:hover,
.star-rating-input label:hover ~ label,
.star-rating-input input:checked ~ label{
    color:#f59e0b;
    transform:translateY(-2px) scale(1.04);
}

.review-submit-btn{
    width:100%;
    min-height:52px;
    border:0;
    border-radius:12px;
    display:flex;
    align-items:center;
    justify-content:center;
    gap:9px;
    background:var(--primary);
    color:#fff;
    font-family:inherit;
    font-size:15px;
    font-weight:900;
    cursor:pointer;
    box-shadow:0 12px 24px rgba(7,87,216,.20);
    transition:.2s ease;
}

.review-submit-btn:hover{
    background:#0044c7;
    transform:translateY(-1px);
}

.review-login-box{
    display:flex;
    align-items:center;
    gap:14px;
    padding:18px;
    border-radius:16px;
    background:#eff6ff;
    border:1px solid #bfdbfe;
}

.review-login-box > i{
    color:var(--primary);
    font-size:28px;
}

.review-login-box strong{
    display:block;
    color:#0f172a;
}

.review-login-box p{
    margin:4px 0 0;
    color:#64748b;
    font-size:14px;
}

.review-login-box a{
    margin-left:auto;
    padding:10px 16px;
    border-radius:10px;
    background:var(--primary);
    color:#fff;
    font-weight:900;
    text-decoration:none;
    white-space:nowrap;
}

.review-list-head{
    display:flex;
    align-items:center;
    justify-content:space-between;
    gap:12px;
    padding-bottom:16px;
    border-bottom:1px solid #e2e8f0;
}

.review-list-head span{
    padding:6px 10px;
    border-radius:999px;
    color:var(--primary);
    background:#eff6ff;
    font-size:12px;
    font-weight:900;
}

.review-list{
    display:grid;
    gap:14px;
    margin-top:16px;
}

.review-item{
    padding:18px;
    border:1px solid #e2e8f0;
    border-radius:16px;
    background:#fff;
    transition:.2s ease;
}

.review-item:hover{
    border-color:#bfdbfe;
    box-shadow:0 10px 24px rgba(7,87,216,.06);
}

.review-item-top{
    display:flex;
    align-items:flex-start;
    justify-content:space-between;
    gap:12px;
}

.review-user{
    display:flex;
    align-items:center;
    gap:11px;
}

.review-avatar{
    width:44px;
    height:44px;
    border-radius:50%;
    display:grid;
    place-items:center;
    color:#fff;
    background:linear-gradient(135deg,var(--primary),#60a5fa);
    font-weight:900;
    box-shadow:0 8px 18px rgba(7,87,216,.18);
}

.review-user strong{
    display:block;
    margin-bottom:5px;
    color:#0f172a;
    font-weight:900;
}

.review-item time{
    color:#94a3b8;
    font-size:13px;
    font-weight:700;
    white-space:nowrap;
}

.review-item h4{
    margin:16px 0 7px;
    color:#0f172a;
    font-size:17px;
    font-weight:900;
}

.review-item p{
    margin:0;
    color:#475569;
    font-size:15px;
    line-height:1.75;
}

.review-approved-badge{
    display:inline-flex;
    align-items:center;
    gap:6px;
    margin-top:14px;
    padding:5px 9px;
    border-radius:999px;
    color:#047857;
    background:#ecfdf5;
    font-size:11px;
    font-weight:900;
}

.review-empty{
    min-height:260px;
    display:flex;
    flex-direction:column;
    align-items:center;
    justify-content:center;
    text-align:center;
    color:#64748b;
    border:1px dashed #cbd5e1;
    border-radius:16px;
    background:#f8fafc;
}

.review-empty i{
    margin-bottom:12px;
    color:#93c5fd;
    font-size:42px;
}

.review-empty strong{
    color:#0f172a;
    font-size:18px;
    font-weight:900;
}

.review-empty p{
    margin:6px 0 0;
    max-width:360px;
    line-height:1.6;
}

@media(max-width:1200px){
    .review-grid{
        grid-template-columns:1fr;
    }

    .detail-top-grid{
        grid-template-columns:1fr;
    }

    .booking-card{
        position:static;
    }

    .schedule-section{
        grid-template-columns:1fr;
    }

    .schedule-left{
        position:static;
    }
}

@media(max-width:768px){
    .review-section{
        padding:22px;
    }

    .review-section-head{
        align-items:flex-start;
        flex-direction:column;
    }

    .review-score-box{
        width:100%;
        min-width:0;
    }

    .review-login-box{
        align-items:flex-start;
        flex-wrap:wrap;
    }

    .review-login-box a{
        width:100%;
        margin-left:0;
        text-align:center;
    }

    .tour-detail-container{
        width:calc(100% - 24px);
    }

    .main-image{
        height:320px;
    }

    .gallery-thumbs{
        justify-content:flex-start;
        overflow-x:auto;
        padding-bottom:8px;
    }

    .booking-info-grid{
        grid-template-columns:1fr;
    }

    .booking-actions{
        grid-template-columns:1fr;
    }

    .overview-card{
        padding:22px;
    }

    .overview-card h2,
    .rules-section h2,
    .booking-form-section h2,
    .schedule-left h2,
    .schedule-right h2{
        font-size:28px;
    }

    .timeline-text h3{
        font-size:23px;
    }

    .accordion-box summary{
        padding:0 18px;
        font-size:18px;
    }

    .accordion-content{
        padding:20px 24px 28px;
    }

    .booking-form-card{
        flex-direction:column;
        align-items:flex-start;
    }

    .booking-form-card a{
        width:100%;
    }
}

@media(max-width:480px){
    .tour-title-box h1{
        font-size:28px;
    }

    .price-box strong{
        font-size:32px;
    }

    .main-image{
        height:260px;
    }

    .schedule-left h2,
    .schedule-right h2,
    .rules-section h2{
        font-size:25px;
    }
}
</style>

@endsection