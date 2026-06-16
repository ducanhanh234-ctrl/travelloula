@extends('layouts.admin')


@section('content')


<div class="card">

<div class="card-body">


<form method="POST"

action="{{route('Admin.danh_mucs.store')}}">


@csrf


@include('Admin.danh_mucs.form')


<button class="btn btn-primary">

Lưu

</button>


</form>


</div>

</div>


@endsection