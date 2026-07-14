@extends('Layouts.guide')

@section('content')

<div class="container">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <h2>
            <i class="fas fa-trash text-danger"></i>
            Thùng rác báo cáo sự cố
        </h2>

        <a href="{{ route('Guide.baocaosuco.index') }}"
           class="btn btn-success">

            <i class="fas fa-arrow-left"></i>

            Quay lại

        </a>

    </div>

    @if(session('success'))

        <div class="alert alert-success">

            {{ session('success') }}

        </div>

    @endif

    @if($baoCaos->isEmpty())

        <div class="alert alert-info">

            Không có báo cáo nào trong thùng rác.

        </div>

    @else

        <table class="table table-bordered table-hover align-middle">

            <thead class="table-dark">

                <tr>

                    <th width="70">
                        STT
                    </th>

                    <th>
                        Tour
                    </th>

                    <th>
                        Tiêu đề
                    </th>

                    <th>
                        Ngày xóa
                    </th>

                    <th width="220">
                        Thao tác
                    </th>

                </tr>

            </thead>

            <tbody>

            @foreach($baoCaos as $baoCao)

                <tr>

                    <td>
                        {{ $loop->iteration }}
                    </td>

                    <td>
                        {{ $baoCao->lichKhoiHanh->tour->ten_tour }}
                    </td>

                    <td>
                        {{ $baoCao->tieu_de }}
                    </td>

                    <td>
                        {{ $baoCao->deleted_at->format('d/m/Y H:i') }}
                    </td>

                    <td>

                        {{-- Khôi phục --}}
                        <form
                            action="{{ route('Guide.baocaosuco.restore',$baoCao->id) }}"
                            method="POST"
                            class="d-inline">

                            @csrf
                            @method('PATCH')

                            <button
                                class="btn btn-success btn-sm">

                                <i class="fas fa-undo"></i>

                                Khôi phục

                            </button>

                        </form>

                        {{-- Xóa vĩnh viễn --}}
                        <form
                            action="{{ route('Guide.baocaosuco.forceDelete',$baoCao->id) }}"
                            method="POST"
                            class="d-inline">

                            @csrf
                            @method('DELETE')

                            <button
                                class="btn btn-danger btn-sm"
                                onclick="return confirm('Xóa vĩnh viễn báo cáo này?')">

                                <i class="fas fa-trash"></i>

                                Xóa

                            </button>

                        </form>

                    </td>

                </tr>

            @endforeach

            </tbody>

        </table>

    @endif

</div>

@endsection
