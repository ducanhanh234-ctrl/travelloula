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
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
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
        border-color: #667eea;
        box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
    }

    .permissions-group {
        background: #f9fafb;
        border-radius: 8px;
        padding: 16px;
        border: 1px solid #e5e7eb;
    }

    .permissions-header {
        font-weight: 600;
        color: #374151;
        margin-bottom: 16px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .permission-item {
        display: flex;
        align-items: center;
        padding: 10px;
        margin: 0;
    }

    .permission-item input[type="checkbox"] {
        width: 18px;
        height: 18px;
        cursor: pointer;
        margin-right: 8px;
    }

    .permission-item label {
        cursor: pointer;
        margin: 0;
    }

    .permission-name {
        font-weight: 500;
        color: #374151;
    }

    .permission-code {
        font-size: 12px;
        color: #6b7280;
        margin-left: 4px;
    }

    .form-actions {
        display: flex;
        gap: 12px;
        margin-top: 32px;
        padding-top: 24px;
        border-top: 1px solid #e5e7eb;
    }

    .btn-save {
        background: #667eea;
        color: white;
        border: none;
        padding: 10px 24px;
        border-radius: 6px;
        font-weight: 600;
        cursor: pointer;
        transition: background 0.3s;
    }

    .btn-save:hover {
        background: #5568d3;
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
</style>

<div class="container py-4">
    <div class="card form-card">
        <div class="form-header">
            <h3>Tạo vai trò mới</h3>
        </div>

        <div class="form-body">
            <form action="{{ route('Admin.vai-tros.store') }}" method="POST">
                @csrf

                <div class="form-group">
                    <label class="form-label">Tên vai trò <span style="color: #ef4444;">*</span></label>
                    <input type="text" name="ten_vai_tro" class="form-control @error('ten_vai_tro') is-invalid @enderror"
                        value="{{ old('ten_vai_tro') }}" placeholder="Ví dụ: Admin, Editor, Contributor" required>
                    @error('ten_vai_tro')
                        <div class="error-text">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Mô tả</label>
                    <textarea name="mo_ta" class="form-control" rows="3" placeholder="Mô tả vai trò này">{{ old('mo_ta') }}</textarea>
                    @error('mo_ta')
                        <div class="error-text">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Gán quyền</label>
                    <div class="permissions-group">
                        <div class="permissions-header">
                            <i class="fas fa-check-circle"></i>
                            Chọn các quyền cho vai trò này
                        </div>
                        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 12px;">
                            @forelse($quyenHans->groupBy('mo_dun') as $module => $permissions)
                                <div>
                                    <div style="font-weight: 600; color: #667eea; margin-bottom: 10px; font-size: 13px; text-transform: uppercase;">
                                        {{ $module ?: 'System' }}
                                    </div>
                                    @foreach($permissions as $quyenHan)
                                        <label class="permission-item">
                                            <input class="form-check-input" type="checkbox" name="quyen_han_ids[]"
                                                value="{{ $quyenHan->id }}"
                                                {{ in_array($quyenHan->id, old('quyen_han_ids', [])) ? 'checked' : '' }}>
                                            <span class="permission-name">{{ $quyenHan->ten_hien_thi }}</span>
                                            <span class="permission-code">{{ $quyenHan->ten }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            @empty
                                <p style="color: #9ca3af;">Không có quyền nào để chọn. <a href="{{ route('Admin.quyen-hans.create') }}">Tạo quyền mới</a></p>
                            @endforelse
                        </div>
                    </div>
                    @error('quyen_han_ids')
                        <div class="error-text">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn-save">💾 Lưu vai trò</button>
                    <a href="{{ route('Admin.vai-tros.index') }}" class="btn-cancel">Hủy</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
