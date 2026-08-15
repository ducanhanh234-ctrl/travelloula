@extends('Layouts.guide')

@section('title', 'Hỗ trợ')
@section('guide', 'Hỗ trợ')

@section('content')
<style>
    :root{
        --sp:#315be8; --sp2:#5b4dea; --navy:#203e78;
        --muted:#7f8ca4; --border:#dce6f5;
    }
    .support-page{padding-bottom:28px}
    .support-head{display:flex;align-items:center;gap:12px;margin-bottom:18px}
    .support-head-icon{width:46px;height:46px;border-radius:12px;color:#fff;
        background:linear-gradient(135deg,var(--sp),var(--sp2));
        display:flex;align-items:center;justify-content:center}
    .support-title{margin:0;color:var(--navy);font-size:22px;font-weight:800}
    .support-subtitle{margin-top:4px;color:var(--muted);font-size:11px}
    .support-card{border:1px solid var(--border);border-radius:14px;overflow:hidden;
        box-shadow:0 8px 24px rgba(28,65,139,.07)}
    .support-card-head{padding:14px 16px;color:#fff;
        background:linear-gradient(135deg,var(--sp),var(--sp2));font-weight:800}
    .tour-row{padding:14px 16px;border-bottom:1px solid #e9eef7;
        display:flex;align-items:center;justify-content:space-between;gap:14px}
    .tour-row:last-child{border-bottom:0}
    .tour-name{color:#26447d;font-weight:800;font-size:12px}
    .tour-meta{margin-top:4px;color:#8794aa;font-size:10px}
    .btn-support{padding:8px 12px;color:#fff;border:0;border-radius:8px;
        background:linear-gradient(135deg,var(--sp),var(--sp2));font-size:10px;font-weight:750}
    .support-status{padding:5px 8px;border-radius:999px;font-size:9px;font-weight:750}
    .waiting{color:#9a630f;background:#fff7e7}
    .done{color:#08754a;background:#eaf9f1}
    .reject{color:#bd3850;background:#fff0f3}
</style>

<div class="container-fluid support-page">
    <div class="support-head">
        <span class="support-head-icon"><i class="fas fa-headset"></i></span>
        <div>
            <h2 class="support-title">Hỗ trợ</h2>
            <div class="support-subtitle">
                Gửi yêu cầu thay hướng dẫn viên trước khi tour khởi hành.
            </div>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif
    @if($errors->any())
        <div class="alert alert-danger">
            @foreach($errors->all() as $error)
                <div>{{ $error }}</div>
            @endforeach
        </div>
    @endif

    <div class="card support-card mb-4">
        <div class="support-card-head">
            <i class="fas fa-route me-2"></i>Tour có thể gửi yêu cầu
        </div>

        <div class="card-body p-0">
            @forelse($lichKhoiHanhs as $lich)
                @php $pending = $pendingBySchedule[$lich->id] ?? null; @endphp

                <div class="tour-row">
                    <div>
                        <div class="tour-name">{{ $lich->tour->ten_tour ?? 'Tour' }}</div>
                        <div class="tour-meta">
                            Khởi hành:
                            {{ \Carbon\Carbon::parse($lich->ngay_khoi_hanh)->format('d/m/Y') }}
                            · Lịch #{{ $lich->id }}
                        </div>
                    </div>

                    <div>
                        @if($pending)
                            <span class="support-status waiting">
                                <i class="fas fa-clock me-1"></i>Đang chờ Admin xử lý
                            </span>
                        @else
                            <button type="button" class="btn-support"
                                data-bs-toggle="modal"
                                data-bs-target="#supportModal{{ $lich->id }}">
                                <i class="fas fa-headset me-1"></i>Yêu cầu hỗ trợ
                            </button>
                        @endif
                    </div>
                </div>

                @if(!$pending)
                    <div class="modal fade" id="supportModal{{ $lich->id }}"
                        tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <form action="{{ route('Guide.ho-tro.store') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="lich_khoi_hanh_id" value="{{ $lich->id }}">

                                    <div class="modal-header">
                                        <h5 class="modal-title">Yêu cầu hỗ trợ</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>

                                    <div class="modal-body">
                                        <div class="alert alert-info">
                                            Chức năng hiện tại:
                                            <strong>Thay HDV trước khởi hành</strong>.
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">Tour</label>
                                            <div class="form-control bg-light">
                                                {{ $lich->tour->ten_tour ?? 'Tour' }} -
                                                {{ \Carbon\Carbon::parse($lich->ngay_khoi_hanh)->format('d/m/Y') }}
                                            </div>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label fw-semibold">
                                                Lý do cần thay HDV <span class="text-danger">*</span>
                                            </label>
                                            <textarea name="ly_do" class="form-control" rows="5"
                                                maxlength="1000" required
                                                placeholder="Ví dụ: Tôi bị ốm và không thể tham gia tour..."></textarea>
                                        </div>
                                    </div>

                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Hủy</button>
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fas fa-paper-plane me-1"></i>Gửi yêu cầu
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                @endif
            @empty
                <div class="p-4 text-center text-muted">
                    Không có tour chưa khởi hành để gửi yêu cầu.
                </div>
            @endforelse
        </div>
    </div>

    <div class="card support-card">
        <div class="support-card-head">
            <i class="fas fa-clock-rotate-left me-2"></i>Lịch sử yêu cầu của tôi
        </div>

        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th>Tour</th>
                        <th>Lý do</th>
                        <th>Trạng thái</th>
                        <th>HDV thay thế</th>
                        <th>Phản hồi Admin</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($yeuCaus as $yeuCau)
                        <tr>
                            <td>{{ $yeuCau->lichKhoiHanh->tour->ten_tour ?? 'Tour' }}</td>
                            <td>{{ $yeuCau->ly_do }}</td>
                            <td>
                                @if($yeuCau->trang_thai === 'cho_xu_ly')
                                    <span class="support-status waiting">Chờ xử lý</span>
                                @elseif($yeuCau->trang_thai === 'da_xu_ly')
                                    <span class="support-status done">Đã xử lý</span>
                                @else
                                    <span class="support-status reject">Từ chối</span>
                                @endif
                            </td>
                            <td>{{ $yeuCau->huongDanVienThayThe->ho_ten ?? '—' }}</td>
                            <td>{{ $yeuCau->phan_hoi_admin ?: '—' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted py-4">
                                Bạn chưa gửi yêu cầu hỗ trợ nào.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
