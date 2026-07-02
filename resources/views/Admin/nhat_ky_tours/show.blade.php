@extends('Layouts.admin')

@section('title', 'Chi tiết nhật ký')

@section('content')

<div class="container-fluid">

    <div class="card">

        <div class="card-header">
            <h3>Chi tiết nhật ký</h3>
        </div>

        <div class="card-body">

            <p>
                <strong>Tour:</strong>
                {{ $nhatKy->tour->ten_tour ?? 'N/A' }}
            </p>

            <p>
                <strong>Người dùng:</strong>
                {{ $nhatKy->nguoiDung->name ?? 'N/A' }}
            </p>

            <p>
                <strong>Hành động:</strong>
                {{ $nhatKy->hanh_dong }}
            </p>

            <p>
                <strong>IP:</strong>
                {{ $nhatKy->dia_chi_ip }}
            </p>

            <p>
                <strong>Thời gian:</strong>
                {{ $nhatKy->created_at }}
            </p>

            <hr>

            <h5>Dữ liệu cũ</h5>

            <pre>{{ $nhatKy->du_lieu_cu }}</pre>

            <h5>Dữ liệu mới</h5>

            <pre>{{ $nhatKy->du_lieu_moi }}</pre>

            <a href="{{ route('Admin.nhat_ky_tours.index') }}"
               class="btn btn-secondary">
                Quay lại
            </a>

        </div>

    </div>

</div>

@endsection