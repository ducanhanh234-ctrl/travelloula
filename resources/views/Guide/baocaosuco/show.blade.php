@extends('layouts.guide')

@section('title', 'Chi tiết báo cáo sự cố')

@section('content')
<div class="container-fluid py-4">

    {{-- Tiêu đề --}}
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
        <div>
            <h3 class="fw-bold mb-1">
                Chi tiết báo cáo sự cố
            </h3>

            <p class="text-muted mb-0">
                Báo cáo #{{ $baoCaoSuCo->id }}
            </p>
        </div>

        <a href="{{ route('Guide.baocaosuco.index') }}"
           class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-2"></i>
            Quay lại danh sách
        </a>
    </div>

    {{-- Thông báo --}}
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}

            <button type="button"
                    class="btn-close"
                    data-bs-dismiss="alert"
                    aria-label="Đóng">
            </button>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}

            <button type="button"
                    class="btn-close"
                    data-bs-dismiss="alert"
                    aria-label="Đóng">
            </button>
        </div>
    @endif

    @php
        $trangThaiText = match ($baoCaoSuCo->trang_thai) {
            'moi' => 'Mới gửi',
            'da_tiep_nhan' => 'Đã tiếp nhận',
            'dang_xu_ly' => 'Đang xử lý',
            'da_xu_ly' => 'Đã xử lý',
            'tu_choi' => 'Từ chối',
            default => ucfirst(str_replace('_', ' ', $baoCaoSuCo->trang_thai)),
        };

        $trangThaiClass = match ($baoCaoSuCo->trang_thai) {
            'moi' => 'bg-danger',
            'da_tiep_nhan' => 'bg-info text-dark',
            'dang_xu_ly' => 'bg-warning text-dark',
            'da_xu_ly' => 'bg-success',
            'tu_choi' => 'bg-secondary',
            default => 'bg-secondary',
        };

        $mucDoText = match ($baoCaoSuCo->muc_do) {
            'thap' => 'Thấp',
            'trung_binh' => 'Trung bình',
            'cao' => 'Cao',
            'khan_cap' => 'Khẩn cấp',
            default => ucfirst(str_replace('_', ' ', $baoCaoSuCo->muc_do)),
        };

        $mucDoClass = match ($baoCaoSuCo->muc_do) {
            'thap' => 'bg-success',
            'trung_binh' => 'bg-warning text-dark',
            'cao' => 'bg-danger',
            'khan_cap' => 'bg-dark',
            default => 'bg-secondary',
        };

        $loaiSuCoText = match ($baoCaoSuCo->loai_su_co) {
            'phuong_tien' => 'Phương tiện',
            'lich_trinh' => 'Lịch trình',
            'khach_hang' => 'Khách hàng',
            'dich_vu' => 'Dịch vụ',
            'an_ninh' => 'An ninh',
            'suc_khoe' => 'Sức khỏe',
            'khac' => 'Khác',
            default => ucfirst(str_replace('_', ' ', $baoCaoSuCo->loai_su_co)),
        };
    @endphp

    <div class="row g-4">

        {{-- Nội dung báo cáo --}}
        <div class="col-lg-8">

            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">

                    <div class="d-flex justify-content-between align-items-start flex-wrap gap-3 mb-4">
                        <div>
                            <h4 class="fw-bold mb-2">
                                {{ $baoCaoSuCo->tieu_de }}
                            </h4>

                            <div class="text-muted">
                                Gửi lúc
                                {{ $baoCaoSuCo->created_at?->format('d/m/Y H:i') ?? '—' }}
                            </div>
                        </div>

                        <div class="d-flex gap-2 flex-wrap">
                            <span class="badge {{ $mucDoClass }} px-3 py-2">
                                {{ $mucDoText }}
                            </span>

                            <span class="badge {{ $trangThaiClass }} px-3 py-2">
                                {{ $trangThaiText }}
                            </span>
                        </div>
                    </div>

                    <hr>

                    <h6 class="fw-bold mb-3">
                        Nội dung sự cố
                    </h6>

                    <div style="white-space: pre-line; line-height: 1.8;">
                        {{ $baoCaoSuCo->noi_dung }}
                    </div>
                </div>
            </div>

            {{-- Phản hồi từ Admin --}}
            <div class="card border-0 shadow-sm mt-4">
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-3">
                        <i class="fas fa-comment-dots me-2"></i>
                        Phản hồi từ Admin
                    </h5>

                    @if (!empty($baoCaoSuCo->ghi_chu_xu_ly))
                        <div class="alert alert-light border mb-0"
                             style="white-space: pre-line; line-height: 1.8;">
                            {{ $baoCaoSuCo->ghi_chu_xu_ly }}
                        </div>
                    @else
                        <div class="text-muted">
                            Admin chưa gửi phản hồi cho báo cáo này.
                        </div>
                    @endif
                </div>
            </div>

            {{-- Tiến trình xử lý --}}
            <div class="card border-0 shadow-sm mt-4">
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-4">
                        <i class="fas fa-clock me-2"></i>
                        Tiến trình xử lý
                    </h5>

                    <div class="d-flex gap-3 mb-4">
                        <div>
                            <span class="badge rounded-pill bg-primary p-2">
                                <i class="fas fa-paper-plane"></i>
                            </span>
                        </div>

                        <div>
                            <div class="fw-bold">
                                Đã gửi báo cáo
                            </div>

                            <div class="text-muted small">
                                {{ $baoCaoSuCo->created_at?->format('d/m/Y H:i') ?? '—' }}
                            </div>
                        </div>
                    </div>

                    <div class="d-flex gap-3 mb-4">
                        <div>
                            <span class="badge rounded-pill
                                {{ $baoCaoSuCo->thoi_gian_tiep_nhan ? 'bg-info text-dark' : 'bg-secondary' }}
                                p-2">
                                <i class="fas fa-hand"></i>
                            </span>
                        </div>

                        <div>
                            <div class="fw-bold">
                                Admin tiếp nhận
                            </div>

                            <div class="text-muted small">
                                @if ($baoCaoSuCo->thoi_gian_tiep_nhan)
                                    {{ $baoCaoSuCo->thoi_gian_tiep_nhan->format('d/m/Y H:i') }}
                                @else
                                    Chưa tiếp nhận
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="d-flex gap-3">
                        <div>
                            <span class="badge rounded-pill
                                {{ $baoCaoSuCo->thoi_gian_xu_ly ? 'bg-success' : 'bg-secondary' }}
                                p-2">
                                <i class="fas fa-check"></i>
                            </span>
                        </div>

                        <div>
                            <div class="fw-bold">
                                Hoàn thành xử lý
                            </div>

                            <div class="text-muted small">
                                @if ($baoCaoSuCo->thoi_gian_xu_ly)
                                    {{ $baoCaoSuCo->thoi_gian_xu_ly->format('d/m/Y H:i') }}
                                @else
                                    Chưa hoàn thành
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Thông tin bên phải --}}
        <div class="col-lg-4">

            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-4">
                        Thông tin báo cáo
                    </h5>

                    <dl class="row gy-3 mb-0">
                        <dt class="col-5">
                            Mã báo cáo
                        </dt>

                        <dd class="col-7 mb-0">
                            #{{ $baoCaoSuCo->id }}
                        </dd>

                        <dt class="col-5">
                            Loại sự cố
                        </dt>

                        <dd class="col-7 mb-0">
                            {{ $loaiSuCoText }}
                        </dd>

                        <dt class="col-5">
                            Mức độ
                        </dt>

                        <dd class="col-7 mb-0">
                            <span class="badge {{ $mucDoClass }}">
                                {{ $mucDoText }}
                            </span>
                        </dd>

                        <dt class="col-5">
                            Trạng thái
                        </dt>

                        <dd class="col-7 mb-0">
                            <span class="badge {{ $trangThaiClass }}">
                                {{ $trangThaiText }}
                            </span>
                        </dd>

                        <dt class="col-5">
                            Ngày gửi
                        </dt>

                        <dd class="col-7 mb-0">
                            {{ $baoCaoSuCo->created_at?->format('d/m/Y H:i') ?? '—' }}
                        </dd>

                        <dt class="col-5">
                            Admin xử lý
                        </dt>

                        <dd class="col-7 mb-0">
                            {{ $baoCaoSuCo->adminXuLy?->name
                                ?? $baoCaoSuCo->adminXuLy?->ho_ten
                                ?? 'Chưa tiếp nhận' }}
                        </dd>
                    </dl>
                </div>
            </div>

            {{-- Thông tin tour --}}
            <div class="card border-0 shadow-sm mt-4">
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-4">
                        Thông tin tour
                    </h5>

                    @if ($baoCaoSuCo->lichKhoiHanh)
                        <dl class="row gy-3 mb-0">
                            <dt class="col-5">
                                Tour
                            </dt>

                            <dd class="col-7 mb-0">
                                {{ $baoCaoSuCo->lichKhoiHanh->tour?->ten_tour
                                    ?? $baoCaoSuCo->lichKhoiHanh->tour?->ten
                                    ?? 'Tour #' . $baoCaoSuCo->lich_khoi_hanh_id }}
                            </dd>

                            <dt class="col-5">
                                Khởi hành
                            </dt>

                            <dd class="col-7 mb-0">
                                {{ $baoCaoSuCo->lichKhoiHanh->ngay_khoi_hanh?->format('d/m/Y') ?? '—' }}
                            </dd>

                            <dt class="col-5">
                                Kết thúc
                            </dt>

                            <dd class="col-7 mb-0">
                                {{ $baoCaoSuCo->lichKhoiHanh->ngay_ket_thuc?->format('d/m/Y') ?? '—' }}
                            </dd>
                        </dl>
                    @else
                        <div class="text-muted">
                            Không tìm thấy thông tin lịch khởi hành.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
