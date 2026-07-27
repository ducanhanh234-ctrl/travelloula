@extends('layouts.guide')

@section('title', 'Báo cáo sự cố')

@section('content')
    <div class="container-fluid py-4">
        {{-- Header --}}
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
            <div>
                <h3 class="fw-bold mb-1">
                    Báo cáo sự cố
                </h3>

                <p class="text-muted mb-0">
                    Theo dõi các sự cố đã gửi đến Admin.
                </p>
            </div>

            <a
                href="{{ route('Guide.baocaosuco.create') }}"
                class="btn btn-primary"
            >
                <i class="fas fa-plus me-2"></i>
                Báo cáo sự cố
            </a>
        </div>

        {{-- Thông báo --}}
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        {{-- Thống kê --}}
        <div class="row g-3 mb-4">
            @foreach ([
                ['Tổng báo cáo', $thongKe['tong'], 'primary'],
                ['Mới', $thongKe['moi'], 'danger'],
                ['Đang xử lý', $thongKe['dang_xu_ly'], 'warning'],
                ['Đã xử lý', $thongKe['da_xu_ly'], 'success'],
            ] as [$label, $value, $color])
                <div class="col-md-3 col-sm-6">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body">
                            <div class="text-muted small">
                                {{ $label }}
                            </div>

                            <div class="fs-3 fw-bold text-{{ $color }}">
                                {{ $value }}
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="card border-0 shadow-sm">
            {{-- Bộ lọc --}}
            <div class="card-body border-bottom">
                <form method="GET" class="row g-2">
                    <div class="col-md-5">
                        <input
                            type="text"
                            name="keyword"
                            value="{{ request('keyword') }}"
                            class="form-control"
                            placeholder="Tìm tiêu đề hoặc nội dung..."
                        >
                    </div>

                    <div class="col-md-3">
                        <select name="trang_thai" class="form-select">
                            <option value="">
                                Tất cả trạng thái
                            </option>

                            @foreach (\App\Models\BaoCaoSuCo::trangThaiList() as $value => $label)
                                <option
                                    value="{{ $value }}"
                                    @selected(request('trang_thai') === $value)
                                >
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-2">
                        <select name="muc_do" class="form-select">
                            <option value="">
                                Tất cả mức độ
                            </option>

                            @foreach (\App\Models\BaoCaoSuCo::mucDoList() as $value => $label)
                                <option
                                    value="{{ $value }}"
                                    @selected(request('muc_do') === $value)
                                >
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-2 d-grid">
                        <button class="btn btn-outline-primary">
                            <i class="fas fa-filter me-1"></i>
                            Lọc
                        </button>
                    </div>
                </form>
            </div>

            {{-- Bảng --}}
            <div class="table-responsive">
                <table class="table align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Sự cố</th>
                            <th>Mức độ</th>
                            <th>Trạng thái báo cáo</th>
                            <th>Phân công</th>
                            <th>Khởi hành</th>
                            <th>Ngày gửi</th>
                            <th></th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($baoCaos as $baoCao)
                            @php
                                $lichKhoiHanh = $baoCao->lichKhoiHanh;

                                /*
                                |--------------------------------------------------------------------------
                                | Trạng thái phân công
                                |--------------------------------------------------------------------------
                                | Dựa vào quan hệ huongDanVien của lịch khởi hành.
                                */
                                $daPhanCong = !empty(
                                    $lichKhoiHanh?->huongDanVien
                                );

                                $trangThaiPhanCongText = $daPhanCong
                                    ? 'Đã phân công'
                                    : 'Chưa phân công';

                                $trangThaiPhanCongClass = $daPhanCong
                                    ? 'bg-success-subtle text-success border border-success-subtle'
                                    : 'bg-secondary-subtle text-secondary border border-secondary-subtle';

                                /*
                                |--------------------------------------------------------------------------
                                | Trạng thái khởi hành
                                |--------------------------------------------------------------------------
                                | Tự tính theo ngày bắt đầu và ngày kết thúc.
                                */
                                $homNay = now()->startOfDay();

                                $ngayKhoiHanh = $lichKhoiHanh?->ngay_khoi_hanh
                                    ? \Carbon\Carbon::parse(
                                        $lichKhoiHanh->ngay_khoi_hanh
                                    )->startOfDay()
                                    : null;

                                $ngayKetThuc = $lichKhoiHanh?->ngay_ket_thuc
                                    ? \Carbon\Carbon::parse(
                                        $lichKhoiHanh->ngay_ket_thuc
                                    )->endOfDay()
                                    : null;

                                if (!$lichKhoiHanh || !$ngayKhoiHanh) {
                                    $trangThaiKhoiHanhText = 'Chưa có lịch';
                                    $trangThaiKhoiHanhClass =
                                        'bg-secondary-subtle text-secondary border border-secondary-subtle';
                                    $trangThaiKhoiHanhIcon =
                                        'fa-calendar-xmark';
                                } elseif ($homNay->lt($ngayKhoiHanh)) {
                                    $trangThaiKhoiHanhText =
                                        'Chưa khởi hành';
                                    $trangThaiKhoiHanhClass =
                                        'bg-info-subtle text-info-emphasis border border-info-subtle';
                                    $trangThaiKhoiHanhIcon =
                                        'fa-hourglass-start';
                                } elseif (
                                    $ngayKetThuc &&
                                    now()->gt($ngayKetThuc)
                                ) {
                                    $trangThaiKhoiHanhText =
                                        'Đã kết thúc';
                                    $trangThaiKhoiHanhClass =
                                        'bg-success-subtle text-success border border-success-subtle';
                                    $trangThaiKhoiHanhIcon =
                                        'fa-flag-checkered';
                                } else {
                                    $trangThaiKhoiHanhText =
                                        'Đang diễn ra';
                                    $trangThaiKhoiHanhClass =
                                        'bg-warning-subtle text-warning-emphasis border border-warning-subtle';
                                    $trangThaiKhoiHanhIcon =
                                        'fa-route';
                                }

                                /*
                                |--------------------------------------------------------------------------
                                | Màu trạng thái báo cáo
                                |--------------------------------------------------------------------------
                                */
                                $trangThaiBaoCaoClass = match (
                                    $baoCao->trang_thai
                                ) {
                                    'moi' =>
                                        'bg-danger-subtle text-danger border border-danger-subtle',

                                    'da_tiep_nhan' =>
                                        'bg-info-subtle text-info-emphasis border border-info-subtle',

                                    'dang_xu_ly' =>
                                        'bg-warning-subtle text-warning-emphasis border border-warning-subtle',

                                    'da_xu_ly' =>
                                        'bg-success-subtle text-success border border-success-subtle',

                                    'tu_choi' =>
                                        'bg-secondary-subtle text-secondary border border-secondary-subtle',

                                    default =>
                                        'bg-secondary-subtle text-secondary border border-secondary-subtle',
                                };

                                /*
                                |--------------------------------------------------------------------------
                                | Màu mức độ
                                |--------------------------------------------------------------------------
                                */
                                $mucDoClass = match ($baoCao->muc_do) {
                                    'thap' =>
                                        'bg-success-subtle text-success border border-success-subtle',

                                    'trung_binh' =>
                                        'bg-warning-subtle text-warning-emphasis border border-warning-subtle',

                                    'cao' =>
                                        'bg-danger-subtle text-danger border border-danger-subtle',

                                    'khan_cap' =>
                                        'bg-dark text-white border border-dark',

                                    default =>
                                        'bg-secondary-subtle text-secondary border border-secondary-subtle',
                                };
                            @endphp

                            <tr>
                                <td>
                                    <span class="fw-semibold text-muted">
                                        #{{ $baoCao->id }}
                                    </span>
                                </td>

                                <td style="min-width: 230px;">
                                    <strong class="d-block">
                                        {{ $baoCao->tieu_de }}
                                    </strong>

                                    <small class="text-muted">
                                        {{ $baoCao->loai_su_co_text }}
                                    </small>

                                    @if ($lichKhoiHanh)
                                        <div class="small text-primary mt-1">
                                            <i class="fas fa-map-location-dot me-1"></i>

                                            {{
                                                $lichKhoiHanh->tour?->ten_tour
                                                ?? 'Tour không xác định'
                                            }}
                                        </div>
                                    @endif
                                </td>

                                <td>
                                    <span class="badge rounded-pill {{ $mucDoClass }}">
                                        {{ $baoCao->muc_do_text }}
                                    </span>
                                </td>

                                <td>
                                    <span class="badge rounded-pill {{ $trangThaiBaoCaoClass }}">
                                        {{ $baoCao->trang_thai_text }}
                                    </span>
                                </td>

                                {{-- Trạng thái phân công --}}
                                <td>
                                    <span class="badge rounded-pill {{ $trangThaiPhanCongClass }}">
                                        <i class="fas fa-user-tie me-1"></i>
                                        {{ $trangThaiPhanCongText }}
                                    </span>

                                    @if ($daPhanCong)
                                        <div class="small text-muted mt-1">
                                            {{
                                                $lichKhoiHanh
                                                    ?->huongDanVien
                                                    ?->ho_ten
                                                ?? ''
                                            }}
                                        </div>
                                    @endif
                                </td>

                                {{-- Trạng thái khởi hành --}}
                                <td>
                                    <span class="badge rounded-pill {{ $trangThaiKhoiHanhClass }}">
                                        <i class="fas {{ $trangThaiKhoiHanhIcon }} me-1"></i>
                                        {{ $trangThaiKhoiHanhText }}
                                    </span>

                                    @if ($ngayKhoiHanh)
                                        <div class="small text-muted mt-1">
                                            {{ $ngayKhoiHanh->format('d/m/Y') }}

                                            @if ($ngayKetThuc)
                                                –
                                                {{ $ngayKetThuc->format('d/m/Y') }}
                                            @endif
                                        </div>
                                    @endif
                                </td>

                                <td class="text-nowrap">
                                    {{
                                        $baoCao->created_at?->format(
                                            'd/m/Y H:i'
                                        )
                                        ?? '—'
                                    }}
                                </td>

                                <td class="text-end">
                                    <a
                                        href="{{ route(
                                            'Guide.baocaosuco.show',
                                            ['id' => $baoCao->id]
                                        ) }}"
                                        class="btn btn-sm btn-outline-primary text-nowrap"
                                    >
                                        <i class="fas fa-eye me-1"></i>
                                        Xem
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td
                                    colspan="8"
                                    class="text-center py-5 text-muted"
                                >
                                    <i class="fas fa-triangle-exclamation fa-2x mb-3 d-block"></i>
                                    Chưa có báo cáo sự cố.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if ($baoCaos->hasPages())
                <div class="card-footer bg-white">
                    {{
                        $baoCaos->links(
                            'pagination::bootstrap-5'
                        )
                    }}
                </div>
            @endif
        </div>
    </div>
@endsection
