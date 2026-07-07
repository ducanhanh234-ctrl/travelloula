@extends('Layouts.guide')

@section('content')

<h2>Danh sách hành khách</h2>

<table border="1" cellpadding="10">

    <tr>
        <th>STT</th>
        <th>Họ tên</th>
        <th>SĐT</th>
        <th>Check-in</th>
    </tr>

    @php
        $stt = 1;
    @endphp

    @foreach($datTours as $datTour)

        @foreach($datTour->khachHangs as $khach)

            <tr>

                <td>{{ $stt++ }}</td>

                <td>{{ $khach->ho_ten }}</td>

                <td>{{ $khach->so_dien_thoai }}</td>

                <td>

                    @if($khach->da_check_in)

                        ✅ Đã check-in

                    @else

                        ❌ Chưa check-in

                    @endif

                </td>

            </tr>

        @endforeach

    @endforeach

</table>

@endsection
