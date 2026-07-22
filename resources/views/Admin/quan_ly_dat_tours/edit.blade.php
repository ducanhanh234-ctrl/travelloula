@extends('layouts.admin')
@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between mb-4">
            <h3>
                Sửa booking #{{ $booking->ma_dat_tour }}
            </h3>
            <a href="{{ route('Admin.quan_ly_dat_tour.index') }}" class="btn btn-secondary">
                Quay lại
            </a>
        </div>
        <form action="{{ route('Admin.dat_tours.update', $booking->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="card">
                <div class="card-body">
                    {{-- Tour --}}
                    <div class="mb-3">
                        <label>Tour</label>
                        <select name="tour_id" class="form-select">
                            @foreach($tours as $tour)
                                <option value="{{ $tour->id }}" data-duration="{{ $tour->lichTrinh->count() ?: 1 }}"
                                    data-adult-price="{{ $tour->gia_nguoi_lon }}" data-child-price="{{ $tour->gia_tre_em }}"
                                    {{ $booking->tour_id == $tour->id ? 'selected' : '' }}>
                                    {{ $tour->ten_tour }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Người đặt --}}
                    <div class="mb-3">
                        <label>
                            Người đặt
                        </label>
                        <input class="form-control" readonly value="{{ $booking->nguoiDung->name ?? '' }}">
                    </div>

                    {{-- Ngày --}}
                    <div class="row">
                        <div class="col-md-6">
                            <label>
                                Ngày khởi hành
                            </label>
                            <input type="date" id="ngay_khoi_hanh" name="ngay_khoi_hanh" class="form-control"
                                value="{{ optional($booking->lichKhoiHanh?->ngay_khoi_hanh)->format('Y-m-d') }}">
                        </div>

                        <div class="col-md-6">
                            <label>
                                Ngày kết thúc
                            </label>
                            <input type="date" readonly id="ngay_ket_thuc" name="ngay_ket_thuc" class="form-control"
                                value="{{ optional($booking->lichKhoiHanh)->ngay_ket_thuc }}">
                        </div>
                    </div>

                    <hr>

                    {{-- Số lượng khách --}}
                    <div class="row">
                        <div class="col-md-6">
                            <label>Người lớn</label>
                            <input id="adult_count" name="so_nguoi_lon" type="number" min="0" class="form-control"
                                value="{{ $booking->so_nguoi_lon }}">
                        </div>

                        <div class="col-md-6">
                            <label>Trẻ em</label>
                            <input id="child_count" name="so_tre_em" type="number" min="0" class="form-control"
                                value="{{ $booking->so_tre_em }}">
                        </div>
                    </div>

                    <hr>

                    <h5>
                        Danh sách hành khách
                    </h5>

                    <div id="new-passenger-container"></div>
                    <div id="passenger-container">
                        @foreach($hanhKhachs as $index => $hk)
                            <div class="card mb-3 passenger-card" data-type="{{ $hk->loai_hanh_khach }}">
                                <div class="card-header d-flex justify-content-between">
                                    <span>
                                        @if($hk->loai_hanh_khach == 'adult')
                                            Người lớn
                                        @elseif($hk->loai_hanh_khach == 'child')
                                            Trẻ em
                                        @endif

                                        #{{ $index + 1 }}
                                    </span>

                                    <button type="button" class="btn btn-danger btn-sm"
                                        onclick="removeOldPassenger(this,{{ $hk->id }})">
                                        Xóa
                                    </button>
                                </div>

                                <div class="card-body">
                                    <input type="hidden" name="hanh_khach[{{ $index }}][id]" value="{{ $hk->id }}">
                                    <div class="row">
    <div class="col-md-4">
        <label>Họ tên</label>
        <input
            class="form-control"
            name="hanh_khach[{{ $index }}][ho_ten]"
            value="{{ $hk->ho_ten }}">
    </div>

    <div class="col-md-4">
        <label>Giới tính</label>
        <select
            class="form-select"
            name="hanh_khach[{{ $index }}][gioi_tinh]">
            <option value="Nam" {{ $hk->gioi_tinh == 'Nam' ? 'selected' : '' }}>Nam</option>
            <option value="Nữ" {{ $hk->gioi_tinh == 'Nữ' ? 'selected' : '' }}>Nữ</option>
        </select>
    </div>

    <div class="col-md-4">
        <label>Ngày sinh</label>
        <input
            type="date"
            class="form-control"
            name="hanh_khach[{{ $index }}][ngay_sinh]"
            value="{{ $hk->ngay_sinh ? \Carbon\Carbon::parse($hk->ngay_sinh)->format('Y-m-d') : '' }}">
    </div>
</div>

<div class="row mt-3">
    <div class="col-md-3">
        <label>Quốc tịch</label>
        <input
            class="form-control"
            name="hanh_khach[{{ $index }}][quoc_tich]"
            value="{{ $hk->quoc_tich }}">
    </div>

    <div class="col-md-3">
        <label>Loại giấy tờ</label>
        <select
            class="form-select"
            name="hanh_khach[{{ $index }}][loai_giay_to]">
            <option value="CCCD" {{ $hk->loai_giay_to == 'CCCD' ? 'selected' : '' }}>CCCD</option>
            <option value="Hộ chiếu" {{ $hk->loai_giay_to == 'Hộ chiếu' ? 'selected' : '' }}>Hộ chiếu</option>
        </select>
    </div>

    <div class="col-md-3">
        <label>Số giấy tờ</label>
        <input
            class="form-control"
            name="hanh_khach[{{ $index }}][so_giay_to]"
            value="{{ $hk->so_giay_to }}">
    </div>

    <div class="col-md-3">
        <label>SĐT</label>
        <input
            class="form-control"
            name="hanh_khach[{{ $index }}][so_dien_thoai]"
            value="{{ $hk->so_dien_thoai }}">
    </div>
</div>

<div class="row mt-3">
    <div class="col-md-12">
        <label>Yêu cầu đặc biệt</label>
        <textarea
            class="form-control"
            rows="2"
            name="hanh_khach[{{ $index }}][yeu_cau_dac_biet]">{{ $hk->yeu_cau_dac_biet }}</textarea>
    </div>
</div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <hr>

                    <div class="mb-3">
                        <label>
                            Tổng tiền
                        </label>

                        <input id="tong_tien" readonly class="form-control"
                            value="{{ number_format($booking->tong_tien, 0, ',', '.') }} VNĐ">
                    </div>

                   <div class="mb-3">
                        <label>Đã thanh toán</label>
                        <input type="number" class="form-control"
                            value="{{ $booking->so_tien_da_thanh_toan }}"
                                readonly>
                    </div>

                   <div class="mb-3">
    <label>Trạng thái</label>

    <input
        type="text"
        class="form-control"
        value="@switch($booking->trang_thai)
            @case('cho_xac_nhan') Chờ xác nhận @break
            @case('da_xac_nhan') Đã xác nhận @break
            @case('da_thanh_toan') Đã thanh toán @break
            @case('da_huy') Đã hủy @break
        @endswitch"
        readonly
    >

    <input
        type="hidden"
        name="trang_thai"
        value="{{ $booking->trang_thai }}"
    >
</div>

                    <div class="mb-3">
                        <label>
                            Ghi chú
                        </label>
                        <textarea name="ghi_chu" class="form-control">
                                {{ $booking->ghi_chu }}
                                </textarea>
                    </div>

                    <button class="btn btn-primary">
                        Cập nhật
                    </button>
                </div>
            </div>
        </form>
    </div>

    <script>
        let oldPassengerCount = {{ count($hanhKhachs) }};
        // tạo form hành khách mới
       function createPassengerForm(index, title, type) {
    let colorClass = '';

    switch (type) {
        case 'adult':
            colorClass = 'bg-primary text-white';
            break;

        case 'child':
            colorClass = 'bg-warning text-dark';
            break;
    }
    return `
        <div class="card mb-3 border-success">
            <div class="card-header ${colorClass}">
                ${title}
            </div>

            <div class="card-body">
                <input
                    type="hidden"
                    name="hanh_khach_moi[${index}][loai_hanh_khach]"
                    value="${type}"
                >

                <div class="row">
                    <div class="col-md-4">
                        <label>Họ tên</label>
                        <input
                            type="text"
                            class="form-control"
                            name="hanh_khach_moi[${index}][ho_ten]"
                        >
                    </div>

                    <div class="col-md-4">
                        <label>Giới tính</label>
                        <select
                            class="form-select"
                            name="hanh_khach_moi[${index}][gioi_tinh]">

                            <option value="Nam">Nam</option>
                            <option value="Nữ">Nữ</option>
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label>Ngày sinh</label>
                        <input
                            type="date"
                            class="form-control"
                            name="hanh_khach_moi[${index}][ngay_sinh]"
                        >
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-md-3">
                        <label>Quốc tịch</label>
                        <input
                            type="text"
                            class="form-control"
                            name="hanh_khach_moi[${index}][quoc_tich]"
                            value="Việt Nam"
                        >
                    </div>

                    <div class="col-md-3">
                        <label>Loại giấy tờ</label>
                        <select
                            class="form-select"
                            name="hanh_khach_moi[${index}][loai_giay_to]">
                            <option value="CCCD">CCCD</option>
                            <option value="Hộ chiếu">Hộ chiếu</option>
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label>Số giấy tờ</label>
                        <input
                            type="text"
                            class="form-control"
                            name="hanh_khach_moi[${index}][so_giay_to]"
                        >
                    </div>

                    <div class="col-md-3">
                        <label>Số điện thoại</label>
                        <input
                            type="text"
                            class="form-control"
                            name="hanh_khach_moi[${index}][so_dien_thoai]"
                        >
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-md-12">
                        <label>Yêu cầu đặc biệt</label>
                        <textarea
                            class="form-control"
                            rows="2"
                            name="hanh_khach_moi[${index}][yeu_cau_dac_biet]"></textarea>
                    </div>
                </div>
            </div>
        </div>
    `;
}

        function generateNewPassengers() {
            let adult =
                Number(document.getElementById('adult_count').value) || 0;

            let child =
                Number(document.getElementById('child_count').value) || 0;
            let container =
                document.getElementById('new-passenger-container');
            container.innerHTML = '';

            // đếm hành khách cũ theo từng loại
            let oldAdult = 0;
            let oldChild = 0;
            document.querySelectorAll(
                '#passenger-container .passenger-card'
            ).forEach(card => {
                let type =
                    card.dataset.type;

                if (type === 'adult') {
                    oldAdult++;
                }

                if (type === 'child') {
                    oldChild++;
                }
            });

            let index =
                document.querySelectorAll(
                    '#passenger-container .passenger-card'
                ).length;

            // NGƯỜI LỚN
            for (let i = oldAdult; i < adult; i++) {
                container.innerHTML +=
                    createPassengerForm(
                        index,
                        `Người lớn #${i + 1}`,
                        'adult'
                    );
                index++;
            }

            // TRẺ EM
            for (let i = oldChild; i < child; i++) {
                container.innerHTML +=
                    createPassengerForm(
                        index,
                        `Trẻ em #${i + 1}`,
                        'child'
                    );
                index++;
            }
        }

        // chạy khi thay đổi số lượng
        document.addEventListener(
            'DOMContentLoaded',
            function () {
                document
                    .getElementById('adult_count')
                    .addEventListener(
                        'input',
                            function() {
                                generateNewPassengers();
                                updateTotalPrice();
                            }
                        );

                document
                    .getElementById('child_count')
                    .addEventListener(
                        'input',
                            function() {
                                generateNewPassengers();
                                updateTotalPrice();
                            }
                        );
                generateNewPassengers();
                updateEndDate();
                updateTotalPrice();
            });

        // tính ngày kết thúc tour
        function updateEndDate() {
            let start =
                document.getElementById('ngay_khoi_hanh').value;
            if (!start) {
                return;
            }
            let option =
                document.querySelector(
                    '[name="tour_id"] option:checked'
                );

            let duration =
                Number(option.dataset.duration || 1);

            let date =
                new Date(start);

            date.setDate(
                date.getDate() + duration - 1
            );

            let result =
                date.getFullYear()
                + "-"
                + String(date.getMonth() + 1)
                    .padStart(2, '0')
                + "-"
                + String(date.getDate())
                    .padStart(2, '0');

            document
                .getElementById('ngay_ket_thuc')
                .value = result;
        }

        document
            .getElementById('ngay_khoi_hanh')
            .addEventListener(
                'change',
                updateEndDate
            );

        document
            .querySelector('[name="tour_id"]')
            .addEventListener(
                'change',
                    function() {
                        updateEndDate();
                        updateTotalPrice();
                    }
                );

    //hàm tính tổng tiền
    function updateTotalPrice() {
    let option =
        document.querySelector(
            '[name="tour_id"] option:checked'
        );

    let adultPrice =
        Number(option.dataset.adultPrice || 0);

    let childPrice =
        Number(option.dataset.childPrice || 0);

    let adult =
        Number(
            document.getElementById('adult_count').value
        ) || 0;

    let child =
        Number(
            document.getElementById('child_count').value
        ) || 0;

    let total = (adult * adultPrice) + (child * childPrice);
    document.getElementById('tong_tien').value =
        total.toLocaleString('vi-VN') + ' VNĐ';
}

        function removeOldPassenger(button, id) {
            let card = button.closest('.passenger-card');
            let type = card.dataset.type;

    if (type === 'adult') {
        let input = document.getElementById('adult_count');
        input.value = Number(input.value) - 1;
    }

    if (type === 'child') {
        let input = document.getElementById('child_count');
        input.value = Number(input.value) - 1;
    }

    let hidden = document.createElement('input');
    hidden.type = "hidden";
    hidden.name = "hanh_khach_xoa[]";
    hidden.value = id;

    document
        .getElementById('passenger-container')
        .appendChild(hidden);

    card.remove();

    generateNewPassengers();
    updateTotalPrice();
}
    </script>
@endsection
