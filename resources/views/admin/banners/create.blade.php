@extends('layouts/admin_pro')


@section('content')


<div class="card">

    <div class="card-body">


        <form method="POST" action="{{route('Admin.banners.store')}}">


            @csrf


            @include('Admin.banners.form')


            <button class="btn btn-primary">

                Lưu

            </button>


        </form>


    </div>

</div>


@endsection
