function capNhatThongTinTour() {

    const tourSelect = document.getElementById('tour_id');

    const soCho = document.getElementById('so_cho');
    const giaNguoiLon = document.getElementById('gia_nguoi_lon');
    const giaTreEm = document.getElementById('gia_tre_em');
    const hienThiThoiLuong = document.getElementById('hien_thi_thoi_luong');

    if (!tourSelect) return;

    const option = tourSelect.options[tourSelect.selectedIndex];

    // Hiển thị thời lượng
    if (hienThiThoiLuong) {
        hienThiThoiLuong.textContent = option.dataset.thoiLuong || '';
    }

    // Fill dữ liệu
    if (soCho) {
        soCho.value = option.dataset.soCho || '';
    }

    if (giaNguoiLon) {
        giaNguoiLon.value = option.dataset.giaNguoiLon || '';
    }

    if (giaTreEm) {
        giaTreEm.value = option.dataset.giaTreEm || '';
    }

    // Tính ngày kết thúc
    tinhNgayKetThuc();
}

function tinhNgayKetThuc() {

    const tourSelect = document.getElementById('tour_id');
    const ngayKhoiHanh = document.getElementById('ngay_khoi_hanh');
    const ngayKetThuc = document.getElementById('ngay_ket_thuc');

    if (!tourSelect || !ngayKhoiHanh || !ngayKetThuc) return;

    if (!ngayKhoiHanh.value) {
        ngayKetThuc.value = '';
        return;
    }

    const option = tourSelect.options[tourSelect.selectedIndex];
    const thoiLuong = option.dataset.thoiLuong;

    if (!thoiLuong) return;

    const match = thoiLuong.match(/(\d+)/);

    if (!match) return;

    const soNgay = parseInt(match[1]);

    const date = new Date(ngayKhoiHanh.value);
    date.setDate(date.getDate() + soNgay - 1);

    const year = date.getFullYear();
    const month = String(date.getMonth() + 1).padStart(2, '0');
    const day = String(date.getDate()).padStart(2, '0');

    ngayKetThuc.value = `${year}-${month}-${day}`;
}

document.addEventListener('DOMContentLoaded', function () {

    const tourSelect = document.getElementById('tour_id');
    const ngayKhoiHanh = document.getElementById('ngay_khoi_hanh');

    if (!tourSelect || !ngayKhoiHanh) return;

    tourSelect.addEventListener('change', capNhatThongTinTour);
    ngayKhoiHanh.addEventListener('change', tinhNgayKetThuc);

    capNhatThongTinTour();
});