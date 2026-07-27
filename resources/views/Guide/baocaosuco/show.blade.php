@extends('layouts.guide')
@section('title', 'Chi tiết sự cố')
@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div><h3 class="fw-bold mb-1">{{ $baoCaoSuCo->tieu_de }}</h3><p class="text-muted mb-0">Báo cáo #{{ $baoCaoSuCo->id }}</p></div>
        <a href="{{ route('Guide.baocaosuco.index') }}" class="btn btn-outline-secondary">Quay lại</a>
    </div>

    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm"><div class="card-body p-4">
                <h5 class="fw-bold">Nội dung sự cố</h5>
                <div class="mt-3" style="white-space: pre-line">{{ $baoCaoSuCo->noi_dung }}</div>
            </div></div>

            <div class="card border-0 shadow-sm mt-4"><div class="card-body p-4">
                <h5 class="fw-bold">Phản hồi của Admin</h5>
                <div class="mt-3" style="white-space: pre-line">{{ $baoCaoSuCo->ghi_chu_xu_ly ?: 'Admin chưa có phản hồi.' }}</div>
            </div></div>
        </div>

        <div class="col-lg-4">
            <div class="card border-0 shadow-sm"><div class="card-body p-4">
                <dl class="row mb-0">
                    <dt class="col-5">Loại</dt><dd class="col-7">{{ $baoCaoSuCo->loai_su_co_text }}</dd>
                    <dt class="col-5">Mức độ</dt><dd class="col-7">{{ $baoCaoSuCo->muc_do_text }}</dd>
                    <dt class="col-5">Trạng thái</dt><dd class="col-7">{{ $baoCaoSuCo->trang_thai_text }}</dd>
                    <dt class="col-5">Admin</dt><dd class="col-7">{{ $baoCaoSuCo->adminXuLy?->name ?? 'Chưa tiếp nhận' }}</dd>
                    <dt class="col-5">Ngày gửi</dt><dd class="col-7">{{ $baoCaoSuCo->created_at?->format('d/m/Y H:i') }}</dd>
                </dl>
            </div></div>
        </div>
    </div>
</div>
@endsection
