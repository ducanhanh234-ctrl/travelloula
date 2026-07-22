@extends('layouts.guide')

@section('guide', 'Hồ sơ cá nhân')

@section('content')
<div class="guide-profile-wrapper">
    <style>
        .guide-profile-wrapper {
            padding: 0;
        }

        .profile-grid {
            display: grid;
            grid-template-columns: 380px 1fr;
            gap: 24px;
            align-items: start;
        }

        .profile-card,
        .profile-form-card {
            background: #fff;
            border-radius: 18px;
            border: 1px solid #e5e7eb;
            box-shadow: 0 8px 24px rgba(15, 23, 42, .06);
        }

        .profile-card {
            padding: 34px 24px;
            text-align: center;
        }

        .profile-avatar-img {
            width: 126px;
            height: 126px;
            border-radius: 50%;
            object-fit: cover;
            margin-bottom: 18px;
        }

        .profile-avatar-text {
            width: 126px;
            height: 126px;
            border-radius: 50%;
            background: #16a34a;
            color: #fff;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 42px;
            font-weight: 900;
            margin-bottom: 18px;
        }

        .profile-card h3 {
            margin: 0 0 6px;
            font-size: 28px;
            font-weight: 800;
            color: #111827;
        }

        .profile-card p {
            margin: 0;
            color: #6b7280;
            font-size: 15px;
        }

        .profile-status {
            margin-top: 16px;
            display: inline-flex;
            padding: 7px 14px;
            border-radius: 999px;
            color: #fff;
            font-size: 13px;
            font-weight: 800;
        }

        .profile-info-list {
            margin-top: 26px;
            text-align: left;
            border-top: 1px solid #e5e7eb;
            padding-top: 18px;
        }

        .profile-info-item {
            display: flex;
            gap: 12px;
            padding: 12px 0;
            border-bottom: 1px solid #f1f5f9;
        }

        .profile-info-item:last-child {
            border-bottom: none;
        }

        .profile-info-icon {
            width: 36px;
            height: 36px;
            border-radius: 10px;
            background: #ecfdf5;
            color: #16a34a;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .profile-info-label {
            font-size: 12px;
            color: #64748b;
            font-weight: 800;
            margin-bottom: 2px;
        }

        .profile-info-value {
            color: #0f172a;
            font-weight: 700;
        }

        .profile-form-card {
            padding: 24px 26px 26px;
        }

        .profile-form-card h3 {
            margin: 0 0 22px;
            font-size: 24px;
            font-weight: 800;
            color: #111827;
        }

        .section-title {
            font-size: 16px;
            font-weight: 900;
            color: #0f172a;
            margin: 22px 0 14px;
            padding-bottom: 8px;
            border-bottom: 1px solid #e5e7eb;
        }

        .section-title:first-of-type {
            margin-top: 0;
        }

        .form-label {
            font-weight: 700;
            color: #111827;
            margin-bottom: 8px;
        }

        .form-control,
        .form-select {
            min-height: 42px;
            border-radius: 8px;
            border: 1px solid #d1d5db;
            font-size: 15px;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: #16a34a;
            box-shadow: 0 0 0 3px rgba(22, 163, 74, .12);
        }

        input[type="file"].form-control {
            height: auto;
            padding: 7px 12px;
        }

        .cccd-preview {
            width: 100%;
            max-height: 170px;
            object-fit: cover;
            border-radius: 12px;
            border: 1px solid #e5e7eb;
            margin-top: 10px;
        }

        .btn-save-profile {
            background: #16a34a;
            color: #fff;
            border: none;
            border-radius: 8px;
            padding: 10px 20px;
            font-weight: 800;
        }

        .btn-save-profile:hover {
            background: #15803d;
            color: #fff;
        }

        .btn-back-profile {
            border-radius: 8px;
            padding: 10px 18px;
            font-weight: 800;
        }

        .alert {
            border-radius: 10px;
        }

        @media (max-width: 992px) {
            .profile-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>

    @php
        $status = $huongDanVien->trang_thai_hien_thi ?? [
            'text' => 'Không xác định',
            'class' => 'bg-dark',
        ];

        $gioiTinhText = match($huongDanVien->gioi_tinh) {
            'nam' => 'Nam',
            'nu' => 'Nữ',
            'khac' => 'Khác',
            default => '-',
        };
    @endphp

    @if (session('success'))
        <div class="alert alert-success mb-4">
            {{ session('success') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger mb-4">
            <strong>Vui lòng kiểm tra lại thông tin vừa nhập.</strong>
        </div>
    @endif

    <div class="profile-grid">
        <div class="profile-card">
            @if ($huongDanVien->anh_dai_dien)
                <img
                    src="{{ asset('storage/' . $huongDanVien->anh_dai_dien) }}"
                    alt="{{ $huongDanVien->ho_ten }}"
                    class="profile-avatar-img"
                >
            @else
                <div class="profile-avatar-text">
                    {{ strtoupper(substr($huongDanVien->ho_ten ?? 'H', 0, 1)) }}
                </div>
            @endif

            <h3>{{ $huongDanVien->ho_ten ?? '-' }}</h3>
            <p>{{ $huongDanVien->email ?? '-' }}</p>

            <span class="profile-status {{ $status['class'] }}">
                {{ $status['text'] }}
            </span>

            <div class="profile-info-list">
                <div class="profile-info-item">
                    <div class="profile-info-icon">
                        <i class="fas fa-phone"></i>
                    </div>
                    <div>
                        <div class="profile-info-label">Số điện thoại</div>
                        <div class="profile-info-value">{{ $huongDanVien->so_dien_thoai ?? '-' }}</div>
                    </div>
                </div>

                <div class="profile-info-item">
                    <div class="profile-info-icon">
                        <i class="fas fa-calendar"></i>
                    </div>
                    <div>
                        <div class="profile-info-label">Ngày sinh</div>
                        <div class="profile-info-value">
                            {{ $huongDanVien->ngay_sinh ? $huongDanVien->ngay_sinh->format('d/m/Y') : '-' }}
                        </div>
                    </div>
                </div>

                <div class="profile-info-item">
                    <div class="profile-info-icon">
                        <i class="fas fa-venus-mars"></i>
                    </div>
                    <div>
                        <div class="profile-info-label">Giới tính</div>
                        <div class="profile-info-value">{{ $gioiTinhText }}</div>
                    </div>
                </div>

                <div class="profile-info-item">
                    <div class="profile-info-icon">
                        <i class="fas fa-briefcase"></i>
                    </div>
                    <div>
                        <div class="profile-info-label">Kinh nghiệm</div>
                        <div class="profile-info-value">
                            {{ $huongDanVien->so_nam_kinh_nghiem ?? 0 }} năm
                        </div>
                    </div>
                </div>

                <div class="profile-info-item">
                    <div class="profile-info-icon">
                        <i class="fas fa-language"></i>
                    </div>
                    <div>
                        <div class="profile-info-label">Ngôn ngữ</div>
                        <div class="profile-info-value">
                            {{ $huongDanVien->ngon_ngu_thanh_thao ?? '-' }}
                        </div>
                    </div>
                </div>

                <div class="profile-info-item">
                    <div class="profile-info-icon">
                        <i class="fas fa-location-dot"></i>
                    </div>
                    <div>
                        <div class="profile-info-label">Địa chỉ</div>
                        <div class="profile-info-value">
                            {{ $huongDanVien->dia_chi ?? '-' }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="profile-form-card">
            <h3>Thông tin cá nhân</h3>

            <form method="POST" action="{{ route('Guide.profile.update') }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="section-title">Thông tin hướng dẫn viên</div>

                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Họ và tên</label>
                        <input
                            type="text"
                            name="ho_ten"
                            class="form-control"
                            value="{{ old('ho_ten', $huongDanVien->ho_ten) }}"
                            required
                        >
                        @error('ho_ten')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Email</label>
                        <input
                            type="email"
                            name="email"
                            class="form-control"
                            value="{{ old('email', $huongDanVien->email) }}"
                            required
                        >
                        @error('email')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Số điện thoại</label>
                        <input
                            type="text"
                            name="so_dien_thoai"
                            class="form-control"
                            value="{{ old('so_dien_thoai', $huongDanVien->so_dien_thoai) }}"
                        >
                        @error('so_dien_thoai')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Ngày sinh</label>
                        <input
                            type="date"
                            name="ngay_sinh"
                            class="form-control"
                            value="{{ old('ngay_sinh', $huongDanVien->ngay_sinh ? $huongDanVien->ngay_sinh->format('Y-m-d') : '') }}"
                        >
                        @error('ngay_sinh')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Giới tính</label>
                        <select name="gioi_tinh" class="form-select">
                            <option value="">-- Chọn giới tính --</option>
                            <option value="nam" {{ old('gioi_tinh', $huongDanVien->gioi_tinh) == 'nam' ? 'selected' : '' }}>Nam</option>
                            <option value="nu" {{ old('gioi_tinh', $huongDanVien->gioi_tinh) == 'nu' ? 'selected' : '' }}>Nữ</option>
                            <option value="khac" {{ old('gioi_tinh', $huongDanVien->gioi_tinh) == 'khac' ? 'selected' : '' }}>Khác</option>
                        </select>
                        @error('gioi_tinh')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Ảnh đại diện</label>
                        <input
                            type="file"
                            name="anh_dai_dien"
                            class="form-control"
                            accept="image/*"
                        >
                        @error('anh_dai_dien')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-12">
                        <label class="form-label">Địa chỉ</label>
                        <input
                            type="text"
                            name="dia_chi"
                            class="form-control"
                            value="{{ old('dia_chi', $huongDanVien->dia_chi) }}"
                        >
                        @error('dia_chi')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="section-title">Thông tin CCCD</div>

                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label">Số CCCD</label>
                        <input
                            type="text"
                            name="so_cccd"
                            class="form-control"
                            value="{{ old('so_cccd', $huongDanVien->so_cccd) }}"
                        >
                        @error('so_cccd')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Ngày cấp CCCD</label>
                        <input
                            type="date"
                            name="ngay_cap_cccd"
                            class="form-control"
                            value="{{ old('ngay_cap_cccd', $huongDanVien->ngay_cap_cccd ? $huongDanVien->ngay_cap_cccd->format('Y-m-d') : '') }}"
                        >
                        @error('ngay_cap_cccd')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Nơi cấp CCCD</label>
                        <input
                            type="text"
                            name="noi_cap_cccd"
                            class="form-control"
                            value="{{ old('noi_cap_cccd', $huongDanVien->noi_cap_cccd) }}"
                        >
                        @error('noi_cap_cccd')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Ảnh CCCD mặt trước</label>
                        <input
                            type="file"
                            name="anh_cccd_truoc"
                            class="form-control"
                            accept="image/*"
                        >

                        @if ($huongDanVien->anh_cccd_truoc)
                            <img
                                src="{{ asset('storage/' . $huongDanVien->anh_cccd_truoc) }}"
                                class="cccd-preview"
                                alt="CCCD mặt trước"
                            >
                        @endif

                        @error('anh_cccd_truoc')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Ảnh CCCD mặt sau</label>
                        <input
                            type="file"
                            name="anh_cccd_sau"
                            class="form-control"
                            accept="image/*"
                        >

                        @if ($huongDanVien->anh_cccd_sau)
                            <img
                                src="{{ asset('storage/' . $huongDanVien->anh_cccd_sau) }}"
                                class="cccd-preview"
                                alt="CCCD mặt sau"
                            >
                        @endif

                        @error('anh_cccd_sau')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="section-title">Thông tin nghiệp vụ</div>

                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Số năm kinh nghiệm</label>
                        <input
                            type="number"
                            name="so_nam_kinh_nghiem"
                            class="form-control"
                            min="0"
                            value="{{ old('so_nam_kinh_nghiem', $huongDanVien->so_nam_kinh_nghiem) }}"
                        >
                        @error('so_nam_kinh_nghiem')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Ngôn ngữ thành thạo</label>
                        <input
                            type="text"
                            name="ngon_ngu_thanh_thao"
                            class="form-control"
                            value="{{ old('ngon_ngu_thanh_thao', $huongDanVien->ngon_ngu_thanh_thao) }}"
                            placeholder="Ví dụ: Tiếng Việt, Tiếng Anh"
                        >
                        @error('ngon_ngu_thanh_thao')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-12">
                        <label class="form-label">Mô tả / Ghi chú</label>
                        <textarea
                            name="mo_ta"
                            class="form-control"
                            rows="4"
                        >{{ old('mo_ta', $huongDanVien->mo_ta) }}</textarea>
                        @error('mo_ta')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="section-title">Đổi mật khẩu tài khoản</div>

                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Mật khẩu mới</label>
                        <input
                            type="password"
                            name="password"
                            class="form-control"
                            autocomplete="new-password"
                            placeholder="Bỏ trống nếu không đổi"
                        >
                        @error('password')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Xác nhận mật khẩu</label>
                        <input
                            type="password"
                            name="password_confirmation"
                            class="form-control"
                            autocomplete="new-password"
                            placeholder="Nhập lại mật khẩu mới"
                        >
                    </div>
                </div>

                <div class="mt-4 d-flex gap-2 flex-wrap">
                    <button type="submit" class="btn btn-save-profile">
                        <i class="fas fa-save me-1"></i>
                        Lưu thay đổi
                    </button>

                    <a href="{{ route('Guide.dashboard') }}" class="btn btn-outline-secondary btn-back-profile">
                        <i class="fas fa-arrow-left me-1"></i>
                        Quay lại
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
