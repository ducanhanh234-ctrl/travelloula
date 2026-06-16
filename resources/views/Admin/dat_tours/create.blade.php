@extends('layouts.admin')

@section('content')

    <div class="container-fluid">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="fw-bold">
                    Thêm đặt tour thủ công
                </h2>
                <p class="text-muted">
                    Tạo booking mới cho khách hàng
                </p>
            </div>

            <a href="{{ route('Admin.dat_tours') }}" class="btn btn-warning">
                Quay lại
            </a>
        </div>

        <form>

            <!-- Thông tin tour -->
            <div class="card mb-4">
                <div class="card-header fw-bold">
                    Thông tin tour
                </div>

                <div class="card-body">

                    <div class="mb-3">
                        <label class="form-label">
                            Tour *
                        </label>

                        <select class="form-select" id="tour_id" name="tour_id">

                            <option value="">
                                -- Chọn tour --
                            </option>

                            @foreach($tours as $tour)
                                <option value="{{ $tour->id }}">
                                    {{ $tour->ten_tour }}
                                </option>
                            @endforeach

                        </select>
                    </div>

                    <select class="form-select" name="lich_khoi_hanh_id">

                        <option value="">
                            -- Chọn lịch khởi hành --
                        </option>

                        @foreach($lichKhoiHanhs as $lich)
                            <option value="{{ $lich->id }}">
                                {{ \Carbon\Carbon::parse($lich->ngay_khoi_hanh)->format('d/m/Y') }}
                                (Còn {{ $lich->so_cho_con_lai }} chỗ)
                            </option>
                        @endforeach

                    </select>
                </div>
            </div>

            <!-- Khách hàng -->
            <div class="card mb-4">
                <div class="card-header fw-bold">
                    Thông tin khách hàng
                </div>

                <div class="card-body">

                    <div class="row">

                        <div class="col-md-6 mb-3">
                            <label>Họ tên</label>
                            <input type="text" class="form-control">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label>Số điện thoại</label>
                            <input type="text" class="form-control">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label>Email</label>
                            <input type="email" class="form-control">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label>Ghi chú</label>
                            <textarea class="form-control"></textarea>
                        </div>

                    </div>

                </div>
            </div>

            <!-- Thông tin sale -->
            <div class="card mb-4">
                <div class="card-header fw-bold">
                    Thông tin sale
                </div>

                <div class="card-body">

                    <div class="row">

                        <div class="col-md-4">
                            <label>Sale phụ trách</label>
                            <input type="number" class="form-control" value="1">
                        </div>

                        <div class="col-md-4">
                            <label>Nguồn booking</label>
                            <select class="form-select">
                                <option value="" selected disabled>-- Chọn nguồn booking --</option>
                                <option>Zalo</option>
                                <option>Website</option>
                                <option>Facebook</option>
                                <option>Khác</option>
                            </select>
                        </div>

                    </div>

                </div>
            </div>

            <div class="card mb-4">
                <div class="card-header fw-bold">
                    Thông tin đoàn
                </div>

                <div class="card-body">

                    <div class="row">

                        <div class="col-md-4">
                            <label>Số người lớn</label>
                            <input type="number" id="adult_count" class="form-control" value="1" min="0">
                        </div>

                        <div class="col-md-4">
                            <label>Số trẻ em</label>
                            <input type="number" id="child_count" class="form-control" value="0" min="0">
                        </div>

                        <div class="col-md-4">
                            <label>Số em bé</label>
                            <input type="number" id="baby_count" class="form-control" value="0" min="0">
                        </div>

                    </div>

                </div>
            </div>

            <div class="card mb-4">
                <div class="card-header fw-bold">
                    Thông tin hành khách
                </div>

                <div class="card-body">

                    <div id="passenger-summary" class="alert alert-info">
                        Tổng số hành khách: 1
                    </div>

                    <div id="passenger-container"></div>

                </div>
            </div>

            <!-- Thanh toán -->
            <div class="card mb-4">
                <div class="card-header fw-bold">
                    Thanh toán
                </div>

                <div class="card-body">

                    <div class="row">

                        <div class="col-md-6">
                            <label>Trạng thái</label>

                            <select class="form-select">
                                <option>Chờ xác nhận</option>
                                <option>Đã xác nhận</option>
                                <option>Đã thanh toán</option>
                                <option>Đã hủy</option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label>Số tiền đã thanh toán</label>

                            <input type="number" class="form-control" value="0">
                        </div>

                        <div class="col-md-6 mt-3">
                            <label>Phương thức thanh toán</label>

                            <select class="form-select">
                                <option>Tiền mặt</option>
                                <option>Chuyển khoản</option>
                                <option>Ví điện tử</option>
                                <option>Khác</option>
                            </select>

                        </div>

                    </div>
                </div>

                <div class="text-end">

                    <a href="{{ route('Admin.dat_tours') }}" class="btn btn-danger">
                        Hủy
                    </a>

                    <button type="submit" class="btn btn-primary">
                        Lưu đặt tour
                    </button>

                </div>

        </form>

    </div>


    <script>
        function createPassenger(type, index) {

            let badgeClass = '';
            let headerClass = '';

            if (type === 'Người lớn') {
                badgeClass = 'bg-success';
                headerClass = 'border-success';
            }

            if (type === 'Trẻ em') {
                badgeClass = 'bg-primary';
                headerClass = 'border-primary';
            }

            if (type === 'Em bé') {
                badgeClass = 'bg-warning text-dark';
                headerClass = 'border-warning';
            }

            return `
                    <div class="card mb-3 ${headerClass}">

                        <div class="card-header bg-light">

                            <span class="badge ${badgeClass}">
                                ${type}
                            </span>

                            <strong class="ms-2">
                                #${index}
                            </strong>

                        </div>

                        <div class="card-body">

                            <div class="row">

                                <div class="col-md-4 mb-3">
                                    <label>Họ tên</label>
                                    <input type="text"
                                           class="form-control">
                                </div>

                                <div class="col-md-2 mb-3">
                                    <label>Giới tính</label>
                                    <select class="form-select">
                                        <option>-- Chọn --</option>
                                        <option>Nam</option>
                                        <option>Nữ</option>
                                    </select>
                                </div>

                                <div class="col-md-2 mb-3">
                                    <label>Năm sinh</label>
                                    <input type="number"
                                           class="form-control">
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label>CCCD / Passport</label>
                                    <input type="text"
                                           class="form-control">
                                </div>

                            </div>

                        </div>

                    </div>
                `;
        }

        function generatePassengers() {

            let adults =
                parseInt(document.getElementById('adult_count').value) || 0;

            let children =
                parseInt(document.getElementById('child_count').value) || 0;

            let babies =
                parseInt(document.getElementById('baby_count').value) || 0;

            let total = adults + children + babies;

            document.getElementById('passenger-summary').innerHTML =
                `Tổng số hành khách: <strong>${total}</strong>`;

            let html = '';

            for (let i = 1; i <= adults; i++) {
                html += createPassenger('Người lớn', i);
            }

            for (let i = 1; i <= children; i++) {
                html += createPassenger('Trẻ em', i);
            }

            for (let i = 1; i <= babies; i++) {
                html += createPassenger('Em bé', i);
            }

            document.getElementById('passenger-container').innerHTML = html;
        }

        document.addEventListener('DOMContentLoaded', function () {

            generatePassengers();

            document
                .getElementById('adult_count')
                .addEventListener('input', generatePassengers);

            document
                .getElementById('child_count')
                .addEventListener('input', generatePassengers);

            document
                .getElementById('baby_count')
                .addEventListener('input', generatePassengers);
        });
    </script>
@endsection
