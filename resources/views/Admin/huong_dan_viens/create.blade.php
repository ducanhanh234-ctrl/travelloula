@extends('layouts.admin')

@section('content')
<div class="guide-create-page">
    <div class="form-header">
        <div>
            <h2>Thêm mới hướng dẫn viên</h2>
            <p>Tạo tài khoản và hồ sơ hướng dẫn viên mới</p>
        </div>

        <a href="{{ route('Admin.huong-dan-viens.index') }}" class="btn-back">
            <i class="fas fa-arrow-left"></i>
            Quay lại
        </a>
    </div>

    <form action="{{ route('Admin.huong-dan-viens.store') }}"
          method="POST"
          enctype="multipart/form-data"
          class="guide-form-card">
        @csrf

        <div class="form-section-title">
            <i class="fas fa-user"></i>
            Thông tin cá nhân
        </div>

        <div class="row g-4">
            <div class="col-md-6">
                <label class="form-label">Họ tên</label>
                <input type="text" name="ho_ten" class="form-control custom-input"
                       value="{{ old('ho_ten') }}"
                       placeholder="Nhập họ tên hướng dẫn viên">
                <div class="text-danger small mt-1">{{ $errors->first('ho_ten') }}</div>
            </div>

            <div class="col-md-6">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control custom-input"
                       value="{{ old('email') }}"
                       placeholder="example@gmail.com">
                <div class="text-danger small mt-1">{{ $errors->first('email') }}</div>
            </div>

            <div class="col-md-6">
                <label class="form-label">Mật khẩu</label>
                <input type="password" name="password" class="form-control custom-input"
                       placeholder="Nhập mật khẩu">
                <div class="text-danger small mt-1">{{ $errors->first('password') }}</div>
            </div>

            <div class="col-md-6">
                <label class="form-label">Số điện thoại</label>
                <input type="text" name="so_dien_thoai" class="form-control custom-input"
                       value="{{ old('so_dien_thoai') }}"
                       placeholder="Nhập số điện thoại">
                <div class="text-danger small mt-1">{{ $errors->first('so_dien_thoai') }}</div>
            </div>

            <div class="col-md-6">
                <label class="form-label">Ngày sinh</label>
                <input type="date" name="ngay_sinh" class="form-control custom-input"
                       value="{{ old('ngay_sinh') }}">
                <div class="text-danger small mt-1">{{ $errors->first('ngay_sinh') }}</div>
            </div>

            <div class="col-md-6">
                <label class="form-label">Giới tính</label>
                <select name="gioi_tinh" class="form-select custom-input">
                    <option value="">Chọn giới tính</option>
                    <option value="nam" {{ old('gioi_tinh') == 'nam' ? 'selected' : '' }}>Nam</option>
                    <option value="nu" {{ old('gioi_tinh') == 'nu' ? 'selected' : '' }}>Nữ</option>
                    <option value="khac" {{ old('gioi_tinh') == 'khac' ? 'selected' : '' }}>Khác</option>
                </select>
                <div class="text-danger small mt-1">{{ $errors->first('gioi_tinh') }}</div>
            </div>

            <div class="col-md-12">
                <label class="form-label">Địa chỉ</label>
                <input type="text" name="dia_chi" class="form-control custom-input"
                       value="{{ old('dia_chi') }}"
                       placeholder="Nhập địa chỉ">
                <div class="text-danger small mt-1">{{ $errors->first('dia_chi') }}</div>
            </div>
        </div>

        <div class="form-section-title mt-5">
            <i class="fas fa-id-card"></i>
            Thông tin CCCD/CMND
        </div>

        <div class="row g-4">
            <div class="col-md-4">
                <label class="form-label">Số CCCD/CMND</label>
                <input type="text"
                       name="so_cccd"
                       class="form-control custom-input"
                       value="{{ old('so_cccd') }}"
                       placeholder="Nhập số CCCD/CMND">
                <div class="text-danger small mt-1">{{ $errors->first('so_cccd') }}</div>
            </div>

            <div class="col-md-4">
                <label class="form-label">Ngày cấp CCCD</label>
                <input type="date"
                       name="ngay_cap_cccd"
                       class="form-control custom-input"
                       value="{{ old('ngay_cap_cccd') }}">
                <div class="text-danger small mt-1">{{ $errors->first('ngay_cap_cccd') }}</div>
            </div>

            <div class="col-md-4">
                <label class="form-label">Nơi cấp CCCD</label>
                <input type="text"
                       name="noi_cap_cccd"
                       class="form-control custom-input"
                       value="{{ old('noi_cap_cccd') }}"
                       placeholder="Ví dụ: Cục CSQLHC về TTXH">
                <div class="text-danger small mt-1">{{ $errors->first('noi_cap_cccd') }}</div>
            </div>

            <div class="col-md-6">
                <label class="form-label">Ảnh CCCD mặt trước</label>
                <input type="file"
                       name="anh_cccd_truoc"
                       class="form-control custom-input"
                       accept="image/*">
                <div class="text-danger small mt-1">{{ $errors->first('anh_cccd_truoc') }}</div>
                <small class="text-muted">Chọn ảnh JPG, PNG hoặc WEBP.</small>
            </div>

            <div class="col-md-6">
                <label class="form-label">Ảnh CCCD mặt sau</label>
                <input type="file"
                       name="anh_cccd_sau"
                       class="form-control custom-input"
                       accept="image/*">
                <div class="text-danger small mt-1">{{ $errors->first('anh_cccd_sau') }}</div>
                <small class="text-muted">Chọn ảnh JPG, PNG hoặc WEBP.</small>
            </div>
        </div>

        <div class="form-section-title mt-5">
            <i class="fas fa-briefcase"></i>
            Thông tin công việc
        </div>

        <div class="row g-4">
            <div class="col-md-6">
                <label class="form-label">Ảnh đại diện</label>
                <input type="file" name="anh_dai_dien" class="form-control custom-input" accept="image/*">
                <div class="text-danger small mt-1">{{ $errors->first('anh_dai_dien') }}</div>
                <small class="text-muted">Chọn ảnh JPG, PNG hoặc WEBP.</small>
            </div>

            <div class="col-md-6">
                <label class="form-label">Số năm kinh nghiệm</label>
                <input type="number" name="so_nam_kinh_nghiem" class="form-control custom-input"
                       value="{{ old('so_nam_kinh_nghiem', 0) }}"
                       min="0">
                <div class="text-danger small mt-1">{{ $errors->first('so_nam_kinh_nghiem') }}</div>
            </div>

            <div class="col-md-6">
                <label class="form-label">Ngôn ngữ thành thạo</label>
                <input type="text"
                       name="ngon_ngu_thanh_thao"
                       class="form-control custom-input"
                       value="{{ old('ngon_ngu_thanh_thao') }}"
                       placeholder="Ví dụ: Tiếng Anh, Tiếng Trung, Tiếng Hàn">
                <div class="text-danger small mt-1">{{ $errors->first('ngon_ngu_thanh_thao') }}</div>
            </div>

            <div class="col-md-6">
                <label class="form-label">Trạng thái</label>
                <select name="trang_thai" class="form-select custom-input">
                    <option value="hoat_dong" {{ old('trang_thai', 'hoat_dong') == 'hoat_dong' ? 'selected' : '' }}>
                        Hoạt động
                    </option>
                    <option value="khong_hoat_dong" {{ old('trang_thai') == 'khong_hoat_dong' ? 'selected' : '' }}>
                        Không hoạt động
                    </option>
                    <option value="bi_khoa" {{ old('trang_thai') == 'bi_khoa' ? 'selected' : '' }}>
                        Bị khóa
                    </option>
                </select>
                <div class="text-danger small mt-1">{{ $errors->first('trang_thai') }}</div>
            </div>

            <div class="col-md-12">
                <label class="form-label">Mô tả</label>
                <textarea name="mo_ta" class="form-control custom-input" rows="5"
                          placeholder="Nhập mô tả, kinh nghiệm, kỹ năng...">{{ old('mo_ta') }}</textarea>
                <div class="text-danger small mt-1">{{ $errors->first('mo_ta') }}</div>
            </div>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn-submit">
                <i class="fas fa-save"></i>
                Lưu hướng dẫn viên
            </button>

            <a class="btn-cancel" href="{{ route('Admin.huong-dan-viens.index') }}">
                Hủy
            </a>
        </div>
    </form>
</div>

<style>
.guide-create-page {
    max-width: 1100px;
    margin: 0 auto;
}

.form-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 22px;
}

.form-header h2 {
    margin: 0;
    font-size: 28px;
    font-weight: 800;
    color: #111827;
}

.form-header p {
    margin: 6px 0 0;
    color: #6b7280;
}

.btn-back {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 10px 16px;
    border-radius: 12px;
    background: #f3f4f6;
    color: #374151;
    text-decoration: none;
    font-weight: 700;
    transition: .25s;
}

.btn-back:hover {
    background: #e5e7eb;
    color: #111827;
    transform: translateY(-2px);
}

.guide-form-card {
    background: #fff;
    border-radius: 22px;
    padding: 32px;
    border: 1px solid #e5e7eb;
    box-shadow: 0 14px 40px rgba(15, 23, 42, 0.08);
}

.form-section-title {
    display: flex;
    align-items: center;
    gap: 10px;
    color: #111827;
    font-size: 18px;
    font-weight: 800;
    margin-bottom: 20px;
}

.form-section-title i {
    color: #2563eb;
}

.form-label {
    font-weight: 700;
    color: #374151;
    margin-bottom: 8px;
}

.custom-input {
    border: 1px solid #dbe1ea;
    border-radius: 13px;
    padding: 12px 14px;
    min-height: 48px;
    font-size: 14px;
    background: #f9fafb;
    transition: .25s;
}

.custom-input:focus {
    background: #fff;
    border-color: #2563eb;
    box-shadow: 0 0 0 4px rgba(37, 99, 235, .12);
}

.form-actions {
    margin-top: 32px;
    padding-top: 22px;
    border-top: 1px solid #eef2f7;
    display: flex;
    justify-content: flex-end;
    gap: 12px;
}

.btn-submit,
.btn-cancel {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    border: none;
    border-radius: 13px;
    padding: 12px 20px;
    font-weight: 800;
    text-decoration: none;
    transition: .25s;
}

.btn-submit {
    background: linear-gradient(135deg, #2563eb, #4f46e5);
    color: #fff;
}

.btn-submit:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 22px rgba(37, 99, 235, .25);
}

.btn-cancel {
    background: #f3f4f6;
    color: #374151;
}

.btn-cancel:hover {
    background: #e5e7eb;
    color: #111827;
}

.text-danger {
    font-weight: 600;
}

@media (max-width: 768px) {
    .form-header {
        flex-direction: column;
        align-items: flex-start;
        gap: 12px;
    }

    .guide-form-card {
        padding: 22px;
    }

    .form-actions {
        flex-direction: column;
    }

    .btn-submit,
    .btn-cancel {
        width: 100%;
    }
}
</style>
@endsection
