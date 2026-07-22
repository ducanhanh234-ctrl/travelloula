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

    $lichGanNhat = $lichGanNhat ?? $tour->lichKhoiHanhTours
        ->where('trang_thai', 'available')
        ->sortBy('ngay_khoi_hanh')
        ->first();

    $soSaoTrungBinh = $soSaoTrungBinh ?? $tour->danhGia->avg('so_sao');
    $tongDanhGia = $tongDanhGia ?? $tour->danhGia->count();
    $soLuotDat = $soLuotDat ?? $tour->datTours()->count();


    $statusMap = [
        'available' => [
            'label' => 'Đang mở',
            'class' => 'departure-status-available',
        ],
        'running' => [
            'label' => 'Đang diễn ra',
            'class' => 'departure-status-running',
        ],
        'full' => [
            'label' => 'Hết chỗ',
            'class' => 'departure-status-full',
        ],
        'closed' => [
            'label' => 'Đã đóng',
            'class' => 'departure-status-closed',
        ],
    ];
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
                @php
                    $slideImages = collect([$mainImage]);

                    foreach ($tour->hinhAnhTours as $image) {
                        /*
                         * Hỗ trợ nhiều tên cột ảnh thường dùng.
                         * Ưu tiên duong_dan_anh, sau đó thử các cột còn lại.
                         */
                        $imagePath = $image->duong_dan_anh
                            ?? $image->hinh_anh
                            ?? $image->anh
                            ?? $image->image_path
                            ?? $image->url
                            ?? null;

                        if (!empty($imagePath)) {
                            $slideImage = \Illuminate\Support\Str::startsWith(
                                $imagePath,
                                ['http://', 'https://']
                            )
                                ? $imagePath
                                : asset($imagePath);

                            $slideImages->push($slideImage);
                        }
                    }

                    $slideImages = $slideImages
                        ->filter()
                        ->unique()
                        ->values();
                @endphp

                <div class="tour-slideshow" id="tourSlideshow">
                    <div class="tour-slides">
                        @foreach($slideImages as $index => $slideImage)
                            <div
                                class="tour-slide {{ $index === 0 ? 'active' : '' }}"
                                data-slide-index="{{ $index }}"
                                style="--slide-bg: url('{{ $slideImage }}');"
                            >
                                <img
                                    class="tour-slide-image"
                                    src="{{ $slideImage }}"
                                    alt="{{ $tour->ten_tour }} - ảnh {{ $index + 1 }}"
                                    loading="{{ $index === 0 ? 'eager' : 'lazy' }}"
                                    decoding="async"
                                    onerror="this.onerror=null;this.src='{{ $fallbackImage }}';"
                                >
                            </div>
                        @endforeach
                    </div>

                    @if($slideImages->count() > 1)
                        <button
                            type="button"
                            class="slide-nav slide-prev"
                            aria-label="Ảnh trước"
                        >
                            <i class="fa-solid fa-chevron-left"></i>
                        </button>

                        <button
                            type="button"
                            class="slide-nav slide-next"
                            aria-label="Ảnh tiếp theo"
                        >
                            <i class="fa-solid fa-chevron-right"></i>
                        </button>

                        <div class="slide-counter">
                            <span id="currentSlideNumber">1</span>
                            /
                            <span>{{ $slideImages->count() }}</span>
                        </div>
                    @endif

                    <button type="button" class="zoom-btn" id="openSlideLightbox">
                        <i class="fa-solid fa-up-right-and-down-left-from-center"></i>
                    </button>
                </div>

                <div class="gallery-thumbs" id="galleryThumbs">
                    @foreach($slideImages->take(5) as $index => $slideImage)
                        <button
                            type="button"
                            class="gallery-thumb {{ $index === 0 ? 'active' : '' }}"
                            data-slide-to="{{ $index }}"
                            aria-label="Xem ảnh {{ $index + 1 }}"
                        >
                            <img
                                src="{{ $slideImage }}"
                                alt="{{ $tour->ten_tour }} - ảnh nhỏ {{ $index + 1 }}"
                                onerror="this.onerror=null;this.src='{{ $fallbackImage }}';"
                            >
                        </button>
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



                <div class="booking-actions">
                    <a href="{{ route('create_dat_tour', $tour->id) }}" class="book-btn">
                        <i class="fa-solid fa-calendar-check"></i>
                        Đặt tour
                    </a>

                    <a href="tel:0965634066" class="consult-btn">
                        Tư vấn
                    </a>
                </div>

                {{-- <div class="contact-line">
                    Liên hệ:
                    <strong>0965634066</strong>
                    <span>-</span>
                    <strong>event@travelloula.vn</strong>
                </div> --}}
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
                    <h2>LỊCH TRÌNH <span>TOUR</span></h2>

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
                    <h2>CHI TIẾT <span>LỊCH TRÌNH TOUR</span></h2>

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

                    <a href="{{ route('create_dat_tour', $tour->id) }}" class="center-book-btn">
                        ĐẶT TOUR NGAY
                    </a>
                </div>
            </section>
        @endif

        <section class="rules-section">
            <h2>QUY ĐỊNH <span>DỊCH VỤ</span></h2>

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

                                    </tr>
                                </thead>

                                <tbody>
                                    @forelse($tour->lichKhoiHanhTours->sortBy('ngay_khoi_hanh')->take(6) as $lich)
                                        <tr>
                                            <td>{{ \Carbon\Carbon::parse($lich->ngay_khoi_hanh)->format('d/m/Y') }}</td>
                                            <td>{{ number_format($giaNguoiLon, 0, ',', '.') }} VND</td>
                                            <td>{{ number_format($giaTreEm, 0, ',', '.') }} VND</td>

                                        </tr>
                                    @empty
                                        <tr>
                                            <td>Đang cập nhật</td>
                                            <td>{{ number_format($giaNguoiLon, 0, ',', '.') }} VND</td>
                                            <td>{{ number_format($giaTreEm, 0, ',', '.') }} VND</td>

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

        <section class="review-section" id="danh-gia">
            <div class="review-section-head">
                <div>
                    <span class="review-kicker">TRẢI NGHIỆM KHÁCH HÀNG</span>
                    <h2>ĐÁNH GIÁ <span>TOUR</span></h2>
                    <p>
                        Mọi tài khoản đã đăng nhập đều có thể đánh giá tour. Đánh giá hiển thị ngay sau khi gửi.
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
                        <span>{{ $tongDanhGia }} đánh giá</span>
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
                        Bạn có thể gửi nhiều đánh giá cho tour này. Mỗi lần gửi sẽ tạo một đánh giá mới.
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
                                Gửi đánh giá mới
                            </button>
                        </form>
                    @else
                        <div class="review-login-box">
                            <i class="fa-solid fa-user-lock"></i>
                            <div>
                                <strong>Bạn cần đăng nhập</strong>
                                <p>Đăng nhập để gửi đánh giá cho tour này.</p>
                            </div>

                            <a href="{{ route('login') }}">
                                Đăng nhập
                            </a>
                        </div>
                    @endauth
                </div>

                <div class="review-list-card">
                    <div class="review-list-head">
                        <h3>Đánh giá khách hàng</h3>
                        <span>{{ $tongDanhGia }} đánh giá</span>
                    </div>

                    <div class="review-list">
                        @forelse($tour->danhGia as $danhGia)
                            <article class="review-item">
                                <div class="review-item-top">
                                    <div class="review-user">
                                        <div class="review-avatar">
                                            {{ mb_strtoupper(mb_substr(
                                                $danhGia->user?->name
                                                    ?? $danhGia->khachHangDatTour?->ho_ten
                                                    ?? 'K',
                                                0,
                                                1
                                            )) }}
                                        </div>

                                        <div>
                                            <strong>
                                                {{ $danhGia->user?->name
                                                    ?? $danhGia->khachHangDatTour?->ho_ten
                                                    ?? 'Khách hàng' }}
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

                                <span class="review-public-badge">
                                    <i class="fa-solid fa-eye"></i>
                                    Đang hiển thị công khai
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

        <section class="consultation-section" id="tu-van-tour">
            <div class="consultation-icon">
                <i class="fa-solid fa-headset"></i>
            </div>

            <div class="consultation-content">
                <span>HỖ TRỢ TƯ VẤN</span>
                <h2>Bạn cần tư vấn thêm về tour?</h2>
                <p>
                    Liên hệ Travelloula để được hỗ trợ về lịch khởi hành, số lượng khách,
                    dịch vụ đi kèm và các yêu cầu riêng cho gia đình hoặc doanh nghiệp.
                </p>
            </div>

            <div class="consultation-actions">
                <a href="tel:0965634066" class="consultation-call">
                    <i class="fa-solid fa-phone"></i>
                    <span>
                        <small>Hotline</small>
                        <strong>0965634066</strong>
                    </span>
                </a>

                <a href="mailto:event@travelloula.vn" class="consultation-mail">
                    <i class="fa-regular fa-envelope"></i>
                    <span>
                        <small>Email</small>
                        <strong>event@travelloula.vn</strong>
                    </span>
                </a>
            </div>
        </section>

    </div>
</section>

<div class="slide-lightbox" id="slideLightbox" aria-hidden="true">
    <button type="button" class="lightbox-close" aria-label="Đóng">
        <i class="fa-solid fa-xmark"></i>
    </button>

    <button type="button" class="lightbox-nav lightbox-prev" aria-label="Ảnh trước">
        <i class="fa-solid fa-chevron-left"></i>
    </button>

    <img id="lightboxImage" src="" alt="{{ $tour->ten_tour }}">

    <button type="button" class="lightbox-nav lightbox-next" aria-label="Ảnh tiếp theo">
        <i class="fa-solid fa-chevron-right"></i>
    </button>
</div>

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

.review-public-badge{
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

/* =========================================================
   ĐỒNG BỘ MÀU TOÀN BỘ TRANG CHI TIẾT TOUR THEO LAYOUT XANH
   ========================================================= */
:root{
    --primary:#0757d8;
    --primary-dark:#0044c7;
    --primary-soft:#eff6ff;
    --primary-line:#bfdbfe;
    --accent:#f59e0b;
    --text:#0f172a;
    --muted:#64748b;
    --line:#e2e8f0;
    --soft:#f8fbff;

    /* Ghi đè màu hồng cũ */
    --pink:var(--primary);
    --pink-dark:var(--primary-dark);
    --orange:var(--accent);
}

/* Card thông tin đặt tour */
.booking-card{
    border:1px solid #dbe5f1;
    box-shadow:0 18px 54px rgba(7,87,216,.09);
}

.booking-info-grid i{
    color:var(--primary);
}

.price-box strong{
    color:var(--primary);
}

.price-detail{
    background:linear-gradient(180deg,#f8fbff 0%,#ffffff 100%);
    border-color:#dbeafe;
}

.nearest-date{
    background:linear-gradient(135deg,#eff6ff,#f8fbff);
    border-color:#bfdbfe;
}

.nearest-date small,
.schedule-mini-item strong{
    color:var(--primary);
}

.schedule-mini-item{
    background:#f8fbff;
    border-color:#dbeafe;
}

.book-btn{
    background:linear-gradient(135deg,var(--primary),var(--primary-dark));
    box-shadow:0 14px 30px rgba(7,87,216,.22);
}

.book-btn:hover{
    background:var(--primary-dark);
}

.consult-btn{
    border-color:var(--primary);
    color:var(--primary);
}

.consult-btn:hover{
    color:var(--primary-dark);
    background:#eff6ff;
}

/* Lịch trình */
.schedule-left h2 span,
.schedule-right h2 span,
.rules-section h2 span,
.booking-form-section h2 span{
    color:var(--primary);
}

.day-list,
.timeline-detail{
    border-left-color:var(--primary);
}

.day-item::before,
.timeline-dot{
    border-color:var(--primary);
}

.day-item span{
    background:linear-gradient(135deg,var(--primary),var(--primary-dark));
}

.timeline-text h3{
    color:var(--primary);
}

.center-book-btn{
    background:linear-gradient(135deg,var(--primary),var(--primary-dark));
    box-shadow:0 16px 34px rgba(7,87,216,.22);
}

.center-book-btn:hover{
    background:var(--primary-dark);
    color:#fff;
}

/* Quy định dịch vụ */
.rules-section{
    padding:30px;
    border:1px solid #dbe5f1;
    border-radius:24px;
    background:linear-gradient(180deg,#ffffff,#f8fbff);
    box-shadow:0 18px 50px rgba(7,87,216,.06);
}

.accordion-box{
    border-color:#dbe5f1;
    box-shadow:0 12px 30px rgba(15,23,42,.04);
}

.accordion-box summary{
    background:#fff;
}

.accordion-box details[open] summary{
    color:var(--primary);
    background:#f8fbff;
}

.accordion-content{
    background:#fff;
}

/* Khối liên hệ đặt tour */
.booking-form-card{
    background:linear-gradient(135deg,#eff6ff,#ffffff);
    border-color:#bfdbfe;
    box-shadow:0 14px 34px rgba(7,87,216,.08);
}

.booking-form-card a{
    background:linear-gradient(135deg,var(--primary),var(--primary-dark));
    box-shadow:0 12px 24px rgba(7,87,216,.20);
}

/* =========================================================
   PHẦN ĐÁNH GIÁ TOUR
   ========================================================= */
.review-section{
    position:relative;
    overflow:hidden;
    margin-top:64px;
    padding:38px;
    border:1px solid #cfe0f5;
    border-radius:26px;
    background:
        radial-gradient(circle at top right,rgba(59,130,246,.10),transparent 34%),
        linear-gradient(180deg,#ffffff 0%,#f8fbff 100%);
    box-shadow:0 22px 60px rgba(7,87,216,.09);
}

.review-section::before{
    content:"";
    position:absolute;
    top:0;
    left:0;
    width:100%;
    height:5px;
    background:linear-gradient(90deg,var(--primary),#38bdf8);
}

.review-section-head{
    align-items:stretch;
}

.review-section-head > div:first-child{
    display:flex;
    flex-direction:column;
    justify-content:center;
}

.review-kicker{
    color:var(--primary);
}

.review-kicker::before{
    background:linear-gradient(90deg,var(--primary),#38bdf8);
}

.review-score-box{
    min-width:300px;
    padding:22px;
    border-color:#bfdbfe;
    background:linear-gradient(135deg,#eff6ff,#ffffff);
    box-shadow:0 12px 28px rgba(7,87,216,.10);
}

.review-score-box > strong{
    color:var(--primary);
}

.review-form-card,
.review-list-card{
    border-color:#dbe5f1;
    box-shadow:0 14px 36px rgba(15,23,42,.06);
}

.review-form-card{
    background:linear-gradient(180deg,#ffffff,#f8fbff);
}

.review-list-card{
    background:#fff;
}

.review-field input[type="text"],
.review-field textarea{
    border-color:#cbd5e1;
    background:#fff;
}

.review-field input[type="text"]:focus,
.review-field textarea:focus{
    border-color:var(--primary);
    box-shadow:0 0 0 4px rgba(7,87,216,.11);
}

.star-rating-input{
    padding:8px 12px;
    border:1px solid #dbe5f1;
    border-radius:12px;
    background:#fff;
}

.review-submit-btn{
    min-height:54px;
    border-radius:13px;
    background:linear-gradient(135deg,var(--primary),var(--primary-dark));
    box-shadow:0 14px 26px rgba(7,87,216,.20);
}

.review-submit-btn:hover{
    background:var(--primary-dark);
}

.review-list-head{
    padding-bottom:18px;
}

.review-list-head span{
    color:var(--primary);
    background:#eff6ff;
    border:1px solid #dbeafe;
}

.review-item{
    border-color:#e2e8f0;
    background:linear-gradient(180deg,#ffffff,#fbfdff);
}

.review-item:hover{
    transform:translateY(-2px);
    border-color:#bfdbfe;
    box-shadow:0 12px 26px rgba(7,87,216,.08);
}

.review-avatar{
    background:linear-gradient(135deg,var(--primary),#38bdf8);
}

.review-public-badge{
    color:#047857;
    background:#ecfdf5;
    border:1px solid #a7f3d0;
}

.review-empty{
    min-height:300px;
    border-color:#bfdbfe;
    background:linear-gradient(180deg,#f8fbff,#ffffff);
}

.review-empty i{
    color:var(--primary);
}

/* Responsive */
@media(max-width:768px){
    .rules-section{
        padding:22px;
    }

    .review-section{
        padding:24px;
    }

    .review-score-box{
        min-width:0;
    }
}


/* =========================================================
   REDESIGN PHẦN ĐÁNH GIÁ - GỌN, CÂN ĐỐI, KHÔNG BỊ PHÓNG TO
   ========================================================= */
.review-section{
    margin-top:56px;
    padding:28px;
    border:1px solid #dbe5f1;
    border-radius:20px;
    background:#fff;
    box-shadow:0 14px 40px rgba(15,23,42,.07);
}

.review-section::before{
    height:4px;
    background:linear-gradient(90deg,#0757d8,#38bdf8);
}

.review-section-head{
    display:grid;
    grid-template-columns:minmax(0,1fr) auto;
    align-items:center;
    gap:24px;
    margin-bottom:24px;
}

.review-kicker{
    margin-bottom:6px;
    font-size:11px;
    letter-spacing:1px;
}

.review-section h2{
    font-size:30px;
    line-height:1.15;
}

.review-section-head p{
    margin-top:7px;
    font-size:14px;
    line-height:1.55;
}

.review-score-box{
    min-width:230px;
    padding:15px 18px;
    border-radius:14px;
    gap:13px;
    background:#f8fbff;
    border:1px solid #d6e5fb;
    box-shadow:none;
}

.review-score-box > strong{
    font-size:38px;
}

.review-score-box span{
    font-size:12px;
}

.review-grid{
    display:grid;
    grid-template-columns:minmax(0,.82fr) minmax(0,1.18fr);
    gap:20px;
    align-items:stretch;
}

.review-form-card,
.review-list-card{
    padding:22px;
    border-radius:16px;
    border:1px solid #e2e8f0;
    box-shadow:none;
}

.review-form-card{
    background:#fbfdff;
}

.review-list-card{
    background:#fff;
}

.review-form-card h3,
.review-list-head h3{
    font-size:20px;
}

.review-form-description{
    margin:6px 0 18px;
    font-size:13px;
}

.review-field{
    margin-bottom:15px;
}

.review-field > label{
    margin-bottom:7px;
    font-size:13px;
}

.review-field input[type="text"],
.review-field textarea{
    border-radius:10px;
    padding:11px 12px;
    font-size:14px;
}

.review-field textarea{
    min-height:118px;
}

.star-rating-input{
    display:flex;
    width:max-content;
    padding:7px 10px;
    gap:5px;
    border-radius:10px;
    background:#fff;
}

.star-rating-input label{
    font-size:25px;
}

.review-submit-btn{
    min-height:46px;
    border-radius:10px;
    font-size:14px;
    box-shadow:none;
}

.review-list-head{
    padding-bottom:13px;
}

.review-list{
    gap:12px;
    margin-top:14px;
}

.review-item{
    padding:15px;
    border-radius:13px;
}

.review-avatar{
    width:40px;
    height:40px;
}

.review-item h4{
    margin:13px 0 6px;
    font-size:16px;
}

.review-item p{
    font-size:14px;
    line-height:1.65;
}

.review-empty{
    min-height:230px;
    border-radius:13px;
    background:#fbfdff;
}

.review-empty i{
    font-size:34px;
    margin-bottom:10px;
}

.review-empty strong{
    font-size:17px;
}

.review-empty p{
    font-size:14px;
}

@media(max-width:1200px){
    .review-grid{
        grid-template-columns:1fr;
    }
}

@media(max-width:768px){
    .review-section{
        padding:20px;
    }

    .review-section-head{
        grid-template-columns:1fr;
    }

    .review-score-box{
        width:100%;
        min-width:0;
    }
}


/* FULL LỊCH KHỞI HÀNH + LỊCH RIÊNG */
.schedule-mini-full{margin:18px 0 0;}
.schedule-mini-heading{display:flex;align-items:flex-end;justify-content:space-between;gap:16px;margin-bottom:12px;}
.schedule-mini-heading span{display:block;margin-bottom:4px;color:var(--primary);font-size:11px;font-weight:900;letter-spacing:.8px;}
.schedule-mini-heading h3{margin:0;color:#0f172a;font-size:18px;}
.schedule-mini-heading>strong{padding:6px 10px;border-radius:999px;color:var(--primary);background:#eff6ff;border:1px solid #dbeafe;font-size:11px;}
.schedule-mini-list{display:grid;gap:9px;max-height:330px;overflow:auto;padding-right:4px;}
.schedule-mini-item-full{display:flex;align-items:center;justify-content:space-between;gap:12px;padding:12px;border:1px solid #dbe5f1;border-radius:13px;background:#fbfdff;}
.schedule-mini-date{display:flex;align-items:center;gap:10px;min-width:0;}
.schedule-mini-date>i{width:34px;height:34px;flex:0 0 34px;display:grid;place-items:center;border-radius:10px;color:var(--primary);background:#eff6ff;}
.schedule-mini-date strong{display:block;color:#0f172a;font-size:13px;}
.schedule-mini-date span{display:block;margin-top:3px;color:#64748b;font-size:11px;}
.schedule-mini-actions{display:flex;align-items:flex-end;flex-direction:column;gap:6px;}
.schedule-status{display:inline-flex;align-items:center;justify-content:center;min-width:92px;padding:6px 10px;border-radius:999px;border:1px solid transparent;font-size:10px;font-weight:900;white-space:nowrap;}
.schedule-status-available{color:#047857;background:#dcfce7;border-color:#bbf7d0;}
.schedule-status-running{color:#0369a1;background:#e0f2fe;border-color:#bae6fd;}
.schedule-status-full{color:#b45309;background:#fef3c7;border-color:#fde68a;}
.schedule-status-closed{color:#475569;background:#e2e8f0;border-color:#cbd5e1;}
.schedule-status-unknown{color:#64748b;background:#f1f5f9;border-color:#e2e8f0;}
.schedule-select-btn{color:var(--primary);font-size:11px;font-weight:900;text-decoration:none;}
.schedule-select-btn.disabled{color:#94a3b8;cursor:not-allowed;}
.schedule-mini-empty{display:flex;align-items:center;gap:9px;padding:14px;color:#64748b;border:1px dashed #cbd5e1;border-radius:13px;background:#f8fafc;}

.booking-form-section{margin-top:58px;padding:30px;border:1px solid #dbe5f1;border-radius:24px;background:linear-gradient(180deg,#ffffff,#f8fbff);box-shadow:0 18px 50px rgba(7,87,216,.07);}
.booking-form-head{margin-bottom:22px;}
.booking-form-head>span{display:block;margin-bottom:5px;color:var(--primary);font-size:11px;font-weight:900;letter-spacing:1px;}
.booking-form-head h2{margin:0 0 8px;color:#0f172a;font-size:30px;}
.booking-form-head p{max-width:850px;margin:0;color:#64748b;line-height:1.65;}
.booking-schedule-list{display:grid;gap:12px;}
.booking-schedule-card{display:grid;grid-template-columns:auto minmax(0,1fr) auto;align-items:center;gap:16px;padding:16px 18px;border:1px solid #dbe5f1;border-radius:16px;background:#fff;transition:.2s ease;}
.booking-schedule-card.is-bookable:hover{transform:translateY(-2px);border-color:#93c5fd;box-shadow:0 12px 26px rgba(7,87,216,.08);}
.booking-schedule-card.is-disabled{background:#f8fafc;opacity:.78;}
.booking-schedule-icon{width:46px;height:46px;display:grid;place-items:center;border-radius:13px;color:var(--primary);background:#eff6ff;font-size:19px;}
.booking-schedule-title{display:flex;align-items:center;gap:12px;flex-wrap:wrap;}
.booking-schedule-title>strong{color:#0f172a;font-size:17px;}
.booking-schedule-meta{display:flex;flex-wrap:wrap;gap:10px 18px;margin-top:7px;color:#64748b;font-size:13px;}
.booking-schedule-meta span{display:inline-flex;align-items:center;gap:6px;}
.booking-schedule-meta i{color:var(--primary);}
.booking-schedule-btn{min-width:150px;height:44px;padding:0 18px;border:0;border-radius:11px;display:inline-flex;align-items:center;justify-content:center;gap:8px;color:#fff;background:linear-gradient(135deg,var(--primary),var(--primary-dark));font-weight:900;text-decoration:none;cursor:pointer;}
.booking-schedule-btn.disabled{color:#64748b;background:#e2e8f0;cursor:not-allowed;}
.booking-schedule-empty{display:flex;align-items:center;gap:14px;padding:20px;border:1px dashed #cbd5e1;border-radius:16px;background:#f8fafc;}

.private-schedule-card{display:grid;grid-template-columns:auto minmax(0,1fr) auto;align-items:center;gap:18px;margin-top:22px;padding:22px;border:1px solid #bfdbfe;border-radius:18px;background:radial-gradient(circle at top right,rgba(56,189,248,.13),transparent 38%),linear-gradient(135deg,#eff6ff,#ffffff);}
.private-schedule-icon{width:56px;height:56px;display:grid;place-items:center;border-radius:16px;color:#fff;background:linear-gradient(135deg,var(--primary),#38bdf8);font-size:22px;}
.private-schedule-content>span{display:block;margin-bottom:4px;color:var(--primary);font-size:11px;font-weight:900;letter-spacing:.9px;}
.private-schedule-content h3{margin:0 0 7px;color:#0f172a;font-size:21px;}
.private-schedule-content p{margin:0;color:#64748b;line-height:1.6;}
.private-schedule-actions{display:flex;gap:10px;flex-wrap:wrap;justify-content:flex-end;}
.private-schedule-actions a{min-height:42px;padding:0 15px;border-radius:10px;display:inline-flex;align-items:center;justify-content:center;gap:7px;font-size:13px;font-weight:900;text-decoration:none;}
.private-call-btn{color:#fff;background:var(--primary);}
.private-mail-btn{color:var(--primary);background:#fff;border:1px solid #93c5fd;}

@media(max-width:900px){
    .booking-schedule-card,.private-schedule-card{grid-template-columns:1fr;}
    .booking-schedule-action,.private-schedule-actions{width:100%;justify-content:flex-start;}
    .booking-schedule-btn{width:100%;}
}
@media(max-width:560px){
    .booking-form-section{padding:20px;}
    .schedule-mini-item-full{align-items:flex-start;flex-direction:column;}
    .schedule-mini-actions{width:100%;align-items:flex-start;}
    .booking-schedule-title{align-items:flex-start;flex-direction:column;}
    .private-schedule-actions{flex-direction:column;}
    .private-schedule-actions a{width:100%;}
}


/* SLIDESHOW ẢNH TOUR */
.tour-slideshow{
    position:relative;
    height:560px;
    overflow:hidden;
    border-radius:16px;
    background:#e5e7eb;
    box-shadow:0 16px 42px rgba(15,23,42,.13);
}

.tour-slides,
.tour-slide{
    width:100%;
    height:100%;
}

.tour-slide{
    position:absolute;
    inset:0;
    opacity:0;
    visibility:hidden;
    transform:scale(1.02);
    transition:opacity .45s ease, transform .6s ease, visibility .45s ease;
}

.tour-slide.active{
    opacity:1;
    visibility:visible;
    transform:scale(1);
}

.tour-slide img{
    width:100%;
    height:100%;
    display:block;
    object-fit:cover;
}

.slide-nav{
    position:absolute;
    top:50%;
    z-index:4;
    width:46px;
    height:46px;
    border:0;
    border-radius:50%;
    display:grid;
    place-items:center;
    color:#0757d8;
    background:rgba(255,255,255,.94);
    box-shadow:0 10px 24px rgba(15,23,42,.18);
    cursor:pointer;
    transform:translateY(-50%);
    transition:.2s ease;
}

.slide-nav:hover{
    color:#fff;
    background:#0757d8;
}

.slide-prev{
    left:18px;
}

.slide-next{
    right:18px;
}

.slide-counter{
    position:absolute;
    left:18px;
    bottom:18px;
    z-index:4;
    padding:7px 12px;
    border-radius:999px;
    color:#fff;
    background:rgba(15,23,42,.66);
    font-size:13px;
    font-weight:900;
    backdrop-filter:blur(5px);
}

.gallery-thumbs{
    margin-top:14px;
    position:relative;
    z-index:3;
    display:flex;
    justify-content:flex-start;
    gap:10px;
    padding:0;
    overflow-x:auto;
    scrollbar-width:thin;
}

.gallery-thumb{
    width:78px;
    height:58px;
    flex:0 0 78px;
    padding:0;
    overflow:hidden;
    border:2px solid transparent;
    border-radius:10px;
    background:#fff;
    box-shadow:0 7px 16px rgba(15,23,42,.12);
    cursor:pointer;
    opacity:.72;
    transition:.2s ease;
}

.gallery-thumb:hover,
.gallery-thumb.active{
    opacity:1;
    border-color:#0757d8;
    transform:translateY(-2px);
}

.gallery-thumb img{
    width:100%;
    height:100%;
    display:block;
    object-fit:cover;
}

.slide-lightbox{
    position:fixed;
    inset:0;
    z-index:99999;
    display:none;
    align-items:center;
    justify-content:center;
    padding:30px;
    background:rgba(2,6,23,.92);
    backdrop-filter:blur(7px);
}

.slide-lightbox.show{
    display:flex;
}

.slide-lightbox > img{
    max-width:min(1180px,calc(100vw - 160px));
    max-height:calc(100vh - 80px);
    border-radius:14px;
    object-fit:contain;
    box-shadow:0 26px 70px rgba(0,0,0,.45);
}

.lightbox-close{
    position:absolute;
    top:22px;
    right:22px;
    width:46px;
    height:46px;
    border:0;
    border-radius:50%;
    display:grid;
    place-items:center;
    color:#fff;
    background:rgba(255,255,255,.16);
    font-size:20px;
    cursor:pointer;
}

.lightbox-nav{
    position:absolute;
    top:50%;
    width:50px;
    height:50px;
    border:0;
    border-radius:50%;
    display:grid;
    place-items:center;
    color:#fff;
    background:rgba(255,255,255,.16);
    font-size:20px;
    cursor:pointer;
    transform:translateY(-50%);
}

.lightbox-prev{
    left:26px;
}

.lightbox-next{
    right:26px;
}

@media(max-width:768px){
    .tour-slideshow{
        height:320px;
    }

    .slide-nav{
        width:40px;
        height:40px;
    }

    .slide-prev{
        left:10px;
    }

    .slide-next{
        right:10px;
    }

    .slide-lightbox{
        padding:18px;
    }

    .slide-lightbox > img{
        max-width:calc(100vw - 36px);
        max-height:calc(100vh - 110px);
    }

    .lightbox-nav{
        width:42px;
        height:42px;
    }

    .lightbox-prev{
        left:12px;
    }

    .lightbox-next{
        right:12px;
    }
}

@media(max-width:480px){
    .tour-slideshow{
        height:260px;
    }

    .gallery-thumb{
        width:66px;
        height:50px;
        flex-basis:66px;
    }
}


/* KHUNG ẢNH NHỎ LUÔN HIỂN THỊ */
.gallery-thumbs-wrap{
    margin-top:14px;
    padding:14px;
    border:1px solid #dbe5f1;
    border-radius:15px;
    background:#fff;
    box-shadow:0 10px 26px rgba(15,23,42,.05);
}

.gallery-thumbs-head{
    display:flex;
    align-items:center;
    justify-content:space-between;
    gap:12px;
    margin-bottom:10px;
}

.gallery-thumbs-head strong{
    color:#0f172a;
    font-size:14px;
    font-weight:900;
}

.gallery-thumbs-head span{
    padding:5px 9px;
    border-radius:999px;
    color:var(--primary);
    background:#eff6ff;
    border:1px solid #dbeafe;
    font-size:11px;
    font-weight:900;
}

.gallery-thumbs-wrap .gallery-thumbs{
    margin-top:0;
}

.gallery-single-note{
    margin:10px 0 0;
    color:#64748b;
    font-size:12px;
    line-height:1.55;
}


/* =========================================================
   HIỂN THỊ ẢNH THẤP ĐỘ PHÂN GIẢI KHÔNG BỊ PHÓNG VỠ
   ========================================================= */
.tour-slide{
    display:flex;
    align-items:center;
    justify-content:center;
    isolation:isolate;
    background:#dbe5f1;
}

.tour-slide::before{
    content:"";
    position:absolute;
    inset:-28px;
    z-index:0;
    background-image:var(--slide-bg);
    background-position:center;
    background-size:cover;
    background-repeat:no-repeat;
    filter:blur(24px) brightness(.78) saturate(1.08);
    transform:scale(1.10);
    opacity:.72;
}

.tour-slide::after{
    content:"";
    position:absolute;
    inset:0;
    z-index:1;
    background:linear-gradient(
        180deg,
        rgba(15,23,42,.08),
        rgba(15,23,42,.16)
    );
    pointer-events:none;
}

.tour-slide-image{
    position:relative;
    z-index:2;
    width:auto !important;
    height:auto !important;
    max-width:100%;
    max-height:100%;
    object-fit:contain !important;
    object-position:center;
    image-rendering:auto;
    box-shadow:0 16px 38px rgba(15,23,42,.18);
}

/* Ảnh đủ lớn mới được phép phủ kín khung */
.tour-slide.high-resolution .tour-slide-image{
    width:100% !important;
    height:100% !important;
    max-width:none;
    max-height:none;
    object-fit:cover !important;
    box-shadow:none;
}

.tour-slide.high-resolution::before{
    opacity:0;
}

.tour-slide.low-resolution .tour-slide-image{
    border-radius:10px;
}

/* Ảnh nhỏ trong gallery luôn sắc nét, không bị kéo méo */
.gallery-thumb img{
    width:100%;
    height:100%;
    object-fit:cover;
    object-position:center;
    image-rendering:auto;
}


/* 5 ẢNH NHỎ NẰM NGAY DƯỚI ẢNH LỚN */
.gallery-thumbs-wrap,
.gallery-thumbs-head,
.gallery-single-note{
    display:none !important;
}

.detail-left > .gallery-thumbs{
    margin-top:8px !important;
    padding:0 !important;
    display:grid !important;
    grid-template-columns:repeat(5,minmax(0,1fr));
    gap:8px;
    overflow:visible;
}

.detail-left > .gallery-thumbs .gallery-thumb{
    width:100% !important;
    height:76px !important;
    min-width:0;
    flex:initial !important;
    border-radius:10px;
    border:2px solid transparent;
    box-shadow:0 6px 16px rgba(15,23,42,.10);
}

.detail-left > .gallery-thumbs .gallery-thumb.active{
    border-color:var(--primary);
    box-shadow:0 0 0 2px rgba(7,87,216,.10);
}

.detail-left > .gallery-thumbs .gallery-thumb img{
    width:100%;
    height:100%;
    object-fit:cover;
    display:block;
}

@media(max-width:768px){
    .detail-left > .gallery-thumbs{
        grid-template-columns:repeat(5,88px);
        overflow-x:auto;
        padding-bottom:4px !important;
    }

    .detail-left > .gallery-thumbs .gallery-thumb{
        height:64px !important;
    }
}

@media(max-width:480px){
    .detail-left > .gallery-thumbs{
        grid-template-columns:repeat(5,74px);
        gap:7px;
    }

    .detail-left > .gallery-thumbs .gallery-thumb{
        height:54px !important;
    }
}


/* =========================================================
   RESPONSIVE TOÀN MÀN HÌNH
   TV / DESKTOP / LAPTOP / TABLET / ĐIỆN THOẠI
   ========================================================= */

html,
body{
    width:100%;
    max-width:100%;
    overflow-x:hidden;
}

.tour-detail-page{
    width:100%;
    padding:
        clamp(24px,3vw,56px)
        0
        clamp(48px,5vw,96px);
}

.tour-detail-container{
    width:100% !important;
    max-width:none !important;
    margin:0 auto;
    padding-left:clamp(16px,3vw,72px);
    padding-right:clamp(16px,3vw,72px);
}

/* Tiêu đề co giãn theo kích thước màn hình */
.tour-title-box h1{
    font-size:clamp(27px,2.6vw,58px);
    line-height:1.12;
    overflow-wrap:anywhere;
}

.tour-title-meta{
    gap:clamp(8px,1vw,14px);
}

.tour-title-meta div{
    font-size:clamp(12px,.9vw,16px);
}

/* Khu vực ảnh và thông tin đặt tour */
.detail-top-grid{
    width:100%;
    grid-template-columns:minmax(0,1.55fr) minmax(360px,.75fr);
    gap:clamp(20px,2.2vw,44px);
}

.detail-left,
.booking-card{
    min-width:0;
}

.tour-slideshow{
    width:100%;
    height:clamp(320px,34vw,780px);
    border-radius:clamp(12px,1vw,20px);
}

.tour-slide-image{
    max-width:100%;
    max-height:100%;
}

.detail-left > .gallery-thumbs{
    width:100%;
    grid-template-columns:repeat(5,minmax(0,1fr));
    gap:clamp(6px,.7vw,12px);
}

.detail-left > .gallery-thumbs .gallery-thumb{
    width:100% !important;
    height:clamp(58px,5.2vw,108px) !important;
}

/* Card thông tin bên phải */
.booking-card{
    width:100%;
    padding:clamp(18px,1.8vw,32px);
    border-radius:clamp(16px,1.4vw,24px);
    top:clamp(76px,6vw,110px);
}

.booking-info-grid{
    grid-template-columns:repeat(2,minmax(0,1fr));
}

.booking-info-grid div{
    min-width:0;
    padding:clamp(11px,1vw,17px);
}

.booking-info-grid span,
.booking-info-grid strong{
    overflow-wrap:anywhere;
}

.price-box strong{
    font-size:clamp(30px,2.4vw,48px);
}

.price-detail{
    width:100%;
}

.booking-actions{
    grid-template-columns:repeat(2,minmax(0,1fr));
}

.booking-actions a{
    width:100%;
    min-width:0;
    padding:0 12px;
}

/* Nội dung tổng quan */
.overview-card,
.rules-section,
.review-section{
    width:100%;
    padding:clamp(20px,2vw,38px);
    border-radius:clamp(16px,1.5vw,26px);
}

.overview-card h2,
.rules-section h2,
.schedule-left h2,
.schedule-right h2,
.review-section h2{
    font-size:clamp(25px,2vw,40px);
}

.overview-card p,
.timeline-text p,
.accordion-content p,
.accordion-content li{
    font-size:clamp(15px,1vw,19px);
}

/* Lịch trình */
.schedule-section{
    width:100%;
    grid-template-columns:minmax(280px,.75fr) minmax(0,1.65fr);
    gap:clamp(24px,3vw,64px);
}

.timeline-text h3{
    font-size:clamp(21px,1.65vw,34px);
    overflow-wrap:anywhere;
}

/* Bảng giá luôn cuộn được trên màn hình nhỏ */
.price-table-wrap{
    width:100%;
    overflow-x:auto;
    -webkit-overflow-scrolling:touch;
}

.price-table-wrap table{
    width:100%;
    min-width:620px;
}

/* Đánh giá */
.review-grid{
    grid-template-columns:minmax(320px,.85fr) minmax(0,1.15fr);
}

.review-section-head{
    grid-template-columns:minmax(0,1fr) auto;
}

.review-score-box{
    max-width:100%;
}

/* Màn hình TV và màn hình rất lớn */
@media(min-width:1920px){
    .tour-detail-container{
        padding-left:clamp(72px,4vw,120px);
        padding-right:clamp(72px,4vw,120px);
    }

    .detail-top-grid{
        grid-template-columns:minmax(0,1.65fr) minmax(440px,.7fr);
    }

    .booking-info-grid div{
        min-height:82px;
    }

    .booking-info-grid i{
        font-size:26px;
    }

    .booking-info-grid span,
    .booking-info-grid strong{
        font-size:17px;
    }

    .booking-actions a{
        height:64px;
        font-size:17px;
    }

    .gallery-thumb{
        border-radius:14px;
    }
}

/* Laptop nhỏ và tablet ngang */
@media(max-width:1280px){
    .tour-detail-container{
        padding-left:24px;
        padding-right:24px;
    }

    .detail-top-grid{
        grid-template-columns:minmax(0,1.25fr) minmax(330px,.75fr);
        gap:22px;
    }

    .booking-info-grid{
        grid-template-columns:1fr;
    }

    .tour-slideshow{
        height:clamp(340px,43vw,590px);
    }

    .schedule-section{
        grid-template-columns:320px minmax(0,1fr);
    }

    .review-grid{
        grid-template-columns:1fr;
    }
}

/* Tablet dọc */
@media(max-width:992px){
    .tour-detail-page{
        padding-top:28px;
    }

    .tour-detail-container{
        padding-left:20px;
        padding-right:20px;
    }

    .detail-top-grid{
        grid-template-columns:1fr;
    }

    .booking-card{
        position:static;
    }

    .booking-info-grid{
        grid-template-columns:repeat(2,minmax(0,1fr));
    }

    .tour-slideshow{
        height:clamp(360px,58vw,620px);
    }

    .schedule-section{
        grid-template-columns:1fr;
    }

    .schedule-left{
        position:static;
    }

    .review-section-head{
        grid-template-columns:1fr;
    }

    .review-score-box{
        width:100%;
        min-width:0;
    }
}

/* Điện thoại lớn */
@media(max-width:768px){
    .tour-detail-container{
        padding-left:14px;
        padding-right:14px;
    }

    .breadcrumb{
        font-size:12px;
    }

    .tour-title-meta div{
        width:100%;
        border-radius:12px;
    }

    .tour-slideshow{
        height:auto;
        aspect-ratio:16/10;
        min-height:260px;
    }

    .slide-nav{
        width:40px;
        height:40px;
    }

    .slide-prev{
        left:10px;
    }

    .slide-next{
        right:10px;
    }

    .zoom-btn{
        top:12px;
        right:12px;
        width:40px;
        height:40px;
    }

    .detail-left > .gallery-thumbs{
        grid-template-columns:repeat(5,88px);
        overflow-x:auto;
        overscroll-behavior-inline:contain;
        scrollbar-width:thin;
        padding-bottom:6px !important;
    }

    .detail-left > .gallery-thumbs .gallery-thumb{
        height:64px !important;
    }

    .booking-card{
        padding:18px;
    }

    .booking-info-grid{
        grid-template-columns:1fr;
    }

    .booking-info-grid div{
        min-height:auto;
    }

    .booking-actions{
        grid-template-columns:1fr;
    }

    .overview-card,
    .rules-section,
    .review-section{
        padding:20px 16px;
    }

    .accordion-box summary{
        min-height:62px;
        padding:10px 15px;
        font-size:16px;
    }

    .accordion-content{
        padding:18px 16px 24px;
    }

    .review-form-card,
    .review-list-card{
        padding:17px;
    }

    .review-item-top{
        flex-direction:column;
    }

    .review-item time{
        margin-left:52px;
    }

    .slide-lightbox{
        padding:14px;
    }

    .slide-lightbox > img{
        max-width:calc(100vw - 28px);
        max-height:calc(100vh - 100px);
    }
}

/* Điện thoại nhỏ */
@media(max-width:480px){
    .tour-detail-page{
        padding-top:20px;
        padding-bottom:52px;
    }

    .tour-detail-container{
        padding-left:10px;
        padding-right:10px;
    }

    .tour-title-box h1{
        font-size:25px;
    }

    .tour-slideshow{
        min-height:220px;
        aspect-ratio:4/3;
        border-radius:12px;
    }

    .detail-left > .gallery-thumbs{
        grid-template-columns:repeat(5,72px);
        gap:6px;
    }

    .detail-left > .gallery-thumbs .gallery-thumb{
        height:52px !important;
    }

    .slide-counter{
        left:10px;
        bottom:10px;
        font-size:11px;
    }

    .booking-card{
        padding:15px;
        border-radius:14px;
    }

    .price-box{
        padding-top:18px;
    }

    .price-detail{
        padding:13px;
    }

    .contact-line{
        overflow-wrap:anywhere;
        font-size:13px;
    }

    .day-list,
    .timeline-detail{
        margin-left:4px;
        padding-left:19px;
    }

    .day-item::before,
    .timeline-dot{
        left:-29px;
    }

    .timeline-block{
        padding-bottom:36px;
    }

    .center-book-btn{
        height:52px;
    }

    .review-score-box{
        align-items:flex-start;
        flex-direction:column;
    }

    .review-login-box{
        flex-direction:column;
    }

    .review-login-box a{
        width:100%;
        margin-left:0;
        text-align:center;
    }

    .price-table-wrap table{
        min-width:520px;
    }
}


/* =========================================================
   LỊCH KHỞI HÀNH - CHỈ HIỂN THỊ THÔNG TIN
   ========================================================= */
.departure-section{
    width:100%;
    margin-top:clamp(36px,4vw,68px);
    padding:clamp(20px,2.2vw,38px);
    border:1px solid #dbe5f1;
    border-radius:clamp(18px,1.6vw,28px);
    background:linear-gradient(180deg,#ffffff 0%,#f8fbff 100%);
    box-shadow:0 18px 50px rgba(7,87,216,.07);
}

.departure-section-head{
    display:grid;
    grid-template-columns:minmax(0,1fr) auto;
    align-items:end;
    gap:20px;
    margin-bottom:24px;
}

.departure-section-head > div > span{
    display:block;
    margin-bottom:6px;
    color:var(--primary);
    font-size:12px;
    font-weight:1000;
    letter-spacing:1.1px;
}

.departure-section-head h2{
    margin:0;
    color:#0f172a;
    font-size:clamp(26px,2vw,40px);
    line-height:1.2;
    font-weight:1000;
}

.departure-section-head p{
    margin:9px 0 0;
    color:#64748b;
    font-size:clamp(14px,1vw,17px);
    line-height:1.65;
}

.departure-section-head > strong{
    padding:9px 14px;
    border-radius:999px;
    color:var(--primary);
    background:#eff6ff;
    border:1px solid #bfdbfe;
    font-size:13px;
    white-space:nowrap;
}

.departure-grid{
    display:grid;
    gap:14px;
}

.departure-card{
    display:grid;
    grid-template-columns:auto minmax(0,1fr) auto;
    align-items:center;
    gap:18px;
    min-width:0;
    padding:16px 18px;
    border:1px solid #dbe5f1;
    border-radius:18px;
    background:#fff;
    transition:.22s ease;
}

.departure-card.is-open:hover{
    transform:translateY(-2px);
    border-color:#93c5fd;
    box-shadow:0 14px 30px rgba(7,87,216,.08);
}

.departure-card.is-unavailable{
    background:#f8fafc;
}

.departure-date-box{
    width:70px;
    min-width:70px;
    min-height:70px;
    padding:9px;
    border-radius:16px;
    display:flex;
    flex-direction:column;
    align-items:center;
    justify-content:center;
    color:#fff;
    background:linear-gradient(135deg,var(--primary),var(--primary-dark));
    box-shadow:0 10px 22px rgba(7,87,216,.20);
}

.departure-date-box span{
    font-size:26px;
    line-height:1;
    font-weight:1000;
}

.departure-date-box strong{
    margin-top:5px;
    font-size:12px;
}

.departure-card-content{
    min-width:0;
}

.departure-card-title{
    display:flex;
    align-items:flex-start;
    justify-content:space-between;
    gap:14px;
}

.departure-card-title > div{
    min-width:0;
}

.departure-card-title > div > span{
    display:block;
    color:#64748b;
    font-size:12px;
    font-weight:800;
}

.departure-card-title > div > strong{
    display:block;
    margin-top:4px;
    color:#0f172a;
    font-size:clamp(15px,1.1vw,19px);
    overflow-wrap:anywhere;
}

.departure-status{
    display:inline-flex;
    align-items:center;
    justify-content:center;
    min-width:104px;
    padding:7px 11px;
    border-radius:999px;
    border:1px solid transparent;
    font-size:11px;
    font-weight:1000;
    white-space:nowrap;
}

.departure-status-available{
    color:#047857;
    background:#dcfce7;
    border-color:#86efac;
}

.departure-status-running{
    color:#0369a1;
    background:#e0f2fe;
    border-color:#7dd3fc;
}

.departure-status-full{
    color:#b45309;
    background:#fef3c7;
    border-color:#fcd34d;
}

.departure-status-closed,
.departure-status-unknown{
    color:#475569;
    background:#e2e8f0;
    border-color:#cbd5e1;
}

.departure-card-meta{
    display:flex;
    flex-wrap:wrap;
    gap:8px 20px;
    margin-top:10px;
    color:#64748b;
    font-size:13px;
    font-weight:800;
}

.departure-card-meta span{
    display:inline-flex;
    align-items:center;
    gap:7px;
}

.departure-card-meta i{
    color:var(--primary);
}

.departure-card-action a,
.departure-card-action > span{
    min-width:140px;
    min-height:44px;
    padding:0 16px;
    border-radius:12px;
    display:inline-flex;
    align-items:center;
    justify-content:center;
    gap:8px;
    font-size:13px;
    font-weight:1000;
    text-decoration:none;
    white-space:nowrap;
}

.departure-card-action a{
    color:#fff;
    background:linear-gradient(135deg,var(--primary),var(--primary-dark));
    box-shadow:0 10px 22px rgba(7,87,216,.20);
}

.departure-card-action > span{
    color:#64748b;
    background:#e2e8f0;
}

.departure-empty{
    min-height:150px;
    padding:24px;
    border:1px dashed #bfdbfe;
    border-radius:18px;
    display:flex;
    align-items:center;
    justify-content:center;
    gap:15px;
    color:#64748b;
    background:#f8fbff;
}

.departure-empty > i{
    color:var(--primary);
    font-size:36px;
}

.departure-empty strong{
    display:block;
    color:#0f172a;
    font-size:18px;
}

.departure-empty p{
    margin:5px 0 0;
}

/* =========================================================
   KHỐI TƯ VẤN DƯỚI ĐÁNH GIÁ
   ========================================================= */
.consultation-section{
    width:100%;
    margin-top:clamp(28px,3vw,48px);
    padding:clamp(22px,2.3vw,40px);
    border:1px solid #bfdbfe;
    border-radius:clamp(18px,1.6vw,28px);
    display:grid;
    grid-template-columns:auto minmax(0,1fr) auto;
    align-items:center;
    gap:clamp(18px,2vw,34px);
    background:
        radial-gradient(circle at top right,rgba(56,189,248,.16),transparent 35%),
        linear-gradient(135deg,#eff6ff,#ffffff);
    box-shadow:0 18px 48px rgba(7,87,216,.08);
}

.consultation-icon{
    width:72px;
    height:72px;
    border-radius:20px;
    display:grid;
    place-items:center;
    color:#fff;
    background:linear-gradient(135deg,var(--primary),#38bdf8);
    font-size:30px;
    box-shadow:0 14px 30px rgba(7,87,216,.20);
}

.consultation-content{
    min-width:0;
}

.consultation-content > span{
    display:block;
    margin-bottom:5px;
    color:var(--primary);
    font-size:11px;
    font-weight:1000;
    letter-spacing:1px;
}

.consultation-content h2{
    margin:0;
    color:#0f172a;
    font-size:clamp(24px,1.8vw,36px);
    font-weight:1000;
}

.consultation-content p{
    max-width:820px;
    margin:9px 0 0;
    color:#64748b;
    font-size:clamp(14px,1vw,17px);
    line-height:1.65;
}

.consultation-actions{
    display:grid;
    grid-template-columns:repeat(2,minmax(0,1fr));
    gap:12px;
}

.consultation-actions a{
    min-width:190px;
    min-height:60px;
    padding:10px 14px;
    border-radius:14px;
    display:flex;
    align-items:center;
    gap:11px;
    text-decoration:none;
    transition:.2s ease;
}

.consultation-actions a:hover{
    transform:translateY(-2px);
}

.consultation-call{
    color:#fff;
    background:linear-gradient(135deg,var(--primary),var(--primary-dark));
    box-shadow:0 12px 24px rgba(7,87,216,.20);
}

.consultation-mail{
    color:var(--primary);
    background:#fff;
    border:1px solid #93c5fd;
}

.consultation-actions i{
    font-size:20px;
}

.consultation-actions span{
    min-width:0;
}

.consultation-actions small{
    display:block;
    margin-bottom:2px;
    opacity:.75;
    font-size:11px;
    font-weight:800;
}

.consultation-actions strong{
    display:block;
    font-size:13px;
    overflow-wrap:anywhere;
}

/* Responsive khu vực lịch và tư vấn */
@media(max-width:1100px){
    .consultation-section{
        grid-template-columns:auto minmax(0,1fr);
    }

    .consultation-actions{
        grid-column:1/-1;
        width:100%;
    }

    .consultation-actions a{
        min-width:0;
    }
}

@media(max-width:768px){
    .departure-section{
        padding:20px 14px;
    }

    .departure-section-head{
        grid-template-columns:1fr;
        align-items:start;
    }

    .departure-section-head > strong{
        width:max-content;
    }

    .departure-card{
        grid-template-columns:auto minmax(0,1fr);
        align-items:start;
        gap:13px;
        padding:14px;
    }

    .departure-date-box{
        width:60px;
        min-width:60px;
        min-height:60px;
    }

    .departure-date-box span{
        font-size:22px;
    }

    .departure-card-title{
        flex-direction:column;
        gap:8px;
    }

    .departure-card-action{
        grid-column:1/-1;
    }

    .departure-card-action a,
    .departure-card-action > span{
        width:100%;
    }

    .consultation-section{
        grid-template-columns:1fr;
        padding:22px 16px;
    }

    .consultation-icon{
        width:58px;
        height:58px;
        border-radius:16px;
        font-size:24px;
    }

    .consultation-actions{
        grid-template-columns:1fr;
    }

    .consultation-actions a{
        width:100%;
        min-width:0;
    }
}

@media(max-width:480px){
    .departure-card{
        grid-template-columns:1fr;
    }

    .departure-date-box{
        width:100%;
        min-width:0;
        min-height:54px;
        flex-direction:row;
        gap:7px;
    }

    .departure-date-box strong{
        margin-top:0;
    }

    .departure-card-action{
        grid-column:auto;
    }

    .departure-card-meta{
        flex-direction:column;
        gap:7px;
    }

    .consultation-content h2{
        font-size:23px;
    }
}


.review-public-badge{
    display:inline-flex;
    align-items:center;
    gap:6px;
    margin-top:14px;
    padding:5px 9px;
    border-radius:999px;
    color:#0757d8;
    background:#eff6ff;
    border:1px solid #bfdbfe;
    font-size:11px;
    font-weight:900;
}

</style>


<script>
document.addEventListener('DOMContentLoaded', function () {
    const slideshow = document.getElementById('tourSlideshow');

    if (!slideshow) {
        return;
    }

    const slides = Array.from(slideshow.querySelectorAll('.tour-slide'));
    const thumbs = Array.from(document.querySelectorAll('[data-slide-to]'));
    const prevButton = slideshow.querySelector('.slide-prev');
    const nextButton = slideshow.querySelector('.slide-next');
    const currentNumber = document.getElementById('currentSlideNumber');

    const lightbox = document.getElementById('slideLightbox');
    const lightboxImage = document.getElementById('lightboxImage');
    const openLightboxButton = document.getElementById('openSlideLightbox');
    const closeLightboxButton = lightbox?.querySelector('.lightbox-close');
    const lightboxPrev = lightbox?.querySelector('.lightbox-prev');
    const lightboxNext = lightbox?.querySelector('.lightbox-next');

    let currentIndex = 0;

    function showSlide(index) {
        if (!slides.length) {
            return;
        }

        currentIndex = (index + slides.length) % slides.length;

        slides.forEach(function (slide, slideIndex) {
            slide.classList.toggle('active', slideIndex === currentIndex);
        });

        thumbs.forEach(function (thumb, thumbIndex) {
            thumb.classList.toggle('active', thumbIndex === currentIndex);
        });

        if (currentNumber) {
            currentNumber.textContent = String(currentIndex + 1);
        }

        if (lightbox?.classList.contains('show') && lightboxImage) {
            lightboxImage.src = slides[currentIndex].querySelector('img').src;
        }

        thumbs[currentIndex]?.scrollIntoView({
            behavior: 'smooth',
            block: 'nearest',
            inline: 'center'
        });
    }

    function nextSlide() {
        showSlide(currentIndex + 1);
    }

    function previousSlide() {
        showSlide(currentIndex - 1);
    }

    function startAutoplay() {
        if (slides.length <= 1) {
            return;
        }

        stopAutoplay();
        autoplayTimer = window.setInterval(nextSlide, 4500);
    }

    function stopAutoplay() {
        if (autoplayTimer) {
            window.clearInterval(autoplayTimer);
            autoplayTimer = null;
        }
    }

    prevButton?.addEventListener('click', function () {
        previousSlide();
    });

    nextButton?.addEventListener('click', function () {
        nextSlide();
    });

    thumbs.forEach(function (thumb) {
        thumb.addEventListener('click', function () {
            showSlide(Number(thumb.dataset.slideTo));
        });
    });

    openLightboxButton?.addEventListener('click', function () {
        if (!lightbox || !lightboxImage || !slides.length) {
            return;
        }

        lightboxImage.src = slides[currentIndex].querySelector('img').src;
        lightbox.classList.add('show');
        lightbox.setAttribute('aria-hidden', 'false');
        document.body.style.overflow = 'hidden';
    });

    function closeLightbox() {
        if (!lightbox) {
            return;
        }

        lightbox.classList.remove('show');
        lightbox.setAttribute('aria-hidden', 'true');
        document.body.style.overflow = '';
    }

    closeLightboxButton?.addEventListener('click', closeLightbox);
    lightboxPrev?.addEventListener('click', previousSlide);
    lightboxNext?.addEventListener('click', nextSlide);

    lightbox?.addEventListener('click', function (event) {
        if (event.target === lightbox) {
            closeLightbox();
        }
    });

    document.addEventListener('keydown', function (event) {
        if (event.key === 'Escape') {
            closeLightbox();
        }

        if (lightbox?.classList.contains('show')) {
            if (event.key === 'ArrowLeft') {
                previousSlide();
            }

            if (event.key === 'ArrowRight') {
                nextSlide();
            }
        }
    });

    let touchStartX = 0;

    slideshow.addEventListener('touchstart', function (event) {
        touchStartX = event.changedTouches[0].screenX;
    }, { passive: true });

    slideshow.addEventListener('touchend', function (event) {
        const touchEndX = event.changedTouches[0].screenX;
        const distance = touchEndX - touchStartX;

        if (Math.abs(distance) < 45) {
            return;
        }

        if (distance > 0) {
            previousSlide();
        } else {
            nextSlide();
        }
    }, { passive: true });

    showSlide(0);
});
</script>


<script>
document.addEventListener('DOMContentLoaded', function () {
    const slideshow = document.getElementById('tourSlideshow');

    if (!slideshow) {
        return;
    }

    const evaluateImageQuality = function (slide) {
        const image = slide.querySelector('.tour-slide-image');

        if (!image || !image.naturalWidth || !image.naturalHeight) {
            return;
        }

        const frameWidth = slideshow.clientWidth || 1;
        const frameHeight = slideshow.clientHeight || 1;

        /*
         * Chỉ cho ảnh phủ kín khung khi độ phân giải thực đủ lớn.
         * Ảnh nhỏ sẽ giữ kích thước tự nhiên và dùng nền mờ phía sau,
         * tránh bị kéo giãn dẫn đến vỡ hạt.
         */
        const enoughWidth = image.naturalWidth >= frameWidth * 0.9;
        const enoughHeight = image.naturalHeight >= frameHeight * 0.9;

        slide.classList.toggle('high-resolution', enoughWidth && enoughHeight);
        slide.classList.toggle('low-resolution', !(enoughWidth && enoughHeight));
    };

    const evaluateAllImages = function () {
        slideshow.querySelectorAll('.tour-slide').forEach(function (slide) {
            const image = slide.querySelector('.tour-slide-image');

            if (!image) {
                return;
            }

            if (image.complete) {
                evaluateImageQuality(slide);
            } else {
                image.addEventListener('load', function () {
                    evaluateImageQuality(slide);
                }, { once: true });
            }
        });
    };

    evaluateAllImages();

    let resizeTimer = null;

    window.addEventListener('resize', function () {
        window.clearTimeout(resizeTimer);
        resizeTimer = window.setTimeout(evaluateAllImages, 160);
    });
});
</script>

@endsection