@extends('layouts.admin')

@section('title', 'Quản lý liên hệ')

@section('content')
    <div class="container-fluid">

        {{-- Header --}}
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h3 class="fw-bold mb-1">
                    <i class="fas fa-envelope-open-text text-primary me-2"></i>
                    Quản lý liên hệ
                </h3>
                <p class="text-muted mb-0">
                    Quản lý các yêu cầu hỗ trợ và liên hệ từ khách hàng.
                </p>
            </div>
            <div>
                <span class="badge bg-primary fs-6 px-3 py-2">
                    Tổng: {{ $tong }}
                </span>
            </div>
        </div>

        {{-- Thống kê --}}
        <div class="row g-4 mb-4">
            {{-- Tổng liên hệ --}}
            <div class="col-xl-4 col-md-6">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <p class="text-muted mb-2">Tổng liên hệ</p>
                                <h2 class="fw-bold text-primary mb-0">{{ $tong }}</h2>
                            </div>
                            <div class="rounded-circle bg-primary bg-opacity-10 d-flex align-items-center justify-content-center"
                                style="width:65px;height:65px;">
                                <i class="fas fa-envelope fa-2x text-primary"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Chưa xử lý --}}
            <div class="col-xl-4 col-md-6">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <p class="text-muted mb-2">Chưa xử lý</p>
                                <h2 class="fw-bold text-warning mb-0">
                                    {{-- Chưa xử lý --}}
                                    <h2 class="fw-bold text-warning mb-0">
                                        {{ $chuaXuLy }}
                                    </h2>
                                </h2>
                            </div>
                            <div class="rounded-circle bg-warning bg-opacity-10 d-flex align-items-center justify-content-center"
                                style="width:65px;height:65px;">
                                <i class="fas fa-envelope fa-2x text-warning"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Đã xử lý --}}
            <div class="col-xl-4 col-md-6">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <p class="text-muted mb-2">Đã xử lý</p>
                                <h2 class="fw-bold text-success mb-0">{{-- Đã xử lý --}}
                                    <h2 class="fw-bold text-success mb-0">
                                        {{ $daXuLy }}
                                    </h2>
                                </h2>
                            </div>
                            <div class="rounded-circle bg-success bg-opacity-10 d-flex align-items-center justify-content-center"
                                style="width:65px;height:65px;">
                                <i class="fas fa-check-circle fa-2x text-success"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Card danh sách --}}
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white">
                <h5 class="mb-0 fw-semibold">Danh sách liên hệ</h5>
            </div>

            <div class="card-body">
                {{-- Thanh tìm kiếm & Bộ lọc --}}
                <form method="GET" action="{{ route('Admin.lien_hes.index') }}">
                    <div class="row g-3 align-items-end mb-4">
                        {{-- Tìm kiếm --}}
                        <div class="col-lg-5">
                            <label class="form-label fw-semibold">Tìm kiếm</label>
                            <div class="input-group">
                                <span class="input-group-text bg-white">
                                    <i class="fas fa-search text-muted"></i>
                                </span>
                                <input type="text" name="keyword" value="{{ request('keyword') }}" class="form-control"
                                    placeholder="Tên, email, số điện thoại hoặc tiêu đề...">
                            </div>
                        </div>

                        {{-- Trạng thái --}}
                        <div class="col-lg-3">
                            <label class="form-label fw-semibold">Trạng thái</label>
                            <select name="trang_thai" class="form-select">
                                <option value="">-- Tất cả --</option>
                                <option value="Chưa xử lý" @selected(request('trang_thai') == 'Chưa xử lý')>Chưa xử lý</option>
                                <option value="Đã xử lý" @selected(request('trang_thai') == 'Đã xử lý')>Đã xử lý</option>
                            </select>
                        </div>

                        {{-- Nút lọc & Reset --}}
                        <div class="col-lg-2">
                            <button type="submit" class="btn btn-primary w-100">
                                <i class="fas fa-filter me-2"></i> Lọc
                            </button>
                        </div>
                        <div class="col-lg-2">
                            <a href="{{ route('Admin.lien_hes.index') }}" class="btn btn-outline-secondary w-100">
                                <i class="fas fa-rotate-left me-2"></i> Đặt lại
                            </a>
                        </div>
                    </div>
                </form>

                <hr class="mb-4">

                {{-- Bảng danh sách --}}
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th width="60">#</th>
                                <th>Khách hàng</th>
                                <th>Tiêu đề</th>
                                <th>Ngày gửi</th>
                                <th width="120" class="text-center">Trạng thái</th>
                                <th width="190" class="text-center">Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($lienHes as $lienHe)
                                <tr>
                                    <td>{{ ($lienHes->currentPage() - 1) * $lienHes->perPage() + $loop->iteration }}</td>
                                    <td>
                                        <div class="fw-semibold">{{ $lienHe->ho_ten }}</div>
                                        <small class="text-muted d-block">
                                            <i class="fas fa-envelope me-1"></i>{{ $lienHe->email }}
                                        </small>
                                        <small class="text-muted d-block">
                                            <i class="fas fa-phone me-1"></i>{{ $lienHe->so_dien_thoai }}
                                        </small>
                                    </td>
                                    <td>
                                        <div class="fw-semibold">{{ $lienHe->tieu_de }}</div>
                                        <small class="text-muted">
                                            {{ \Illuminate\Support\Str::limit($lienHe->noi_dung, 70) }}
                                        </small>
                                    </td>
                                    <td>
                                        {{ $lienHe->created_at->format('d/m/Y') }}
                                        <small class="text-muted d-block">
                                            {{ $lienHe->created_at->format('H:i') }}
                                        </small>
                                    </td>
                                    <td class="text-center">
                                        @if ($lienHe->trang_thai == 'Đã xử lý')
                                            <span class="badge bg-success">
                                                <i class="fas fa-check-circle me-1"></i> Đã xử lý
                                            </span>
                                        @else
                                            <span class="badge bg-warning text-dark">
                                                <i class="fas fa-envelope me-1"></i> Chưa xử lý
                                            </span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <div class="btn-group">
                                            <a href="{{ route('Admin.lien_hes.show', $lienHe->id) }}"
                                                class="btn btn-sm btn-primary" title="Xem">
                                                <i class="fas fa-eye"></i>
                                            </a>

                                            @if ($lienHe->trang_thai == 'Chưa xử lý')
                                                <form action="{{ route('Admin.lien_hes.read', $lienHe->id) }}"
                                                    method="POST" class="d-inline">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button class="btn btn-sm btn-success" title="Đánh dấu Đã xử lý">
                                                        <i class="fas fa-check"></i>
                                                    </button>
                                                </form>
                                            @endif

                                            <form action="{{ route('Admin.lien_hes.destroy', $lienHe->id) }}"
                                                method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-sm btn-danger"
                                                    onclick="return confirm('Bạn có chắc muốn xóa liên hệ này?')"
                                                    title="Xóa">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-5">
                                        <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                                        <div class="fw-semibold text-muted">Chưa có liên hệ nào.</div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Chân trang bảng: Số lượng & Phân trang --}}
                <div class="d-flex flex-wrap justify-content-between align-items-center mt-4 pt-3 border-top">
                    <div class="text-muted mb-2 mb-md-0">
                        Hiển thị <strong>{{ $lienHes->count() }}</strong> / <strong>{{ $tong }}</strong> liên hệ
                    </div>
                    <div>
                        {{ $lienHes->appends(request()->query())->links() }}
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        .card {
            border: none;
            border-radius: 16px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, .05);
        }

        .card-header {
            background: #fff;
            border-bottom: 1px solid #eef2f7;
            padding: 18px 24px;
        }

        .card-body {
            padding: 24px;
        }

        .form-control,
        .form-select {
            border-radius: 10px;
            min-height: 45px;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: #0d6efd;
            box-shadow: 0 0 0 .2rem rgba(13, 110, 253, .15);
        }

        .table thead th {
            background: #f8fafc;
            color: #495057;
            font-weight: 700;
            border-bottom: 2px solid #e9ecef;
            white-space: nowrap;
        }

        .table tbody td {
            padding: 16px 12px;
        }

        .table-hover tbody tr:hover {
            background: #f5f9ff;
        }

        .badge {
            border-radius: 50px;
            padding: 8px 14px;
            font-size: 12px;
            font-weight: 600;
        }

        .btn {
            border-radius: 10px;
        }

        .btn-group .btn {
            width: 36px;
            height: 36px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 0;
        }

        .pagination .page-link {
            border-radius: 8px !important;
            margin: 0 2px;
        }
    </style>
@endpush
