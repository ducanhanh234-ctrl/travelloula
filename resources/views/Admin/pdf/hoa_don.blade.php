<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">

    <style>
        /* Lề A4: lùi vào hai bên để nội dung không sát mép */
        @page {
            size: A4;
            margin: 15mm 18mm 15mm 18mm;
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
            line-height: 1.4;
        }

        .invoice {
            width: 100%;
        }

        /* Header Styles */
        .header-table {
            width: 100%;
            margin-bottom: 15px;
            border-collapse: collapse;
        }

        .header-table td {
            vertical-align: top;
        }

        .logo-container img {
            max-width: 140px;
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
            margin-top: 15px;
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
            table-layout: fixed;
        }

        .product-table th,
        .product-table td {
            border: 1px solid #bdc3c7;
            padding: 8px;
            word-wrap: break-word;
            overflow-wrap: break-word;
        }

        .product-table th {
            background-color: #ecf0f1;
            color: #2c3e50;
            font-weight: bold;
            text-align: center;
            font-size: 12px;
        }

        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }

        .bold {
            font-weight: bold;
        }

        /* Summary Table */
        .summary-table {
            width: 100%;
            margin-top: 15px;
            border-collapse: collapse;
            table-layout: fixed;
        }

        .summary-table td {
            padding: 5px 10px;
        }

        /* Footer - giữ đơn giản, giống mẫu */
        .invoice-footer {
            width: 100%;
            margin-top: 28px;
            border-collapse: collapse;
            table-layout: fixed;
            page-break-inside: avoid;
            background: #fff1bf;
            border: 1px solid #c8a85a;
        }

        .invoice-footer td {
            width: 50%;
            padding: 10px 12px;
            vertical-align: top;
            font-size: 10px;
            line-height: 1.55;
            color: #514b3b;
        }

        .invoice-footer td:first-child {
            border-right: 1px solid #c8a85a;
        }

        .footer-title {
            font-size: 10px;
            font-weight: bold;
            text-transform: uppercase;
            margin-bottom: 4px;
            color: #4d4637;
        }

        .footer-accent {
            font-weight: bold;
            color: #2c3e50;
        }
    </style>
</head>

<body>

    <div class="invoice">

        <!-- HEADER -->
        <table class="header-table">
            <tr>
                <td width="30%" class="logo-container">
                    <img src="{{ public_path('images/logo/logo_ngang.png') }}" alt="Logo Công Ty">
                    <div style="margin-top: 5px; font-size: 11px; font-weight: bold; color: #e74c3c;">
                        TRAVELLOULA
                    </div>
                </td>

                <td width="40%" class="invoice-title">
                    <h2>HÓA ĐƠN</h2>
                    <h2>THANH TOÁN</h2>
                    <div class="sub-title">(Bản thể hiện hóa đơn điện tử)</div>
                </td>

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
                <td width="80%">
                    {{ optional($booking?->tour)->ten_tour ?? optional($payment->datTour?->tour)->ten_tour }}
                </td>
            </tr>

            <tr>
                <td><b>Ngày khởi hành:</b></td>
                <td>
                    {{ optional($booking?->lichKhoiHanh)->ngay_khoi_hanh ?? optional($payment->datTour?->lichKhoiHanh)->ngay_khoi_hanh }}
                </td>
            </tr>

            <tr>
                <td><b>Ngày kết thúc:</b></td>
                <td>
                    {{ optional($booking?->lichKhoiHanh)->ngay_ket_thuc ?? optional($payment->datTour?->lichKhoiHanh)->ngay_ket_thuc }}
                </td>
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
                <td>
                    {{ number_format(optional($booking?->lichKhoiHanh)->gia_nguoi_lon ?? optional($payment->datTour?->lichKhoiHanh)->gia_nguoi_lon) }} VND
                </td>
            </tr>

            <tr>
                <td><b>Giá Trẻ Em:</b></td>
                <td>
                    {{ number_format(optional($booking?->lichKhoiHanh)->gia_tre_em ?? optional($payment->datTour?->lichKhoiHanh)->gia_tre_em) }} VND
                </td>
            </tr>
        </table>

        <!-- PHẦN 2: THÔNG TIN KHÁCH HÀNG -->
        <div class="section-title">THÔNG TIN KHÁCH HÀNG</div>

        <table class="info-table">
            <tr>
                <td width="20%"><b>Họ và tên:</b></td>
                <td width="80%">
                    {{ optional($booking?->nguoiDung)->name ?? optional($payment->datTour?->nguoiDung)->name }}
                </td>
            </tr>

            <tr>
                <td><b>Email liên hệ:</b></td>
                <td>
                    {{ optional($booking?->nguoiDung)->email ?? optional($payment->datTour?->nguoiDung)->email }}
                </td>
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
                        {{ number_format(
                            $payment->datTour->tong_tien /
                            max(($payment->datTour->so_nguoi_lon + $payment->datTour->so_tre_em), 1)
                        ) }}
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
                    <table style="width: 100%; border-collapse: collapse; table-layout: fixed;">
                        <tr>
                            <td width="55%"><b>Tổng tiền:</b></td>
                            <td width="45%" class="text-right bold">
                                {{ number_format($payment->datTour->tong_tien) }}
                            </td>
                        </tr>

                        <tr>
                            <td><b>Đã thanh toán:</b></td>
                            <td class="text-right bold">
                                {{ number_format($payment->datTour->so_tien_da_thanh_toan) }}
                            </td>
                        </tr>

                        <tr>
                            <td style="border-top: 1px solid #000; padding-top: 8px;">
                                <b>Còn lại phải thu:</b>
                            </td>

                            <td
                                class="text-right bold"
                                style="border-top: 1px solid #000; padding-top: 8px; color: red;"
                            >
                                {{ number_format(
                                    max(
                                        $payment->datTour->tong_tien -
                                        $payment->datTour->so_tien_da_thanh_toan,
                                        0
                                    )
                                ) }}
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>

        <!-- FOOTER: CHỈ THÊM PHẦN NÀY -->
        <table class="invoice-footer">
            <tr>
                <td>
                    <div class="footer-title">Thông tin thanh toán</div>

                    <div>
                        <b>Tên ngân hàng:</b>
                        NGÂN HÀNG VIỆT NAM
                    </div>

                    <div>
                        <b>Số tài khoản:</b>
                        <span class="footer-accent">123-456-7890</span>
                    </div>

                    <div>
                        <b>Tên tài khoản:</b>
                        CÔNG TY LỮ HÀNH TRAVELLOULA
                    </div>
                </td>

                <td>
                    <div class="footer-title">
                        Cảm ơn bạn đã giao dịch với chúng tôi!
                    </div>

                    <div>
                        Nếu bạn có bất kỳ câu hỏi hoặc thắc mắc nào,
                        vui lòng liên hệ với chúng tôi để được hỗ trợ.
                    </div>

                    <div style="margin-top: 4px;">
                        <b>Website:</b>
                        <span class="footer-accent">TRAVELLOULA</span>
                    </div>
                </td>
            </tr>
        </table>

    </div>

</body>
</html>
