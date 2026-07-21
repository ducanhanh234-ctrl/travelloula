@extends('layouts.admin')

@section('title', 'Cập nhật danh mục')

@section('content')
    <style>
        :root {
            --category-primary: #315be8;
            --category-purple: #5b4dea;
            --category-dark: #173576;
            --category-text: #344563;
            --category-muted: #6b7895;
            --category-border: #dce6f5;
            --category-soft: #f5f8ff;
            --category-white: #ffffff;
            --category-danger: #c13d55;
            --category-success: #08754a;
        }

        .category-edit-page {
            padding: 24px 0;
            color: var(--category-text);
        }

        .category-page-header {
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            flex-wrap: wrap;
        }

        .category-page-heading {
            min-width: 0;
            display: flex;
            align-items: center;
            gap: 13px;
        }

        .category-page-icon {
            width: 47px;
            height: 47px;
            flex-shrink: 0;
            color: var(--category-primary);
            background: #edf4ff;
            border: 1px solid #cfe0ff;
            border-radius: 12px;
            font-size: 18px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .category-page-heading h3 {
            margin: 0;
            color: var(--category-dark);
            font-size: 23px;
            font-weight: 750;
        }

        .category-page-heading p {
            margin: 6px 0 0;
            color: var(--category-muted);
            font-size: 14px;
        }

        .btn-back-category {
            min-height: 41px;
            padding: 9px 15px;
            color: #40537a;
            background: var(--category-white);
            border: 1px solid #ccd9ed;
            border-radius: 9px;
            font-size: 13px;
            font-weight: 700;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 7px;
            transition: all 0.18s ease;
        }

        .btn-back-category:hover {
            color: var(--category-primary);
            background: #edf4ff;
            border-color: #b9ccef;
            text-decoration: none;
            transform: translateY(-1px);
        }

        .category-card {
            position: relative;
            overflow: hidden;
            background: var(--category-white);
            border: 1px solid #d8e4f6;
            border-radius: 15px;
            box-shadow: 0 8px 30px rgba(28, 65, 139, 0.1);
        }

        .category-card::before {
            position: absolute;
            top: 0;
            right: 0;
            left: 0;
            z-index: 3;
            height: 4px;
            content: "";
            background: linear-gradient(90deg,
                    #2458e7,
                    #3478ef,
                    #18c7e7,
                    #5947e9);
        }

        .category-card-header {
            position: relative;
            min-height: 112px;
            padding: 24px;
            overflow: hidden;
            color: var(--category-white);
            background: linear-gradient(120deg,
                    #2856df 0%,
                    #316cec 55%,
                    #5b49e8 100%);
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
        }

        .category-card-header::before {
            position: absolute;
            right: -50px;
            bottom: -110px;
            width: 235px;
            height: 235px;
            content: "";
            border: 21px solid rgba(255, 255, 255, 0.07);
            border-radius: 50%;
        }

        .category-card-header::after {
            position: absolute;
            top: -80px;
            right: 120px;
            width: 170px;
            height: 170px;
            content: "";
            background: rgba(255, 255, 255, 0.045);
            border-radius: 50%;
        }

        .category-card-heading {
            position: relative;
            z-index: 2;
            min-width: 0;
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .category-card-icon {
            width: 46px;
            height: 46px;
            flex-shrink: 0;
            color: var(--category-white);
            background: rgba(255, 255, 255, 0.16);
            border: 1px solid rgba(255, 255, 255, 0.3);
            border-radius: 12px;
            font-size: 18px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .category-card-heading h4 {
            margin: 0;
            color: var(--category-white);
            font-size: 20px;
            font-weight: 750;
        }

        .category-card-heading p {
            margin: 6px 0 0;
            color: rgba(255, 255, 255, 0.82);
            font-size: 12px;
        }

        .category-code {
            position: relative;
            z-index: 2;
            padding: 9px 13px;
            color: var(--category-white);
            background: rgba(255, 255, 255, 0.14);
            border: 1px solid rgba(255, 255, 255, 0.25);
            border-radius: 9px;
            font-size: 11px;
            font-weight: 700;
            white-space: nowrap;
        }

        .category-card-body {
            padding: 22px;
        }

        .category-form-section {
            overflow: hidden;
            background: var(--category-white);
            border: 1px solid var(--category-border);
            border-radius: 12px;
        }

        .category-form-header {
            padding: 15px 18px;
            color: #24417d;
            background: #f1f6ff;
            border-bottom: 1px solid var(--category-border);
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .category-form-header-icon {
            width: 34px;
            height: 34px;
            flex-shrink: 0;
            color: var(--category-primary);
            background: var(--category-white);
            border: 1px solid #cfe0ff;
            border-radius: 9px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .category-form-header h5 {
            margin: 0;
            color: #24417d;
            font-size: 15px;
            font-weight: 750;
        }

        .category-form-header p {
            margin: 3px 0 0;
            color: #75829b;
            font-size: 11px;
        }

        .category-form-body {
            padding: 22px;
        }

        .category-form-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 20px;
        }

        .category-form-group {
            min-width: 0;
        }

        .category-form-group.full-width {
            grid-column: 1 / -1;
        }

        .category-form-label {
            margin-bottom: 8px;
            color: #31456f;
            font-size: 13px;
            font-weight: 700;
            display: block;
        }

        .category-input-wrapper {
            position: relative;
        }

        .category-input-icon {
            position: absolute;
            top: 50%;
            left: 13px;
            z-index: 2;
            color: #7185b5;
            font-size: 12px;
            pointer-events: none;
            transform: translateY(-50%);
        }

        .category-textarea-wrapper .category-input-icon {
            top: 15px;
            transform: none;
        }

        .category-form-section .form-control,
        .category-form-section .form-select {
            width: 100%;
            min-height: 44px;
            padding: 10px 13px 10px 38px;
            color: var(--category-text);
            background: var(--category-white);
            border: 1px solid #cfdaec;
            border-radius: 9px;
            font-size: 14px;
            box-shadow: none;
            transition:
                border-color 0.18s ease,
                box-shadow 0.18s ease;
        }

        .category-form-section textarea.form-control {
            min-height: 120px;
            padding-top: 12px;
            line-height: 1.65;
            resize: vertical;
        }

        .category-form-section .form-control::placeholder {
            color: #a4aec1;
        }

        .category-form-section .form-control:focus,
        .category-form-section .form-select:focus {
            color: #24375c;
            background: var(--category-white);
            border-color: #4f78eb;
            outline: none;
            box-shadow: 0 0 0 4px rgba(49, 91, 232, 0.11);
        }

        .category-form-section .form-control.is-invalid,
        .category-form-section .form-select.is-invalid {
            border-color: #dc4c64;
            background-image: none;
        }

        .category-error {
            margin-top: 7px;
            color: #cf3f58;
            font-size: 12px;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .category-form-hint {
            margin-top: 7px;
            color: #7b879f;
            font-size: 11px;
            line-height: 1.5;
            display: flex;
            align-items: flex-start;
            gap: 6px;
        }

        .category-form-hint i {
            margin-top: 2px;
            color: #5f81de;
            font-size: 10px;
        }

        .category-status-preview {
            margin-top: 10px;
            padding: 11px 13px;
            background: #f7faff;
            border: 1px solid var(--category-border);
            border-radius: 9px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 10px;
        }

        .category-status-preview-label {
            color: var(--category-muted);
            font-size: 11px;
            font-weight: 650;
        }

        .category-status-badge {
            padding: 5px 10px;
            border: 1px solid transparent;
            border-radius: 999px;
            font-size: 10px;
            font-weight: 700;
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }

        .category-status-dot {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: currentColor;
        }

        .category-status-active {
            color: var(--category-success);
            background: #eaf9f1;
            border-color: #c5ead8;
        }

        .category-status-inactive {
            color: var(--category-danger);
            background: #fff0f3;
            border-color: #f0c9d1;
        }

        .category-form-actions {
            margin-top: 20px;
            padding-top: 18px;
            border-top: 1px solid #e5ecf6;
            display: flex;
            align-items: center;
            justify-content: flex-end;
            gap: 10px;
        }

        .btn-category-action {
            min-height: 41px;
            padding: 9px 16px;
            border: 1px solid transparent;
            border-radius: 9px;
            font-size: 13px;
            font-weight: 700;
            text-decoration: none;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 7px;
            transition: all 0.18s ease;
        }

        .btn-category-cancel {
            color: #53698f;
            background: var(--category-white);
            border-color: #ccd9ed;
        }

        .btn-category-cancel:hover {
            color: #304d83;
            background: #edf3fb;
            border-color: #b9c9e0;
            text-decoration: none;
        }

        .btn-category-update {
            color: var(--category-white);
            background: linear-gradient(135deg,
                    #315be8,
                    #584be8);
            border-color: #315be8;
            box-shadow: 0 5px 14px rgba(49, 91, 232, 0.22);
        }

        .btn-category-update:hover {
            color: var(--category-white);
            background: linear-gradient(135deg,
                    #264ed4,
                    #4c40d7);
            transform: translateY(-1px);
        }

        @media (max-width: 768px) {
            .category-edit-page {
                padding: 14px 0;
            }

            .category-page-header {
                align-items: stretch;
                flex-direction: column;
            }

            .btn-back-category {
                width: 100%;
            }

            .category-card-header {
                align-items: flex-start;
                padding: 20px 18px;
                flex-direction: column;
            }

            .category-card-body,
            .category-form-body {
                padding: 16px;
            }

            .category-form-grid {
                grid-template-columns: 1fr;
            }

            .category-form-group.full-width {
                grid-column: auto;
            }

            .category-form-actions {
                align-items: stretch;
                flex-direction: column-reverse;
            }

            .btn-category-action {
                width: 100%;
            }
        }
    </style>

    @php
        $categoryStatus = old('trang_thai', $danhMuc->trang_thai ?? 'active');
    @endphp

    <div class="container-fluid category-edit-page">
        <div class="category-page-header">
            <div class="category-page-heading">
                <span class="category-page-icon">
                    <i class="fas fa-edit"></i>
                </span>

                <div>
                    <h3>Cập nhật danh mục</h3>

                    <p>
                        Chỉnh sửa thông tin và trạng thái của danh mục.
                    </p>
                </div>
            </div>

            <a href="{{ route('Admin.danh_mucs.index') }}" class="btn-back-category">
                <i class="fas fa-arrow-left"></i>
                Quay lại
            </a>
        </div>

        <div class="category-card">
            <div class="category-card-header">
                <div class="category-card-heading">
                    <span class="category-card-icon">
                        <i class="fas fa-folder-open"></i>
                    </span>

                    <div>
                        <h4>Cập nhật danh mục</h4>

                        <p>
                            Chỉnh sửa thông tin của
                            {{ $danhMuc->ten_danh_muc ?? 'danh mục' }}.
                        </p>
                    </div>
                </div>

                <div class="category-code">
                    Danh mục #{{ $danhMuc->id }}
                </div>
            </div>

            <div class="category-card-body">
                <form method="POST" action="{{ route('Admin.danh_mucs.update', $danhMuc) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                        <div class="category-form-section">
                            <div class="category-form-header">
                                <span class="category-form-header-icon">
                                    <i class="fas fa-info-circle"></i>
                                </span>

                                <div>
                                    <h5>Thông tin danh mục</h5>

                                    <p>
                                        Cập nhật tên, mô tả, hình ảnh và trạng thái.
                                    </p>
                                </div>
                            </div>

                            <div class="category-form-body">
                                <div class="category-form-grid">
                                    <div class="category-form-group full-width">
                                        <label for="ten_danh_muc" class="category-form-label">
                                            Tên danh mục
                                        </label>

                                        <div class="category-input-wrapper">
                                            <i class="fas fa-folder category-input-icon"></i>

                                            <input type="text" name="ten_danh_muc" id="ten_danh_muc"
                                                class="form-control @error('ten_danh_muc') is-invalid @enderror"
                                                value="{{ old('ten_danh_muc', $danhMuc->ten_danh_muc ?? '') }}"
                                                placeholder="Nhập tên danh mục">
                                        </div>

                                        @error('ten_danh_muc')
                                            <div class="category-error">
                                                <i class="fas fa-exclamation-circle"></i>
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>

                                    <div class="category-form-group full-width">
                                        <label for="mo_ta" class="category-form-label">
                                            Mô tả
                                        </label>

                                        <div class="category-input-wrapper category-textarea-wrapper">
                                            <i class="fas fa-align-left category-input-icon"></i>

                                            <textarea name="mo_ta" id="mo_ta" rows="5" class="form-control @error('mo_ta') is-invalid @enderror"
                                                placeholder="Nhập mô tả cho danh mục">{{ old('mo_ta', $danhMuc->mo_ta ?? '') }}</textarea>
                                        </div>

                                        @error('mo_ta')
                                            <div class="category-error">
                                                <i class="fas fa-exclamation-circle"></i>
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>

                                    <div class="category-form-group">
                                        <label for="hinh_anh" class="category-form-label">
                                            Hình ảnh
                                        </label>

                                        <div class="category-input-wrapper">
                                            <i class="fas fa-image category-input-icon"></i>

                                            <input type="file" name="hinh_anh" id="hinh_anh"
                                                class="form-control @error('hinh_anh') is-invalid @enderror"
                                                value="{{ old('hinh_anh', $danhMuc->hinh_anh ?? '') }}"
                                                placeholder="Nhập URL hoặc đường dẫn hình ảnh">
                                        </div>

                                        <div class="category-form-hint">
                                            <i class="fas fa-info-circle"></i>

                                            <span>
                                                Nhập URL hoặc đường dẫn hình ảnh
                                                của danh mục.
                                            </span>
                                        </div>

                                        @error('hinh_anh')
                                            <div class="category-error">
                                                <i class="fas fa-exclamation-circle"></i>
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>

                                    <div class="category-form-group">
                                        <label for="trang_thai" class="category-form-label">
                                            Trạng thái
                                        </label>

                                        <div class="category-input-wrapper">
                                            <i class="fas fa-check-circle category-input-icon"></i>

                                            <select name="trang_thai" id="trang_thai"
                                                class="form-select @error('trang_thai') is-invalid @enderror">
                                                <option value="active" @selected($categoryStatus === 'active')>
                                                    Hoạt động
                                                </option>

                                                <option value="inactive" @selected($categoryStatus === 'inactive')>
                                                    Không hoạt động
                                                </option>
                                            </select>
                                        </div>

                                        @error('trang_thai')
                                            <div class="category-error">
                                                <i class="fas fa-exclamation-circle"></i>
                                                {{ $message }}
                                            </div>
                                        @enderror

                                        <div class="category-status-preview">
                                            <span class="category-status-preview-label">
                                                Trạng thái đang chọn
                                            </span>

                                            <span id="category_status_preview" class="category-status-badge">
                                                <span class="category-status-dot"></span>
                                                <span id="category_status_text"></span>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="category-form-actions">
                            <a href="{{ route('Admin.danh_mucs.index') }}" class="btn-category-action btn-category-cancel">
                                <i class="fas fa-times"></i>
                                Hủy
                            </a>

                            <button type="submit" class="btn-category-action btn-category-update">
                                <i class="fas fa-save"></i>
                                Cập nhật danh mục
                            </button>
                        </div>
                    </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const statusSelect =
                document.getElementById('trang_thai');

            const statusPreview =
                document.getElementById('category_status_preview');

            const statusText =
                document.getElementById('category_status_text');

            function updateCategoryStatus() {
                if (!statusSelect || !statusPreview || !statusText) {
                    return;
                }

                if (statusSelect.value === 'inactive') {
                    statusPreview.className =
                        'category-status-badge category-status-inactive';

                    statusText.textContent = 'Không hoạt động';
                    return;
                }

                statusPreview.className =
                    'category-status-badge category-status-active';

                statusText.textContent = 'Hoạt động';
            }

            statusSelect.addEventListener(
                'change',
                updateCategoryStatus
            );

            updateCategoryStatus();
        });
    </script>
@endsection
