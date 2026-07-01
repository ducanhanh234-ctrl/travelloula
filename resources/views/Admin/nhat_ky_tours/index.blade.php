@extends('Layouts.admin')

@section('title', 'Nhật ký tour')

@section('content')

<div class="container-fluid">

    <div class="card">

        <div class="card-header">
            <h3>Nhật ký tour</h3>
        </div>

        <div class="card-body">

            <table class="table table-bordered">

                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Tour</th>
                        <th>Người dùng</th>
                        <th>Hành động</th>
                        <th>IP</th>
                        <th>Thời gian</th>
                        <th></th>
                    </tr>
                </thead>

                <tbody>

                    @foreach($nhatKys as $item)

                    <tr>

                        <td>{{ $item->id }}</td>

                        <td>
                            {{ $item->tour->ten_tour ?? 'N/A' }}
                        </td>

                        <td>
                            {{ $item->nguoiDung->name ?? 'N/A' }}
                        </td>

                        <td>
                            {{ $item->hanh_dong }}
                        </td>

                        <td>
                            {{ $item->dia_chi_ip }}
                        </td>

                        <td>
                            {{ strtotime($item->created_at) ? date('d/m/Y H:i:s', strtotime($item->created_at)) : 'N/A' }}
                        </td>

                        <td>
                            <a href="{{ route('Admin.nhat_ky_tours.show', $item->id) }}" class="btn btn-info btn-sm">
                                Chi tiết
                            </a>
                        </td>

                    </tr>

                    @endforeach

                </tbody>

            </table>

            {{ $nhatKys->links() }}

        </div>

    </div>

</div>

@endsection
