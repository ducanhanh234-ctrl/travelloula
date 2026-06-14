@extends('layouts.app')
@section('content')
<div class="container">
    <h3>{{ request()->path() }}</h3>
    <a class="btn btn-primary mb-3" href="{{ url()->current().'/create' }}">Thêm mới</a>
    @if(session('success')) <div class="alert alert-success">{{ session('success') }}</div> @endif
    <p>View danh sách mẫu. Bạn có thể tùy biến cột theo controller tương ứng.</p>
</div>
@endsection
