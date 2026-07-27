@extends('layouts.guide')

@section('guide', 'Hồ sơ cá nhân')

@section('content')
<div class="guide-profile-wrapper">
    <style>
        :root {
            --profile-primary: #315be8;
            --profile-primary-dark: #264ed4;
            --profile-purple: #5b4dea;
            --profile-dark: #173576;
            --profile-text: #344563;
            --profile-muted: #6b7895;
            --profile-light: #98a2b3;
            --profile-white: #ffffff;
            --profile-soft: #f5f8ff;
            --profile-soft-2: #edf3ff;
            --profile-hover: #f3f7ff;
            --profile-border: #dce6f5;
            --profile-border-light: #e8eef8;
            --profile-success: #08754a;
            --profile-success-bg: #eaf9f1;
            --profile-danger: #c13d55;
            --profile-danger-bg: #fff0f3;
            --profile-warning: #ae6c0d;
            --profile-warning-bg: #fff7e8;
            --profile-shadow: 0 10px 32px rgba(28, 65, 139, .09);
            --profile-shadow-hover: 0 16px 40px rgba(28, 65, 139, .13);
        }

        .guide-profile-wrapper {
            width: 100%;
            padding: 4px 0 28px;
            color: var(--profile-text);
        }

        .profile-grid {
            display: grid;
            grid-template-columns: minmax(300px, 360px) minmax(0, 1fr);
            gap: 22px;
            align-items: start;
        }

        .profile-card,
        .profile-form-card {
            position: relative;
            overflow: hidden;
            background: var(--profile-white);
            border: 1px solid var(--profile-border);
            border-radius: 16px;
            box-shadow: var(--profile-shadow);
        }

        .profile-card::before,
        .profile-form-card::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, var(--profile-primary), var(--profile-purple));
        }

        .profile-card {
            padding: 34px 24px 26px;
            text-align: center;
            position: sticky;
            top: 18px;
        }

        .profile-avatar-img,
        .profile-avatar-text {
            width: 126px;
            height: 126px;
            margin: 0 auto 18px;
            border-radius: 50%;
            border: 5px solid var(--profile-white);
            outline: 3px solid #dce7ff;
            box-shadow: 0 10px 28px rgba(49, 91, 232, .20);
        }

        .profile-avatar-img {
            display: block;
            object-fit: cover;
            background: var(--profile-soft-2);
        }

        .profile-avatar-text {
            color: var(--profile-white);
            background: linear-gradient(135deg, var(--profile-primary), var(--profile-purple));
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 42px;
            font-weight: 900;
            letter-spacing: -.04em;
        }

        .profile-card h3 {
            margin: 0 0 6px;
            color: var(--profile-dark);
            font-size: 23px;
            font-weight: 850;
            line-height: 1.35;
            overflow-wrap: anywhere;
        }

        .profile-card > p {
            margin: 0;
            color: var(--profile-muted);
            font-size: 13px;
            line-height: 1.55;
            overflow-wrap: anywhere;
        }

        .profile-status {
            min-height: 29px;
            margin-top: 15px;
            padding: 6px 13px;
            color: var(--profile-white) !important;
            background: linear-gradient(135deg, var(--profile-primary), var(--profile-purple)) !important;
            border: 1px solid rgba(49, 91, 232, .20);
            border-radius: 999px;
            box-shadow: 0 5px 14px rgba(49, 91, 232, .16);
            font-size: 10px;
            font-weight: 850;
            letter-spacing: .025em;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
        }

        .profile-status::before {
            content: "";
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: currentColor;
            box-shadow: 0 0 0 3px rgba(255, 255, 255, .17);
        }

        .profile-info-list {
            margin-top: 25px;
            padding-top: 17px;
            text-align: left;
            border-top: 1px solid var(--profile-border-light);
        }

        .profile-info-item {
            min-width: 0;
            padding: 11px 8px;
            border-bottom: 1px solid var(--profile-border-light);
            border-radius: 10px;
            display: flex;
            align-items: flex-start;
            gap: 11px;
            transition: background-color .18s ease, transform .18s ease;
        }

        .profile-info-item:hover {
            background: var(--profile-hover);
            transform: translateX(2px);
        }

        .profile-info-item:last-child {
            border-bottom: 0;
        }

        .profile-info-item > div:last-child {
            min-width: 0;
        }

        .profile-info-icon {
            width: 36px;
            height: 36px;
            flex: 0 0 36px;
            color: var(--profile-primary);
            background: var(--profile-soft-2);
            border: 1px solid #d4e2ff;
            border-radius: 9px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
        }

        .profile-info-label {
            margin-bottom: 3px;
            color: var(--profile-muted);
            font-size: 9px;
            font-weight: 800;
            letter-spacing: .045em;
            text-transform: uppercase;
        }

        .profile-info-value {
            color: #29457d;
            font-size: 12px;
            font-weight: 750;
            line-height: 1.55;
            overflow-wrap: anywhere;
        }

        .profile-form-card {
            min-width: 0;
            padding: 24px 26px 27px;
        }

        .profile-form-card > h3 {
            margin: 0 0 23px;
            padding: 0 0 14px;
            color: var(--profile-dark);
            border-bottom: 1px solid var(--profile-border);
            font-size: 21px;
            font-weight: 850;
            letter-spacing: -.2px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .profile-form-card > h3::before {
            content: "";
            width: 9px;
            height: 25px;
            flex-shrink: 0;
            border-radius: 999px;
            background: linear-gradient(180deg, var(--profile-primary), var(--profile-purple));
        }

        .section-title {
            position: relative;
            margin: 26px 0 16px;
            padding: 11px 14px 11px 42px;
            color: #24417d;
            background: linear-gradient(90deg, #eef4ff, #f8faff);
            border: 1px solid var(--profile-border);
            border-radius: 10px;
            font-size: 13px;
            font-weight: 850;
            line-height: 1.4;
        }

        .section-title::before {
            content: "";
            position: absolute;
            left: 15px;
            top: 50%;
            width: 12px;
            height: 12px;
            border: 3px solid var(--profile-white);
            border-radius: 50%;
            background: var(--profile-primary);
            box-shadow: 0 0 0 3px #dce7ff;
            transform: translateY(-50%);
        }

        .section-title:first-of-type {
            margin-top: 0;
        }

        .guide-profile-wrapper .row.g-3 {
            --bs-gutter-x: 16px;
            --bs-gutter-y: 15px;
        }

        .guide-profile-wrapper .form-label {
            margin-bottom: 7px;
            color: #344563;
            font-size: 11px;
            font-weight: 800;
        }

        .guide-profile-wrapper .form-control,
        .guide-profile-wrapper .form-select {
            width: 100%;
            min-height: 43px;
            padding: 9px 12px;
            color: #29457d;
            background-color: #fbfdff;
            border: 1px solid #ccd9ed;
            border-radius: 9px;
            box-shadow: none;
            font-size: 12px;
            font-weight: 600;
            transition: border-color .18s ease, box-shadow .18s ease, background-color .18s ease;
        }

        .guide-profile-wrapper textarea.form-control {
            min-height: 108px;
            line-height: 1.65;
            resize: vertical;
        }

        .guide-profile-wrapper .form-control:hover,
        .guide-profile-wrapper .form-select:hover {
            border-color: #b7c9e7;
            background-color: var(--profile-white);
        }

        .guide-profile-wrapper .form-control:focus,
        .guide-profile-wrapper .form-select:focus {
            color: #29457d;
            background-color: var(--profile-white);
            border-color: var(--profile-primary);
            box-shadow: 0 0 0 3px rgba(49, 91, 232, .12);
        }

        .guide-profile-wrapper .form-control::placeholder {
            color: #98a7bf;
            font-weight: 500;
        }

        .guide-profile-wrapper input[type="file"].form-control {
            height: auto;
            padding: 6px;
            color: var(--profile-muted);
            cursor: pointer;
        }

        .guide-profile-wrapper input[type="file"].form-control::file-selector-button {
            margin-right: 10px;
            padding: 7px 12px;
            color: var(--profile-primary);
            background: var(--profile-soft-2);
            border: 0;
            border-radius: 7px;
            font-size: 11px;
            font-weight: 800;
            cursor: pointer;
            transition: background-color .18s ease, color .18s ease;
        }

        .guide-profile-wrapper input[type="file"].form-control::file-selector-button:hover {
            color: var(--profile-white);
            background: var(--profile-primary);
        }

        .cccd-preview {
            width: 100%;
            height: 175px;
            margin-top: 11px;
            padding: 4px;
            object-fit: cover;
            background: var(--profile-white);
            border: 1px solid var(--profile-border);
            border-radius: 11px;
            box-shadow: 0 6px 18px rgba(28, 65, 139, .08);
            transition: transform .18s ease, box-shadow .18s ease;
        }

        .cccd-preview:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 26px rgba(28, 65, 139, .13);
        }

        .guide-profile-wrapper .text-danger.small {
            color: var(--profile-danger) !important;
            font-size: 10px;
            font-weight: 650;
        }

        .btn-save-profile,
        .btn-back-profile {
            min-height: 42px;
            padding: 9px 17px;
            border-radius: 9px;
            font-size: 11px;
            font-weight: 800;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 5px;
            transition: transform .18s ease, box-shadow .18s ease, background-color .18s ease, border-color .18s ease;
        }

        .btn-save-profile {
            color: var(--profile-white);
            background: linear-gradient(135deg, var(--profile-primary), var(--profile-purple));
            border: 1px solid var(--profile-primary);
            box-shadow: 0 6px 16px rgba(49, 91, 232, .20);
        }

        .btn-save-profile:hover,
        .btn-save-profile:focus {
            color: var(--profile-white);
            background: linear-gradient(135deg, var(--profile-primary-dark), #4c40d7);
            border-color: var(--profile-primary-dark);
            box-shadow: 0 9px 22px rgba(49, 91, 232, .26);
            transform: translateY(-1px);
        }

        .btn-back-profile {
            color: #53698f;
            background: var(--profile-white);
            border: 1px solid #ccd9ed;
        }

        .btn-back-profile:hover,
        .btn-back-profile:focus {
            color: var(--profile-primary);
            background: var(--profile-soft);
            border-color: #bfcff0;
            transform: translateY(-1px);
        }

        .guide-profile-wrapper .alert {
            padding: 13px 15px;
            border-radius: 10px;
            box-shadow: 0 6px 18px rgba(28, 65, 139, .07);
            font-size: 12px;
            font-weight: 650;
        }

        .guide-profile-wrapper .alert-success {
            color: var(--profile-success);
            background: var(--profile-success-bg);
            border-color: #c5ead8;
        }

        .guide-profile-wrapper .alert-danger {
            color: var(--profile-danger);
            background: var(--profile-danger-bg);
            border-color: #f0c9d1;
        }

        @media (max-width: 1199.98px) {
            .profile-grid {
                grid-template-columns: 320px minmax(0, 1fr);
                gap: 18px;
            }

            .profile-card {
                padding-inline: 20px;
            }

            .profile-form-card {
                padding-inline: 22px;
            }
        }

        @media (max-width: 991.98px) {
            .profile-grid {
                grid-template-columns: 1fr;
            }

            .profile-card {
                position: static;
            }

            .profile-info-list {
                display: grid;
                grid-template-columns: repeat(2, minmax(0, 1fr));
                gap: 4px 12px;
            }

            .profile-info-item {
                border-bottom: 1px solid var(--profile-border-light);
            }
        }

        @media (max-width: 767.98px) {
            .guide-profile-wrapper {
                padding-bottom: 18px;
            }

            .profile-grid {
                gap: 15px;
            }

            .profile-card,
            .profile-form-card {
                border-radius: 13px;
            }

            .profile-card {
                padding: 28px 17px 20px;
            }

            .profile-form-card {
                padding: 21px 16px 20px;
            }

            .profile-avatar-img,
            .profile-avatar-text {
                width: 108px;
                height: 108px;
            }

            .profile-avatar-text {
                font-size: 36px;
            }

            .profile-card h3 {
                font-size: 20px;
            }

            .profile-form-card > h3 {
                font-size: 19px;
            }

            .profile-info-list {
                grid-template-columns: 1fr;
            }

            .section-title {
                margin-top: 21px;
                padding-left: 40px;
                font-size: 12px;
            }

            .guide-profile-wrapper .mt-4.d-flex {
                display: grid !important;
                grid-template-columns: 1fr;
            }

            .btn-save-profile,
            .btn-back-profile {
                width: 100%;
            }
        }

        @media (max-width: 420px) {
            .profile-form-card {
                padding-inline: 13px;
            }

            .guide-profile-wrapper .form-control,
            .guide-profile-wrapper .form-select {
                font-size: 11px;
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
