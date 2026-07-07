@extends('Layouts.guide')

@section('content')

<h2>Danh sách lịch khởi hành</h2>

<table border="1" cellpadding="10">

    <tr>
        <th>ID</th>
        <th>Tên tour</th>
        <th>Ngày khởi hành</th>
        <th>Thao tác</th>
    </tr>

    @foreach($lichKhoiHanhs as $lich)

    <tr>

        <td>{{ $lich->id }}</td>

        <td>{{ $lich->tour->ten_tour }}</td>

        <td>{{ $lich->ngay_khoi_hanh }}</td>

        <td>

           <a href="{{ route('Guide.checkin.show', $lich->id) }}">
    Xem hành khách
</a>

        </td>

    </tr>

    @endforeach

</table>

@endsection
