@extends('Layouts.admin')

@section('content')
<div class="container-fluid">

    <div class="card shadow">

        <div class="card-header d-flex justify-content-between align-items-center">

            <div>
                <h4 class="mb-1">
                    <i class="fas fa-clock text-primary"></i>
                    Hoạt động theo giờ
                </h4>

                <small class="text-muted">
                    {{ $lichTrinh->tieu_de }}
                </small>
            </div>

            <div>

                <a href="{{ route('Admin.lich_trinh_tours.tour', $lichTrinh->tour_id) }}" class="btn btn-secondary">

                    <i class="fas fa-arrow-left"></i>

                    Quay lại

                </a>

                <a href="{{ route('Admin.chi_tiet_lich_trinhs.create', $lichTrinh->id) }}" class="btn btn-primary">

                    <i class="fas fa-plus"></i>

                    Thêm hoạt động

                </a>

            </div>

        </div>

        <div class="card-body">

            @if (session('success'))
            <div class="alert alert-success">

                {{ session('success') }}

            </div>
            @endif

            <table class="table table-bordered table-hover align-middle">

                <thead class="table-dark">

                    <tr>

                        <th width="120">Giờ</th>

                        <th width="250">Tiêu đề</th>

                        <th>Nội dung</th>

                        <th width="170">Thao tác</th>

                    </tr>

                </thead>

                <tbody>

                    @forelse($lichTrinh->chiTiets as $item)
                    <tr>

                        <td>

                            <span class="badge bg-primary fs-6">

                                {{ \Carbon\Carbon::parse($item->gio_bat_dau)->format('H:i') }}

                                -

                                {{ \Carbon\Carbon::parse($item->gio_ket_thuc)->format('H:i') }}

                            </span>

                        </td>

                        <td>

                            <strong>

                                {{ $item->tieu_de }}

                            </strong>

                        </td>

                        <td>

                            {{ $item->noi_dung }}

                        </td>

                        <td>

                            <a href="{{ route('Admin.chi_tiet_lich_trinhs.edit', $item->id) }}" class="btn btn-warning btn-sm">

                                <i class="fas fa-edit"></i>

                            </a>

                            <form action="{{ route('Admin.chi_tiet_lich_trinhs.destroy', $item->id) }}" method="POST" class="d-inline">

                                @csrf
                                @method('DELETE')

                                <button class="btn btn-danger btn-sm" onclick="return confirm('Xóa hoạt động?')">

                                    <i class="fas fa-trash"></i>

                                </button>

                            </form>

                        </td>

                    </tr>

                    @empty

                    <tr>

                        <td colspan="4" class="text-center">

                            Chưa có hoạt động nào

                        </td>

                    </tr>
                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>
@endsection
