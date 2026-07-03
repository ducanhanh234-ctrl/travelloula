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

            <a href="{{ route('Admin.phan-cong.edit',$phanCong->id) }}" class="btn btn-warning">

                <i class="fas fa-edit"></i>

                Chỉnh sửa

            </a>

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
                                {{ optional($phanCong->created_at)->format('d/m/Y H:i') }}
                            </td>
                        </tr>



                        <tr>
                            <th>Ghi chú</th>
                            <td>

                                {{ $phanCong->ghi_chu ?: 'Không có ghi chú.' }}

                            </td>
                        </tr>

                    </table>

                </div>

            </div>

        </div>

        {{-- Thông tin nhanh --}}
        <div class="col-lg-4">

            <div class="card shadow-sm mb-4">

                <div class="card-header">

                    <i class="fas fa-user-tie me-2"></i>

                    Hướng dẫn viên

                </div>

                <div class="card-body">

                    <h5>

                        {{ $phanCong->hdv->ho_ten ?? 'Không xác định' }}

                    </h5>

                    <p class="mb-1">

                        📞 {{ $phanCong->hdv->so_dien_thoai }}

                    </p>

                    <p class="mb-0">

                        📧 {{ $phanCong->hdv->email }}

                    </p>

                </div>

            </div>

            <div class="card shadow-sm">

                <div class="card-header">

                    <i class="fas fa-bus me-2"></i>

                    Phương tiện

                </div>

                <div class="card-body">

                    <h5>

                        {{ $phanCong->phuongTien->bien_so_xe }}

                    </h5>

                    <p class="mb-1">

                        Loại xe:
                        {{ $phanCong->phuongTien->loai_phuong_tien }}

                    </p>



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

                        MKH {{ $phanCong->lichKhoiHanh->id }}

                    </td>

                </tr>

                <tr>

                    <th>
                        Ngày khởi hành
                    </th>

                    <td>

                        {{ \Carbon\Carbon::parse($phanCong->lichKhoiHanh->ngay_khoi_hanh)->format('d/m/Y') }}

                    </td>

                </tr>

                <tr>

                    <th>
                        Ngày kết thúc
                    </th>

                    <td>

                        {{ \Carbon\Carbon::parse($phanCong->lichKhoiHanh->ngay_ket_thuc)->format('d/m/Y') }}

                    </td>

                </tr>

                <tr>

                    <th>
                        Số khách
                    </th>

                    <td>

                        {{ $phanCong->lichKhoiHanh->so_cho_da_dat }}
                        /
                        {{ $phanCong->lichKhoiHanh->so_cho_con_lai + $phanCong->lichKhoiHanh->so_cho_da_dat}}

                    </td>

                </tr>

            </table>

        </div>

    </div>

</div>

@endsection
