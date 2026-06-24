@extends('layouts.admin_pro')

@section('content')
<style>
    .vehicle-form-page {
        max-width: 1380px;
        margin: 0 auto;
        padding: 32px 32px 48px;
    }

    .back-link {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        color: #64748b;
        text-decoration: none;
        font-weight: 600;
        margin-bottom: 14px;
    }

    .back-link:hover {
        color: #2563eb;
    }

    .page-title {
        font-size: 32px;
        font-weight: 800;
        color: #0f172a;
        margin-bottom: 6px;
    }

    .page-subtitle {
        color: #64748b;
        margin-bottom: 28px;
    }

    .form-card {
        background: #fff;
        border: 1px solid #e5e7eb;
        border-radius: 12px;
        overflow: hidden;
        margin-bottom: 22px;
        box-shadow: 0 2px 8px rgba(15, 23, 42, .04);
    }

    .form-card-header {
        padding: 16px 24px;
        border-bottom: 1px solid #e5e7eb;
        font-weight: 800;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .form-card-badge {
        background: #10b981;
        color: white;
        padding: 5px 14px;
        border-radius: 999px;
        font-size: 12px;
        font-weight: 800;
    }

    .form-card-body {
        padding: 26px 24px 14px;
    }

    .form-label {
        font-weight: 700;
        margin-bottom: 8px;
        color: #0f172a;
    }

    .input-control,
    .textarea-control {
        width: 100%;
        border: 1px solid #cbd5e1;
        border-radius: 8px;
        padding: 10px 14px;
        transition: .2s;
    }

    .input-control {
        height: 44px;
    }

    .textarea-control {
        min-height: 120px;
        resize: vertical;
    }

    .input-control:focus,
    .textarea-control:focus {
        outline: none;
        border-color: #3b82f6;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, .12);
    }

    .alert-custom {
        background: #fee2e2;
        color: #991b1b;
        border: 1px solid #fecaca;
        padding: 14px 18px;
        border-radius: 10px;
        margin-bottom: 20px;
        font-weight: 700;
    }

    .actions-bar {
        display: flex;
        justify-content: flex-end;
        gap: 12px;
        margin-top: 24px;
    }

    .btn-cancel {
        padding: 10px 22px;
        border-radius: 8px;
        background: white;
        border: 1px solid #cbd5e1;
        text-decoration: none;
        color: #334155;
        font-weight: 700;
    }

    .btn-submit {
        padding: 10px 24px;
        border: none;
        border-radius: 8px;
        background: #10b981;
        color: white;
        font-weight: 800;
        box-shadow: 0 8px 18px rgba(16, 185, 129, .25);
    }

    .btn-submit:hover {
        background: #059669;
    }

    @media(max-width:768px) {
        .vehicle-form-page {
            padding: 20px;
        }

        .page-title {
            font-size: 26px;
        }

        .actions-bar {
            flex-direction: column-reverse;
        }

        .btn-cancel,
        .btn-submit {
            width: 100%;
            text-align: center;
        }
    }

</style>

<div class="vehicle-form-page">

    <a href="{{ route('Admin.phuong-tiens.index') }}" class="back-link">
        <i class="fa fa-arrow-left"></i>
        Quay lại danh sách
    </a>

    <h1 class="page-title">Thêm xe mới</h1>

    <div class="page-subtitle">
        Thêm phương tiện và thông tin tài xế vận hành
    </div>

    @if($errors->any())
    <div class="alert-custom">
        Vui lòng kiểm tra lại dữ liệu.
    </div>
    @endif

    <form action="{{ route('Admin.phuong-tiens.store') }}" method="POST">
        @csrf

        <div class="form-card">
            <div class="form-card-header">
                <span>Thông tin phương tiện</span>
                <span class="form-card-badge">THÊM MỚI</span>
            </div>

            <div class="form-card-body">
                <div class="row">

                    <div class="col-md-4 mb-4">
                        <label class="form-label">Biển số xe *</label>
                        <input type="text" name="bien_so_xe" class="input-control" value="{{ old('bien_so_xe') }}">
                    </div>

                    <div class="col-md-4 mb-4">
                        <label class="form-label">Loại phương tiện *</label>
                        <input type="text" name="loai_phuong_tien" class="input-control" placeholder="16 chỗ, 29 chỗ, 45 chỗ..." value="{{ old('loai_phuong_tien') }}">
                    </div>

                    <div class="col-md-4 mb-4">
                        <label class="form-label">Hãng xe *</label>
                        <input type="text" name="hang_xe" class="input-control" value="{{ old('hang_xe') }}">
                    </div>

                    <div class="col-md-4 mb-4">
                        <label class="form-label">Năm sản xuất *</label>
                        <input type="number" name="nam_san_xuat" class="input-control" value="{{ old('nam_san_xuat') }}">
                    </div>

                    <div class="col-md-4 mb-4">
                        <label class="form-label">Màu xe *</label>
                        <input type="text" name="mau_xe" class="input-control" value="{{ old('mau_xe') }}">
                    </div>

                    <div class="col-md-4 mb-4">
                        <label class="form-label">Trạng thái *</label>
                        <select name="trang_thai" class="input-control">
                            @foreach(\App\Models\PhuongTien::trangThaiList() as $key => $value)
                            <option value="{{ $key }}" @selected(old('trang_thai', 1)==$key)>
                                {{ $value }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                </div>
            </div>
        </div>

        <div class="form-card">
            <div class="form-card-header">
                <span>Thông tin tài xế</span>
            </div>

            <div class="form-card-body">
                <div class="row">

                    <div class="col-md-6 mb-4">
                        <label class="form-label">Tên tài xế *</label>
                        <input type="text" name="ten_tai_xe" class="input-control" value="{{ old('ten_tai_xe') }}">
                    </div>

                    <div class="col-md-6 mb-4">
                        <label class="form-label">Số điện thoại tài xế *</label>
                        <input type="text" name="so_dien_thoai_tai_xe" class="input-control" value="{{ old('so_dien_thoai_tai_xe') }}">
                    </div>

                </div>
            </div>
        </div>

        <div class="form-card">
            <div class="form-card-header">
                <span>Ghi chú</span>
            </div>

            <div class="form-card-body">
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label class="form-label">Ghi chú về xe</label>
                        <textarea name="ghi_chu" class="textarea-control" placeholder="Thông tin bảo trì, lưu ý vận hành, tình trạng xe...">{{ old('ghi_chu') }}</textarea>
                    </div>
                </div>
            </div>
        </div>

        <div class="actions-bar">
            <a href="{{ route('Admin.phuong-tiens.index') }}" class="btn-cancel">
                Hủy
            </a>

            <button type="submit" class="btn-submit">
                <i class="fa fa-plus"></i>
                Thêm xe mới
            </button>
        </div>
    </form>
</div>
@endsection
