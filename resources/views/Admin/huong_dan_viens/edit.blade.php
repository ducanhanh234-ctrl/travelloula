@extends('layouts.admin')

@section('content')
<div class="guide-form-page">
    <div class="form-header">
        <div>
            <h2>Chỉnh sửa hướng dẫn viên</h2>
            <p>Cập nhật thông tin hồ sơ hướng dẫn viên</p>
        </div>

        <a href="{{ route('Admin.huong-dan-viens.index') }}" class="btn-back">
            <i class="fas fa-arrow-left"></i> Quay lại
        </a>
    </div>

    <form action="{{ route('Admin.huong-dan-viens.update', $huongDanVien->id) }}"
          method="POST"
          enctype="multipart/form-data"
          class="guide-form-card">
        @csrf
        @method('PUT')

        <div class="form-section-title">
            <i class="fas fa-user"></i>
            Thông tin cá nhân
        </div>

        <div class="row g-4">
            <div class="col-md-6">
                <label class="form-label">Họ tên</label>
                <input type="text" name="ho_ten" class="form-control custom-input"
                       value="{{ old('ho_ten', $huongDanVien->ho_ten) }}">
                <div class="text-danger small mt-1">{{ $errors->first('ho_ten') }}</div>
            </div>

            <div class="col-md-6">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control custom-input"
                       value="{{ old('email', $huongDanVien->email) }}">
                <div class="text-danger small mt-1">{{ $errors->first('email') }}</div>
            </div>

            <div class="col-md-6">
                <label class="form-label">Mật khẩu mới</label>
                <input type="password" name="password" class="form-control custom-input"
                       placeholder="Để trống nếu không đổi">
                <div class="text-danger small mt-1">{{ $errors->first('password') }}</div>
            </div>

            <div class="col-md-6">
                <label class="form-label">Số điện thoại</label>
                <input type="text" name="so_dien_thoai" class="form-control custom-input"
                       value="{{ old('so_dien_thoai', $huongDanVien->so_dien_thoai) }}">
            </div>

            <div class="col-md-6">
                <label class="form-label">Ngày sinh</label>
                <input type="date" name="ngay_sinh" class="form-control custom-input"
                       value="{{ old('ngay_sinh', optional($huongDanVien->ngay_sinh)->format('Y-m-d')) }}">
            </div>

            <div class="col-md-6">
                <label class="form-label">Giới tính</label>
                <select name="gioi_tinh" class="form-select custom-input">
                    <option value="">Chọn giới tính</option>
                    <option value="nam" {{ old('gioi_tinh', $huongDanVien->gioi_tinh) == 'nam' ? 'selected' : '' }}>Nam</option>
                    <option value="nu" {{ old('gioi_tinh', $huongDanVien->gioi_tinh) == 'nu' ? 'selected' : '' }}>Nữ</option>
                    <option value="khac" {{ old('gioi_tinh', $huongDanVien->gioi_tinh) == 'khac' ? 'selected' : '' }}>Khác</option>
                </select>
            </div>

            <div class="col-md-12">
                <label class="form-label">Địa chỉ</label>
                <input type="text" name="dia_chi" class="form-control custom-input"
                       value="{{ old('dia_chi', $huongDanVien->dia_chi) }}">
            </div>
        </div>

        <div class="form-section-title mt-5">
            <i class="fas fa-briefcase"></i>
            Thông tin công việc
        </div>

        <div class="row g-4">
            <div class="col-md-6">
                <label class="form-label">Ảnh đại diện</label>
                <input type="file" name="anh_dai_dien" class="form-control custom-input">

                @if($huongDanVien->anh_dai_dien)
                    <div class="avatar-preview mt-3">
                        <img src="{{ asset('storage/' . $huongDanVien->anh_dai_dien) }}" alt="Avatar">
                        <span>Ảnh hiện tại</span>
                    </div>
                @endif
            </div>

            <div class="col-md-6">
                <label class="form-label">Số năm kinh nghiệm</label>
                <input type="number" name="so_nam_kinh_nghiem" class="form-control custom-input"
                       value="{{ old('so_nam_kinh_nghiem', $huongDanVien->so_nam_kinh_nghiem) }}" min="0">
            </div>

            <div class="col-md-6">
                <label class="form-label">Trạng thái</label>
                <select name="trang_thai" class="form-select custom-input">
                    <option value="hoat_dong" {{ old('trang_thai', $huongDanVien->trang_thai) == 'hoat_dong' ? 'selected' : '' }}>Hoạt động</option>
                    <option value="khong_hoat_dong" {{ old('trang_thai', $huongDanVien->trang_thai) == 'khong_hoat_dong' ? 'selected' : '' }}>Không hoạt động</option>
                    <option value="bi_khoa" {{ old('trang_thai', $huongDanVien->trang_thai) == 'bi_khoa' ? 'selected' : '' }}>Bị khóa</option>
                </select>
                <div class="text-danger small mt-1">{{ $errors->first('trang_thai') }}</div>
            </div>

            <div class="col-md-12">
                <label class="form-label">Mô tả</label>
                <textarea name="mo_ta" class="form-control custom-input" rows="5">{{ old('mo_ta', $huongDanVien->mo_ta) }}</textarea>
            </div>
        </div>

        <div class="form-actions">
            <button class="btn-submit">
                <i class="fas fa-save"></i>
                Cập nhật
            </button>

            <a class="btn-cancel" href="{{ route('Admin.huong-dan-viens.index') }}">
                Hủy
            </a>
        </div>
    </form>
</div>

<style>
.guide-form-page {
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
    padding: 10px 16px;
    border-radius: 12px;
    background: #f3f4f6;
    color: #374151;
    text-decoration: none;
    font-weight: 700;
}

.btn-back:hover {
    background: #e5e7eb;
    color: #111827;
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

.avatar-preview {
    display: flex;
    align-items: center;
    gap: 12px;
    background: #f9fafb;
    border: 1px dashed #cbd5e1;
    border-radius: 14px;
    padding: 12px;
}

.avatar-preview img {
    width: 70px;
    height: 70px;
    border-radius: 14px;
    object-fit: cover;
}

.avatar-preview span {
    color: #6b7280;
    font-weight: 600;
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
    box-shadow: 0 10px 22px rgba(37,99,235,.25);
}

.btn-cancel {
    background: #f3f4f6;
    color: #374151;
}

.btn-cancel:hover {
    background: #e5e7eb;
    color: #111827;
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
        text-align: center;
    }
}
</style>
@endsection
