@extends('layouts.admin')

@section('content')
<style>
    .terms-page {
        min-height: 100vh;
        background: #f8fafc;
        padding: 28px 20px 48px;
        font-family: Arial, sans-serif;
        color: #0f172a;
    }

    .terms-wrapper {
        width: 100%;
        max-width: none;
        margin: 0;
    }

    .terms-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        gap: 24px;
        margin-bottom: 26px;
    }

    .terms-back {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        color: #475569;
        text-decoration: none;
        font-size: 15px;
        font-weight: 600;
        margin-bottom: 14px;
        transition: .18s ease;
    }

    .terms-back:hover {
        color: #2563eb;
    }

    .terms-title-row {
        display: flex;
        align-items: center;
        gap: 14px;
    }

    .terms-icon {
        width: 50px;
        height: 50px;
        border-radius: 14px;
        background: #eef2ff;
        color: #2563eb;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 21px;
        flex-shrink: 0;
    }

    .terms-title {
        margin: 0;
        font-size: 34px;
        line-height: 1.2;
        font-weight: 700;
        color: #020617;
        letter-spacing: -0.4px;
    }

    .terms-subtitle {
        margin-top: 7px;
        color: #475569;
        font-size: 16px;
        line-height: 1.45;
        font-weight: 400;
    }

    .terms-header-actions {
        display: flex;
        align-items: center;
        gap: 12px;
        padding-top: 30px;
    }

    .terms-btn {
        min-height: 48px;
        padding: 0 24px;
        border-radius: 9px;
        border: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 9px;
        font-size: 15px;
        font-weight: 600;
        text-decoration: none;
        cursor: pointer;
        transition: .18s ease;
        white-space: nowrap;
    }

    .terms-btn-secondary {
        background: #ffffff;
        color: #334155;
        border: 1px solid #cbd5e1;
    }

    .terms-btn-secondary:hover {
        background: #f8fafc;
        color: #0f172a;
    }

    .terms-btn-primary {
        background: #3b82f6;
        color: #ffffff;
        box-shadow: 0 8px 18px rgba(59, 130, 246, .20);
    }

    .terms-btn-primary:hover {
        background: #2563eb;
    }

    .terms-alert-success {
        background: #dcfce7;
        color: #166534;
        border: 1px solid #bbf7d0;
        padding: 14px 18px;
        border-radius: 10px;
        margin-bottom: 20px;
        font-size: 15px;
        font-weight: 500;
    }

    .terms-alert-error {
        background: #fee2e2;
        color: #991b1b;
        border: 1px solid #fecaca;
        padding: 14px 18px;
        border-radius: 10px;
        margin-bottom: 20px;
        font-size: 15px;
        font-weight: 500;
    }

    .terms-card {
        background: #ffffff;
        border: 1px solid #dbe3ee;
        border-radius: 14px;
        overflow: hidden;
        box-shadow: 0 2px 8px rgba(15, 23, 42, .06);
    }

    .terms-card-header {
        padding: 22px 28px;
        border-bottom: 1px solid #e2e8f0;
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 16px;
        background: #ffffff;
    }

    .terms-card-title {
        margin: 0;
        font-size: 22px;
        line-height: 1.35;
        font-weight: 700;
        color: #020617;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .terms-card-title i {
        color: #2563eb;
        font-size: 20px;
    }

    .terms-slug-badge {
        min-height: 36px;
        padding: 0 18px;
        border-radius: 999px;
        background: #eef2ff;
        color: #4f46e5;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 15px;
        font-weight: 600;
        white-space: nowrap;
    }

    .terms-card-body {
        padding: 28px;
    }

    .terms-grid {
        display: grid;
        grid-template-columns: minmax(0, 1fr) 340px;
        gap: 30px;
        align-items: start;
    }

    .terms-group {
        margin-bottom: 24px;
    }

    .terms-label {
        display: block;
        margin-bottom: 9px;
        color: #0f172a;
        font-size: 16px;
        line-height: 1.35;
        font-weight: 600;
    }

    .terms-input,
    .terms-select,
    .terms-textarea {
        width: 100%;
        border: 1px solid #cbd5e1;
        background: #ffffff;
        color: #111827;
        border-radius: 9px;
        font-size: 16px;
        font-weight: 400;
        transition: border-color .18s ease, box-shadow .18s ease;
    }

    .terms-input,
    .terms-select {
        height: 54px;
        padding: 0 18px;
    }

    .terms-input::placeholder,
    .terms-textarea::placeholder {
        color: #94a3b8;
        font-weight: 400;
    }

    .terms-input:hover,
    .terms-select:hover,
    .terms-textarea:hover {
        border-color: #94a3b8;
    }

    .terms-input:focus,
    .terms-select:focus,
    .terms-textarea:focus {
        outline: none;
        border-color: #3b82f6;
        box-shadow: 0 0 0 4px rgba(59, 130, 246, .12);
    }

    .terms-readonly {
        min-height: 54px;
        padding: 0 18px;
        border-radius: 9px;
        border: 1px solid #e2e8f0;
        background: #f8fafc;
        color: #475569;
        display: flex;
        align-items: center;
        font-size: 16px;
        font-weight: 500;
    }

    .terms-textarea {
        min-height: 460px;
        padding: 18px 20px;
        resize: vertical;
        line-height: 1.8;
        font-family: Arial, sans-serif;
    }

    .terms-actions {
        padding: 22px 28px;
        border-top: 1px solid #e2e8f0;
        background: #ffffff;
        display: flex;
        align-items: center;
        justify-content: flex-end;
        gap: 12px;
    }

    @media (max-width: 1200px) {
        .terms-page {
            padding: 28px 18px 44px;
        }

        .terms-grid {
            grid-template-columns: minmax(0, 1fr) 300px;
            gap: 24px;
        }
    }

    @media (max-width: 900px) {
        .terms-header {
            flex-direction: column;
        }

        .terms-header-actions {
            padding-top: 0;
            width: 100%;
        }

        .terms-header-actions .terms-btn {
            flex: 1;
        }

        .terms-grid {
            grid-template-columns: 1fr;
            gap: 0;
        }
    }

    @media (max-width: 640px) {
        .terms-page {
            padding: 22px 12px 36px;
        }

        .terms-title-row {
            align-items: flex-start;
        }

        .terms-icon {
            width: 46px;
            height: 46px;
            font-size: 20px;
        }

        .terms-title {
            font-size: 28px;
        }

        .terms-subtitle {
            font-size: 15px;
        }

        .terms-card-header,
        .terms-card-body,
        .terms-actions {
            padding-left: 18px;
            padding-right: 18px;
        }

        .terms-card-header {
            flex-direction: column;
            align-items: flex-start;
        }

        .terms-textarea {
            min-height: 380px;
        }

        .terms-actions {
            flex-direction: column-reverse;
        }

        .terms-btn {
            width: 100%;
        }
    }
</style>

<div class="terms-page">
    <div class="terms-wrapper">
        @if(session('success'))
            <div class="terms-alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="terms-alert-error">
                Vui lòng kiểm tra lại dữ liệu.
            </div>
        @endif

        <form action="{{ route('Admin.trang_dieu_khoans.update') }}" method="POST">
            @csrf
            @method('PUT')

            <div class="terms-header">
                <div>
                    <a href="{{ route('Admin.dashboard') }}" class="terms-back">
                        <i class="fas fa-arrow-left"></i>
                        Quay lại
                    </a>

                    <div class="terms-title-row">
                        <div class="terms-icon">
                            <i class="fas fa-file-contract"></i>
                        </div>

                        <div>
                            <h1 class="terms-title">
                                Trang điều khoản
                            </h1>

                            <div class="terms-subtitle">
                                Quản lý nội dung điều khoản hiển thị ngoài website
                            </div>
                        </div>
                    </div>
                </div>

                <div class="terms-header-actions">
                    <a href="{{ route('Admin.dashboard') }}" class="terms-btn terms-btn-secondary">
                        Hủy
                    </a>

                    <button type="submit" class="terms-btn terms-btn-primary">
                        <i class="fas fa-save"></i>
                        Lưu điều khoản
                    </button>
                </div>
            </div>

            <div class="terms-card">
                <div class="terms-card-header">
                    <h2 class="terms-card-title">
                        <i class="fas fa-pen-to-square"></i>
                        Nội dung điều khoản
                    </h2>

                    <div class="terms-slug-badge">
                        {{ $trangDieuKhoan->duong_dan }}
                    </div>
                </div>

                <div class="terms-card-body">
                    <div class="terms-grid">
                        <div class="terms-group">
                            <label class="terms-label">
                                Tiêu đề
                            </label>

                            <input
                                type="text"
                                name="tieu_de"
                                class="terms-input"
                                value="{{ old('tieu_de', $trangDieuKhoan->tieu_de) }}"
                                placeholder="Nhập tiêu đề điều khoản"
                            >
                        </div>

                        <div class="terms-group">
                            <label class="terms-label">
                                Trạng thái
                            </label>

                            <select name="trang_thai" class="terms-select">
                                <option value="1" @selected(old('trang_thai', $trangDieuKhoan->trang_thai) == 1)>
                                    Hiển thị
                                </option>

                                <option value="0" @selected(old('trang_thai', $trangDieuKhoan->trang_thai) == 0)>
                                    Ẩn
                                </option>
                            </select>
                        </div>
                    </div>

                    <div class="terms-group">
                        <label class="terms-label">
                            Đường dẫn
                        </label>

                        <div class="terms-readonly">
                            {{ $trangDieuKhoan->duong_dan }}
                        </div>
                    </div>

                    <div class="terms-group">
                        <label class="terms-label">
                            Nội dung
                        </label>

                        <textarea
                            name="noi_dung"
                            class="terms-textarea"
                            placeholder="Nhập nội dung điều khoản tại đây..."
                        >{{ old('noi_dung', $trangDieuKhoan->noi_dung) }}</textarea>
                    </div>
                </div>

                <div class="terms-actions">
                    <a href="{{ route('Admin.dashboard') }}" class="terms-btn terms-btn-secondary">
                        Hủy
                    </a>

                    <button type="submit" class="terms-btn terms-btn-primary">
                        <i class="fas fa-save"></i>
                        Lưu điều khoản
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection