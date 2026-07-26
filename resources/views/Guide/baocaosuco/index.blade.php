@extends('Layouts.guide')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="fw-bold text-success mb-1">
            <i class="fas fa-exclamation-circle"></i>
            Báo cáo sự cố
        </h2>

        <small class="text-muted">
            Theo dõi và quản lý các báo cáo sự cố trong quá trình dẫn tour.
        </small>
    </div>

    <div class="d-flex gap-2">
        <a href="{{ route('Guide.baocaosuco.trash') }}" class="btn btn-outline-danger">
            <i class="fas fa-trash"></i>
            Thùng rác
        </a>

        <a href="{{ route('Guide.baocaosuco.create') }}" class="btn btn-success">
            <i class="fas fa-plus"></i>
            Tạo báo cáo
        </a>
    </div>
</div>

<div class="row mb-4">
    <div class="col-md-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <h6 class="text-muted">
                    Tổng báo cáo
                </h6>

                <h2 class="text-success">
                    {{ $tongBaoCao }}
                </h2>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <h6 class="text-muted">
                    Chờ xử lý
                </h6>

                <h2 class="text-secondary">
                    {{ $choXuLy }}
                </h2>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <h6 class="text-muted">
                    Đang xử lý
                </h6>
                <h2 class="text-warning">
                    {{ $dangXuLy }}
                </h2>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <h6 class="text-muted">
                    Đã xử lý
                </h6>

                <h2 class="text-success">
                    {{ $daXuLy }}
                </h2>
            </div>
        </div>
    </div>
</div>

@if(session('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    <i class="fas fa-check-circle me-2"></i>
    {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif

<div class="card shadow-sm border-0">
    <div class="card-header bg-success text-white">
        <h5 class="mb-0">
            <i class="fas fa-list me-2"></i>
            Danh sách báo cáo sự cố
        </h5>
    </div>

    <div class="card-body">
        @if($baoCaos->isEmpty())
        <div class="text-center py-5">
            <i class="fas fa-folder-open fa-4x text-success mb-3"></i>
            <h5 class="fw-bold">
                Chưa có báo cáo sự cố nào
            </h5>
            <p class="text-muted">
                Hãy tạo báo cáo đầu tiên của bạn.
            </p>
            <a href="{{ route('Guide.baocaosuco.create') }}" class="btn btn-success">
                <i class="fas fa-plus me-1"></i>
                Tạo báo cáo
            </a>
        </div>

        @else
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-success">
                    <tr>
                        <th width="70">STT</th>
                        <th>Tour</th>
                        <th>Tiêu đề</th>
                        <th>Loại sự cố</th>
                        <th>Mức độ</th>
                        <th>Trạng thái</th>
                        <th>Ngày gửi</th>
                        <th width="130" class="text-center">
                            Thao tác
                        </th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($baoCaos as $baoCao)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $baoCao->lichKhoiHanh->tour->ten_tour }}</td>
                        <td>
                            <strong>{{ $baoCao->tieu_de }}</strong>
                        </td>
                        <td>{{ ucfirst(str_replace('_', ' ', $baoCao->loai_su_co)) }}</td>
                        <td>
                            @if($baoCao->muc_do == 'thap')
                            <span class="badge rounded-pill bg-success">
                                Thấp
                            </span>

                            @elseif($baoCao->muc_do == 'trung_binh')
                            <span class="badge rounded-pill bg-warning text-dark">
                                Trung bình
                            </span>

                            @else
                            <span class="badge rounded-pill bg-danger">
                                Cao
                            </span>
                            @endif
                        </td>

                        <td>
                            @if($baoCao->trang_thai == 'cho_xu_ly')
                            <span class="badge rounded-pill bg-secondary">
                                Chờ xử lý
                            </span>

                            @elseif($baoCao->trang_thai == 'dang_xu_ly')
                            <span class="badge rounded-pill bg-info text-dark">
                                Đang xử lý
                            </span>

                            @else
                            <span class="badge rounded-pill bg-success">
                                Đã xử lý
                            </span>
                            @endif
                        </td>

                        <td>{{ $baoCao->created_at->format('d/m/Y H:i') }}</td>

                        <td class="text-center">
                            {{-- Xem --}}
                            <a href="{{ route('Guide.baocaosuco.show', $baoCao->id) }}" class="btn btn-outline-success btn-sm" title="Xem">
                                <i class="fas fa-eye"></i>
                            </a>

                            @if($baoCao->trang_thai == 'cho_xu_ly')
                            {{-- Sửa --}}
                            <a href="{{ route('Guide.baocaosuco.edit', $baoCao->id) }}" class="btn btn-outline-warning btn-sm" title="Chỉnh sửa">
                                <i class="fas fa-edit"></i>
                            </a>

                            {{-- Xóa --}}
                            <form action="{{ route('Guide.baocaosuco.destroy', $baoCao->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-outline-danger btn-sm" onclick="return confirm('Bạn có chắc muốn xóa báo cáo này không?')" title="Xóa">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @endif
    </div>
</div>
@endsection
