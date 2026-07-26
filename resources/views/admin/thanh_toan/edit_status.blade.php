@extends('layouts.admin')

@section('title', 'Cập nhật trạng thái thanh toán')

@section('breadcrumb')
<li class="breadcrumb-item">

    <a href="{{ route('Admin.thanh_toans.index') }}">

        Quản lý Thanh toán
    </a>
</li>
<li class="breadcrumb-item active">
    Cập nhật trạng thái
</li>
@endsection

@section('content')

<div class="fade-in">

    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h3 class="fw-bold mb-1">
                Cập nhật trạng thái thanh toán
            </h3>

            <p class="text-muted mb-0">
                Quản lý và xử lý giao dịch thanh toán của khách hàng
            </p>
        </div>


        <a href="{{ route('Admin.thanh_toans.index') }}" class="btn btn-secondary">

            <i class="fas fa-arrow-left"></i>
            Quay lại
        </a>

    </div>
    @if (session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="fas fa-exclamation-triangle me-2"></i>{{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif
    <div class="row">

        {{-- Thông tin thanh toán --}}
        <div class="col-lg-8">

            <div class="card mb-4">

                <div class="card-header">
                    <i class="fas fa-credit-card me-2"></i>
                    Thông tin giao dịch
                </div>

                <div class="card-body">

                    <div class="row">

                        <div class="col-md-6 mb-3">
                            <label class="form-label text-muted">
                                Mã giao dịch
                            </label>

                            <div class="fw-semibold">
                                {{ $thanhToan->ma_giao_dich }}
                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label text-muted">
                                Mã đặt tour
                            </label>

                            <div class="fw-semibold">
                                {{ $thanhToan->datTour->ma_dat_tour ?? 'Không xác định' }}
                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label text-muted">
                                Khách hàng
                            </label>

                            <div class="fw-semibold">
                                {{ $thanhToan->nguoiDung->name ?? 'Không xác định' }}
                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label text-muted">
                                Số điện thoại
                            </label>

                            <div class="fw-semibold">
                                {{ $thanhToan->nguoiDung->phone ?? '---' }}
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label text-muted">
                                Phương thức thanh toán
                            </label>

                            <div class="fw-semibold">
                                {{ $thanhToan->phuong_thuc_thanh_toan }}
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label text-muted">
                                Số tiền
                            </label>

                            <div class="fw-bold text-success fs-5">
                                {{ number_format($thanhToan->datTour->tong_tien ?? 0, 0, ',', '.') }} VNĐ
                            </div>
                        </div>

                    </div>

                </div>

            </div>

            {{-- Form cập nhật --}}
            <div class="card">

                <div class="card-header">
                    <i class="fas fa-edit me-2"></i>
                    Cập nhật trạng thái
                </div>

                <div class="card-body">


                    <form action="{{ route('Admin.thanh_toans.update_status', $thanhToan->id) }}" method="POST">


                        @csrf
                        @method('PUT')

                        <div class="mb-4">

                            <label class="form-label fw-semibold">
                                Trạng thái thanh toán
                            </label>

                            <select name="status" class="form-select">

                                <option value="" {{ $thanhToan->trang_thai === null ? 'selected' : '' }}>Chọn trạng thái</option>

                                <option value="da_thanh_toan" {{ $thanhToan->trang_thai == 'da_thanh_toan' ? 'selected' : '' }}>
                                    Đã thanh toán
                                </option>
                                <option value="chua_thanh_toan" {{ $thanhToan->trang_thai == 'chua_thanh_toan' ? 'selected' : '' }}>
                                    Chưa thanh toán
                                </option>
                                <option value="cho_thanh_toan" {{ $thanhToan->trang_thai == 'cho_thanh_toan' ? 'selected' : '' }}>
                                    Chờ xử lý
                                </option>

                                <option value="thanh_toan_that_bai" {{ $thanhToan->trang_thai == 'thanh_toan_that_bai' ? 'selected' : '' }}>
                                    Thất bại
                                </option>

                                <option value="hoan_tien" {{ $thanhToan->trang_thai == 'hoan_tien' ? 'selected' : '' }}>
                                    Hoàn tiền
                                </option>
                                <option value="dat_coc" {{ $thanhToan->trang_thai == 'dat_coc' ? 'selected' : '' }}>
                                    Đặt Cọc
                                </option>
                            </select>

                        </div>

                        <div class="mb-4">

                            <label class="form-label fw-semibold">
                                Ghi chú xử lý
                            </label>

                            <textarea class="form-control" rows="5" name="ghi_chu" placeholder="Nhập ghi chú xử lý giao dịch...">{{ $thanhToan->ghi_chu }}</textarea>

                        </div>

                        <div class="alert alert-warning">

                            <i class="fas fa-exclamation-triangle"></i>

                            <div>
                                Khi chuyển trạng thái sang
                                <strong>Hoàn tiền</strong>
                                hoặc
                                <strong>Đã hủy</strong>,
                                hệ thống sẽ ghi nhận vào lịch sử giao dịch.
                            </div>

                        </div>

                        <div class="d-flex gap-2">

                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i>
                                Lưu thay đổi
                            </button>


                            <a href="{{ route('Admin.thanh_toans.index') }}" class="btn btn-secondary">


                                Hủy

                            </a>

                        </div>

                    </form>

                </div>

            </div>

        </div>

        {{-- Sidebar --}}
        <div class="col-lg-4">

            {{-- Trạng thái hiện tại --}}
            <div class="card mb-4">

                <div class="card-header">
                    <i class="fas fa-info-circle me-2"></i>
                    Trạng thái hiện tại
                </div>

                <div class="card-body text-center">

                    <div class="mb-3">

                        @if($thanhToan->trang_thai == 'da_thanh_toan')
                        <i class="fas fa-check-circle text-success" style="font-size:60px"></i>
                        @elseif($thanhToan->trang_thai == 'chua_thanh_toan')
                        <i class="fas fa-hourglass-half text-warning" style="font-size:60px"></i>
                        @elseif($thanhToan->trang_thai == 'cho_xu_ly')
                        <i class="fas fa-clock text-warning" style="font-size:60px"></i>
                        @elseif($thanhToan->trang_thai == 'thanh_toan_that_bai')
                        <i class="fas fa-times-circle text-danger" style="font-size:60px"></i>
                        @elseif($thanhToan->trang_thai == 'hoan_tien')
                        <i class="fas fa-undo text-info" style="font-size:60px"></i>
                        @elseif($thanhToan->trang_thai == 'dat_coc')
                        <i class="fas fa-coins text-primary" style="font-size:60px"></i>
                        @else
                        <i class="fas fa-question-circle text-secondary" style="font-size:60px"></i>
                        @endif

                    </div>

                    @if ($thanhToan->trang_thai == 'da_thanh_toan')
                    <span class="badge badge-success fs-6 px-3 py-2 text-black">Đã thanh toán</span>
                    @elseif ($thanhToan->trang_thai == 'cho_thanh_toan')
                    <span class="badge badge-warning fs-6 px-3 py-2 text-black">Chờ xử lý</span>
                    @elseif ($thanhToan->trang_thai == 'thanh_toan_that_bai')
                    <span class="badge badge-danger fs-6 px-3 py-2 text-black">Thất bại</span>
                    @elseif ($thanhToan->trang_thai == 'hoan_tien')
                    <span class="badge badge-info fs-6 px-3 py-2 text-black">Hoàn tiền</span>
                    @elseif ($thanhToan->trang_thai == 'dat_coc')
                    <span class="badge badge-primary fs-6 px-3 py-2 text-black">Đặt cọc</span>
                    @else
                    <span class="badge badge-secondary fs-6 px-3 py-2 text-black">Không xác định</span>
                    @endif

                    <p class="text-muted mt-3 mb-0">
                        {{ $thanhToan->ghi_chu ?? 'Không có ghi chú.' }}
                    </p>

                </div>

            </div>

            {{-- Lịch sử --}}
            <div class="card">

                <div class="card-header">
                    <i class="fas fa-history me-2"></i>
                    Lịch sử xử lý
                </div>

                <div class="card-body">

                    <div class="border-start ps-3">

                        {{-- <div class="mb-4">
                            <h6 class="mb-1">
                                Tạo giao dịch
                            </h6>

                            <small class="text-muted">
                                12/06/2026 - 10:20
                            </small>
                        </div>

                        <div class="mb-4">
                            <h6 class="mb-1 text-primary">
                                Chờ xác nhận
                            </h6>

                            <small class="text-muted">
                                12/06/2026 - 10:22
                            </small>
                        </div>

                        <div>
                            <h6 class="mb-1 text-success">
                                Thanh toán thành công
                            </h6>

                            <small class="text-muted">
                                12/06/2026 - 10:30
                            </small>
                        </div> --}}

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection
