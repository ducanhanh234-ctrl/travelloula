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

.btn-update{
    padding:12px 24px;
    border:none;
    border-radius:8px;
    background:#3b82f6;
    color:#fff;
    font-weight:700;
    cursor:pointer;
}

.btn-update:hover{
    background:#2563eb;
}
</style>

<div class="edit-customer-page">

    <a href="{{ route('khach-hang-dat-tours.index') }}" class="back-link">
        ← Quay lại danh sách
    </a>

    <h1 class="page-title">Chỉnh sửa khách hàng đặt tour</h1>

    <div class="page-subtitle">
        Cập nhật thông tin cá nhân, thanh toán và trạng thái check-in
    </div>

    <form action="{{ route('khach-hang-dat-tours.update',$khachHang->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-card">
            <div class="form-card-header">
                Thông tin khách hàng
            </div>

            <div class="form-card-body">

                <div class="field">
                    <label>Họ tên *</label>
                    <input type="text" name="ho_ten"
                           class="input-control"
                           value="{{ old('ho_ten',$khachHang->ho_ten) }}">
                </div>

                <div class="field">
                    <label>Email</label>
                    <input type="email" name="email"
                           class="input-control"
                           value="{{ old('email',$khachHang->email) }}">
                </div>

                <div class="field">
                    <label>Số điện thoại</label>
                    <input type="text" name="so_dien_thoai"
                           class="input-control"
                           value="{{ old('so_dien_thoai',$khachHang->so_dien_thoai) }}">
                </div>

                <div class="field">
                    <label>Giới tính</label>
                    <select name="gioi_tinh" class="input-control">
                        <option value="nam">Nam</option>
                        <option value="nu">Nữ</option>
                        <option value="khac">Khác</option>
                    </select>
                </div>

                <div class="field">
                    <label>Năm sinh</label>
                    <input type="number" name="nam_sinh"
                           class="input-control"
                           value="{{ old('nam_sinh',$khachHang->nam_sinh) }}">
                </div>

                <div class="field">
                    <label>Loại giấy tờ</label>
                    <input type="text" name="loai_giay_to"
                           class="input-control"
                           value="{{ old('loai_giay_to',$khachHang->loai_giay_to) }}">
                </div>

                <div class="field">
                    <label>Số giấy tờ</label>
                    <input type="text" name="so_giay_to"
                           class="input-control"
                           value="{{ old('so_giay_to',$khachHang->so_giay_to) }}">
                </div>

                <div class="field">
                    <label>Loại hành khách</label>
                    <select name="loai_hanh_khach" class="input-control">
                        <option value="adult">Người lớn</option>
                        <option value="child">Trẻ em</option>
                        <option value="baby">Em bé</option>
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
                    <input type="text"
                           name="trang_thai_thanh_toan"
                           class="input-control"
                           value="{{ old('trang_thai_thanh_toan',$khachHang->trang_thai_thanh_toan) }}">
                </div>

                <div class="field">
                    <label>Trạng thái check-in</label>
                    <select name="trang_thai_check_in" class="input-control">
                        <option value="chua_check_in">Chưa check-in</option>
                        <option value="da_check_in">Đã check-in</option>
                    </select>
                </div>

                <div class="field">
                    <label>Số tiền đã thanh toán</label>
                    <input type="number"
                           name="so_tien_da_thanh_toan"
                           class="input-control"
                           value="{{ old('so_tien_da_thanh_toan',$khachHang->so_tien_da_thanh_toan) }}">
                </div>

                <div class="field">
                    <label>Tổng tiền</label>
                    <input type="number"
                           name="tong_tien"
                           class="input-control"
                           value="{{ old('tong_tien',$khachHang->tong_tien) }}">
                </div>

                <div class="field">
                    <label>Số phòng</label>
                    <input type="text"
                           name="so_phong"
                           class="input-control"
                           value="{{ old('so_phong',$khachHang->so_phong) }}">
                </div>

                <div class="field">
                    <label>Loại phòng</label>
                    <input type="text"
                           name="loai_phong"
                           class="input-control"
                           value="{{ old('loai_phong',$khachHang->loai_phong) }}">
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
                    <textarea name="yeu_cau_dac_biet"
                              class="textarea-control">{{ old('yeu_cau_dac_biet',$khachHang->yeu_cau_dac_biet) }}</textarea>
                </div>

                <div class="field">
                    <label>Ghi chú</label>
                    <textarea name="ghi_chu"
                              class="textarea-control">{{ old('ghi_chu',$khachHang->ghi_chu) }}</textarea>
                </div>

            </div>
        </div>

        <div class="actions-bar">
            <a href="{{ route('khach-hang-dat-tours.index') }}" class="btn-cancel">
                Hủy
            </a>

            <button type="submit" class="btn-update">
                Cập nhật
            </button>
        </div>

    </form>

</div>


@endsection