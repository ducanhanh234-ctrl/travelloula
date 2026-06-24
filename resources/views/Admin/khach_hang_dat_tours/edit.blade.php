@extends('layouts.admin_pro')

@section('content')
<style>
    .customer-edit-wrap {
        max-width: 1380px;
        margin: 0 auto;
        padding: 32px 32px 48px;
    }

    .back-link {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        color: #64748b;
        text-decoration: none;
        font-weight: 600;
        margin-bottom: 14px;
        transition: .2s;
    }

    .back-link:hover {
        color: #2563eb;
    }

    .page-title {
        font-size: 32px;
        font-weight: 800;
        color: #0f172a;
        margin: 0 0 6px;
    }

    .page-subtitle {
        color: #64748b;
        font-size: 15px;
        margin-bottom: 28px;
    }

    .form-card {
        background: #fff;
        border: 1px solid #e5e7eb;
        border-radius: 12px;
        overflow: hidden;
        margin-bottom: 22px;
        box-shadow: 0 2px 8px rgba(15, 23, 42, .04);
    }

    .form-card-header {
        padding: 16px 24px;
        border-bottom: 1px solid #e5e7eb;
        background: #fff;
        display: flex;
        justify-content: space-between;
        align-items: center;
        font-weight: 800;
        color: #0f172a;
    }

    .form-card-badge {
        background: #3b82f6;
        color: #fff;
        padding: 5px 14px;
        border-radius: 999px;
        font-size: 12px;
        font-weight: 800;
    }

    .form-card-body {
        padding: 26px 24px 14px;
    }

    .form-label {
        display: block;
        font-weight: 700;
        color: #0f172a;
        margin-bottom: 8px;
        font-size: 15px;
    }

    .input-control,
    .textarea-control {
        width: 100%;
        border: 1px solid #cbd5e1;
        border-radius: 8px;
        padding: 10px 14px;
        font-size: 15px;
        color: #0f172a;
        background: #fff;
        transition: .2s;
    }

    .input-control {
        height: 44px;
    }

    .textarea-control {
        min-height: 110px;
        resize: vertical;
    }

    .input-control:focus,
    .textarea-control:focus {
        outline: none;
        border-color: #3b82f6;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, .12);
    }

    .alert-custom {
        background: #fee2e2;
        color: #991b1b;
        border: 1px solid #fecaca;
        padding: 14px 18px;
        border-radius: 10px;
        margin-bottom: 20px;
        font-weight: 700;
    }

    .actions-bar {
        display: flex;
        justify-content: flex-end;
        gap: 12px;
        margin-top: 24px;
    }

    .btn-cancel {
        padding: 10px 22px;
        border-radius: 8px;
        background: #fff;
        border: 1px solid #cbd5e1;
        text-decoration: none;
        color: #334155;
        font-weight: 800;
        transition: .2s;
    }

    .btn-cancel:hover {
        background: #f8fafc;
        color: #0f172a;
    }

    .btn-submit {
        padding: 10px 24px;
        border: none;
        border-radius: 8px;
        background: #3b82f6;
        color: #fff;
        font-weight: 800;
        box-shadow: 0 8px 18px rgba(59, 130, 246, .22);
        transition: .2s;
        cursor: pointer;
    }

    .btn-submit:hover {
        background: #2563eb;
    }

    @media (max-width: 768px) {
        .customer-edit-wrap {
            padding: 24px 16px;
        }

        .page-title {
            font-size: 26px;
        }

        .actions-bar {
            flex-direction: column-reverse;
        }

        .btn-cancel,
        .btn-submit {
            width: 100%;
            text-align: center;
        }
    }

</style>

<div class="customer-edit-wrap">

    <a href="{{ route('Admin.khach-hang.index') }}" class="back-link">
        <i class="fa fa-arrow-left"></i>
        Quay lại danh sách
    </a>

    <h1 class="page-title">
        Chỉnh sửa khách hàng đặt tour
    </h1>

    <div class="page-subtitle">
        Cập nhật thông tin cá nhân, thanh toán và trạng thái check-in
    </div>

    @if($errors->any())
    <div class="alert-custom">
        Vui lòng kiểm tra lại dữ liệu.
    </div>
    @endif

    <form action="{{ route('Admin.khach-hang.update', $khachHang->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-card">
            <div class="form-card-header">
                <span>Thông tin khách hàng</span>
                <span class="form-card-badge">CHỈNH SỬA</span>
            </div>

            <div class="form-card-body">
                <div class="row">
                    <div class="col-md-4 mb-4">
                        <label class="form-label">Họ tên *</label>
                        <input type="text" name="ho_ten" class="input-control" value="{{ old('ho_ten', $khachHang->ho_ten) }}">
                    </div>

                    <div class="col-md-4 mb-4">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="input-control" value="{{ old('email', $khachHang->email) }}">
                    </div>

                    <div class="col-md-4 mb-4">
                        <label class="form-label">Số điện thoại</label>
                        <input type="text" name="so_dien_thoai" class="input-control" value="{{ old('so_dien_thoai', $khachHang->so_dien_thoai) }}">
                    </div>

                    <div class="col-md-4 mb-4">
                        <label class="form-label">Giới tính</label>
                        <select name="gioi_tinh" class="input-control">
                            <option value="">-- Chọn --</option>
                            <option value="nam" @selected(old('gioi_tinh', $khachHang->gioi_tinh) == 'nam')>Nam</option>
                            <option value="nu" @selected(old('gioi_tinh', $khachHang->gioi_tinh) == 'nu')>Nữ</option>
                            <option value="khac" @selected(old('gioi_tinh', $khachHang->gioi_tinh) == 'khac')>Khác</option>
                        </select>
                    </div>

                    <div class="col-md-4 mb-4">
                        <label class="form-label">Năm sinh</label>
                        <input type="number" name="nam_sinh" class="input-control" value="{{ old('nam_sinh', $khachHang->nam_sinh) }}">
                    </div>

                    <div class="col-md-4 mb-4">
                        <label class="form-label">Loại hành khách</label>
                        <select name="loai_hanh_khach" class="input-control">
                            <option value="adult" @selected(old('loai_hanh_khach', $khachHang->loai_hanh_khach) == 'adult')>Người lớn</option>
                            <option value="child" @selected(old('loai_hanh_khach', $khachHang->loai_hanh_khach) == 'child')>Trẻ em</option>
                            <option value="baby" @selected(old('loai_hanh_khach', $khachHang->loai_hanh_khach) == 'baby')>Em bé</option>
                        </select>
                    </div>

                    <div class="col-md-6 mb-4">
                        <label class="form-label">Loại giấy tờ</label>
                        <input type="text" name="loai_giay_to" class="input-control" value="{{ old('loai_giay_to', $khachHang->loai_giay_to) }}">
                    </div>

                    <div class="col-md-6 mb-4">
                        <label class="form-label">Số giấy tờ</label>
                        <input type="text" name="so_giay_to" class="input-control" value="{{ old('so_giay_to', $khachHang->so_giay_to) }}">
                    </div>
                </div>
            </div>
        </div>

        <div class="form-card">
            <div class="form-card-header">
                <span>Thanh toán và Check-in</span>
            </div>

            <div class="form-card-body">
                <div class="row">

                    <div class="col-md-4 mb-4">
                        <label class="form-label">Trạng thái thanh toán</label>

                        <select name="trang_thai_thanh_toan" class="input-control">
                            <option value="chua_thanh_toan" @selected(old('trang_thai_thanh_toan', 'chua_thanh_toan' )=='chua_thanh_toan' )>
                                Chưa thanh toán
                            </option>

                            <option value="da_coc" @selected(old('trang_thai_thanh_toan')=='da_coc' )>
                                Đã đặt cọc
                            </option>

                            <option value="thanh_toan_mot_phan" @selected(old('trang_thai_thanh_toan')=='thanh_toan_mot_phan' )>
                                Thanh toán một phần
                            </option>

                            <option value="da_thanh_toan" @selected(old('trang_thai_thanh_toan')=='da_thanh_toan' )>
                                Đã thanh toán
                            </option>

                            <option value="hoan_tien" @selected(old('trang_thai_thanh_toan')=='hoan_tien' )>
                                Đã hoàn tiền
                            </option>

                            <option value="that_bai" @selected(old('trang_thai_thanh_toan')=='that_bai' )>
                                Thanh toán thất bại
                            </option>
                        </select>
                    </div>

                    <div class="col-md-4 mb-4">
                        <label class="form-label">Trạng thái check-in</label>
                        <select name="trang_thai_check_in" class="input-control">
                            <option value="chua_check_in" @selected(old('trang_thai_check_in', $khachHang->trang_thai_check_in) == 'chua_check_in')>
                                Chưa check-in
                            </option>
                            <option value="da_check_in" @selected(old('trang_thai_check_in', $khachHang->trang_thai_check_in) == 'da_check_in')>
                                Đã check-in
                            </option>
                        </select>
                    </div>

                    <div class="col-md-4 mb-4">
                        <label class="form-label">Số tiền đã thanh toán</label>
                        <input type="number" name="so_tien_da_thanh_toan" class="input-control" value="{{ old('so_tien_da_thanh_toan', $khachHang->so_tien_da_thanh_toan) }}">
                    </div>

                    <div class="col-md-4 mb-4">
                        <label class="form-label">Tổng tiền</label>
                        <input type="number" name="tong_tien" class="input-control" value="{{ old('tong_tien', $khachHang->tong_tien) }}">
                    </div>

                    <div class="col-md-4 mb-4">
                        <label class="form-label">Số phòng</label>
                        <input type="text" name="so_phong" class="input-control" value="{{ old('so_phong', $khachHang->so_phong) }}">
                    </div>

                    <div class="col-md-4 mb-4">
                        <label class="form-label">Loại phòng</label>
                        <input type="text" name="loai_phong" class="input-control" value="{{ old('loai_phong', $khachHang->loai_phong) }}">
                    </div>
                </div>
            </div>
        </div>

        <div class="form-card">
            <div class="form-card-header">
                <span>Ghi chú</span>
            </div>

            <div class="form-card-body">
                <div class="row">
                    <div class="col-md-6 mb-4">
                        <label class="form-label">Yêu cầu đặc biệt</label>
                        <textarea name="yeu_cau_dac_biet" class="textarea-control">{{ old('yeu_cau_dac_biet', $khachHang->yeu_cau_dac_biet) }}</textarea>
                    </div>

                    <div class="col-md-6 mb-4">
                        <label class="form-label">Ghi chú</label>
                        <textarea name="ghi_chu" class="textarea-control">{{ old('ghi_chu', $khachHang->ghi_chu) }}</textarea>
                    </div>
                </div>
            </div>
        </div>

        <div class="actions-bar">
            <a href="{{ route('Admin.khach-hang.index') }}" class="btn-cancel">
                Hủy
            </a>

            <button type="submit" class="btn-submit">
                <i class="fa fa-save"></i>
                Cập nhật
            </button>
        </div>
    </form>
</div>
@endsection
