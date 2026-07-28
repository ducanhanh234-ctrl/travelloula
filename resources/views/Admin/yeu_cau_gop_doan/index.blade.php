@extends('layouts.admin')

@section('content')
    <div class="container-fluid">

        {{-- Header --}}
        <div class="d-flex justify-content-between align-items-center mb-4">

            <div>
                <h3 class="fw-bold mb-1">
                    <i class="fas fa-list-check text-primary me-2"></i>
                    Danh sách yêu cầu gộp đoàn
                </h3>

                <small class="text-muted">
                    Quản lý các yêu cầu gộp đoàn của hệ thống.
                </small>
            </div>

            <a href="{{ route('Admin.gop-doan.index') }}" class="btn btn-outline-primary">

                <i class="fas fa-arrow-left"></i>

                Quay lại Gộp đoàn

            </a>

        </div>


        {{-- Alert --}}

        @if (session('success'))
            <div class="alert alert-success">

                {{ session('success') }}

            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger">

                {{ session('error') }}

            </div>
        @endif


        {{-- Thống kê --}}

        <div class="row mb-4">

            <div class="col-md-3">

                <div class="card border-0 shadow-sm">

                    <div class="card-body text-center">

                        <h6 class="text-muted">

                            Tổng yêu cầu

                        </h6>

                        <h2 class="fw-bold text-primary">

                            {{ $data->total() }}

                        </h2>

                    </div>

                </div>

            </div>


            <div class="col-md-3">

                <div class="card border-0 shadow-sm">

                    <div class="card-body text-center">

                        <h6 class="text-muted">

                            Chờ xử lý

                        </h6>

                        <h2 class="fw-bold text-warning">

                            {{ $data->where('trang_thai', 'cho_xu_ly')->count() }}

                        </h2>

                    </div>

                </div>

            </div>


            <div class="col-md-3">

                <div class="card border-0 shadow-sm">

                    <div class="card-body text-center">

                        <h6 class="text-muted">

                            Hoàn tất

                        </h6>

                        <h2 class="fw-bold text-success">

                            {{ $data->where('trang_thai', 'hoan_tat')->count() }}

                        </h2>

                    </div>

                </div>

            </div>


            <div class="col-md-3">

                <div class="card border-0 shadow-sm">

                    <div class="card-body text-center">

                        <h6 class="text-muted">

                            Booking chưa liên hệ

                        </h6>

                        <h2 class="fw-bold text-danger">

                            {{ $data->sum('bookingChuaLienHe') }}

                        </h2>

                    </div>

                </div>

            </div>

        </div>



        {{-- Table --}}

        <div class="card shadow">

            <div class="card-header bg-white">

                <strong>

                    Danh sách yêu cầu

                </strong>

            </div>

            <div class="table-responsive">

                <table class="table table-bordered table-hover align-middle mb-0">

                    <thead class="table-light">

                        <tr class="text-center">

                            <th width="60">#</th>

                            <th>Mã yêu cầu</th>

                            <th>Loại</th>

                            <th>Trạng thái</th>

                            <th>Tour</th>

                            <th>Lịch chính</th>

                            <th>Lịch gộp</th>

                            <th>Số lịch</th>

                            <th>Booking</th>

                            <th>Đồng ý</th>

                            <th>Từ chối</th>

                            <th width="120">

                                Thao tác

                            </th>

                        </tr>

                    </thead>

                    <tbody>

                        @forelse($data as $index => $yeuCau)
                            <tr>

                                <td class="text-center">

                                    {{ $data->firstItem() + $index }}

                                </td>

                                <td>
                                    <strong title="{{ $yeuCau->ma_yeu_cau }}" style="cursor: help;">
                                        {{ $yeuCau->ma_hien_thi }}
                                    </strong>

                                    <button class="btn btn-link btn-sm p-0 ms-1"
                                        onclick="navigator.clipboard.writeText('{{ $yeuCau->ma_yeu_cau }}')"
                                        title="Sao chép mã">

                                        <i class="fas fa-copy"></i>

                                    </button>

                                </td>

                                <td class="text-center">

                                    @if ($yeuCau->loai_de_xuat == 'tu_dong')
                                        <span class="badge bg-primary">

                                            AI

                                        </span>
                                    @else
                                        <span class="badge bg-secondary">

                                            Thủ công

                                        </span>
                                    @endif

                                </td>

                                <td class="text-center">

                                    @if ($yeuCau->trang_thai == 'cho_xu_ly')
                                        <span class="badge bg-warning text-dark">

                                            Chờ xử lý

                                        </span>
                                    @else
                                        <span class="badge bg-success">

                                            Hoàn tất

                                        </span>
                                    @endif

                                </td>

                                <td>

                                    {{ $yeuCau->tenTour }}

                                </td>

                                <td class="text-center">

                                    @if ($yeuCau->lichChinh)
                                        #{{ $yeuCau->lichChinh->lich_khoi_hanh_id }}
                                    @else
                                        -
                                    @endif

                                </td>

                                <td class="text-center">

                                    @forelse($yeuCau->lich_bi_gop as $lich)
                                        <span class="badge bg-info me-1">

                                            #{{ $lich }}

                                        </span>

                                    @empty

                                        -
                                    @endforelse

                                </td>

                                <td class="text-center">

                                    <span class="badge bg-primary">

                                        {{ $yeuCau->soLich }}

                                    </span>

                                </td>

                                <td class="text-center">

                                    {{ $yeuCau->tongBooking }}

                                </td>

                                <td class="text-center">

                                    <span class="badge bg-success">

                                        {{ $yeuCau->bookingDongY }}

                                    </span>

                                </td>

                                <td class="text-center">

                                    <span class="badge bg-danger">

                                        {{ $yeuCau->bookingTuChoi }}

                                    </span>

                                </td>

                                <td class="text-center">

                                    <a href="{{ route('Admin.yeu-cau-gop-doan.show', $yeuCau->id) }}"
                                        class="btn btn-primary btn-sm">

                                        <i class="fas fa-eye"></i>

                                        Xử lý

                                    </a>

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="11" class="text-center py-5">

                                    <span class="text-muted">

                                        Chưa có yêu cầu gộp đoàn.

                                    </span>

                                </td>

                            </tr>
                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

        <div class="mt-3">

            {{ $data->links() }}

        </div>

    </div>
@endsection
