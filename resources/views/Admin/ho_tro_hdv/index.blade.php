@extends('Layouts.admin')

@section('title', 'Hỗ trợ HDV')
@section('admin', 'Hỗ trợ HDV')

@section('content')
<style>
    :root{--p:#315be8;--p2:#5b4dea;--navy:#203e78;--muted:#8190aa;--border:#dce6f5}
    .support-page{padding-bottom:28px}
    .support-title{color:var(--navy);font-size:23px;font-weight:800}
    .support-subtitle{color:var(--muted);font-size:11px}
    .support-panel{overflow:hidden;border:1px solid var(--border);border-radius:14px;
        box-shadow:0 9px 28px rgba(28,65,139,.08)}
    .support-panel-head{padding:17px 19px;color:#fff;
        background:linear-gradient(135deg,var(--p),var(--p2))}
    .support-filter{margin:15px;padding:12px;display:grid;
        grid-template-columns:1fr 200px auto;gap:9px;background:#f7f9fe;
        border:1px solid var(--border);border-radius:10px}
    .status-pill{padding:5px 8px;border-radius:999px;font-size:9px;font-weight:750}
    .waiting{color:#a26809;background:#fff7e7}
    .done{color:#08754a;background:#eaf9f1}
    .reject{color:#bd3850;background:#fff0f3}
    @media(max-width:768px){.support-filter{grid-template-columns:1fr}}
</style>

<div class="container-fluid support-page">
    <div class="mb-4">
        <h2 class="support-title mb-1">
            <i class="fas fa-headset me-2"></i>Hỗ trợ HDV
        </h2>
        <div class="support-subtitle">
            Tiếp nhận và xử lý yêu cầu thay hướng dẫn viên trước khởi hành.
        </div>
    </div>

    <div class="support-panel">
        <div class="support-panel-head">
            <strong><i class="fas fa-inbox me-2"></i>Yêu cầu hỗ trợ</strong>
        </div>

        <form method="GET" action="{{ route('Admin.ho-tro-hdv.index') }}"
            class="support-filter">
            <input type="text" name="q" value="{{ request('q') }}"
                class="form-control" placeholder="Tên tour, HDV hoặc lý do...">

            <select name="trang_thai" class="form-select">
                <option value="">Tất cả trạng thái</option>
                <option value="cho_xu_ly"
                    {{ request('trang_thai') === 'cho_xu_ly' ? 'selected' : '' }}>
                    Chờ xử lý
                </option>
                <option value="da_xu_ly"
                    {{ request('trang_thai') === 'da_xu_ly' ? 'selected' : '' }}>
                    Đã xử lý
                </option>
                <option value="tu_choi"
                    {{ request('trang_thai') === 'tu_choi' ? 'selected' : '' }}>
                    Từ chối
                </option>
            </select>

            <button type="submit" class="btn btn-primary">
                <i class="fas fa-search me-1"></i>Tìm
            </button>
        </form>

        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th>Thời gian</th>
                        <th>Tour</th>
                        <th>HDV gửi</th>
                        <th>Lý do</th>
                        <th>Trạng thái</th>
                        <th>HDV thay thế</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($yeuCaus as $yeuCau)
                        <tr>
                            <td>{{ $yeuCau->created_at->format('H:i d/m/Y') }}</td>
                            <td>
                                <strong>{{ $yeuCau->lichKhoiHanh->tour->ten_tour ?? 'Tour' }}</strong>
                                <div class="text-muted small">
                                    Khởi hành:
                                    {{ \Carbon\Carbon::parse($yeuCau->lichKhoiHanh->ngay_khoi_hanh)->format('d/m/Y') }}
                                </div>
                            </td>
                            <td>{{ $yeuCau->huongDanVien->ho_ten ?? '—' }}</td>
                            <td style="max-width:320px;">
                                {{ \Illuminate\Support\Str::limit($yeuCau->ly_do, 100) }}
                            </td>
                            <td>
                                @if($yeuCau->trang_thai === 'cho_xu_ly')
                                    <span class="status-pill waiting">Chờ xử lý</span>
                                @elseif($yeuCau->trang_thai === 'da_xu_ly')
                                    <span class="status-pill done">Đã xử lý</span>
                                @else
                                    <span class="status-pill reject">Từ chối</span>
                                @endif
                            </td>
                            <td>{{ $yeuCau->huongDanVienThayThe->ho_ten ?? '—' }}</td>
                            <td>
                                <a href="{{ route('Admin.ho-tro-hdv.show', $yeuCau->id) }}"
                                    class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-eye me-1"></i>Xem
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted py-5">
                                Chưa có yêu cầu hỗ trợ.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($yeuCaus->hasPages())
            <div class="p-3">{{ $yeuCaus->links() }}</div>
        @endif
    </div>
</div>
@endsection
