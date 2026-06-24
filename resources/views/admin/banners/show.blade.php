@extends('layouts.admin_pro')


@section('content')


<div class="card">

<div class="card-body">


<h3>{{$banner->tieu_de}}</h3>


<img 

src="{{$banner->hinh_anh    }}"

width="400">


<p>

{{$banner->mo_ta}}

</p>


</div>


</div>


@endsection