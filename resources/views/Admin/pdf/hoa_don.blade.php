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

    <p><strong>Khách hàng:</strong> {{ $payment->datTour->NguoiDung->name }}</p>

    <p><strong>Email:</strong> {{ $payment->datTour->NguoiDung->email }}</p>

    <p><strong>Tour:</strong> {{ $payment->datTour->tour->ten_tour }}</p>

    <p><strong>Ngày khởi hành:</strong> {{ $payment->datTour->lichKhoiHanh->ngay_khoi_hanh }}</p>

    <p><strong>Tổng tiền:</strong>
        {{ number_format($payment->datTour->tong_tien) }} VNĐ
    </p>

</body>
</html>
