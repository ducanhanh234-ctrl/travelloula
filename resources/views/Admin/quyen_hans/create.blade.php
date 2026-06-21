@extends('layouts.admin')
@section('content')
<style>
    .form-card {
        border: none;
        border-radius: 10px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        overflow: hidden;
    }

    .form-header {
        background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
        color: white;
        padding: 24px;
    }

    .form-header h3 {
        margin: 0;
        font-size: 22px;
        font-weight: 600;
    }

    .form-body {
        padding: 30px;
    }

    .form-group {
        margin-bottom: 24px;
    }

    .form-label {
        font-weight: 600;
        color: #374151;
        margin-bottom: 8px;
        display: block;
    }

    .form-control {
        border: 1px solid #d1d5db;
        border-radius: 6px;
        padding: 10px 12px;
        font-size: 14px;
    }

    .form-control:focus {
        border-color: #f59e0b;
        box-shadow: 0 0 0 3px rgba(245, 158, 11, 0.1);
    }

    .form-hint {
        font-size: 12px;
        color: #6b7280;
        margin-top: 6px;
    }

    .form-actions {
        display: flex;
        gap: 12px;
        margin-top: 32px;
        padding-top: 24px;
        border-top: 1px solid #e5e7eb;
    }

    .btn-save {
        background: #f59e0b;
        color: white;
        border: none;
        padding: 10px 24px;
        border-radius: 6px;
        font-weight: 600;
        cursor: pointer;
        transition: background 0.3s;
    }

    .btn-save:hover {
        background: #d97706;
    }

    .btn-cancel {
        background: #e5e7eb;
        color: #374151;
        border: none;
        padding: 10px 24px;
        border-radius: 6px;
        font-weight: 600;
        cursor: pointer;
        text-decoration: none;
        display: inline-block;
    }

    .btn-cancel:hover {
        background: #d1d5db;
    }

    .error-text {
        color: #ef4444;
        font-size: 12px;
        margin-top: 6px;
    }

    .checkbox-group {
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 12px;
        background: #f9fafb;
        border-radius: 6px;
        border: 1px solid #e5e7eb;
    }

    .checkbox-group input[type="checkbox"] {
        width: 18px;
        height: 18px;
        cursor: pointer;
    }

    .checkbox-group label {
        cursor: pointer;
        margin: 0;
        font-weight: 500;
    }
</style>

<div class="container py-4">
    <div class="card form-card">
        <div class="form-header">
            <h3>Tạo quyền mới</h3>
        </div>

        <div class="form-body">
            <form action="{{ route('Admin.quyen-hans.store') }}" method="POST">
                @csrf

                <div class="form-group">
                    <label class="form-label">Tên kỹ thuật <span style="color: #ef4444;">*</span></label>
                    <input type="text" name="ten" class="form-control @error('ten') is-invalid @enderror" 
                        value="{{ old('ten') }}" placeholder="Ví dụ: users.create" required>
                    <div class="form-hint">Sử dụng chữ thường, dấu chấm hoặc gạch dưới. Ví dụ: users.create, posts.edit</div>
                    @error('ten')
                        <div class="error-text">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Tên hiển thị <span style="color: #ef4444;">*</span></label>
                    <input type="text" name="ten_hien_thi" class="form-control @error('ten_hien_thi') is-invalid @enderror" 
                        value="{{ old('ten_hien_thi') }}" placeholder="Ví dụ: Tạo người dùng" required>
                    @error('ten_hien_thi')
                        <div class="error-text">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Mô đun</label>
                    <input type="text" name="mo_dun" class="form-control" value="{{ old('mo_dun') }}" 
                        placeholder="Ví dụ: users, posts, tours">
                    <div class="form-hint">Tên nhóm mô đun mà quyền này thuộc về</div>
                </div>

                <div class="form-group">
                    <label class="form-label">Mô tả</label>
                    <textarea name="mo_ta" class="form-control" rows="3" placeholder="Mô tả chi tiết về quyền này">{{ old('mo_ta') }}</textarea>
                    @error('mo_ta')
                        <div class="error-text">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <div class="checkbox-group">
                        <input type="checkbox" class="form-check-input" name="trang_thai" id="trang_thai" value="1" 
                            {{ old('trang_thai') ? 'checked' : '' }}>
                        <label for="trang_thai">Kích hoạt quyền này</label>
                    </div>
                    <div class="form-hint" style="margin-top: 8px;">Tắt để vô hiệu hóa quyền mà không cần xóa</div>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn-save">💾 Lưu quyền</button>
                    <a href="{{ route('Admin.quyen-hans.index') }}" class="btn-cancel">Hủy</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
