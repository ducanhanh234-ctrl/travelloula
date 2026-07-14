@extends('Layouts.guide')

@section('content')
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="fw-bold text-success mb-1">
                    <i class="fas fa-book-open"></i>
                    Nhật ký tour
                </h2>

                <small class="text-muted">
                    Theo dõi toàn bộ hoạt động Check-in và Check-out của hành khách.
                </small>
            </div>

            <a href="{{ route('Guide.nhatky.index') }}" class="btn btn-outline-success">
                <i class="fas fa-rotate-right"></i>
                Làm mới
            </a>
        </div>


        {{-- thống kê --}}
        <div class="row mb-4">
            <div class="col-md-4">
                <div class="card border-0 shadow-sm">
                    <div class="card-body text-center">
                        <h3 class="text-success">
                            {{ $tongHoatDong }}
                        </h3>

                        <small class="text-muted">
                            Tổng hoạt động
                        </small>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card border-0 shadow-sm">
                    <div class="card-body text-center">
                        <h3 class="text-primary">
                            {{ $tongCheckIn }}
                        </h3>

                        <small class="text-muted">
                            Check-in
                        </small>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card border-0 shadow-sm">
                    <div class="card-body text-center">
                        <h3 class="text-warning">
                            {{ $tongCheckOut }}
                        </h3>

                        <small class="text-muted">
                            Check-out
                        </small>
                    </div>
                </div>
            </div>
        </div>

        <div class="card shadow-sm border-0 mb-4">
            <div class="card-body">
                <form action="{{ route('Guide.nhatky.index') }}" method="GET">
                    <div class="row">
                        <div class="col-md-5">
                            <input type="text" name="keyword" class="form-control" placeholder="Nhập tên khách hàng..."
                                value="{{ request('keyword') }}">
                        </div>

                        <div class="col-md-4">
                            <select name="hanh_dong" class="form-select">
                                <option value="">
                                    Tất cả hoạt động
                                </option>

                                <option value="Check-in" {{ request('hanh_dong') == 'Check-in' ? 'selected' : '' }}>
                                    Check-in
                                </option>

                                <option value="Check-out" {{ request('hanh_dong') == 'Check-out' ? 'selected' : '' }}>
                                    Check-out
                                </option>
                            </select>
                        </div>

                        <div class="col-md-3 d-grid">
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-search"></i>
                                Tìm kiếm
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        @if($logs->isEmpty())
            <div class="alert alert-info">
                Chưa có nhật ký nào.
            </div>

        @else
        <div class="card border-0 shadow-sm">
            <div class="card-body p-0">
                <table class="table table-bordered table-hover align-middle">
                    <thead style="background:#198754;color:white;">
                        <tr>
                            <th width="70">STT</th>
                            <th width="180">Thời gian</th>
                            <th width="180">Hành động</th>
                            <th>Tour</th>
                            <th>Khách hàng</th>
                            <th>Địa điểm check-in</th>
                            <th width="120">Thao tác</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($logs as $log)
                            <tr>
                                <td>
                                    {{ ($logs->currentPage() - 1) * $logs->perPage() + $loop->iteration }}
                                </td>

                                <td>
                                    <div>
                                        <strong>
                                            {{ $log->created_at->format('d/m/Y') }}
                                        </strong>

                                        <br>
                                        <small class="text-muted">
                                            {{ $log->created_at->format('H:i') }}
                                        </small>
                                    </div>
                                </td>

                                <td>
                                    @if($log->hanh_dong == 'CHECK_IN')

    <span class="badge rounded-pill bg-success px-3 py-2">
        <i class="fas fa-sign-in-alt me-1"></i>
        Check-in
    </span>

@elseif($log->hanh_dong == 'CHECK_OUT')

    <span class="badge rounded-pill bg-warning text-dark px-3 py-2">
        <i class="fas fa-sign-out-alt me-1"></i>
        Check-out
    </span>

@else

    <span class="badge rounded-pill bg-secondary px-3 py-2">
        {{ $log->hanh_dong }}
    </span>

@endif
                                </td>

                            <td>
                                {{ $log->chiTiet->lichTrinh->tour->ten_tour ?? '-' }}
                            </td>

                            <td>
                                {{ $log->khachHang->ho_ten ?? '-' }}
                            </td>

                            <td>
                                {{ $log->chiTiet->tieu_de ?? '-' }}
                            </td>

                            <td>

    <a href="{{ route('Guide.nhatky.show', $log->id) }}"
       class="btn btn-primary btn-sm">

        <i class="fas fa-eye"></i>

        Xem

    </a>

</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

            <div class="mt-3">
                {{ $logs->links() }}
            </div>
        @endif
    </div>
@endsection
