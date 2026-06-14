@extends('layouts.admin')


@section('content')


<div class="card">

<div class="card-body">


<form method="POST"

action="{{route('admin.danh_mucs.update',$danhMuc)}}">


@csrf

@method('PUT')


@include('admin.danh_mucs.form')


<button class="btn btn-success">

Cập nhật

</button>


</form>


</div>

</div>


@endsection