@extends('layouts.admin')

@section('content')
<div class="container py-4">
    <h3>Chi tiết vai trò</h3>

    <div class="card">
        <div class="card-body">
            <dl class="row mb-0">
                <dt class="col-sm-3">Tên vai trò</dt>
                <dd class="col-sm-9">{{ $vaiTro->ten_vai_tro }}</dd>

                <dt class="col-sm-3">Mô tả</dt>
                <dd class="col-sm-9">{{ $vaiTro->mo_ta }}</dd>

                <dt class="col-sm-3">Quyền</dt>
                <dd class="col-sm-9">
                    @if($vaiTro->quyenHans->isEmpty())
                        <span>Chưa có quyền nào</span>
                    @else
                        <ul class="mb-0">
                            @foreach($vaiTro->quyenHans as $quyenHan)
                                <li>{{ $quyenHan->ten_hien_thi }} ({{ $quyenHan->ten }})</li>
                            @endforeach
                        </ul>
                    @endif
                </dd>
            </dl>

            <div class="mt-4">
                @php $currentUser = auth()->user(); @endphp
                @if($currentUser && $currentUser->hasPermission('roles.edit'))
                    <a href="{{ route('Admin.vai-tros.edit', $vaiTro->id) }}" class="btn btn-warning">Sửa</a>
                @endif
                <a href="{{ route('Admin.vai-tros.index') }}" class="btn btn-secondary">Quay lại</a>
            </div>
        </div>
    </div>
</div>
@endsection
