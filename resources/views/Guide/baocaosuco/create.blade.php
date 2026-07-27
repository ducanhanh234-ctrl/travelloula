@extends('layouts.guide')
@section('title', 'Tạo báo cáo sự cố')
@section('content')
<div class="container py-4">
    <h3 class="fw-bold">Tạo báo cáo sự cố</h3>
    <p class="text-muted">Mô tả chính xác để Admin xử lý nhanh hơn.</p>

    <div class="card border-0 shadow-sm mt-4">
        <div class="card-body p-4">
            <form method="POST" action="{{ route('Guide.baocaosuco.store') }}">
                @csrf

                @if($activeLichKhoiHanh)
                    <input type="hidden" name="lich_khoi_hanh_id" value="{{ $activeLichKhoiHanh->id }}">
                    <div class="alert alert-info mb-3">
                        <strong>Tour đang diễn ra:</strong>
                        #{{ $activeLichKhoiHanh->id }} - {{ $activeLichKhoiHanh->tour?->ten_tour ?? 'Tour' }}
                        @if($activeLichKhoiHanh->ngay_khoi_hanh)
                            - {{ \Illuminate\Support\Carbon::parse($activeLichKhoiHanh->ngay_khoi_hanh)->format('d/m/Y') }}
                        @endif
                    </div>
                @else
                    <div class="alert alert-warning mb-3">
                        Hiện tại bạn không có tour đang diễn ra nên không thể gửi báo cáo sự cố.
                    </div>
                @endif

                <div class="mb-3">
                    <label class="form-label fw-semibold">Tiêu đề</label>
                    <input name="tieu_de" value="{{ old('tieu_de') }}" class="form-control @error('tieu_de') is-invalid @enderror" required>
                    @error('tieu_de')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Loại sự cố</label>
                        <select name="loai_su_co" class="form-select" required>
                            <option value="">Chọn loại sự cố</option>
                            @foreach(\App\Models\BaoCaoSuCo::loaiSuCoList() as $value => $label)
                                <option value="{{ $value }}" @selected(old('loai_su_co') === $value)>{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Mức độ</label>
                        <select name="muc_do" class="form-select" required>
                            @foreach(\App\Models\BaoCaoSuCo::mucDoList() as $value => $label)
                                <option value="{{ $value }}" @selected(old('muc_do', 'trung_binh') === $value)>{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="form-label fw-semibold">Nội dung sự cố</label>
                    <textarea name="noi_dung" rows="8" class="form-control @error('noi_dung') is-invalid @enderror" required>{{ old('noi_dung') }}</textarea>
                    @error('noi_dung')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="d-flex justify-content-end gap-2">
                    <a href="{{ route('Guide.baocaosuco.index') }}" class="btn btn-light">Hủy</a>
                    <button class="btn btn-danger" @disabled(!$activeLichKhoiHanh)>
                        <i class="fas fa-paper-plane me-2"></i>Gửi báo cáo
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
