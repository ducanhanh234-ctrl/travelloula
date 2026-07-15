@extends('Layouts.guide')

@section('content')
    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="fw-bold text-success mb-1">
                        <i class="fas fa-map-marked-alt"></i>
                        Check-in hành khách
                    </h2>

                    <small class="text-muted">
                        Theo dõi các tour được phân công và thực hiện điểm danh.
                    </small>
                </div>
                <a href="{{ route('Guide.checkin.index') }}" class="btn btn-outline-success">
                    <i class="fas fa-rotate-right"></i>
                    Làm mới
                </a>
            </div>
        </div>

        <div class="card-body">
            @if($lichKhoiHanhs->isEmpty())
                <div class="alert alert-warning text-center">
                    <i class="fas fa-calendar-times fa-2x mb-2"></i>
                    <br>
                    Hiện tại bạn chưa được phân công lịch khởi hành nào.
                </div>
            @else
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th width="70">STT</th>
                            <th>Tour</th>
                            <th>Ngày khởi hành</th>
                            <th>Ngày kết thúc</th>
                            <th width="180" class="text-center">
                                Thao tác
                            </th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($lichKhoiHanhs as $lich)
                            <tr>
                                <td>
                                    {{ $lichKhoiHanhs->firstItem() + $loop->index }}
                                </td>

                                <td>
                                    {{ $lich->tour->ten_tour }}
                                </td>

                                <td>
                                    {{ $lich->ngay_khoi_hanh->format('d/m/Y') }}
                                </td>

                                <td>
                                    {{ $lich->ngay_ket_thuc->format('d/m/Y') }}
                                </td>

                                <td class="text-center">
                                    <a href="{{ route('Guide.checkin.dia-diem', $lich->id) }}" class="btn btn-success btn-sm">
                                        <i class="fas fa-map-marker-alt"></i>
                                        Chọn địa điểm
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="d-flex justify-content-center mt-4">
                    {{ $lichKhoiHanhs->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection
