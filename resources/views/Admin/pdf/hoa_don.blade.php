<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 14px;
        }

        h1 {
            text-align: center;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        td {
            padding: 6px;
        }

    </style>
</head>
<body>

    <h1>HÓA ĐƠN THANH TOÁN</h1>

    <hr>

    <p><strong>Mã giao dịch:</strong> {{ $payment->ma_giao_dich }}</p>

    <p><strong>Khách hàng:</strong> {{ optional($booking?->nguoiDung)->name ?? optional($payment->datTour?->nguoiDung)->name }}</p>

    <p><strong>Email:</strong> {{ optional($booking?->nguoiDung)->email ?? optional($payment->datTour?->nguoiDung)->email }}</p>

    <p><strong>Tour:</strong> {{ optional($booking?->tour)->ten_tour ?? optional($payment->datTour?->tour)->ten_tour }}</p>

    <p><strong>Ngày khởi hành:</strong> {{ optional($booking?->lichKhoiHanh)->ngay_khoi_hanh ?? optional($payment->datTour?->lichKhoiHanh)->ngay_khoi_hanh }}</p>

    <p><strong>Tổng tiền:</strong>
        {{ number_format(optional($booking)->tong_tien ?? optional($payment->datTour)->tong_tien ?? 0) }} VNĐ
    </p>
    <p><strong>Số tiền đã thanh toán:</strong>
        {{ number_format(optional($booking)->so_tien_da_thanh_toan ?? optional($payment->datTour)->so_tien_da_thanh_toan ?? 0) }} VNĐ
    </p>

</body>
</html>
