@extends('layouts.guide')
@section('title', 'Báo cáo sự cố')
@section('content')
    <div class="container-fluid py-4">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
            <div>
                <h3 class="fw-bold mb-1">Báo cáo sự cố</h3>
                <p class="text-muted mb-0">Theo dõi các sự cố đã gửi đến Admin.</p>
            </div>
            <a href="{{ route('Guide.baocaosuco.create') }}" class="btn btn-primary">
                <i class="fas fa-plus me-2"></i>Báo cáo sự cố
            </a>
        </div>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="row g-3 mb-4">
            @foreach ([['Tổng báo cáo', $thongKe['tong'], 'primary'], ['Mới', $thongKe['moi'], 'danger'], ['Đang xử lý', $thongKe['dang_xu_ly'], 'warning'], ['Đã xử lý', $thongKe['da_xu_ly'], 'success']] as [$label, $value, $color])
                <div class="col-md-3 col-sm-6">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body">
                            <div class="text-muted small">{{ $label }}</div>
                            <div class="fs-3 fw-bold text-{{ $color }}">{{ $value }}</div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="card border-0 shadow-sm">
            <div class="card-body border-bottom">
                <form method="GET" class="row g-2">
                    <div class="col-md-5">
                        <input name="keyword" value="{{ request('keyword') }}" class="form-control"
                            placeholder="Tìm tiêu đề hoặc nội dung...">
                    </div>
                    <div class="col-md-3">
                        <select name="trang_thai" class="form-select">
                            <option value="">Tất cả trạng thái</option>
                            @foreach (\App\Models\BaoCaoSuCo::trangThaiList() as $value => $label)
                                <option value="{{ $value }}" @selected(request('trang_thai') === $value)>{{ $label }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <select name="muc_do" class="form-select">
                            <option value="">Tất cả mức độ</option>
                            @foreach (\App\Models\BaoCaoSuCo::mucDoList() as $value => $label)
                                <option value="{{ $value }}" @selected(request('muc_do') === $value)>{{ $label }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2 d-grid"><button class="btn btn-outline-primary">Lọc</button></div>
                </form>
            </div>

            <div class="table-responsive">
                <table class="table align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Sự cố</th>
                            <th>Mức độ</th>
                            <th>Trạng thái</th>
                            <th>Ngày gửi</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($baoCaos as $baoCao)
                            <tr>
                                <td>{{ $baoCao->id }}</td>
                                <td><strong>{{ $baoCao->tieu_de }}</strong><br><small
                                        class="text-muted">{{ $baoCao->loai_su_co_text }}</small></td>
                                <td>{{ $baoCao->muc_do_text }}</td>
                                <td>{{ $baoCao->trang_thai_text }}</td>
                                <td>{{ $baoCao->created_at?->format('d/m/Y H:i') }}</td>
                                <td class="text-end"><a href="{{ route('Guide.baocaosuco.show', ['id' => $baoCao->id]) }}"
                                        class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-eye me-1"></i>
                                        Xem
                                    </a></td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-5 text-muted">Chưa có báo cáo sự cố.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if ($baoCaos->hasPages())
                <div class="card-footer bg-white">{{ $baoCaos->links('pagination::bootstrap-5') }}</div>
            @endif
        </div>
    </div>
@endsection
