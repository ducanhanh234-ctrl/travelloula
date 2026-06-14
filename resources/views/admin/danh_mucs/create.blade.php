@extends('layouts.admin')


@section('content')


<div class="card">

<div class="card-body">


<form method="POST"

action="{{route('admin.danh_mucs.store')}}">


@csrf


@include('admin.danh_mucs.form')


<button class="btn btn-primary">

Lưu

</button>


</form>


</div>

</div>


@endsection