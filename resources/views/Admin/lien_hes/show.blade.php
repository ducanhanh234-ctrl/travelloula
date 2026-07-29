@extends('layouts.admin')

@section('title', 'Chi tiết liên hệ')

@section('content')

    <div class="container-fluid">

        <div class="card shadow-sm border-0">

            <div class="card-header bg-white d-flex justify-content-between align-items-center">

                <h4 class="mb-0">

                    <i class="fas fa-envelope-open-text text-primary me-2"></i>

                    Chi tiết liên hệ

                </h4>

                <a href="{{ route('Admin.lien_hes.index') }}" class="btn btn-outline-secondary">

                    <i class="fas fa-arrow-left me-2"></i>

                    Quay lại

                </a>

            </div>

            <div class="card-body">

                <div class="row g-4">

                    <div class="col-md-6">

                        <label class="fw-bold text-muted">

                            Họ tên

                        </label>

                        <div class="form-control">

                            {{ $lienHe->ho_ten }}

                        </div>

                    </div>

                    <div class="col-md-6">

                        <label class="fw-bold text-muted">

                            Email

                        </label>

                        <div class="form-control">

                            {{ $lienHe->email }}

                        </div>

                    </div>

                    <div class="col-md-6">

                        <label class="fw-bold text-muted">

                            Số điện thoại

                        </label>

                        <div class="form-control">

                            {{ $lienHe->so_dien_thoai }}

                        </div>

                    </div>

                    <div class="col-md-6">

                        <label class="fw-bold text-muted">

                            Ngày gửi

                        </label>

                        <div class="form-control">

                            {{ $lienHe->created_at->format('d/m/Y H:i') }}

                        </div>

                    </div>

                    <div class="col-md-12">

                        <label class="fw-bold text-muted">

                            Tiêu đề

                        </label>

                        <div class="form-control">

                            {{ $lienHe->tieu_de }}

                        </div>

                    </div>

                    <div class="col-md-12">

                        <label class="fw-bold text-muted">

                            Nội dung

                        </label>

                        <div class="form-control" style="min-height:220px;white-space:pre-wrap">

                            {{ $lienHe->noi_dung }}

                        </div>

                    </div>

                    <div class="col-md-12">

                        <label class="fw-bold text-muted">

                            Trạng thái

                        </label>

                        <div>

                            @if ($lienHe->trang_thai == 'Đã đọc')
                                <span class="badge bg-success">

                                    Đã đọc

                                </span>
                            @else
                                <span class="badge bg-warning text-dark">

                                    Chưa đọc

                                </span>
                            @endif

                        </div>

                    </div>

                </div>

            </div>

            <div class="card-footer bg-white d-flex justify-content-end">

                <div>

                    @if ($lienHe->trang_thai == 'Đã đọc')
                        <form action="{{ route('Admin.lien_hes.unread', $lienHe->id) }}" method="POST">

                            @csrf
                            @method('PATCH')

                            <button class="btn btn-warning">

                                <i class="fas fa-envelope me-2"></i>

                                Đánh dấu chưa đọc

                            </button>

                        </form>
                    @endif

                </div>
                <div class="d-flex gap-2">
                    @if ($lienHe->trang_thai == 'Chưa xử lý')
                        <form action="{{ route('Admin.lien_hes.read', $lienHe->id) }}" method="POST">
                            @csrf
                            @method('PATCH')

                            <button class="btn btn-success">
                                <i class="fas fa-check-circle me-2"></i>
                                Đánh dấu đã xử lý
                            </button>
                        </form>
                    @endif

                </div>
                <form action="{{ route('Admin.lien_hes.destroy', $lienHe->id) }}" method="POST">

                    @csrf
                    @method('DELETE')

                    <button class="btn btn-danger" onclick="return confirm('Bạn chắc chắn muốn xóa?')">

                        <i class="fas fa-trash me-2"></i>

                        Xóa liên hệ

                    </button>

                </form>

            </div>

        </div>

    </div>

@endsection
@push('style')
    <style>
        .form-control {

            background: #f8fafc;

            border-radius: 10px;

            min-height: 48px;

        }

        .card {

            border-radius: 18px;

        }

        .card-header {

            padding: 18px 25px;

        }

        .card-footer {

            padding: 18px 25px;

        }
    </style>
@endpush
