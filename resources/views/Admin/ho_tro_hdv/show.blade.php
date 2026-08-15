@extends('Layouts.admin')

@section('title', 'Xử lý hỗ trợ HDV')
@section('admin', 'Xử lý hỗ trợ HDV')

@section('content')
<style>
    .support-card{border:1px solid #dce6f5;border-radius:14px;overflow:hidden;
        box-shadow:0 9px 28px rgba(28,65,139,.08)}
    .support-head{padding:17px 19px;color:#fff;background:linear-gradient(135deg,#315be8,#5b4dea)}
    .info-box{padding:12px;background:#f8faff;border:1px solid #e0e8f5;border-radius:10px}
</style>

<div class="container-fluid">
    @if(session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif
    @if(session('error'))<div class="alert alert-danger">{{ session('error') }}</div>@endif
    @if($errors->any())
        <div class="alert alert-danger">
            @foreach($errors->all() as $error)<div>{{ $error }}</div>@endforeach
        </div>
    @endif

    <div class="mb-3">
        <a href="{{ route('Admin.ho-tro-hdv.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-1"></i>Quay lại
        </a>
    </div>

    <div class="card support-card">
        <div class="support-head">
            <h4 class="mb-1">Xử lý yêu cầu hỗ trợ</h4>
            <div class="small opacity-75">Yêu cầu #{{ $yeuCau->id }}</div>
        </div>

        <div class="card-body">
            <div class="row g-3 mb-4">
                <div class="col-md-6">
                    <div class="info-box">
                        <div class="text-muted small">Tour</div>
                        <strong>{{ $yeuCau->lichKhoiHanh->tour->ten_tour ?? 'Tour' }}</strong>
                        <div class="small mt-1">
                            Khởi hành:
                            {{ \Carbon\Carbon::parse($yeuCau->lichKhoiHanh->ngay_khoi_hanh)->format('d/m/Y') }}
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="info-box">
                        <div class="text-muted small">HDV hiện tại</div>
                        <strong>{{ $yeuCau->huongDanVien->ho_ten ?? '—' }}</strong>
                    </div>
                </div>

                <div class="col-12">
                    <div class="info-box">
                        <div class="text-muted small mb-1">Lý do yêu cầu thay HDV</div>
                        {{ $yeuCau->ly_do }}
                    </div>
                </div>
            </div>

            @if($yeuCau->trang_thai === 'cho_xu_ly')
                <div class="row g-4">
                    <div class="col-lg-7">
                        <form action="{{ route('Admin.ho-tro-hdv.approve', $yeuCau->id) }}"
                            method="POST">
                            @csrf
                            <h5 class="mb-3">Xác nhận thay HDV</h5>

                            <div class="mb-3">
                                <label class="form-label fw-semibold">HDV thay thế</label>
                                <select name="huong_dan_vien_thay_the_id"
                                    class="form-select" required>
                                    <option value="">-- Chọn HDV --</option>
                                    @foreach($guides as $guide)
                                        <option value="{{ $guide->id }}">
                                            {{ $guide->ho_ten ?? ('HDV #' . $guide->id) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold">Phản hồi cho HDV</label>
                                <textarea name="phan_hoi_admin" class="form-control"
                                    rows="4" maxlength="1000"
                                    placeholder="Ví dụ: Đã bố trí HDV thay thế..."></textarea>
                            </div>

                            <button type="submit" class="btn btn-success"
                                onclick="return confirm('Xác nhận thay hướng dẫn viên cho tour này?');">
                                <i class="fas fa-user-check me-1"></i>Xác nhận thay HDV
                            </button>
                        </form>
                    </div>

                    <div class="col-lg-5">
                        <form action="{{ route('Admin.ho-tro-hdv.reject', $yeuCau->id) }}"
                            method="POST">
                            @csrf
                            <h5 class="mb-3">Từ chối yêu cầu</h5>

                            <div class="mb-3">
                                <label class="form-label fw-semibold">Lý do từ chối</label>
                                <textarea name="phan_hoi_admin" class="form-control"
                                    rows="4" maxlength="1000" required></textarea>
                            </div>

                            <button type="submit" class="btn btn-danger"
                                onclick="return confirm('Bạn chắc chắn muốn từ chối yêu cầu này?');">
                                <i class="fas fa-times me-1"></i>Từ chối
                            </button>
                        </form>
                    </div>
                </div>
            @else
                <div class="alert alert-secondary mb-0">
                    <strong>Yêu cầu đã được xử lý.</strong>
                    <div class="mt-2">
                        Trạng thái:
                        {{ $yeuCau->trang_thai === 'da_xu_ly' ? 'Đã thay HDV' : 'Đã từ chối' }}
                    </div>
                    @if($yeuCau->huongDanVienThayThe)
                        <div class="mt-1">
                            HDV thay thế:
                            <strong>{{ $yeuCau->huongDanVienThayThe->ho_ten }}</strong>
                        </div>
                    @endif
                    @if($yeuCau->phan_hoi_admin)
                        <div class="mt-1">Phản hồi: {{ $yeuCau->phan_hoi_admin }}</div>
                    @endif
                    @if($yeuCau->thoi_gian_xu_ly)
                        <div class="mt-1">
                            Xử lý lúc: {{ $yeuCau->thoi_gian_xu_ly->format('H:i d/m/Y') }}
                        </div>
                    @endif
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
