@extends('layouts.admin')

@section('content')
    <style>
        :root {
            --primary: #315be8;
            --primary-dark: #244bd2;
            --primary-light: #edf4ff;
            --primary-border: #c9dcff;

            --purple: #5b4dea;
            --cyan: #16c7e8;

            --text-dark: #172b4d;
            --text-main: #344563;
            --text-muted: #6b7895;
            --text-light: #98a2b3;

            --border: #dce6f5;
            --border-light: #e8eef8;

            --white: #ffffff;
            --soft-bg: #f6f9ff;

            --danger: #dc4c64;
        }

        .role-form-page {
            padding: 24px 0;
            color: var(--text-dark);
        }

        /* Tiêu đề trang */
        .form-page-top {
            width: 100%;
            max-width: 1100px;
            margin: 0 auto 18px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
        }

        .page-heading h3 {
            margin: 0;
            color: #173576;
            font-size: 23px;
            font-weight: 750;
            letter-spacing: -0.2px;
        }

        .page-heading p {
            margin: 6px 0 0;
            color: var(--text-muted);
            font-size: 14px;
        }

        .btn-back-top {
            min-height: 39px;
            padding: 8px 14px;
            color: #2c57d1;
            background: var(--primary-light);
            border: 1px solid #cbdcff;
            border-radius: 8px;
            font-size: 13px;
            font-weight: 650;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 7px;
            transition: all 0.18s ease;
        }

        .btn-back-top:hover {
            color: #1f46bd;
            background: #dfeaff;
            border-color: #a9c5ff;
            text-decoration: none;
            transform: translateY(-1px);
            box-shadow: 0 5px 14px rgba(49, 91, 232, 0.12);
        }

        /* Card */
        .role-form-card {
            position: relative;
            width: 100%;
            max-width: 1100px;
            margin: 0 auto;
            overflow: hidden;
            background: var(--white);
            border: 1px solid #d8e4f6;
            border-radius: 15px;
            box-shadow: 0 10px 32px rgba(28, 65, 139, 0.11);
        }

        .role-form-card::before {
            position: absolute;
            top: 0;
            right: 0;
            left: 0;
            z-index: 3;
            height: 4px;
            content: "";
            background: linear-gradient(
                90deg,
                #2458e7,
                #3478ef,
                #18c7e7,
                #5947e9
            );
        }

        /* Header */
        .form-header {
            position: relative;
            min-height: 140px;
            padding: 30px;
            overflow: hidden;
            color: var(--white);
            background: linear-gradient(
                120deg,
                #2856df 0%,
                #316cec 55%,
                #5b49e8 100%
            );
            display: flex;
            align-items: center;
        }

        .form-header::before {
            position: absolute;
            right: -55px;
            bottom: -105px;
            width: 250px;
            height: 250px;
            content: "";
            border: 22px solid rgba(255, 255, 255, 0.07);
            border-radius: 50%;
        }

        .form-header::after {
            position: absolute;
            top: -90px;
            right: 110px;
            width: 180px;
            height: 180px;
            content: "";
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.045);
        }

        .form-header-content {
            position: relative;
            z-index: 2;
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .form-header-icon {
            width: 54px;
            height: 54px;
            flex-shrink: 0;
            color: var(--white);
            background: rgba(255, 255, 255, 0.16);
            border: 1px solid rgba(255, 255, 255, 0.3);
            border-radius: 14px;
            box-shadow: 0 7px 18px rgba(20, 43, 128, 0.2);
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .form-header-icon i {
            font-size: 21px;
        }

        .form-header h3 {
            margin: 0;
            color: var(--white);
            font-size: 23px;
            font-weight: 750;
        }

        .form-header p {
            margin: 7px 0 0;
            color: rgba(255, 255, 255, 0.84);
            font-size: 13px;
            line-height: 1.5;
        }

        /* Nội dung form */
        .form-body {
            padding: 30px;
            background: var(--white);
        }

        .form-section {
            margin-bottom: 30px;
        }

        .form-section:last-of-type {
            margin-bottom: 0;
        }

        .form-section-title {
            margin-bottom: 20px;
            color: #24417d;
            font-size: 14px;
            font-weight: 750;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .form-section-title::before {
            width: 4px;
            height: 18px;
            content: "";
            border-radius: 999px;
            background: linear-gradient(
                180deg,
                #315be8,
                #5b4dea
            );
        }

        .form-row-custom {
            display: grid;
            grid-template-columns: minmax(0, 1fr) minmax(0, 1fr);
            gap: 20px;
        }

        .form-group {
            margin-bottom: 22px;
        }

        .form-label {
            margin-bottom: 8px;
            color: #31456f;
            font-size: 13px;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .required-mark {
            color: var(--danger);
            font-size: 14px;
        }

        /* Input */
        .form-control {
            width: 100%;
            min-height: 44px;
            padding: 10px 13px;
            color: #344563;
            background: #ffffff;
            border: 1px solid #cfdaec;
            border-radius: 9px;
            font-size: 14px;
            transition:
                border-color 0.18s ease,
                box-shadow 0.18s ease,
                background-color 0.18s ease;
        }

        textarea.form-control {
            min-height: 110px;
            padding-top: 12px;
            line-height: 1.6;
            resize: vertical;
        }

        .form-control::placeholder {
            color: #a4aec1;
        }

        .form-control:hover {
            border-color: #b6c9e8;
        }

        .form-control:focus {
            color: #24375c;
            background: #ffffff;
            border-color: #4f78eb;
            outline: none;
            box-shadow: 0 0 0 4px rgba(49, 91, 232, 0.11);
        }

        .form-control.is-invalid {
            border-color: var(--danger);
            background-image: none;
        }

        .form-control.is-invalid:focus {
            border-color: var(--danger);
            box-shadow: 0 0 0 4px rgba(220, 76, 100, 0.1);
        }

        .form-hint {
            margin-top: 7px;
            color: #7b879f;
            font-size: 12px;
            line-height: 1.5;
            display: flex;
            align-items: flex-start;
            gap: 6px;
        }

        .form-hint i {
            margin-top: 2px;
            color: #5f81de;
            font-size: 11px;
        }

        .error-text {
            margin-top: 7px;
            color: #cf3f58;
            font-size: 12px;
            font-weight: 550;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        /* Khối phân quyền */
        .permissions-wrapper {
            overflow: hidden;
            background: #f8faff;
            border: 1px solid #d8e4f6;
            border-radius: 12px;
        }

        .permissions-toolbar {
            padding: 16px 18px;
            background: #f1f6ff;
            border-bottom: 1px solid #d8e4f6;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 15px;
            flex-wrap: wrap;
        }

        .permissions-select-all {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .permissions-select-all input {
            width: 18px;
            height: 18px;
            margin: 0;
            cursor: pointer;
            accent-color: var(--primary);
        }

        .permissions-select-all label {
            margin: 0;
            color: #29457d;
            font-size: 13px;
            font-weight: 750;
            cursor: pointer;
        }

        .selected-counter {
            padding: 4px 9px;
            color: #3158ce;
            background: #ffffff;
            border: 1px solid #ccdcf7;
            border-radius: 999px;
            font-size: 11px;
            font-weight: 700;
        }

        .permission-search-box {
            position: relative;
            width: 100%;
            max-width: 290px;
        }

        .permission-search-box i {
            position: absolute;
            top: 50%;
            left: 12px;
            color: #7d8ba7;
            font-size: 12px;
            pointer-events: none;
            transform: translateY(-50%);
        }

        .permission-search {
            width: 100%;
            height: 38px;
            padding: 8px 12px 8px 34px;
            color: #344563;
            background: #ffffff;
            border: 1px solid #ccd9ed;
            border-radius: 8px;
            font-size: 12px;
            outline: none;
            transition: all 0.18s ease;
        }

        .permission-search:focus {
            border-color: #4f78eb;
            box-shadow: 0 0 0 3px rgba(49, 91, 232, 0.1);
        }

        .permissions-grid {
            padding: 18px;
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 16px;
        }

        /* Card mô đun */
        .permission-module {
            overflow: hidden;
            background: #ffffff;
            border: 1px solid #dce6f5;
            border-radius: 10px;
            transition:
                border-color 0.18s ease,
                box-shadow 0.18s ease;
        }

        .permission-module:hover {
            border-color: #c3d6f6;
            box-shadow: 0 6px 17px rgba(38, 76, 148, 0.07);
        }

        .module-header {
            min-height: 48px;
            padding: 10px 13px;
            background: linear-gradient(
                135deg,
                #f1f6ff,
                #edf3ff
            );
            border-bottom: 1px solid #dce6f5;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 10px;
        }

        .module-title {
            min-width: 0;
            color: #29457d;
            font-size: 12px;
            font-weight: 750;
            letter-spacing: 0.025em;
            text-transform: uppercase;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .module-title-icon {
            width: 27px;
            height: 27px;
            flex-shrink: 0;
            color: #315be8;
            background: #ffffff;
            border: 1px solid #cfddf7;
            border-radius: 7px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .module-title-icon i {
            font-size: 11px;
        }

        .module-count {
            padding: 3px 8px;
            color: #526c9d;
            background: rgba(255, 255, 255, 0.8);
            border: 1px solid #d4e0f2;
            border-radius: 999px;
            font-size: 10px;
            font-weight: 700;
            white-space: nowrap;
        }

        .module-select {
            display: flex;
            align-items: center;
            gap: 6px;
            white-space: nowrap;
        }

        .module-select input {
            width: 16px;
            height: 16px;
            margin: 0;
            cursor: pointer;
            accent-color: var(--primary);
        }

        .module-select label {
            margin: 0;
            color: #526c9d;
            font-size: 10px;
            font-weight: 700;
            cursor: pointer;
        }

        .module-permissions {
            padding: 8px;
        }

        /* Từng quyền */
        .permission-item {
            position: relative;
            margin: 0;
            padding: 9px 10px;
            border: 1px solid transparent;
            border-radius: 8px;
            cursor: pointer;
            display: flex;
            align-items: flex-start;
            gap: 10px;
            transition:
                background-color 0.16s ease,
                border-color 0.16s ease;
        }

        .permission-item:hover {
            background: #f3f7ff;
            border-color: #dbe6f8;
        }

        .permission-item.is-checked {
            background: #edf4ff;
            border-color: #c8dcff;
        }

        .permission-item.is-hidden {
            display: none;
        }

        .permission-checkbox {
            width: 17px;
            height: 17px;
            flex-shrink: 0;
            margin: 2px 0 0;
            cursor: pointer;
            accent-color: var(--primary);
        }

        .permission-content {
            min-width: 0;
            flex: 1;
        }

        .permission-name {
            overflow: hidden;
            color: #344563;
            font-size: 12px;
            font-weight: 700;
            line-height: 1.4;
            text-overflow: ellipsis;
            white-space: nowrap;
            display: block;
        }

        .permission-code {
            margin-top: 3px;
            overflow: hidden;
            color: #77849c;
            font-family: Consolas, Monaco, monospace;
            font-size: 10px;
            line-height: 1.4;
            text-overflow: ellipsis;
            white-space: nowrap;
            display: block;
        }

        .empty-permissions {
            padding: 45px 20px;
            color: #8793aa;
            text-align: center;
        }

        .empty-permissions-icon {
            width: 48px;
            height: 48px;
            margin: 0 auto 12px;
            color: #3664dd;
            background: #edf3ff;
            border: 1px solid #d3e1ff;
            border-radius: 13px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .empty-permissions a {
            color: #315be8;
            font-weight: 700;
            text-decoration: none;
        }

        /* Nút cuối form */
        .form-actions {
            margin-top: 30px;
            padding-top: 23px;
            border-top: 1px solid var(--border-light);
            display: flex;
            align-items: center;
            justify-content: flex-end;
            gap: 10px;
        }

        .btn-form {
            min-width: 135px;
            min-height: 42px;
            padding: 9px 18px;
            border: 1px solid transparent;
            border-radius: 9px;
            font-size: 13px;
            font-weight: 700;
            cursor: pointer;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 7px;
            transition: all 0.18s ease;
        }

        .btn-form:hover {
            text-decoration: none;
            transform: translateY(-1px);
        }

        .btn-update {
            color: var(--white);
            background: linear-gradient(
                135deg,
                #315be8 0%,
                #3b6dee 55%,
                #594bea 100%
            );
            border-color: #315be8;
            box-shadow: 0 6px 16px rgba(49, 91, 232, 0.24);
        }

        .btn-update:hover {
            color: var(--white);
            background: linear-gradient(
                135deg,
                #264ed4 0%,
                #315edc 55%,
                #4d40d8 100%
            );
            border-color: #264ed4;
            box-shadow: 0 8px 19px rgba(49, 91, 232, 0.3);
        }

        .btn-update:focus {
            outline: none;
            box-shadow: 0 0 0 4px rgba(49, 91, 232, 0.15);
        }

        .btn-cancel {
            color: #53698f;
            background: #f2f6fc;
            border-color: #d4dfef;
        }

        .btn-cancel:hover {
            color: #304d83;
            background: #e7eef9;
            border-color: #bdcce3;
            box-shadow: 0 5px 13px rgba(41, 73, 132, 0.1);
        }

        /* Responsive */
        @media (max-width: 900px) {
            .permissions-grid {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 768px) {
            .role-form-page {
                padding: 15px 0;
            }

            .form-page-top {
                align-items: stretch;
                flex-direction: column;
            }

            .btn-back-top {
                width: 100%;
            }

            .role-form-card {
                border-radius: 11px;
            }

            .form-header {
                min-height: 120px;
                padding: 23px 20px;
            }

            .form-header h3 {
                font-size: 21px;
            }

            .form-body {
                padding: 22px 18px;
            }

            .form-row-custom {
                grid-template-columns: 1fr;
                gap: 0;
            }

            .permissions-toolbar {
                align-items: stretch;
                flex-direction: column;
            }

            .permission-search-box {
                max-width: none;
            }

            .permissions-grid {
                padding: 12px;
                gap: 12px;
            }

            .form-actions {
                align-items: stretch;
                flex-direction: column-reverse;
            }

            .btn-form {
                width: 100%;
            }
        }

        @media (max-width: 480px) {
            .page-heading h3 {
                font-size: 20px;
            }

            .form-header-content {
                align-items: flex-start;
            }

            .form-header-icon {
                width: 46px;
                height: 46px;
            }

            .form-header p {
                font-size: 12px;
            }

            .module-header {
                align-items: flex-start;
                flex-direction: column;
            }

            .module-select {
                padding-left: 35px;
            }
        }
    </style>

    <div class="container-fluid role-form-page">
        <div class="form-page-top">
            <div class="page-heading">
                <h3>Chỉnh sửa vai trò</h3>

                <p>
                    Cập nhật thông tin và quyền hạn của vai trò.
                </p>
            </div>

            <a
                href="{{ route('Admin.vai-tros.index') }}"
                class="btn-back-top"
            >
                <i class="fas fa-arrow-left"></i>
                Quay lại danh sách
            </a>
        </div>

        <div class="card role-form-card">
            <div class="form-header">
                <div class="form-header-content">
                    <span class="form-header-icon">
                        <i class="fas fa-user-pen"></i>
                    </span>

                    <div>
                        <h3>Chỉnh sửa vai trò</h3>

                        <p>
                            Cập nhật vai trò
                            <strong>{{ $vaiTro->ten_vai_tro }}</strong>
                            và các quyền truy cập trong hệ thống.
                        </p>
                    </div>
                </div>
            </div>

            <div class="form-body">
                <form
                    action="{{ route('Admin.vai-tros.update', $vaiTro->id) }}"
                    method="POST"
                >
                    @csrf
                    @method('PUT')

                    <div class="form-section">
                        <div class="form-section-title">
                            Thông tin vai trò
                        </div>

                        <div class="form-row-custom">
                            <div class="form-group">
                                <label for="ten_vai_tro" class="form-label">
                                    Tên vai trò
                                    <span class="required-mark">*</span>
                                </label>

                                <input
                                    type="text"
                                    name="ten_vai_tro"
                                    id="ten_vai_tro"
                                    class="form-control @error('ten_vai_tro') is-invalid @enderror"
                                    value="{{ old('ten_vai_tro', $vaiTro->ten_vai_tro) }}"
                                    placeholder="Ví dụ: Admin, Editor, Hướng dẫn viên"
                                    autocomplete="off"
                                    required
                                >

                                <div class="form-hint">
                                    <i class="fas fa-circle-info"></i>

                                    <span>
                                        Đặt tên ngắn gọn, dễ nhận biết chức năng
                                        của vai trò.
                                    </span>
                                </div>

                                @error('ten_vai_tro')
                                    <div class="error-text">
                                        <i class="fas fa-circle-exclamation"></i>
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="mo_ta" class="form-label">
                                    Mô tả
                                </label>

                                <textarea
                                    name="mo_ta"
                                    id="mo_ta"
                                    class="form-control @error('mo_ta') is-invalid @enderror"
                                    rows="3"
                                    placeholder="Mô tả nhiệm vụ và phạm vi sử dụng của vai trò..."
                                >{{ old('mo_ta', $vaiTro->mo_ta) }}</textarea>

                                <div class="form-hint">
                                    <i class="fas fa-align-left"></i>

                                    <span>
                                        Mô tả ngắn gọn trách nhiệm và phạm vi
                                        sử dụng của vai trò.
                                    </span>
                                </div>

                                @error('mo_ta')
                                    <div class="error-text">
                                        <i class="fas fa-circle-exclamation"></i>
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="form-section">
                        <div class="form-section-title">
                            Cập nhật quyền hạn
                        </div>

                        <div class="permissions-wrapper">
                            <div class="permissions-toolbar">
                                <div class="permissions-select-all">
                                    <input
                                        type="checkbox"
                                        id="select_all_permissions"
                                    >

                                    <label for="select_all_permissions">
                                        Chọn tất cả quyền
                                    </label>

                                    <span
                                        class="selected-counter"
                                        id="selected_counter"
                                    >
                                        0/{{ $quyenHans->count() }} đã chọn
                                    </span>
                                </div>

                                <div class="permission-search-box">
                                    <i class="fas fa-search"></i>

                                    <input
                                        type="text"
                                        id="permission_search"
                                        class="permission-search"
                                        placeholder="Tìm tên hoặc mã quyền..."
                                        autocomplete="off"
                                    >
                                </div>
                            </div>

                            @if ($quyenHans->isNotEmpty())
                                @php
                                    $selectedPermissionIds = old(
                                        'quyen_han_ids',
                                        $vaiTro->quyenHans->pluck('id')->toArray()
                                    );

                                    $moduleNames = [
                                        'users' => 'Người dùng',
                                        'roles' => 'Vai trò',
                                        'permissions' => 'Quyền hạn',
                                        'tours' => 'Tour',
                                        'bookings' => 'Đặt tour',
                                        'guides' => 'Hướng dẫn viên',
                                        'banners' => 'Banner',
                                        'danh_mucs' => 'Danh mục',
                                        'phuong_tiens' => 'Phương tiện',
                                        'phan_cong' => 'Phân công',
                                        'lich_khoi_hanh' => 'Lịch khởi hành',
                                        'gop_doan' => 'Gộp đoàn',
                                        'payments' => 'Thanh toán',
                                        'reports' => 'Báo cáo',
                                        'customers' => 'Khách hàng',
                                        'lich_trinh_tours' => 'Lịch trình tour',
                                        'chi_tiet_lich_trinhs' => 'Chi tiết lịch trình',
                                        'nhat_ky_tours' => 'Nhật ký tour',
                                        'reviews' => 'Đánh giá',
                                        'terms' => 'Điều khoản',
                                        'favorites' => 'Tour yêu thích',
                                        'system' => 'Hệ thống',
                                    ];

                                    $moduleIcons = [
                                        'users' => 'fa-user',
                                        'roles' => 'fa-user-tag',
                                        'permissions' => 'fa-key',
                                        'tours' => 'fa-map-location-dot',
                                        'bookings' => 'fa-calendar-check',
                                        'guides' => 'fa-users',
                                        'banners' => 'fa-image',
                                        'danh_mucs' => 'fa-tags',
                                        'phuong_tiens' => 'fa-bus',
                                        'phan_cong' => 'fa-user-group',
                                        'lich_khoi_hanh' => 'fa-plane-departure',
                                        'gop_doan' => 'fa-object-group',
                                        'payments' => 'fa-credit-card',
                                        'reports' => 'fa-chart-column',
                                        'customers' => 'fa-user-check',
                                        'lich_trinh_tours' => 'fa-calendar-days',
                                        'chi_tiet_lich_trinhs' => 'fa-list',
                                        'nhat_ky_tours' => 'fa-book',
                                        'reviews' => 'fa-star',
                                        'terms' => 'fa-file-contract',
                                        'favorites' => 'fa-heart',
                                        'system' => 'fa-gear',
                                    ];
                                @endphp

                                <div class="permissions-grid">
                                    @foreach ($quyenHans->groupBy('mo_dun') as $module => $permissions)
                                        @php
                                            $moduleKey = $module ?: 'system';

                                            $moduleLabel =
                                                $moduleNames[$moduleKey]
                                                ?? ucfirst(
                                                    str_replace(
                                                        '_',
                                                        ' ',
                                                        $moduleKey
                                                    )
                                                );

                                            $moduleIcon =
                                                $moduleIcons[$moduleKey]
                                                ?? 'fa-folder';

                                            $moduleId =
                                                'module_' . md5($moduleKey);
                                        @endphp

                                        <div
                                            class="permission-module"
                                            data-module-card
                                        >
                                            <div class="module-header">
                                                <div class="module-title">
                                                    <span class="module-title-icon">
                                                        <i class="fas {{ $moduleIcon }}"></i>
                                                    </span>

                                                    <span>{{ $moduleLabel }}</span>

                                                    <span class="module-count">
                                                        {{ $permissions->count() }}
                                                        quyền
                                                    </span>
                                                </div>

                                                <div class="module-select">
                                                    <input
                                                        type="checkbox"
                                                        id="select_{{ $moduleId }}"
                                                        class="module-select-all"
                                                        data-module="{{ $moduleId }}"
                                                    >

                                                    <label for="select_{{ $moduleId }}">
                                                        Chọn nhóm
                                                    </label>
                                                </div>
                                            </div>

                                            <div class="module-permissions">
                                                @foreach ($permissions as $quyenHan)
                                                    @php
                                                        $isChecked = in_array(
                                                            $quyenHan->id,
                                                            $selectedPermissionIds
                                                        );
                                                    @endphp

                                                    <label
                                                        class="permission-item {{ $isChecked ? 'is-checked' : '' }}"
                                                        data-permission-item
                                                        data-search="{{ strtolower($quyenHan->ten_hien_thi . ' ' . $quyenHan->ten) }}"
                                                    >
                                                        <input
                                                            type="checkbox"
                                                            name="quyen_han_ids[]"
                                                            value="{{ $quyenHan->id }}"
                                                            class="permission-checkbox module-permission"
                                                            data-module="{{ $moduleId }}"
                                                            {{ $isChecked ? 'checked' : '' }}
                                                        >

                                                        <span class="permission-content">
                                                            <span class="permission-name">
                                                                {{ $quyenHan->ten_hien_thi }}
                                                            </span>

                                                            <span class="permission-code">
                                                                {{ $quyenHan->ten }}
                                                            </span>
                                                        </span>
                                                    </label>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="empty-permissions">
                                    <div class="empty-permissions-icon">
                                        <i class="fas fa-key"></i>
                                    </div>

                                    <div>
                                        Không có quyền hạn nào để lựa chọn.
                                    </div>

                                    <div class="mt-2">
                                        <a href="{{ route('Admin.quyen-hans.create') }}">
                                            Tạo quyền mới
                                        </a>
                                    </div>
                                </div>
                            @endif
                        </div>

                        @error('quyen_han_ids')
                            <div class="error-text">
                                <i class="fas fa-circle-exclamation"></i>
                                {{ $message }}
                            </div>
                        @enderror

                        @error('quyen_han_ids.*')
                            <div class="error-text">
                                <i class="fas fa-circle-exclamation"></i>
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="form-actions">
                        <a
                            href="{{ route('Admin.vai-tros.index') }}"
                            class="btn-form btn-cancel"
                        >
                            <i class="fas fa-xmark"></i>
                            Hủy
                        </a>

                        <button type="submit" class="btn-form btn-update">
                            <i class="fas fa-floppy-disk"></i>
                            Cập nhật vai trò
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const allCheckbox =
                document.getElementById('select_all_permissions');

            const permissionCheckboxes = Array.from(
                document.querySelectorAll('.permission-checkbox')
            );

            const moduleCheckboxes = Array.from(
                document.querySelectorAll('.module-select-all')
            );

            const searchInput =
                document.getElementById('permission_search');

            const selectedCounter =
                document.getElementById('selected_counter');

            function updatePermissionStyle(checkbox) {
                const item = checkbox.closest('.permission-item');

                if (!item) {
                    return;
                }

                item.classList.toggle(
                    'is-checked',
                    checkbox.checked
                );
            }

            function updateCounter() {
                const selectedCount = permissionCheckboxes.filter(
                    function (checkbox) {
                        return checkbox.checked;
                    }
                ).length;

                if (selectedCounter) {
                    selectedCounter.textContent =
                        selectedCount +
                        '/' +
                        permissionCheckboxes.length +
                        ' đã chọn';
                }
            }

            function updateModuleCheckbox(moduleId) {
                const modulePermissions = permissionCheckboxes.filter(
                    function (checkbox) {
                        return checkbox.dataset.module === moduleId;
                    }
                );

                const moduleSelect = moduleCheckboxes.find(
                    function (checkbox) {
                        return checkbox.dataset.module === moduleId;
                    }
                );

                if (!moduleSelect || modulePermissions.length === 0) {
                    return;
                }

                const selectedCount = modulePermissions.filter(
                    function (checkbox) {
                        return checkbox.checked;
                    }
                ).length;

                moduleSelect.checked =
                    selectedCount === modulePermissions.length;

                moduleSelect.indeterminate =
                    selectedCount > 0 &&
                    selectedCount < modulePermissions.length;
            }

            function updateAllCheckbox() {
                if (!allCheckbox || permissionCheckboxes.length === 0) {
                    return;
                }

                const selectedCount = permissionCheckboxes.filter(
                    function (checkbox) {
                        return checkbox.checked;
                    }
                ).length;

                allCheckbox.checked =
                    selectedCount === permissionCheckboxes.length;

                allCheckbox.indeterminate =
                    selectedCount > 0 &&
                    selectedCount < permissionCheckboxes.length;
            }

            function updateAllStates() {
                permissionCheckboxes.forEach(updatePermissionStyle);

                moduleCheckboxes.forEach(function (moduleCheckbox) {
                    updateModuleCheckbox(
                        moduleCheckbox.dataset.module
                    );
                });

                updateAllCheckbox();
                updateCounter();
            }

            if (allCheckbox) {
                allCheckbox.addEventListener('change', function () {
                    permissionCheckboxes.forEach(function (checkbox) {
                        checkbox.checked = allCheckbox.checked;
                        updatePermissionStyle(checkbox);
                    });

                    updateAllStates();
                });
            }

            moduleCheckboxes.forEach(function (moduleCheckbox) {
                moduleCheckbox.addEventListener('change', function () {
                    const moduleId = this.dataset.module;

                    permissionCheckboxes
                        .filter(function (checkbox) {
                            return checkbox.dataset.module === moduleId;
                        })
                        .forEach(function (checkbox) {
                            checkbox.checked = moduleCheckbox.checked;
                            updatePermissionStyle(checkbox);
                        });

                    updateAllStates();
                });
            });

            permissionCheckboxes.forEach(function (checkbox) {
                checkbox.addEventListener('change', function () {
                    updatePermissionStyle(this);
                    updateModuleCheckbox(this.dataset.module);
                    updateAllCheckbox();
                    updateCounter();
                });
            });

            if (searchInput) {
                searchInput.addEventListener('input', function () {
                    const keyword = this.value
                        .trim()
                        .toLowerCase();

                    document
                        .querySelectorAll('[data-permission-item]')
                        .forEach(function (item) {
                            const searchValue =
                                item.dataset.search || '';

                            item.classList.toggle(
                                'is-hidden',
                                keyword !== '' &&
                                !searchValue.includes(keyword)
                            );
                        });

                    document
                        .querySelectorAll('[data-module-card]')
                        .forEach(function (moduleCard) {
                            const visibleItems =
                                moduleCard.querySelectorAll(
                                    '[data-permission-item]:not(.is-hidden)'
                                );

                            moduleCard.style.display =
                                visibleItems.length > 0
                                    ? ''
                                    : 'none';
                        });
                });
            }

            updateAllStates();
        });
    </script>
@endsection
