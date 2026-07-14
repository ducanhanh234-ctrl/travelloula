@extends('layouts.admin')

@section('content')
    <style>
        .vehicle-edit-page {
            background: #f8fafc;
            min-height: 100vh;
            padding: 20px 12px 40px;
            color: #0f172a;
            width: 100%;
        }

        .vehicle-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 24px;
        }

        .back-link {
            color: #64748b;
            text-decoration: none;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 12px;
        }

        .back-link:hover {
            color: #2563eb;
        }

        .page-title {
            font-size: 32px;
            font-weight: 800;
            margin: 0 0 6px;
            color: #0f172a;
        }

        .page-subtitle {
            color: #64748b;
            font-size: 15px;
        }

        .form-card {
            background: #fff;
            border: 1px solid #e2e8f0;
            border-radius: 16px;
            overflow: hidden;
            margin-bottom: 24px;
            box-shadow: 0 1px 3px rgba(15, 23, 42, .06);
        }

        .form-card-header {
            padding: 18px 24px;
            border-bottom: 1px solid #e2e8f0;
            background: #fff;
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 18px;
            font-weight: 800;
            color: #0f172a;
        }

        .form-card-badge {
            background: #eef2ff;
            color: #4f46e5;
            padding: 6px 14px;
            border-radius: 999px;
            font-size: 13px;
            font-weight: 800;
        }

        .form-card-body {
            padding: 24px 24px 8px;
        }

        .form-label {
            display: block;
            font-weight: 700;
            color: #0f172a;
            margin-bottom: 8px;
            font-size: 15px;
        }

        .input-control,
        .textarea-control {
            width: 100%;
            border: 1px solid #d1d5db;
            border-radius: 9px;
            padding: 0 16px;
            font-size: 15px;
            color: #0f172a;
            background: #fff;
            transition: .2s;
        }

        .input-control {
            height: 50px;
        }

        .textarea-control {
            min-height: 120px;
            padding: 14px 16px;
            resize: vertical;
        }

        .input-control:focus,
        .textarea-control:focus {
            outline: none;
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, .15);
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
            background: #fff;
            border: 1px solid #e2e8f0;
            border-radius: 16px;
            padding: 18px 24px;
            display: flex;
            justify-content: flex-end;
            gap: 12px;
            box-shadow: 0 1px 3px rgba(15, 23, 42, .06);
        }

        .btn-cancel {
            padding: 11px 24px;
            border-radius: 9px;
            background: #fff;
            border: 1px solid #cbd5e1;
            text-decoration: none;
            color: #334155;
            font-weight: 800;
            transition: .2s;
        }

        .btn-cancel:hover {
            background: #f8fafc;
            color: #0f172a;
        }

        .btn-submit {
            padding: 11px 26px;
            border: none;
            border-radius: 9px;
            background: #3b82f6;
            color: #fff;
            font-weight: 800;
            box-shadow: 0 6px 14px rgba(59, 130, 246, .22);
            transition: .2s;
        }

        .btn-submit:hover {
            background: #2563eb;
            transform: translateY(-1px);
        }

        @media(max-width:1100px) {
            .vehicle-edit-page {
                padding: 20px 10px 32px;
            }

            .vehicle-header {
                flex-direction: column;
                gap: 18px;
            }
        }

        @media(max-width:768px) {
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

    <div class="vehicle-edit-page">

        <div class="vehicle-header">
            <div>
                <a href="{{ route('Admin.phuong-tiens.index') }}" class="back-link">
                    <i class="fa fa-arrow-left"></i>
                    Quay lại danh sách
                </a>

                <h1 class="page-title">
                    Chỉnh sửa xe
                </h1>

                <div class="page-subtitle">
                    {{ $phuongTien->bien_so_xe }} - {{ $phuongTien->hang_xe }}
                </div>
            </div>
        </div>

        @if ($errors->any())
            <div class="alert-custom">
                Vui lòng kiểm tra lại dữ liệu.
            </div>
        @endif

        <form action="{{ route('Admin.phuong-tiens.update', $phuongTien->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-card">
                <div class="form-card-header">
                    <span>🚐 Thông tin cơ bản</span>
                    <span class="form-card-badge">CHỈNH SỬA</span>
                </div>

                <div class="form-card-body">
                    <div class="row">
                        <div class="col-md-4 mb-4">
                            <label class="form-label">Tên phương tiện</label>

                            <input type="text" name="ten_phuong_tien" value="{{ old('ten_phuong_tien', $phuongTien->ten_phuong_tien) }}" class="input-control">
                        </div>
                        <div class="col-md-4 mb-4">
                            <label class="form-label">Biển số xe *</label>
                            <input type="text" name="bien_so_xe" class="input-control"
                                value="{{ old('bien_so_xe', $phuongTien->bien_so_xe) }}">
                        </div>

                        <div class="col-md-4 mb-4">
                            <label class="form-label">Loại xe *</label>
                            <select name="loai_phuong_tien" class="input-control">
                                <option value="">-- Chọn loại xe --</option>

                                @foreach (\App\Models\PhuongTien::loaiPhuongTienList() as $key => $value)
                                    <option value="{{ $key }}" @selected(old('loai_phuong_tien', $phuongTien->loai_phuong_tien) == $key)>
                                        {{ $value }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-4 mb-4">
                            <label class="form-label">Hãng xe *</label>
                            <input type="text" name="hang_xe" class="input-control"
                                value="{{ old('hang_xe', $phuongTien->hang_xe) }}">
                        </div>

                        <div class="col-md-4 mb-4">
                            <label class="form-label">Năm sản xuất *</label>
                            <input type="number" name="nam_san_xuat" class="input-control"
                                value="{{ old('nam_san_xuat', $phuongTien->nam_san_xuat) }}">
                        </div>

                        <div class="col-md-4 mb-4">
                            <label class="form-label">Màu xe *</label>
                            <input type="text" name="mau_xe" class="input-control"
                                value="{{ old('mau_xe', $phuongTien->mau_xe) }}">
                        </div>

                        <div class="col-md-4 mb-4">
                            <label class="form-label">Trạng thái *</label>
                            <select name="trang_thai" class="input-control">
                                @foreach (\App\Models\PhuongTien::trangThaiList() as $key => $value)
                                    <option value="{{ $key }}" @selected(old('trang_thai', $phuongTien->trang_thai) == $key)>
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
                    <span>👤 Thông tin tài xế</span>
                </div>

                <div class="form-card-body">
                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <label class="form-label">Tên tài xế *</label>
                            <input type="text" name="ten_tai_xe" class="input-control"
                                value="{{ old('ten_tai_xe', $phuongTien->ten_tai_xe) }}">
                        </div>

                        <div class="col-md-6 mb-4">
                            <label class="form-label">Số điện thoại tài xế *</label>
                            <input type="text" name="so_dien_thoai_tai_xe" class="input-control"
                                value="{{ old('so_dien_thoai_tai_xe', $phuongTien->so_dien_thoai_tai_xe) }}">
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-card">
                <div class="form-card-header">
                    <span>📝 Ghi chú</span>
                </div>

                <div class="form-card-body">
                    <div class="row">
                        <div class="col-md-12 mb-4">
                            <label class="form-label">Ghi chú về xe</label>
                            <textarea name="ghi_chu" class="textarea-control"
                                placeholder="Ghi chú về tình trạng xe, lịch bảo trì, lưu ý vận hành...">{{ old('ghi_chu', $phuongTien->ghi_chu) }}</textarea>
                        </div>
                    </div>
                </div>
            </div>

            <div class="actions-bar">
                <a href="{{ route('Admin.phuong-tiens.index') }}" class="btn-cancel">
                    Hủy
                </a>

                <button type="submit" class="btn-submit">
                    <i class="fa fa-save"></i>
                    Cập nhật
                </button>
            </div>
        </form>
    </div>
@endsection
