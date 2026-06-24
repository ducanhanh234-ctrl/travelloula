@extends('layouts.admin_pro')


@section('content')


<div class="card">

    <div class="card-body">


        <form method="POST" action="{{route('Admin.danh_mucs.update',$danhMuc)}}">


            @csrf

            @method('PUT')


            @include('Admin.danh_mucs.form')


            <button class="btn btn-success">

                Cập nhật

            </button>


        </form>


    </div>

</div>


@endsection
