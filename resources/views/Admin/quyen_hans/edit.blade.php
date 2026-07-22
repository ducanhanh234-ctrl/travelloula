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

            --danger: #dc4c64;
            --danger-light: #fff0f3;
        }

        .permission-form-page {
            padding: 24px 0;
            color: var(--text-dark);
        }

        /* Phần tiêu đề bên ngoài */
        .form-page-top {
            width: 100%;
            max-width: 920px;
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
            background: #edf4ff;
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
        .form-card {
            position: relative;
            width: 100%;
            max-width: 920px;
            margin: 0 auto;
            overflow: hidden;
            background: var(--white);
            border: 1px solid #d8e4f6;
            border-radius: 15px;
            box-shadow: 0 10px 32px rgba(28, 65, 139, 0.11);
        }

        .form-card::before {
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
            min-height: 135px;
            padding: 28px 30px;
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
            bottom: -100px;
            width: 240px;
            height: 240px;
            content: "";
            border: 22px solid rgba(255, 255, 255, 0.07);
            border-radius: 50%;
        }

        .form-header::after {
            position: absolute;
            top: -85px;
            right: 105px;
            width: 175px;
            height: 175px;
            content: "";
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.045);
        }

        .form-header-content {
            position: relative;
            z-index: 2;
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .form-header-icon {
            width: 50px;
            height: 50px;
            flex-shrink: 0;
            color: var(--white);
            background: rgba(255, 255, 255, 0.16);
            border: 1px solid rgba(255, 255, 255, 0.3);
            border-radius: 13px;
            box-shadow: 0 7px 18px rgba(20, 43, 128, 0.2);
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .form-header-icon i {
            font-size: 19px;
        }

        .form-header h3 {
            margin: 0;
            color: var(--white);
            font-size: 23px;
            font-weight: 750;
        }

        .form-header p {
            margin: 7px 0 0;
            color: rgba(255, 255, 255, 0.85);
            font-size: 13px;
            line-height: 1.5;
        }

        /* Nội dung form */
        .form-body {
            padding: 30px;
            background: var(--white);
        }

        .form-section {
            margin-bottom: 28px;
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
            grid-template-columns: repeat(2, minmax(0, 1fr));
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
            min-height: 115px;
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

        /* Gợi ý */
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

        /* Trạng thái */
        .checkbox-group {
            padding: 15px 16px;
            background: linear-gradient(
                135deg,
                #f3f7ff 0%,
                #edf3ff 100%
            );
            border: 1px solid #cfddf7;
            border-radius: 10px;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 12px;
            transition: all 0.18s ease;
        }

        .checkbox-group:hover {
            background: #eaf2ff;
            border-color: #b5cbf6;
        }

        .checkbox-group input[type="checkbox"] {
            width: 19px;
            height: 19px;
            flex-shrink: 0;
            margin: 0;
            cursor: pointer;
            accent-color: #315be8;
        }

        .checkbox-content {
            flex: 1;
        }

        .checkbox-content label {
            margin: 0;
            color: #27447e;
            font-size: 13px;
            font-weight: 700;
            cursor: pointer;
        }

        .checkbox-description {
            margin-top: 3px;
            color: #72809a;
            font-size: 12px;
        }

        .checkbox-icon {
            width: 32px;
            height: 32px;
            flex-shrink: 0;
            color: #315be8;
            background: rgba(255, 255, 255, 0.78);
            border: 1px solid #cfddf7;
            border-radius: 8px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .checkbox-icon i {
            font-size: 13px;
        }

        /* Nút hành động */
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
            min-width: 130px;
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
        @media (max-width: 768px) {
            .permission-form-page {
                padding: 15px 0;
            }

            .form-page-top {
                align-items: stretch;
                flex-direction: column;
            }

            .btn-back-top {
                width: 100%;
            }

            .form-card {
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
                width: 44px;
                height: 44px;
            }

            .form-header p {
                font-size: 12px;
            }

            .checkbox-icon {
                display: none;
            }
        }
    </style>

    <div class="container-fluid permission-form-page">
        <div class="form-page-top">
            <div class="page-heading">
                <h3>Chỉnh sửa quyền hạn</h3>

                <p>
                    Cập nhật thông tin và trạng thái của quyền hạn.
                </p>
            </div>

            <a
                href="{{ route('Admin.quyen-hans.index') }}"
                class="btn-back-top"
            >
                <i class="fas fa-arrow-left"></i>
                Quay lại danh sách
            </a>
        </div>

        <div class="card form-card">
            <div class="form-header">
                <div class="form-header-content">
                    <span class="form-header-icon">
                        <i class="fas fa-pen-to-square"></i>
                    </span>

                    <div>
                        <h3>Chỉnh sửa quyền</h3>

                        <p>
                            Cập nhật quyền
                            <strong>{{ $quyenHan->ten_hien_thi }}</strong>
                            trong hệ thống.
                        </p>
                    </div>
                </div>
            </div>

            <div class="form-body">
                <form
                    action="{{ route('Admin.quyen-hans.update', $quyenHan->id) }}"
                    method="POST"
                >
                    @csrf
                    @method('PUT')

                    <div class="form-section">
                        <div class="form-section-title">
                            Thông tin quyền hạn
                        </div>

                        <div class="form-row-custom">
                            <div class="form-group">
                                <label for="ten" class="form-label">
                                    Tên kỹ thuật
                                    <span class="required-mark">*</span>
                                </label>

                                <input
                                    type="text"
                                    name="ten"
                                    id="ten"
                                    class="form-control @error('ten') is-invalid @enderror"
                                    value="{{ old('ten', $quyenHan->ten) }}"
                                    placeholder="Ví dụ: users.create"
                                    autocomplete="off"
                                    required
                                >

                                <div class="form-hint">
                                    <i class="fas fa-circle-info"></i>

                                    <span>
                                        Sử dụng chữ thường, dấu chấm hoặc gạch
                                        dưới. Ví dụ: users.create.
                                    </span>
                                </div>

                                @error('ten')
                                    <div class="error-text">
                                        <i class="fas fa-circle-exclamation"></i>
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="ten_hien_thi" class="form-label">
                                    Tên hiển thị
                                    <span class="required-mark">*</span>
                                </label>

                                <input
                                    type="text"
                                    name="ten_hien_thi"
                                    id="ten_hien_thi"
                                    class="form-control @error('ten_hien_thi') is-invalid @enderror"
                                    value="{{ old('ten_hien_thi', $quyenHan->ten_hien_thi) }}"
                                    placeholder="Ví dụ: Tạo người dùng"
                                    autocomplete="off"
                                    required
                                >

                                <div class="form-hint">
                                    <i class="fas fa-circle-info"></i>

                                    <span>
                                        Tên dễ hiểu được hiển thị cho quản trị viên.
                                    </span>
                                </div>

                                @error('ten_hien_thi')
                                    <div class="error-text">
                                        <i class="fas fa-circle-exclamation"></i>
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="mo_dun" class="form-label">
                                Mô đun
                            </label>

                            <input
                                type="text"
                                name="mo_dun"
                                id="mo_dun"
                                class="form-control @error('mo_dun') is-invalid @enderror"
                                value="{{ old('mo_dun', $quyenHan->mo_dun) }}"
                                placeholder="Ví dụ: users, posts, tours"
                                autocomplete="off"
                            >

                            <div class="form-hint">
                                <i class="fas fa-layer-group"></i>

                                <span>
                                    Nhóm chức năng mà quyền hạn này thuộc về.
                                </span>
                            </div>

                            @error('mo_dun')
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
                                rows="4"
                                placeholder="Mô tả chi tiết về quyền hạn này..."
                            >{{ old('mo_ta', $quyenHan->mo_ta) }}</textarea>

                            <div class="form-hint">
                                <i class="fas fa-align-left"></i>

                                <span>
                                    Giải thích quyền này cho phép người dùng
                                    thực hiện thao tác gì.
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

                    <div class="form-section">
                        <div class="form-section-title">
                            Trạng thái hoạt động
                        </div>

                        <div
                            class="checkbox-group"
                            onclick="toggleStatusCheckbox(event)"
                        >
                            <input
                                type="checkbox"
                                class="form-check-input"
                                name="trang_thai"
                                id="trang_thai"
                                value="1"
                                {{ old('trang_thai', $quyenHan->trang_thai) ? 'checked' : '' }}
                            >

                            <div class="checkbox-content">
                                <label for="trang_thai">
                                    Kích hoạt quyền này
                                </label>

                                <div class="checkbox-description">
                                    Khi được kích hoạt, quyền có thể được cấp cho
                                    các vai trò trong hệ thống.
                                </div>
                            </div>

                            <span class="checkbox-icon">
                                <i class="fas fa-shield-halved"></i>
                            </span>
                        </div>

                        <div class="form-hint">
                            <i class="fas fa-circle-info"></i>

                            <span>
                                Bỏ chọn để vô hiệu hóa quyền mà không cần xóa
                                khỏi hệ thống.
                            </span>
                        </div>

                        @error('trang_thai')
                            <div class="error-text">
                                <i class="fas fa-circle-exclamation"></i>
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="form-actions">
                        <a
                            href="{{ route('Admin.quyen-hans.index') }}"
                            class="btn-form btn-cancel"
                        >
                            <i class="fas fa-xmark"></i>
                            Hủy
                        </a>

                        <button type="submit" class="btn-form btn-update">
                            <i class="fas fa-floppy-disk"></i>
                            Cập nhật quyền
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function toggleStatusCheckbox(event) {
            if (
                event.target.tagName === 'INPUT' ||
                event.target.tagName === 'LABEL'
            ) {
                return;
            }

            const checkbox = document.getElementById('trang_thai');

            if (checkbox) {
                checkbox.checked = !checkbox.checked;
            }
        }
    </script>
@endsection
