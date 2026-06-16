@extends('layouts.admin')


@section('content')


<div class="card">

<div class="card-body">


<form method="POST"

action="{{route('Admin.banners.update',$banner)}}">


@csrf

@method('PUT')


@include('Admin.banners.form')


<button class="btn btn-success">

Cập nhật

</button>


</form>


</div>

</div>


@endsection