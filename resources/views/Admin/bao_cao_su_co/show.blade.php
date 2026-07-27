@extends('layouts.admin')

@section('title', 'Xử lý sự cố')

@section('content')
    <div class="container-fluid py-4">

        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
            <div>
                <h3 class="fw-bold mb-1">
                    {{ $baoCaoSuCo->tieu_de }}
                </h3>

                <p class="text-muted mb-0">
                    Báo cáo #{{ $baoCaoSuCo->id }}
                    từ
                    {{ $baoCaoSuCo->huongDanVien?->ho_ten ?? 'Hướng dẫn viên' }}
                </p>
            </div>

            <a href="{{ route('Admin.baocaosuco.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-2"></i>
                Quay lại
            </a>
        </div>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}

                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Đóng">
                </button>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}

                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Đóng">
                </button>
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger">
                <div class="fw-bold mb-2">
                    Vui lòng kiểm tra lại dữ liệu:
                </div>

                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="row g-4">

            {{-- Nội dung và cập nhật xử lý --}}
            <div class="col-lg-7">

                <div class="card border-0 shadow-sm">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-start gap-3 mb-3">
                            <h5 class="fw-bold mb-0">
                                Nội dung sự cố
                            </h5>

                            @php
                                $mucDoClass = match ($baoCaoSuCo->muc_do) {
                                    'thap' => 'bg-success',
                                    'trung_binh' => 'bg-warning text-dark',
                                    'cao' => 'bg-danger',
                                    'khan_cap' => 'bg-dark',
                                    default => 'bg-secondary',
                                };
                            @endphp

                            <span class="badge {{ $mucDoClass }}">
                                {{ $baoCaoSuCo->muc_do_text }}
                            </span>
                        </div>

                        <div class="text-muted" style="white-space: pre-line; line-height: 1.8;">
                            {{ $baoCaoSuCo->noi_dung }}
                        </div>
                    </div>
                </div>

                <div class="card border-0 shadow-sm mt-4">
                    <div class="card-body p-4">
                        <h5 class="fw-bold mb-3">
                            Cập nhật xử lý
                        </h5>

                        <form method="POST"
                            action="{{ route('Admin.baocaosuco.update', [
                                'id' => request()->route('id'),
                            ]) }}">

                            @csrf
                            @method('PUT')

                            <div class="mb-3">
                                <label for="trang_thai" class="form-label fw-semibold">
                                    Trạng thái
                                </label>

                                <select name="trang_thai" id="trang_thai"
                                    class="form-select @error('trang_thai') is-invalid @enderror" required>

                                    @foreach ([
            'da_tiep_nhan' => 'Đã tiếp nhận',
            'dang_xu_ly' => 'Đang xử lý',
            'da_xu_ly' => 'Đã xử lý',
            'tu_choi' => 'Từ chối',
        ] as $value => $label)
                                        <option value="{{ $value }}" @selected(old('trang_thai', $baoCaoSuCo->trang_thai) === $value)>
                                            {{ $label }}
                                        </option>
                                    @endforeach
                                </select>

                                @error('trang_thai')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="ghi_chu_xu_ly" class="form-label fw-semibold">
                                    Ghi chú hoặc phản hồi cho Guide
                                </label>

                                <textarea name="ghi_chu_xu_ly" id="ghi_chu_xu_ly" rows="7" maxlength="10000"
                                    class="form-control @error('ghi_chu_xu_ly') is-invalid @enderror"
                                    placeholder="Nhập nội dung xử lý hoặc phản hồi cho hướng dẫn viên...">{{ old('ghi_chu_xu_ly', $baoCaoSuCo->ghi_chu_xu_ly) }}</textarea>

                                @error('ghi_chu_xu_ly')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="d-flex justify-content-end">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save me-2"></i>
                                    Lưu xử lý
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            {{-- Thông tin báo cáo --}}
            <div class="col-lg-5">

                <div class="card border-0 shadow-sm">
                    <div class="card-body p-4">
                        <h5 class="fw-bold mb-3">
                            Thông tin báo cáo
                        </h5>

                        @php
                            $trangThaiClass = match ($baoCaoSuCo->trang_thai) {
                                'moi' => 'bg-danger',
                                'da_tiep_nhan' => 'bg-info text-dark',
                                'dang_xu_ly' => 'bg-warning text-dark',
                                'da_xu_ly' => 'bg-success',
                                'tu_choi' => 'bg-secondary',
                                default => 'bg-secondary',
                            };
                        @endphp

                        <dl class="row mb-0 gy-3">
                            <dt class="col-5">
                                Loại
                            </dt>

                            <dd class="col-7 mb-0">
                                {{ $baoCaoSuCo->loai_su_co_text }}
                            </dd>

                            <dt class="col-5">
                                Mức độ
                            </dt>

                            <dd class="col-7 mb-0">
                                {{ $baoCaoSuCo->muc_do_text }}
                            </dd>

                            <dt class="col-5">
                                Trạng thái
                            </dt>

                            <dd class="col-7 mb-0">
                                <span class="badge {{ $trangThaiClass }}">
                                    {{ $baoCaoSuCo->trang_thai_text }}
                                </span>
                            </dd>

                            <dt class="col-5">
                                Guide
                            </dt>

                            <dd class="col-7 mb-0">
                                {{ $baoCaoSuCo->huongDanVien?->ho_ten ?? '—' }}
                            </dd>

                            <dt class="col-5">
                                Admin xử lý
                            </dt>

                            <dd class="col-7 mb-0">
                                {{ $baoCaoSuCo->adminXuLy?->name ?? 'Chưa tiếp nhận' }}
                            </dd>

                            <dt class="col-5">
                                Ngày gửi
                            </dt>

                            <dd class="col-7 mb-0">
                                {{ $baoCaoSuCo->created_at?->format('d/m/Y H:i') ?? '—' }}
                            </dd>

                            <dt class="col-5">
                                Tiếp nhận
                            </dt>

                            <dd class="col-7 mb-0">
                                {{ $baoCaoSuCo->thoi_gian_tiep_nhan?->format('d/m/Y H:i') ?? '—' }}
                            </dd>

                            <dt class="col-5">
                                Hoàn thành
                            </dt>

                            <dd class="col-7 mb-0">
                                {{ $baoCaoSuCo->thoi_gian_xu_ly?->format('d/m/Y H:i') ?? '—' }}
                            </dd>
                        </dl>

                        @if ($baoCaoSuCo->trang_thai === 'moi')
                            <form method="POST"
                                action="{{ route('Admin.baocaosuco.tiep-nhan', [
                                    'id' => request()->route('id'),
                                ]) }}"
                                class="mt-4">

                                @csrf

                                <button type="submit" class="btn btn-success w-100">
                                    <i class="fas fa-hand me-2"></i>
                                    Tiếp nhận sự cố
                                </button>
                            </form>
                        @endif
                    </div>
                </div>

                @if (!empty($baoCaoSuCo->ghi_chu_xu_ly))
                    <div class="card border-0 shadow-sm mt-4">
                        <div class="card-body p-4">
                            <h5 class="fw-bold mb-3">
                                Phản hồi hiện tại
                            </h5>

                            <div class="text-muted" style="white-space: pre-line; line-height: 1.8;">
                                {{ $baoCaoSuCo->ghi_chu_xu_ly }}
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
