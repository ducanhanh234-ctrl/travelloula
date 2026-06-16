@extends('layouts.app')

@section('title', 'Điều khoản & Chính sách')

@section('content')

<style>
    .policy-page {
        background: linear-gradient(to right, #f5f7fa, #e9f3fb);
        min-height: 100vh;
    }

    .policy-banner {
        background: linear-gradient(135deg, #0ea5e9, #2563eb);
        color: white;
        padding: 60px 0;
        text-align: center;
    }

    .policy-banner h1 {
        font-weight: 700;
    }

    .policy-card {
        border: none;
        border-radius: 20px;
        overflow: hidden;
    }

    .policy-section {
        padding: 25px;
        border-bottom: 1px solid #eee;
    }

    .policy-section:last-child {
        border-bottom: none;
    }

    .policy-icon {
        width: 50px;
        height: 50px;
        background: #e0f2fe;
        color: #0284c7;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
        margin-right: 15px;
    }

    .notice-box {
        background: #e0f7fa;
        border-left: 5px solid #00acc1;
        border-radius: 12px;
        padding: 15px;
    }

    .info-box {
        background: #f8fafc;
        border: 1px solid #e5e7eb;
        border-radius: 15px;
        padding: 20px;
    }

</style>

<div class="policy-page">

    ```
    <!-- Banner -->
    <div class="policy-banner">
        <div class="container">
            <h1>Điều khoản & Chính sách Travelloula</h1>
            <p class="mb-0">
                Vui lòng đọc kỹ các điều khoản trước khi đặt tour
            </p>
        </div>
    </div>

    <div class="container py-5">

        <div class="card shadow policy-card">

            <!-- Điều khoản 1 -->
            <div class="policy-section">
                <div class="d-flex">
                    <div class="policy-icon">
                        <i class="fas fa-child"></i>
                    </div>

                    <div>
                        <h4>Chính sách trẻ em</h4>

                        <ul class="mb-0">
                            <li>Dưới 5 tuổi: Miễn phí.</li>
                            <li>Từ 5 - dưới 10 tuổi: 75% giá tour.</li>
                            <li>Từ 10 tuổi trở lên: Tính như người lớn.</li>
                            <li>Gia đình tự chịu trách nhiệm chăm sóc trẻ.</li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Điều khoản 2 -->
            <div class="policy-section">
                <div class="d-flex">
                    <div class="policy-icon">
                        <i class="fas fa-credit-card"></i>
                    </div>

                    <div>
                        <h4>Thanh toán</h4>

                        <ul class="mb-0">
                            <li>Đặt cọc tối thiểu 50% khi đăng ký tour.</li>
                            <li>Thanh toán đủ trước ngày khởi hành.</li>
                            <li>Hỗ trợ chuyển khoản và thanh toán trực tuyến.</li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Điều khoản 3 -->
            <div class="policy-section">
                <div class="d-flex">
                    <div class="policy-icon">
                        <i class="fas fa-calendar-times"></i>
                    </div>

                    <div>
                        <h4>Hủy tour</h4>

                        <ul class="mb-0">
                            <li>Hủy trước 15 ngày: hoàn 90%.</li>
                            <li>Hủy trước 7 ngày: hoàn 50%.</li>
                            <li>Hủy dưới 7 ngày: không hoàn tiền.</li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Điều khoản 4 -->
            <div class="policy-section">
                <div class="d-flex">
                    <div class="policy-icon">
                        <i class="fas fa-bus"></i>
                    </div>

                    <div>
                        <h4>Thay đổi lịch trình</h4>

                        <p class="mb-0">
                            Công ty có quyền điều chỉnh lịch trình trong trường
                            hợp thời tiết, thiên tai hoặc các nguyên nhân bất
                            khả kháng nhằm đảm bảo an toàn cho khách hàng.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Điều khoản 5 -->
            <div class="policy-section">
                <div class="d-flex">
                    <div class="policy-icon">
                        <i class="fas fa-shield-alt"></i>
                    </div>

                    <div>
                        <h4>Trách nhiệm khách hàng</h4>

                        <ul class="mb-0">
                            <li>Cung cấp thông tin chính xác.</li>
                            <li>Mang theo giấy tờ tùy thân hợp lệ.</li>
                            <li>Tuân thủ quy định của đoàn và hướng dẫn viên.</li>
                        </ul>
                    </div>
                </div>
            </div>

        </div>

        <!-- Lưu ý -->
        <div class="notice-box mt-4 shadow-sm">
            <h5>
                <i class="fas fa-exclamation-circle me-2"></i>
                Lưu ý quan trọng
            </h5>

            <p class="mb-0">
                Việc đặt tour đồng nghĩa với việc khách hàng đã đọc,
                hiểu và đồng ý với toàn bộ điều khoản sử dụng dịch vụ.
            </p>
        </div>

        <!-- Thông tin bổ sung -->
        <div class="info-box mt-4">
            <h4>
                <i class="fas fa-info-circle text-primary me-2"></i>
                Thông tin bổ sung
            </h4>

            <ul class="mb-0">
                <li>Giá tour có thể thay đổi tùy thời điểm.</li>
                <li>Khách đoàn được hỗ trợ tư vấn riêng.</li>
                <li>Ưu đãi áp dụng theo chương trình hiện hành.</li>
            </ul>
        </div>

        <!-- Nút -->
        <div class="text-center mt-4">
            <a href="#" class="btn btn-primary me-2">
                <i class="fas fa-arrow-left"></i>
                Xem các tour
            </a>

            <a href="#" class="btn btn-outline-primary">
                Liên hệ hỗ trợ
            </a>
        </div>

    </div>
    ```

</div>

@endsection
