@extends('layouts.admin')

@section('title', 'Quản lý lịch khởi hành')

@section('content')
    <link rel="stylesheet" href="{{ asset('admin-assets/css/lich-khoi-hanh-index.css') }}">

    <div class="container-fluid departure-page fade-in">
        <div class="departure-page-top">
            <div class="departure-page-heading">
                <h3>Quản lý lịch khởi hành</h3>

                <p>
                    Theo dõi thời gian, số chỗ, giá bán và trạng thái các chuyến
                    khởi hành.
                </p>
            </div>

            <a href="{{ route('Admin.lich-khoi-hanh.create') }}" class="btn-add-departure">
                <i class="fas fa-plus"></i>
                Thêm lịch mới
            </a>
        </div>

        @if (session('success'))
            <div class="departure-alert">
                <i class="fas fa-check-circle"></i>
                {{ session('success') }}
            </div>
        @endif

        <div class="departure-stats-grid">
            <div class="departure-stat-card stat-primary">
                <span class="departure-stat-icon">
                    <i class="fas fa-calendar-alt"></i>
                </span>

                <div class="departure-stat-content">
                    <div class="departure-stat-value">
                        {{ $data->total() }}
                    </div>

                    <div class="departure-stat-label">
                        Tổng lịch khởi hành
                    </div>
                </div>
            </div>

            <div class="departure-stat-card stat-success">
                <span class="departure-stat-icon">
                    <i class="fas fa-check"></i>
                </span>

                <div class="departure-stat-content">
                    <div class="departure-stat-value">
                        {{ $moBan }}
                    </div>

                    <div class="departure-stat-label">
                        Đang mở bán
                    </div>
                </div>
            </div>

            <div class="departure-stat-card stat-warning">
                <span class="departure-stat-icon">
                    <i class="fas fa-route"></i>
                </span>

                <div class="departure-stat-content">
                    <div class="departure-stat-value">
                        {{ $dangDienRa }}
                    </div>

                    <div class="departure-stat-label">
                        Đang diễn ra
                    </div>
                </div>
            </div>

            <div class="departure-stat-card stat-danger">
                <span class="departure-stat-icon">
                    <i class="fas fa-users-slash"></i>
                </span>

                <div class="departure-stat-content">
                    <div class="departure-stat-value">
                        {{ $hetCho }}
                    </div>

                    <div class="departure-stat-label">
                        Đã hết chỗ
                    </div>
                </div>
            </div>

            <div class="departure-stat-card stat-neutral">
                <span class="departure-stat-icon">
                    <i class="fas fa-flag-checkered"></i>
                </span>

                <div class="departure-stat-content">
                    <div class="departure-stat-value">
                        {{ $daKetThuc }}
                    </div>

                    <div class="departure-stat-label">
                        Đã kết thúc
                    </div>
                </div>
            </div>

            <div class="departure-stat-card stat-dark">
                <span class="departure-stat-icon">
                    <i class="fas fa-lock"></i>
                </span>

                <div class="departure-stat-content">
                    <div class="departure-stat-value">
                        {{ $daDong }}
                    </div>

                    <div class="departure-stat-label">
                        Đã đóng
                    </div>
                </div>
            </div>
        </div>

        <div class="departure-card">
            <div class="departure-card-header">
                <div class="departure-card-heading">
                    <span class="departure-card-icon">
                        <i class="fas fa-plane-departure"></i>
                    </span>

                    <div>
                        <h4>Danh sách lịch khởi hành</h4>

                        <p>
                            Quản lý lịch chạy, hướng dẫn viên, số chỗ và giá bán.
                        </p>
                    </div>
                </div>

                <div class="departure-total">
                    <strong>{{ $data->total() }}</strong>
                    <span>Lịch khởi hành</span>
                </div>
            </div>

            <div class="departure-card-body">
                <div class="departure-filter-box">
                    <div class="departure-filter-title">
                        <i class="fas fa-filter"></i>
                        Bộ lọc lịch khởi hành
                    </div>

                    <form method="GET" action="{{ route('Admin.lich-khoi-hanh.index') }}" class="departure-filter-form">
                        <div class="departure-filter-field">
                            <label for="keyword">Tìm kiếm Tour</label>

                            <div class="filter-control">
                                <i class="fas fa-search filter-icon"></i>

                                <input type="text" name="keyword" id="keyword" class="form-control"
                                    placeholder="Nhập tên Tour..." value="{{ request('keyword') }}" autocomplete="off">
                            </div>
                        </div>

                        <div class="departure-filter-field">
                            <label for="status">Trạng thái</label>

                            <select name="status" id="status" class="form-select">
                                <option value="">
                                    Tất cả trạng thái
                                </option>

                                <option value="Mở bán" @selected(request('status') === 'Mở bán')>
                                    Mở bán
                                </option>

                                <option value="Đang diễn ra" @selected(request('status') === 'Đang diễn ra')>
                                    Đang diễn ra
                                </option>

                                <option value="Hết chỗ" @selected(request('status') === 'Hết chỗ')>
                                    Hết chỗ
                                </option>

                                <option value="Đã kết thúc" @selected(request('status') === 'Đã kết thúc')>
                                    Đã kết thúc
                                </option>

                                <option value="Đã đóng" @selected(request('status') === 'Đã đóng')>
                                    Đã đóng
                                </option>

                                <option value="Đã hủy" @selected(request('status') === 'Đã hủy')>
                                    Đã hủy
                                </option>
                            </select>
                        </div>

                        <div class="departure-filter-field">
                            <label for="from_date">Từ ngày</label>

                            <input type="date" name="from_date" id="from_date" class="form-control"
                                value="{{ request('from_date') }}">
                        </div>

                        <div class="departure-filter-field">
                            <label for="to_date">Đến ngày</label>

                            <input type="date" name="to_date" id="to_date" class="form-control"
                                value="{{ request('to_date') }}">
                        </div>

                        <button type="submit" class="btn-filter-action btn-filter">
                            <i class="fas fa-search"></i>
                            Tìm kiếm
                        </button>

                        <a href="{{ route('Admin.lich-khoi-hanh.index') }}" class="btn-filter-action btn-reset">
                            <i class="fas fa-sync-alt"></i>
                            Làm mới
                        </a>
                    </form>
                </div>

                <div class="departure-table-wrapper">
                    <table class="table departure-table">
                        <thead>
                            <tr>
                                <th>STT</th>
                                <th>Tour</th>
                                <th>Thời gian</th>
                                <th>Số chỗ</th>
                                <th>Giá</th>
                                <th>Trạng thái</th>
                                <th>Thao tác</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse ($data as $item)
                                @php
                                    $tyLe = $item->so_cho > 0 ? ($item->so_cho_da_dat / $item->so_cho) * 100 : 0;

                                    $seatClass = $tyLe < 50 ? 'seat-low' : ($tyLe < 80 ? 'seat-medium' : 'seat-high');

                                    $statusConfig = match ($item->trang_thai_hien_thi) {
                                        'Mở bán' => [
                                            'class' => 'status-open',
                                            'label' => 'Mở bán',
                                        ],
                                        'Đang diễn ra' => [
                                            'class' => 'status-running',
                                            'label' => 'Đang diễn ra',
                                        ],
                                        'Hết chỗ' => [
                                            'class' => 'status-full',
                                            'label' => 'Hết chỗ',
                                        ],
                                        'Đã kết thúc' => [
                                            'class' => 'status-ended',
                                            'label' => 'Đã kết thúc',
                                        ],
                                        'Đã đóng' => [
                                            'class' => 'status-closed',
                                            'label' => 'Đã đóng',
                                        ],
                                        'Đã chốt' => [
                                            'class' => 'status-finalized',
                                            'label' => 'Đã chốt',
                                        ],
                                        'Đã hủy' => [
                                            'class' => 'status-cancelled',
                                            'label' => 'Đã hủy',
                                        ],
                                        default => [
                                            'class' => 'status-ended',
                                            'label' => $item->trang_thai_hien_thi ?: 'Không xác định',
                                        ],
                                    };
                                @endphp

                                <tr>
                                    <td>
                                        <span class="departure-index">
                                            {{ ($data->currentPage() - 1) * $data->perPage() + $loop->iteration }}
                                        </span>
                                    </td>

                                    <td>
                                        <span class="tour-name" title="{{ $item->tour->ten_tour ?? 'Không có Tour' }}">
                                            {{ $item->tour->ten_tour ?? 'Không có Tour' }}
                                        </span>

                                        <span class="departure-code">
                                            <i class="fas fa-calendar-alt"></i>

                                            LKH-{{ str_pad($item->id, 3, '0', STR_PAD_LEFT) }}
                                        </span>

                                    <td>
                                        <div class="departure-date">
                                            <i class="fas fa-calendar-alt"></i>

                                            {{ \Carbon\Carbon::parse($item->ngay_khoi_hanh)->format('d/m/Y') }}
                                        </div>

                                        <div class="departure-end-date">
                                            đến
                                            {{ \Carbon\Carbon::parse($item->ngay_ket_thuc)->format('d/m/Y') }}
                                        </div>
                                    </td>

                                    <td>
                                        <span class="seat-badge {{ $seatClass }}">
                                            <i class="fas fa-users"></i>

                                            {{ $item->so_cho_da_dat }}/{{ $item->so_cho }}
                                        </span>

                                        <div class="remaining-seat">
                                            Còn {{ $item->so_cho_con_lai }} chỗ
                                        </div>

                                        @if ($item->da_gop)
                                            <div class="merged-note">
                                                <i class="fas fa-code-branch"></i>
                                                Gộp vào lịch
                                                #{{ $item->gop_vao_lich_id }}
                                            </div>
                                        @endif
                                    </td>

                                    <td>
                                        <div class="adult-price">
                                            Người lớn:
                                            {{ number_format($item->gia_nguoi_lon, 0, ',', '.') }}₫
                                        </div>

                                        <div class="child-price">
                                            Trẻ em:
                                            {{ number_format($item->gia_tre_em, 0, ',', '.') }}₫
                                        </div>
                                    </td>

                                    <td>
                                        @if ($item->trang_thai == 'finalized')
                                            <span class="departure-status status-finalized">
                                                <span class="status-dot"></span>
                                                Đã chốt
                                            </span>
                                        @elseif ($item->da_gop)
                                            <span class="departure-status status-merged">
                                                <span class="status-dot"></span>
                                                Đã gộp
                                            </span>
                                        @else
                                            <span class="departure-status {{ $statusConfig['class'] }}">
                                                <span class="status-dot"></span>
                                                {{ $statusConfig['label'] }}
                                            </span>
                                        @endif
                                    </td>

                                    <td>
                                        <div class="departure-actions">
                                            <a href="{{ route('Admin.lich-khoi-hanh.show', $item->id) }}"
                                                class="btn-table-action btn-view" title="Xem chi tiết">
                                                <i class="fas fa-eye"></i>
                                            </a>

                                            <a href="{{ route('Admin.lich-khoi-hanh.edit', $item->id) }}"
                                                class="btn-table-action btn-edit" title="Chỉnh sửa">
                                                <i class="fas fa-edit"></i>
                                            </a>

                                            @if ($item->coTheChot() && !$item->daDuocChot())
                                                <form action="{{ route('Admin.lich-khoi-hanh.chot', $item->id) }}"
                                                    method="POST">

                                                    @csrf
                                                    @method('PATCH')

                                                    <button class="btn-table-action btn-confirm" title="Chốt lịch">
                                                        <i class="fas fa-check"></i>
                                                    </button>

                                                </form>
                                            @endif

                                            <form action="{{ route('Admin.lich-khoi-hanh.destroy', $item->id) }}"
                                                method="POST">
                                                @csrf
                                                @method('DELETE')

                                                <button type="button" class="btn-table-action btn-delete"
                                                    title="Xóa lịch khởi hành">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="departure-empty-row">
                                        <div class="empty-state-icon">
                                            <i class="fas fa-calendar-times"></i>
                                        </div>

                                        <div class="empty-state-title">
                                            Chưa có lịch khởi hành
                                        </div>

                                        <div class="empty-state-text">
                                            Không tìm thấy dữ liệu phù hợp với
                                            điều kiện lọc.
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="departure-card-footer">
                <div class="departure-result-info">
                    @if ($data->total() > 0)
                        Hiển thị {{ $data->firstItem() }}
                        đến {{ $data->lastItem() }}
                        trong tổng số {{ $data->total() }} lịch khởi hành
                    @else
                        Không có lịch khởi hành nào
                    @endif
                </div>

                {{ $data->withQueryString()->links() }}
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document
                .querySelectorAll('.btn-delete')
                .forEach(function(button) {
                    button.addEventListener('click', function() {
                        const form = this.closest('form');

                        if (!form) {
                            return;
                        }

                        if (typeof Swal !== 'undefined') {
                            Swal.fire({
                                title: 'Xóa lịch khởi hành?',
                                text: 'Dữ liệu sau khi xóa sẽ không thể khôi phục.',
                                icon: 'warning',
                                showCancelButton: true,
                                confirmButtonText: 'Xóa',
                                cancelButtonText: 'Hủy',
                                confirmButtonColor: '#dc4c64',
                                cancelButtonColor: '#6b7895',
                                reverseButtons: true
                            }).then(function(result) {
                                if (result.isConfirmed) {
                                    form.submit();
                                }
                            });

                            return;
                        }

                        if (
                            confirm(
                                'Bạn có chắc muốn xóa lịch khởi hành này?'
                            )
                        ) {
                            form.submit();
                        }
                    });
                });
        });
    </script>
@endsection
