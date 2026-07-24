function capNhatThongTinTour() {


    const tourSelect = document.getElementById('tour_id');

    const soCho = document.getElementById('so_cho');
    const giaNguoiLon = document.getElementById('gia_nguoi_lon');
    const giaTreEm = document.getElementById('gia_tre_em');
    const giaEmBe = document.getElementById('gia_em_be');
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

    // Xóa giá cũ
    if (giaNguoiLon) {
        giaNguoiLon.value = '';
    }

    if (giaTreEm) {
        giaTreEm.value = '';
    }

    if (giaEmBe) {
        giaEmBe.value = '';
    }
    // Lấy giá theo loại mùa
    layBangGia();

    // Tính ngày kết thúc

    tinhNgayKetThuc();
}

function layBangGia() {

    const tourId = document.getElementById('tour_id').value;
    const loaiMua = document.getElementById('loai_mua').value;

    const giaNguoiLon = document.getElementById('gia_nguoi_lon');
    const giaTreEm = document.getElementById('gia_tre_em');
    const giaEmBe = document.getElementById('gia_em_be');

    // Chưa chọn đủ dữ liệu
    if (!tourId || !loaiMua) {

        giaNguoiLon.value = '';
        giaTreEm.value = '';
        giaEmBe.value = '';

        return;
    }

    fetch(`/Admin/lich-khoi-hanh/bang-gia?tour_id=${tourId}&loai_mua=${loaiMua}`)

        .then(response => response.json())

        .then(result => {

            if (result.success) {

                giaNguoiLon.value = result.data.gia_nguoi_lon;
                giaTreEm.value = result.data.gia_tre_em;
                giaEmBe.value = result.data.gia_em_be;

            } else {

                giaNguoiLon.value = '';
                giaTreEm.value = '';
                giaEmBe.value = '';
            }

        })

        .catch(error => {

            console.error(error);

            giaNguoiLon.value = '';
            giaTreEm.value = '';
            giaEmBe.value = '';
        });

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

// document.addEventListener('DOMContentLoaded', function () {

//     const tourSelect = document.getElementById('tour_id');
//     const loaiMua = document.getElementById('loai_mua');
//     const ngayKhoiHanh = document.getElementById('ngay_khoi_hanh');



//     if (!tourSelect || !ngayKhoiHanh || !loaiMua) return;

//     tourSelect.addEventListener('change', capNhatThongTinTour);
//     loaiMua.addEventListener('change', layBangGia);
//     ngayKhoiHanh.addEventListener('change', tinhNgayKetThuc);
//     capNhatThongTinTour();

// });

document.addEventListener('DOMContentLoaded', function () {

    const tourSelect = document.getElementById('tour_id');
    const loaiMua = document.getElementById('loai_mua');
    const ngayKhoiHanh = document.getElementById('ngay_khoi_hanh');

    if (!tourSelect || !ngayKhoiHanh || !loaiMua) return;

    // Khởi tạo Select2
    $('#tour_id').select2({
        placeholder: 'Tìm kiếm tour...',
        width: '100%'
    });

    // Khi đổi tour
    $('#tour_id').on('change', function () {
        capNhatThongTinTour();
    });

    // Khi đổi loại mùa
    loaiMua.addEventListener('change', layBangGia);

    // Khi đổi ngày khởi hành
    ngayKhoiHanh.addEventListener('change', tinhNgayKetThuc);

    // Load lần đầu
    capNhatThongTinTour();

});