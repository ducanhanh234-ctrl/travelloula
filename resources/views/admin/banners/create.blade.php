@extends('layouts.admin')


@section('content')


<div class="card">

<div class="card-body">


<form method="POST"

action="{{route('admin.banners.store')}}">


@csrf


@include('admin.banners.form')


<button class="btn btn-primary">

Lưu

</button>


</form>


</div>

</div>


@endsection