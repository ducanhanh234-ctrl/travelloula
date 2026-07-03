@extends('layouts.admin')

@section('content')
@php $currentUser = auth()->user(); @endphp

<div class="container">
    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold mb-1">Quản lý Tour</h3>
            <p class="text-muted mb-0">
                Quản lý danh sách các tour du lịch trong hệ thống
            </p>
        </div>

        @if($currentUser && $currentUser->hasPermission('tours.create'))
            <a href="{{ route('Admin.tours.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i>
                Thêm Tour
            </a>
        @endif
    </div>

    {{-- Thống kê --}}
    <div class="stats-grid mb-4">
        <div class="stat-card">
            <div class="stat-icon stat-icon-primary">
                <i class="fas fa-route"></i>
            </div>
            <div class="stat-value">{{ $tongTour ?? 0 }}</div>
            <div class="stat-label">Tổng Tour</div>
        </div>

        <div class="stat-card">
            <div class="stat-icon stat-icon-success">
                <i class="fas fa-check-circle"></i>
            </div>
            <div class="stat-value">{{ $activeTour ?? 0 }}</div>
            <div class="stat-label">Đang hoạt động</div>
        </div>

        <div class="stat-card">
            <div class="stat-icon stat-icon-danger">
                <i class="fas fa-ban"></i>
            </div>
            <div class="stat-value">{{ $inactiveTour ?? 0 }}</div>
            <div class="stat-label">Ngừng hoạt động</div>
        </div>

        <div class="stat-card">
            <div class="stat-icon stat-icon-warning">
                <i class="fas fa-list"></i>
            </div>
            <div class="stat-value">{{ $tongDanhMuc ?? 0 }}</div>
            <div class="stat-label">Danh mục</div>
        </div>
    </div>

    {{-- Bộ lọc --}}
    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-filter me-2"></i>
            Bộ lọc tìm kiếm
        </div>

        <div class="card-body">
            <form method="GET" action="{{ route('Admin.tours.index') }}">
                <div class="row g-3">
                    <div class="col-md-3">
                        <input
                            class="form-control"
                            name="keyword"
                            value="{{ request('keyword') }}"
                            placeholder="Tên tour..."
                        >
                    </div>

                    <div class="col-md-3">
                        <select name="danh_muc_id" class="form-select">
                            <option value="">Tất cả danh mục</option>

                            @foreach ($danhMucs as $item)
                                <option value="{{ $item->id }}"
                                    {{ request('danh_muc_id') == $item->id ? 'selected' : '' }}>
                                    {{ $item->ten_danh_muc }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-2">
                        <select name="trang_thai" class="form-select">
                            <option value="">Trạng thái</option>
                            <option value="active" {{ request('trang_thai') == 'active' ? 'selected' : '' }}>
                                Đang hoạt động
                            </option>
                            <option value="inactive" {{ request('trang_thai') == 'inactive' ? 'selected' : '' }}>
                                Ngừng hoạt động
                            </option>
                        </select>
                    </div>

                    <div class="col-md-2">
                        <select name="sort_price" class="form-select">
                            <option value="">Sắp xếp giá</option>
                            <option value="asc" {{ request('sort_price') == 'asc' ? 'selected' : '' }}>
                                Giá tăng
                            </option>
                            <option value="desc" {{ request('sort_price') == 'desc' ? 'selected' : '' }}>
                                Giá giảm
                            </option>
                        </select>
                    </div>

                    <div class="col-md-2 d-flex gap-2">
                        <button type="submit" class="btn btn-primary flex-fill">
                            <i class="fas fa-search"></i>
                        </button>

                        <a href="{{ route('Admin.tours.index') }}" class="btn btn-secondary">
                            <i class="fas fa-rotate-right"></i>
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- Danh sách tour --}}
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <span>
                <i class="fas fa-route me-2"></i>
                Danh sách Tour
            </span>

            <span class="badge badge-primary">
                {{ $tours->total() }} Tour
            </span>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table mb-0 align-middle">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Ảnh</th>
                            <th>Tên Tour</th>
                            <th>Giá</th>
                            <th>Danh mục</th>
                            <th>Thời lượng</th>
                            <th>Trạng thái</th>
                            <th width="220">Thao tác</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($tours as $tour)
                            <tr>
                                <td>
                                    {{ ($tours->currentPage() - 1) * $tours->perPage() + $loop->iteration }}
                                </td>

                                <td>
                                    @if ($tour->anh_dai_dien)
                                        <img
                                            src="{{ asset('storage/' . $tour->anh_dai_dien) }}"
                                            alt="{{ $tour->ten_tour }}"
                                            width="100"
                                            height="70"
                                            style="object-fit: cover; border-radius: 8px;"
                                        >
                                    @else
                                        <span class="text-muted">Chưa có ảnh</span>
                                    @endif
                                </td>

                                <td>
                                    <strong>{{ $tour->ten_tour }}</strong>
                                </td>

                                <td>
                                    {{ number_format($tour->gia_tour, 0, ',', '.') }} VNĐ
                                </td>

                                <td>
                                    {{ $tour->danhMuc?->ten_danh_muc ?? 'Chưa có danh mục' }}
                                </td>

                                <td>
                                    {{ $tour->thoi_luong }}
                                </td>

                                <td>
                                    @if ($tour->trang_thai == 'active')
                                        <span class="badge badge-success">
                                            Đang hoạt động
                                        </span>
                                    @else
                                        <span class="badge badge-danger">
                                            Ngừng hoạt động
                                        </span>
                                    @endif
                                </td>

                                <td>
                                    <div class="d-flex gap-1">
                                        @if($currentUser && $currentUser->hasPermission('tours.view'))
                                            <a href="{{ route('Admin.tours.show', $tour) }}"
                                               class="btn btn-outline-primary btn-sm"
                                               title="Xem">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                        @endif

                                        @if($currentUser && $currentUser->hasPermission('tours.edit'))
                                            <a href="{{ route('Admin.tours.edit', $tour) }}"
                                               class="btn btn-warning btn-sm"
                                               title="Sửa">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                        @endif

                                        @if($currentUser && $currentUser->hasPermission('tours.delete'))
                                            <form
                                                action="{{ route('Admin.tours.destroy', $tour) }}"
                                                method="POST"
                                                class="d-inline"
                                                onsubmit="return confirm('Bạn có chắc muốn xóa tour này?');"
                                            >
                                                @csrf
                                                @method('DELETE')

                                                <button type="submit" class="btn btn-danger btn-sm" title="Xóa">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center text-muted py-4">
                                    Không tìm thấy tour phù hợp.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="card-footer text-center">
            {{ $tours->appends(request()->query())->links() }}
        </div>
    </div>
</div>

<style>
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 16px;
    }

    .stat-card {
        background: #fff;
        border: 1px solid #e5e7eb;
        border-radius: 16px;
        padding: 18px;
        box-shadow: 0 6px 20px rgba(15, 23, 42, 0.06);
    }

    .stat-icon {
        width: 42px;
        height: 42px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 12px;
        font-size: 18px;
    }

    .stat-icon-primary {
        background: #eef2ff;
        color: #4f46e5;
    }

    .stat-icon-success {
        background: #dcfce7;
        color: #15803d;
    }

    .stat-icon-danger {
        background: #fee2e2;
        color: #dc2626;
    }

    .stat-icon-warning {
        background: #fef3c7;
        color: #d97706;
    }

    .stat-value {
        font-size: 26px;
        font-weight: 800;
        color: #111827;
        line-height: 1;
    }

    .stat-label {
        color: #6b7280;
        font-weight: 600;
        margin-top: 6px;
    }

    .badge-primary {
        background: #eef2ff;
        color: #4f46e5;
    }

    .badge-success {
        background: #dcfce7;
        color: #15803d;
    }

    .badge-danger {
        background: #fee2e2;
        color: #dc2626;
    }

    @media (max-width: 992px) {
        .stats-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 576px) {
        .stats-grid {
            grid-template-columns: 1fr;
        }
    }
</style>
@endsection
