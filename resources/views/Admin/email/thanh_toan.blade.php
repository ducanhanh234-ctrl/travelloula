<h2>Thanh toán thành công</h2>

<p>Xin chào {{ $datTour->ho_ten }}</p>

<p>Bạn đã thanh toán thành công tour:</p>

<b>{{ $datTour->tour->ten_tour }}</b>

<p>Mã đặt tour:
    {{ $datTour->ma_dat_tour }}</p>

<p>Tổng tiền:
    {{ number_format($thanhToan->so_tien) }} VNĐ</p>

<p>Cảm ơn bạn đã sử dụng dịch vụ.</p>
