@extends('layouts.admin')

@section('content')
    <style>
        .customer-edit-page {
            background: #f8fafc;
            padding: 30px 16px 40px;
            min-height: 100vh;
            color: #0f172a;
            font-family: Inter, Arial, sans-serif;
        }

        .customer-edit-wrap {
            width: 100%;
            margin: 0;
        }

        .edit-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 20px;
            margin-bottom: 28px;
        }

        .back-link {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            color: #64748b;
            text-decoration: none;
            font-weight: 750;
            font-size: 15px;
            margin-bottom: 12px;
            transition: .18s ease;
        }

        .back-link:hover {
            color: #2563eb;
            transform: translateX(-2px);
        }

        .title-wrap {
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .title-icon {
            width: 52px;
            height: 52px;
            border-radius: 14px;
            background: #eef2ff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 26px;
            line-height: 1;
        }

        .page-title {
            font-size: 34px;
            font-weight: 850;
            color: #020617;
            margin: 0;
            letter-spacing: -0.8px;
        }

        .page-subtitle {
            color: #64748b;
            font-size: 16px;
            margin-top: 8px;
        }

        .header-badge {
            margin-top: 34px;
            min-height: 52px;
            padding: 0 24px;
            background: #eef2ff;
            color: #4f46e5;
            border-radius: 999px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-weight: 850;
            white-space: nowrap;
        }

        .alert-custom {
            background: #fee2e2;
            color: #991b1b;
            border: 1px solid #fecaca;
            padding: 14px 18px;
            border-radius: 10px;
            margin-bottom: 20px;
            font-weight: 750;
        }

        .form-card {
            background: #fff;
            border: 1px solid #dbe3ee;
            border-radius: 14px;
            overflow: hidden;
            margin-bottom: 24px;
            box-shadow: 0 2px 8px rgba(15, 23, 42, .06);
        }

        .form-card-header {
            padding: 20px 28px;
            border-bottom: 1px solid #e2e8f0;
            background: #fff;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 16px;
            font-size: 20px;
            font-weight: 850;
            color: #020617;
        }

        .form-card-title {
            display: inline-flex;
            align-items: center;
            gap: 10px;
        }

        .form-card-badge {
            background: #3b82f6;
            color: #fff;
            padding: 7px 15px;
            border-radius: 999px;
            font-size: 12px;
            font-weight: 850;
            white-space: nowrap;
        }

        .form-card-body {
            padding: 28px 28px 8px;
        }

        .form-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 22px 24px;
        }

        .form-grid.two-cols {
            grid-template-columns: repeat(2, 1fr);
        }

        .form-group {
            margin-bottom: 18px;
        }

        .form-label {
            display: block;
            font-weight: 850;
            color: #0f172a;
            margin-bottom: 8px;
            font-size: 15px;
        }

        .required {
            color: #ef4444;
        }

        .input-control,
        .textarea-control {
            width: 100%;
            border: 1px solid #cbd5e1;
            border-radius: 9px;
            padding: 0 16px;
            font-size: 15.5px;
            color: #0f172a;
            background: #fff;
            transition: .18s ease;
        }

        .input-control {
            height: 48px;
        }

        .textarea-control {
            min-height: 120px;
            resize: vertical;
            padding-top: 13px;
            line-height: 1.5;
        }

        .input-control:focus,
        .textarea-control:focus {
            outline: none;
            border-color: #3b82f6;
            box-shadow: 0 0 0 4px rgba(59, 130, 246, .14);
        }

        .input-control::placeholder,
        .textarea-control::placeholder {
            color: #94a3b8;
        }

        .actions-bar {
            background: #fff;
            border: 1px solid #dbe3ee;
            border-radius: 14px;
            padding: 20px 28px;
            display: flex;
            justify-content: flex-end;
            align-items: center;
            gap: 12px;
            box-shadow: 0 2px 8px rgba(15, 23, 42, .06);
        }

        .btn-cancel,
        .btn-submit {
            min-height: 48px;
            padding: 0 24px;
            border-radius: 9px;
            font-weight: 850;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 9px;
            transition: .18s ease;
            cursor: pointer;
            border: none;
            font-size: 15.5px;
        }

        .btn-cancel {
            background: #fff;
            border: 1px solid #cbd5e1;
            color: #334155;
        }

        .btn-cancel:hover {
            background: #f8fafc;
            color: #0f172a;
            transform: translateY(-1px);
        }

        .btn-submit {
            background: #3b82f6;
            color: #fff;
            box-shadow: 0 8px 18px rgba(59, 130, 246, .22);
        }

        .btn-submit:hover {
            background: #2563eb;
            color: #fff;
            transform: translateY(-1px);
            box-shadow: 0 10px 24px rgba(37, 99, 235, .3);
        }

        @media (max-width: 1100px) {
            .customer-edit-page {
                padding: 24px 12px;
            }

            .edit-header {
                flex-direction: column;
            }

            .header-badge {
                margin-top: 0;
            }

            .form-grid,
            .form-grid.two-cols {
                grid-template-columns: 1fr;
                gap: 0;
            }
        }

        @media (max-width: 640px) {
            .title-wrap {
                align-items: flex-start;
            }

            .title-icon {
                width: 46px;
                height: 46px;
                font-size: 23px;
            }

            .page-title {
                font-size: 28px;
            }

            .form-card-header {
                padding: 18px 20px;
                font-size: 18px;
                flex-direction: column;
                align-items: flex-start;
            }

            .form-card-body {
                padding: 22px 20px 4px;
            }

            .actions-bar {
                padding: 18px 20px;
                flex-direction: column-reverse;
            }

            .btn-cancel,
            .btn-submit {
                width: 100%;
            }
        }
    </style>

    <div class="customer-edit-page">
        <div class="customer-edit-wrap">

            <div class="edit-header">
                <div>
                    <a href="{{ route('Admin.khach-hang.index') }}" class="back-link">
                        ← Quay lại danh sách
                    </a>

                    <div class="title-wrap">
                        <div class="title-icon">✏️</div>

                        <div>
                            <h1 class="page-title">
                                Chỉnh sửa khách hàng
                            </h1>

                            <div class="page-subtitle">
                                Cập nhật thông tin cá nhân, thanh toán và trạng thái check-in
                            </div>
                        </div>
                    </div>
                </div>

                <div class="header-badge">
                    {{ $khachHang->ho_ten }}
                </div>
            </div>

            @if ($errors->any())
                <div class="alert-custom">
                    Vui lòng kiểm tra lại dữ liệu.
                </div>
            @endif

            <form action="{{ route('Admin.khach-hang.update', $khachHang->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="form-card">
                    <div class="form-card-header">
                        <span class="form-card-title">
                            👤 Thông tin khách hàng
                        </span>

                        <span class="form-card-badge">
                            CHỈNH SỬA
                        </span>
                    </div>

                    <div class="form-card-body">
                        <div class="form-grid">
                            <div class="form-group">
                                <label class="form-label">
                                    Họ tên <span class="required">*</span>
                                </label>

                                <input type="text" name="ho_ten" class="input-control"
                                    value="{{ old('ho_ten', $khachHang->ho_ten) }}" placeholder="Nhập họ tên">
                            </div>

                            <div class="form-group">
                                <label class="form-label">
                                    Email
                                </label>

                                <input type="email" name="email" class="input-control"
                                    value="{{ old('email', $khachHang->email) }}" placeholder="Nhập email">
                            </div>

                            <div class="form-group">
                                <label class="form-label">
                                    Số điện thoại
                                </label>

                                <input type="text" name="so_dien_thoai" class="input-control"
                                    value="{{ old('so_dien_thoai', $khachHang->so_dien_thoai) }}"
                                    placeholder="Nhập số điện thoại">
                            </div>

                            <div class="form-group">
                                <label class="form-label">
                                    Giới tính
                                </label>

                                <select name="gioi_tinh" class="input-control">
                                    <option value="">-- Chọn giới tính --</option>
                                    <option value="nam" @selected(old('gioi_tinh', $khachHang->gioi_tinh) == 'nam')>
                                        Nam
                                    </option>
                                    <option value="nu" @selected(old('gioi_tinh', $khachHang->gioi_tinh) == 'nu')>
                                        Nữ
                                    </option>
                                    <option value="khac" @selected(old('gioi_tinh', $khachHang->gioi_tinh) == 'khac')>
                                        Khác
                                    </option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label class="form-label">
                                    Năm sinh
                                </label>

                                <input type="number" name="nam_sinh" class="input-control"
                                    value="{{ old('nam_sinh', $khachHang->nam_sinh) }}" placeholder="Nhập năm sinh">
                            </div>

                            <div class="form-group">
                                <label class="form-label">
                                    Loại hành khách
                                </label>

                                <select name="loai_hanh_khach" class="input-control">
                                    <option value="adult" @selected(old('loai_hanh_khach', $khachHang->loai_hanh_khach) == 'adult')>
                                        Người lớn
                                    </option>
                                    <option value="child" @selected(old('loai_hanh_khach', $khachHang->loai_hanh_khach) == 'child')>
                                        Trẻ em
                                    </option>
                                    <option value="baby" @selected(old('loai_hanh_khach', $khachHang->loai_hanh_khach) == 'baby')>
                                        Em bé
                                    </option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label class="form-label">
                                    Loại giấy tờ
                                </label>

                                <input type="text" name="loai_giay_to" class="input-control"
                                    value="{{ old('loai_giay_to', $khachHang->loai_giay_to) }}"
                                    placeholder="CCCD, CMND, Hộ chiếu...">
                            </div>

                            <div class="form-group">
                                <label class="form-label">
                                    Số giấy tờ
                                </label>

                                <input type="text" name="so_giay_to" class="input-control"
                                    value="{{ old('so_giay_to', $khachHang->so_giay_to) }}" placeholder="Nhập số giấy tờ">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-card">
                    <div class="form-card-header">
                        <span class="form-card-title">
                            💳 Thanh toán và Check-in
                        </span>
                    </div>

                    <div class="form-card-body">
                        <div class="form-grid">
                            <div class="form-group">
                                <label class="form-label">
                                    Trạng thái thanh toán
                                </label>

                                <select name="trang_thai_thanh_toan" class="input-control">
                                    <option value="chua_thanh_toan" @selected(old('trang_thai_thanh_toan', $khachHang->trang_thai_thanh_toan ?? 'chua_thanh_toan') == 'chua_thanh_toan')>
                                        Chưa thanh toán
                                    </option>

                                    <option value="da_coc" @selected(old('trang_thai_thanh_toan', $khachHang->trang_thai_thanh_toan ?? '') == 'da_coc')>
                                        Đã đặt cọc
                                    </option>

                                    <option value="thanh_toan_mot_phan" @selected(old('trang_thai_thanh_toan', $khachHang->trang_thai_thanh_toan ?? '') == 'thanh_toan_mot_phan')>
                                        Thanh toán một phần
                                    </option>

                                    <option value="da_thanh_toan" @selected(old('trang_thai_thanh_toan', $khachHang->trang_thai_thanh_toan ?? '') == 'da_thanh_toan')>
                                        Đã thanh toán
                                    </option>

                                    <option value="hoan_tien" @selected(old('trang_thai_thanh_toan', $khachHang->trang_thai_thanh_toan ?? '') == 'hoan_tien')>
                                        Đã hoàn tiền
                                    </option>

                                    <option value="that_bai" @selected(old('trang_thai_thanh_toan', $khachHang->trang_thai_thanh_toan ?? '') == 'that_bai')>
                                        Thanh toán thất bại
                                    </option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label class="form-label">
                                    Trạng thái check-in
                                </label>

                                <select name="trang_thai_check_in" class="input-control">
                                    <option value="chua_check_in" @selected(old('trang_thai_check_in', $khachHang->trang_thai_check_in) == 'chua_check_in')>
                                        Chưa check-in
                                    </option>

                                    <option value="da_check_in" @selected(old('trang_thai_check_in', $khachHang->trang_thai_check_in) == 'da_check_in')>
                                        Đã check-in
                                    </option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label class="form-label">
                                    Số tiền đã thanh toán
                                </label>

                                <input type="number" name="so_tien_da_thanh_toan" class="input-control"
                                    value="{{ old('so_tien_da_thanh_toan', $khachHang->so_tien_da_thanh_toan) }}"
                                    placeholder="0">
                            </div>

                            <div class="form-group">
                                <label class="form-label">
                                    Tổng tiền
                                </label>

                                <input type="number" name="tong_tien" class="input-control"
                                    value="{{ old('tong_tien', $khachHang->tong_tien) }}" placeholder="0">
                            </div>

                            <div class="form-group">
                                <label class="form-label">
                                    Số phòng
                                </label>

                                <input type="text" name="so_phong" class="input-control"
                                    value="{{ old('so_phong', $khachHang->so_phong) }}" placeholder="Nhập số phòng">
                            </div>

                            <div class="form-group">
                                <label class="form-label">
                                    Loại phòng
                                </label>

                                <select name="loai_phong" class="input-control">
                                    <option value="">-- Chọn loại phòng --</option>

                                    <option value="phong_don" @selected(old('loai_phong', $khachHang->loai_phong) == 'phong_don')>
                                        Phòng đơn
                                    </option>

                                    <option value="phong_doi" @selected(old('loai_phong', $khachHang->loai_phong) == 'phong_doi')>
                                        Phòng đôi
                                    </option>

                                    <option value="phong_twin" @selected(old('loai_phong', $khachHang->loai_phong) == 'phong_twin')>
                                        Phòng twin
                                    </option>

                                    <option value="phong_ba" @selected(old('loai_phong', $khachHang->loai_phong) == 'phong_ba')>
                                        Phòng ba
                                    </option>

                                    <option value="phong_gia_dinh" @selected(old('loai_phong', $khachHang->loai_phong) == 'phong_gia_dinh')>
                                        Phòng gia đình
                                    </option>

                                    <option value="phong_deluxe" @selected(old('loai_phong', $khachHang->loai_phong) == 'phong_deluxe')>
                                        Phòng Deluxe
                                    </option>

                                    <option value="phong_suite" @selected(old('loai_phong', $khachHang->loai_phong) == 'phong_suite')>
                                        Phòng Suite
                                    </option>

                                    <option value="phong_vip" @selected(old('loai_phong', $khachHang->loai_phong) == 'phong_vip')>
                                        Phòng VIP
                                    </option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-card">
                    <div class="form-card-header">
                        <span class="form-card-title">
                            📝 Ghi chú
                        </span>
                    </div>

                    <div class="form-card-body">
                        <div class="form-grid two-cols">
                            <div class="form-group">
                                <label class="form-label">
                                    Yêu cầu đặc biệt
                                </label>

                                <textarea name="yeu_cau_dac_biet" class="textarea-control" placeholder="Nhập yêu cầu đặc biệt nếu có">{{ old('yeu_cau_dac_biet', $khachHang->yeu_cau_dac_biet) }}</textarea>
                            </div>

                            <div class="form-group">
                                <label class="form-label">
                                    Ghi chú
                                </label>

                                <textarea name="ghi_chu" class="textarea-control" placeholder="Nhập ghi chú">{{ old('ghi_chu', $khachHang->ghi_chu) }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="actions-bar">
                    <a href="{{ route('Admin.khach-hang.index') }}" class="btn-cancel">
                        Hủy
                    </a>

                    <button type="submit" class="btn-submit">
                        💾 Cập nhật
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
