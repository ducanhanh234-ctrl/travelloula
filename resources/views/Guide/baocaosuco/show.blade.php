@extends('Layouts.guide')

@section('content')

<div class="container">
    <div class="card shadow">
        <div class="card-header bg-success text-white">
            <h4 class="mb-1">
                <i class="fas fa-file-alt me-2"></i>
                    Chi tiết báo cáo sự cố
            </h4>

            <small class="text-white-50">
                Xem thông tin chi tiết báo cáo sự cố của hướng dẫn viên.
            </small>
        </div>

<div class="card-body">
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center">
                    <h6 class="text-success">
                        <i class="fas fa-route"></i>
                            Tour
                    </h6>

                <strong>
                    {{ $baoCao->lichKhoiHanh->tour->ten_tour }}
                </strong>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card border-0 shadow-sm">
            <div class="card-body text-center">
                <h6 class="text-success">
                    <i class="fas fa-calendar-alt"></i>
                    Khởi hành
                </h6>

                <strong>
                    {{ \Carbon\Carbon::parse($baoCao->lichKhoiHanh->ngay_khoi_hanh)->format('d/m/Y') }}
                </strong>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card border-0 shadow-sm">
            <div class="card-body text-center">
                <h6 class="text-success">
                    <i class="fas fa-user-tie"></i>
                    Hướng dẫn viên
                </h6>

                <strong>
                    {{ $baoCao->huongDanVien->ho_ten }}
                </strong>
            </div>
        </div>
    </div>
</div>

            <table class="table table-bordered">
                <tr>
                    <th width="220">Tour</th>
                    <td>{{ $baoCao->lichKhoiHanh->tour->ten_tour }}</td>
                </tr>

                <tr>
                    <th>Ngày khởi hành</th>
                    <td>
                        {{ \Carbon\Carbon::parse($baoCao->lichKhoiHanh->ngay_khoi_hanh)->format('d/m/Y') }}
                    </td>
                </tr>

                <tr>
                    <th>Hướng dẫn viên</th>
                    <td>
                        {{ $baoCao->huongDanVien->ho_ten }}
                    </td>
                </tr>

                <tr>
                    <th>Tiêu đề</th>
                    <td>{{ $baoCao->tieu_de }}</td>
                </tr>

                <tr>
                    <th>Loại sự cố</th>
                    <td>{{ ucfirst(str_replace('_',' ',$baoCao->loai_su_co)) }}</td>
                </tr>

                <tr>
                    <th>Mức độ</th>
                    <td>
                        @switch($baoCao->muc_do)
                            @case('thap')
                                <span class="badge bg-success">
                                    Thấp
                                </span>
                                @break

                            @case('trung_binh')
                                <span class="badge bg-warning text-dark">
                                    Trung bình
                                </span>
                                @break

                            @case('cao')
                                <span class="badge bg-danger">
                                    Cao
                                </span>
                                @break
                        @endswitch
                    </td>
                </tr>

                <tr>
                    <th>Trạng thái</th>
                        <td>
                            @switch($baoCao->trang_thai)
                                @case('cho_xu_ly')
                                    <span class="badge bg-secondary">
                                        Chờ xử lý
                                    </span>
                                @break

                                @case('dang_xu_ly')
                                    <span class="badge bg-info">
                                        Đang xử lý
                                    </span>
                                @break

                                @case('da_xu_ly')
                                    <span class="badge bg-success">
                                        Đã xử lý
                                    </span>
                                @break
                        @endswitch
                    </td>
                </tr>

                <tr>
                    <th>Nội dung</th>
                    <td>
                        <div class="border rounded bg-light p-3" style="white-space: pre-line;">
                            {{ $baoCao->noi_dung }}
                        </div>
                    </td>
                </tr>

                <tr>
                    <th>Ngày gửi</th>
                    <td>
                        {{ $baoCao->created_at->format('d/m/Y H:i') }}
                    </td>
                </tr>
            </table>

            <div class="d-flex justify-content-between mt-4">
                <a href="{{ route('Guide.baocaosuco.index') }}"
                    class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left"></i>
                            Quay lại
                </a>

                @if($baoCao->trang_thai == 'cho_xu_ly')

                <a href="{{ route('Guide.baocaosuco.edit',$baoCao->id) }}"
                    class="btn btn-success">
                        <i class="fas fa-edit"></i>
                            Chỉnh sửa
                </a>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
