<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <style>
        /* Thiết lập lề chuẩn cho trang PDF A4 */
        @page {
            size: A4;
            margin: 15mm;
        }

        *, *::before, *::after {
            box-sizing: border-box;
        }

        body {
            font-family: DejaVu Sans, Arial, sans-serif;
            font-size: 13px;
            color: #333;
            margin: 0;
            padding: 0;
            line-height: 1.4; /* Thu nhỏ khoảng cách dòng một chút */
        }

        .invoice {
            width: 100%;
        }

        /* Header Styles */
        .header-table {
            width: 100%;
            margin-bottom: 15px; /* Rút gọn margin */
            border-collapse: collapse;
        }

        .header-table td {
            vertical-align: top;
        }

        .logo-container img {
            max-width: 140px; /* Thu nhỏ logo lại một chút cho cân đối */
            height: auto;
            object-fit: contain;
        }

        .invoice-title {
            text-align: center;
        }

        .invoice-title h2 {
            margin: 0;
            font-size: 22px;
            color: #2c3e50;
            text-transform: uppercase;
        }

        .sub-title {
            font-style: italic;
            color: #7f8c8d;
            margin-top: 5px;
            font-size: 12px;
        }

        .transaction-info {
            text-align: right;
            font-size: 12px;
        }

        /* Section Styles */
        .section-title {
            font-size: 13px;
            font-weight: bold;
            color: #fff;
            background-color: #2980b9;
            padding: 5px 10px;
            margin-top: 15px; /* Thu nhỏ khoảng cách */
            margin-bottom: 8px;
            text-transform: uppercase;
        }

        .info-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
        }

        .info-table td {
            padding: 4px 10px;
            vertical-align: top;
        }

        /* Product Table Styles */
        .product-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        .product-table th,
        .product-table td {
            border: 1px solid #bdc3c7;
            padding: 8px; /* Giảm padding để tiết kiệm dòng */
        }

        .product-table th {
            background-color: #ecf0f1;
            color: #2c3e50;
            font-weight: bold;
            text-align: center;
            font-size: 12px;
        }

        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .bold { font-weight: bold; }

        /* Summary Table */
        .summary-table {
            width: 100%;
            margin-top: 15px;
            border-collapse: collapse;
        }

        .summary-table td {
            padding: 5px 10px;
        }

        /* Footer */
        .footer {
            width: 100%;
            margin-top: 30px; /* Thu nhỏ khoảng cách trước chữ ký */
            page-break-inside: avoid; /* Tránh việc chữ ký bị rớt sang trang mới */
        }

        .footer td {
            text-align: center;
            vertical-align: top;
            width: 50%;
        }

        .footer-sign {
            margin-top: 60px; /* Khoảng để ký tên */
        }
    </style>
</head>

<body>

    <div class="invoice">

        <!-- HEADER -->
        <table class="header-table">
            <tr>
                <!-- Cột Logo bên trái (Sử dụng public_path để không lỗi ảnh khi xuất PDF) -->
                <td width="30%" class="logo-container">
                    <img src="{{ public_path('images/logo/logo_ngang.png') }}" alt="Logo Công Ty">
                    <div style="margin-top: 5px; font-size: 11px; font-weight: bold; color: #e74c3c;">TRAVELLOULA</div>
                </td>

                <!-- Cột Tiêu đề ở giữa -->
                <td width="40%" class="invoice-title">
                    <h2>HÓA ĐƠN</h2>
                    <h2>THANH TOÁN</h2>
                    <div class="sub-title">(Bản thể hiện hóa đơn điện tử)</div>
                </td>

                <!-- Cột Thông tin giao dịch bên phải -->
                <td width="30%" class="transaction-info">
                    <b>Mã GD:</b> {{ $payment->ma_giao_dich }} <br><br>
                    <b>Ngày lập:</b> {{ date('d/m/Y') }}
                </td>
            </tr>
        </table>

        <!-- PHẦN 1: THÔNG TIN TOUR ĐÃ ĐẶT -->
        <div class="section-title">THÔNG TIN TOUR ĐÃ ĐẶT</div>
        <table class="info-table">
            <tr>
                <td width="20%"><b>Tên Tour:</b></td>
                <td width="80%">{{ optional($booking?->tour)->ten_tour ?? optional($payment->datTour?->tour)->ten_tour }}</td>
            </tr>
            <tr>
                <td><b>Ngày khởi hành:</b></td>
                <td>{{ optional($booking?->lichKhoiHanh)->ngay_khoi_hanh ?? optional($payment->datTour?->lichKhoiHanh)->ngay_khoi_hanh }}</td>
            </tr>
            <tr>
                <td><b>Ngày kết thúc:</b></td>
                <td>{{ optional($booking?->lichKhoiHanh)->ngay_ket_thuc ?? optional($payment->datTour?->lichKhoiHanh)->ngay_ket_thuc }}</td>
            </tr>
            <tr>
                <td><b>Số lượng khách:</b></td>
                <td>
                    {{ $payment->datTour->so_nguoi_lon }} Người lớn 
                    @if($payment->datTour->so_tre_em > 0)
                        , {{ $payment->datTour->so_tre_em }} Trẻ em
                    @endif
                </td>
            </tr>
            <tr>
                <td><b>Giá Người Lớn:</b></td>
                <td>{{ number_format(optional($booking?->lichKhoiHanh)->gia_nguoi_lon ?? optional($payment->datTour?->lichKhoiHanh)->gia_nguoi_lon) }} VND</td>
            </tr>
            <tr>
                <td><b>Giá Trẻ Em:</b></td>
                <td>{{ number_format(optional($booking?->lichKhoiHanh)->gia_tre_em ?? optional($payment->datTour?->lichKhoiHanh)->gia_tre_em) }} VND</td>
            </tr>
        </table>

        <!-- PHẦN 2: THÔNG TIN KHÁCH HÀNG -->
        <div class="section-title">THÔNG TIN KHÁCH HÀNG</div>
        <table class="info-table">
            <tr>
                <td width="20%"><b>Họ và tên:</b></td>
                <td width="80%">{{ optional($booking?->nguoiDung)->name ?? optional($payment->datTour?->nguoiDung)->name }}</td>
            </tr>
            <tr>
                <td><b>Email liên hệ:</b></td>
                <td>{{ optional($booking?->nguoiDung)->email ?? optional($payment->datTour?->nguoiDung)->email }}</td>
            </tr>
        </table>

        <!-- PHẦN 3: CHI TIẾT THANH TOÁN -->
        <table class="product-table">
            <thead>
                <tr>
                    <th width="8%">STT</th>
                    <th>Nội dung thanh toán</th>
                    <th width="15%">Số lượng<br>(Người)</th>
                    <th width="20%">Đơn giá bình quân<br>(VNĐ)</th>
                    <th width="22%">Thành tiền<br>(VNĐ)</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="text-center">1</td>
                    <td>
                        {{ optional($booking?->tour)->ten_tour ?? optional($payment->datTour?->tour)->ten_tour }}
                    </td>
                    <td class="text-center">
                        {{ $payment->datTour->so_nguoi_lon + $payment->datTour->so_tre_em }}
                    </td>
                    <td class="text-right">
                        {{ number_format($payment->datTour->tong_tien / max(($payment->datTour->so_nguoi_lon + $payment->datTour->so_tre_em), 1)) }}
                    </td>
                    <td class="text-right bold">
                        {{ number_format($payment->datTour->tong_tien) }}
                    </td>
                </tr>
            </tbody>
        </table>

        <!-- TỔNG KẾT TIỀN -->
        <table class="summary-table">
            <tr>
                <td width="55%"></td>
                <td width="45%">
                    <table style="width: 100%; border-collapse: collapse;">
                        <tr>
                            <td width="55%"><b>Tổng tiền:</b></td>
                            <td width="45%" class="text-right bold">{{ number_format($payment->datTour->tong_tien) }}</td>
                        </tr>
                        <tr>
                            <td><b>Đã thanh toán:</b></td>
                            <td class="text-right bold">{{ number_format($payment->datTour->so_tien_da_thanh_toan) }}</td>
                        </tr>
                        <tr>
                            <td style="border-top: 1px solid #000; padding-top: 8px;"><b>Còn lại phải thu:</b></td>
                            <td class="text-right bold" style="border-top: 1px solid #000; padding-top: 8px; color: red;">
                                {{ number_format(max($payment->datTour->tong_tien - $payment->datTour->so_tien_da_thanh_toan, 0)) }}
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>

    </div>

</body>

</html>