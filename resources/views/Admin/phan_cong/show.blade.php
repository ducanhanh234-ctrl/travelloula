@extends('layouts.admin')

@section('title', 'Chi tiết phân công')

@section('breadcrumb')
<li class="breadcrumb-item">
    <a href="{{ route('Admin.phan-cong.index') }}">
        Quản lý phân công
    </a>
</li>

<li class="breadcrumb-item active">
    Chi tiết phân công
</li>
@endsection

@section('content')

<div class="fade-in">

    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <h3 class="fw-bold mb-1">
                Chi tiết phân công
            </h3>

            <p class="text-muted mb-0">
                Thông tin chi tiết về phân công hướng dẫn viên và phương tiện
            </p>

        </div>

        <div class="d-flex gap-2">
            @if($phanCong->trang_thai === 'assigned')
            <a href="{{ route('Admin.phan-cong.edit',$phanCong->phanCong->id) }}" class="btn btn-warning">

                <i class="fas fa-edit"></i>

                Chỉnh sửa

            </a>
            @endif
            <a href="{{ route('Admin.phan-cong.index') }}" class="btn btn-secondary">

                <i class="fas fa-arrow-left"></i>

                Quay lại

            </a>

        </div>

    </div>

    <div class="row">

        {{-- Thông tin phân công --}}
        <div class="col-lg-8">

            <div class="card shadow-sm mb-4">

                <div class="card-header">

                    <i class="fas fa-tasks me-2"></i>

                    Thông tin phân công

                </div>

                <div class="card-body">

                    <table class="table table-bordered align-middle">

                        <tr>
                            <th width="220">Mã phân công</th>
                            <td>#PC{{ str_pad($phanCong->id,5,'0',STR_PAD_LEFT) }}</td>
                        </tr>

                        <tr>
                            <th>Ngày phân công</th>
                            <td>
                                @if($phanCong->phanCong)
                                {{ \Carbon\Carbon::parse($phanCong->phanCong->ngay_phan_cong)->format('d/m/Y H:i') }}
                                @else
                                Chưa có ngày phân công
                                @endif
                            </td>
                        </tr>



                        <tr>
                            <th>Ghi chú</th>
                            <td>
                                @if($phanCong->phanCong )
                                {{ $phanCong->phanCong->ghi_chu ?? 'Không có ghi chú.' }}
                                @else
                                Không có ghi chú.
                                @endif

                            </td>
                        </tr>

                    </table>

                </div>

            </div>

        </div>

        {{-- Thông tin nhanh --}}
        <div class="col-lg-4">

            @php
            $hdvs = optional($phanCong->phanCong)->hdvList ?? collect();
            $vehicles = optional($phanCong->phanCong)->phuongTienList ?? collect();
            @endphp

            <div class="card shadow-sm mb-4">

                <div class="card-header">

                    <i class="fas fa-user-tie me-2"></i>

                    Hướng dẫn viên

                </div>

                <div class="card-body">

                    @if($hdvs->isNotEmpty())
                    @foreach($hdvs as $hdv)
                    <h5>{{ $hdv->ho_ten }}</h5>
                    <p class="mb-1">📞 {{ $hdv->so_dien_thoai }}</p>
                    <p class="mb-0">📧 {{ $hdv->email }}</p>
                    @if (!$loop->last)
                    <hr>
                    @endif
                    @endforeach
                    @else
                    <h5>Chưa phân công hướng dẫn viên</h5>
                    <p class="mb-0 text-muted">Chưa phân công hướng dẫn viên</p>
                    @endif

                </div>

            </div>

            <div class="card shadow-sm">

                <div class="card-header">

                    <i class="fas fa-bus me-2"></i>

                    Phương tiện

                </div>

                <div class="card-body">

                    @if($vehicles->isNotEmpty())
                    @foreach($vehicles as $vehicle)
                    <h5>{{ $vehicle->bien_so_xe }}</h5>
                    <p class="mb-1">Số chỗ: {{ $vehicle->so_cho }}</p>
                    @if (!$loop->last)
                    <hr>
                    @endif
                    @endforeach
                    @else
                    <h5>Chưa phân công phương tiện</h5>
                    <p class="mb-0 text-muted">Chưa phân công phương tiện</p>
                    @endif

                </div>

            </div>

        </div>

    </div>

    {{-- Lịch khởi hành --}}
    <div class="card shadow-sm">

        <div class="card-header">

            <i class="fas fa-calendar-alt me-2"></i>

            Lịch khởi hành

        </div>

        <div class="card-body">

            <table class="table table-bordered">

                <tr>

                    <th width="220">
                        Mã lịch
                    </th>

                    <td>

                        MKH {{ $phanCong->id }}

                    </td>

                </tr>

                <tr>

                    <th>
                        Ngày khởi hành
                    </th>

                    <td>

                        {{ \Carbon\Carbon::parse($phanCong->ngay_khoi_hanh)->format('d/m/Y') }}

                    </td>

                </tr>

                <tr>

                    <th>
                        Ngày kết thúc
                    </th>

                    <td>

                        {{ \Carbon\Carbon::parse($phanCong->ngay_ket_thuc)->format('d/m/Y') }}

                    </td>

                </tr>

                <tr>

                    <th>
                        Số khách
                    </th>

                    <td>

                        {{ $phanCong->so_cho_da_dat }}
                        /
                        {{ $phanCong->so_cho_con_lai + $phanCong->so_cho_da_dat}}

                    </td>

                </tr>

            </table>

        </div>

    </div>

</div>

@endsection
