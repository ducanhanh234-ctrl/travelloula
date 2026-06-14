@extends('layouts.admin')

@section('content')
<style>
.edit-customer-page{
    max-width:1000px;
    margin:0 auto;
    padding:30px;
}

.page-title{
    font-size:42px;
    font-weight:800;
    color:#0f172a;
    margin-bottom:8px;
}

.page-subtitle{
    color:#64748b;
    margin-bottom:30px;
    font-size:16px;
}

.back-link{
    display:inline-flex;
    align-items:center;
    gap:8px;
    padding:10px 18px;
    border-radius:8px;
    background:#f1f5f9;
    color:#334155;
    text-decoration:none;
    font-weight:600;
    margin-bottom:20px;
}

.back-link:hover{
    background:#e2e8f0;
}

.form-card{
    background:#fff;
    border-radius:14px;
    overflow:hidden;
    margin-bottom:24px;
    box-shadow:0 2px 12px rgba(0,0,0,.05);
}

.form-card-header{
    padding:18px 24px;
    font-size:20px;
    font-weight:700;
    border-bottom:1px solid #e2e8f0;
}

.form-card-body{
    padding:24px;
}

.field{
    margin-bottom:20px;
}

.field:last-child{
    margin-bottom:0;
}

.field label{
    display:block;
    font-weight:700;
    margin-bottom:8px;
    color:#1e293b;
}

.input-control,
.textarea-control{
    width:100%;
    border:1px solid #cbd5e1;
    border-radius:10px;
    padding:12px 14px;
    font-size:15px;
    transition:.2s;
}

.input-control{
    height:48px;
}

.textarea-control{
    min-height:120px;
    resize:vertical;
}

.input-control:focus,
.textarea-control:focus{
    outline:none;
    border-color:#3b82f6;
    box-shadow:0 0 0 4px rgba(59,130,246,.15);
}

.alert-custom{
    background:#fee2e2;
    color:#991b1b;
    border:1px solid #fecaca;
    padding:14px 18px;
    border-radius:10px;
    margin-bottom:20px;
    font-weight:700;
}

.actions-bar{
    display:flex;
    justify-content:flex-end;
    gap:12px;
    margin-top:24px;
}

.btn-cancel{
    padding:12px 24px;
    border-radius:8px;
    border:1px solid #cbd5e1;
    background:#fff;
    color:#334155;
    text-decoration:none;
    font-weight:700;
}

.btn-store{
    padding:12px 24px;
    border:none;
    border-radius:8px;
    background:#3b82f6;
    color:#fff;
    font-weight:700;
    cursor:pointer;
}

.btn-store:hover{
    background:#2563eb;
}
</style>

<div class="edit-customer-page">

    <a href="{{ route('khach-hang-dat-tours.index') }}" class="back-link">
        ← Quay lại danh sách
    </a>

    <h1 class="page-title">Thêm khách hàng đặt tour</h1>

    <div class="page-subtitle">
        Thêm khách hàng vào đơn đặt tour đã có
    </div>

    @if($errors->any())
        <div class="alert-custom">
            Vui lòng kiểm tra lại dữ liệu.
        </div>
    @endif

    <form action="{{ route('khach-hang-dat-tours.store') }}" method="POST">
        @csrf

        <div class="form-card">
            <div class="form-card-header">
                Đơn đặt tour
            </div>

            <div class="form-card-body">
                <div class="field">
                    <label>Chọn đơn đặt tour *</label>
                    <select name="dat_tour_id" class="input-control" required>
                        <option value="">-- Chọn đơn đặt tour --</option>
                        @foreach($datTours as $datTour)
                            <option value="{{ $datTour->id }}" @selected(old('dat_tour_id') == $datTour->id)>
                                {{ $datTour->ma_dat_tour }} -
                                {{ $datTour->tour->ten_tour ?? 'Chưa có tên tour' }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        <div class="form-card">
            <div class="form-card-header">
                Thông tin khách hàng
            </div>

            <div class="form-card-body">

                <div class="field">
                    <label>Họ tên *</label>
                    <input type="text" name="ho_ten" class="input-control" value="{{ old('ho_ten') }}" required>
                </div>

                <div class="field">
                    <label>Email</label>
                    <input type="email" name="email" class="input-control" value="{{ old('email') }}">
                </div>

                <div class="field">
                    <label>Số điện thoại</label>
                    <input type="text" name="so_dien_thoai" class="input-control" value="{{ old('so_dien_thoai') }}">
                </div>

                <div class="field">
                    <label>Giới tính</label>
                    <select name="gioi_tinh" class="input-control">
                        <option value="">-- Chọn --</option>
                        <option value="nam" @selected(old('gioi_tinh') == 'nam')>Nam</option>
                        <option value="nu" @selected(old('gioi_tinh') == 'nu')>Nữ</option>
                        <option value="khac" @selected(old('gioi_tinh') == 'khac')>Khác</option>
                    </select>
                </div>

                <div class="field">
                    <label>Năm sinh</label>
                    <input type="number" name="nam_sinh" class="input-control" value="{{ old('nam_sinh') }}">
                </div>

                <div class="field">
                    <label>Loại giấy tờ</label>
                    <input type="text" name="loai_giay_to" class="input-control" value="{{ old('loai_giay_to') }}">
                </div>

                <div class="field">
                    <label>Số giấy tờ</label>
                    <input type="text" name="so_giay_to" class="input-control" value="{{ old('so_giay_to') }}">
                </div>

                <div class="field">
                    <label>Loại hành khách</label>
                    <select name="loai_hanh_khach" class="input-control">
                        <option value="adult" @selected(old('loai_hanh_khach') == 'adult')>Người lớn</option>
                        <option value="child" @selected(old('loai_hanh_khach') == 'child')>Trẻ em</option>
                        <option value="baby" @selected(old('loai_hanh_khach') == 'baby')>Em bé</option>
                    </select>
                </div>

            </div>
        </div>

        <div class="form-card">
            <div class="form-card-header">
                Thanh toán và Check-in
            </div>

            <div class="form-card-body">

                <div class="field">
                    <label>Trạng thái thanh toán</label>
                    <input type="text" name="trang_thai_thanh_toan" class="input-control" value="{{ old('trang_thai_thanh_toan', 'pending') }}">
                </div>

                <div class="field">
                    <label>Trạng thái check-in</label>
                    <select name="trang_thai_check_in" class="input-control">
                        <option value="chua_check_in" @selected(old('trang_thai_check_in') == 'chua_check_in')>Chưa check-in</option>
                        <option value="da_check_in" @selected(old('trang_thai_check_in') == 'da_check_in')>Đã check-in</option>
                    </select>
                </div>

                <div class="field">
                    <label>Số tiền đã thanh toán</label>
                    <input type="number" name="so_tien_da_thanh_toan" class="input-control" value="{{ old('so_tien_da_thanh_toan', 0) }}">
                </div>

                <div class="field">
                    <label>Tổng tiền</label>
                    <input type="number" name="tong_tien" class="input-control" value="{{ old('tong_tien', 0) }}">
                </div>

                <div class="field">
                    <label>Số phòng</label>
                    <input type="text" name="so_phong" class="input-control" value="{{ old('so_phong') }}">
                </div>

                <div class="field">
                    <label>Loại phòng</label>
                    <input type="text" name="loai_phong" class="input-control" value="{{ old('loai_phong') }}">
                </div>

            </div>
        </div>

        <div class="form-card">
            <div class="form-card-header">
                Ghi chú
            </div>

            <div class="form-card-body">
                <div class="field">
                    <label>Yêu cầu đặc biệt</label>
                    <textarea name="yeu_cau_dac_biet" class="textarea-control">{{ old('yeu_cau_dac_biet') }}</textarea>
                </div>

                <div class="field">
                    <label>Ghi chú</label>
                    <textarea name="ghi_chu" class="textarea-control">{{ old('ghi_chu') }}</textarea>
                </div>
            </div>
        </div>

        <div class="actions-bar">
            <a href="{{ route('khach-hang-dat-tours.index') }}" class="btn-cancel">
                Hủy
            </a>

            <button type="submit" class="btn-store">
                Thêm khách hàng
            </button>
        </div>
    </form>
</div>
@endsection