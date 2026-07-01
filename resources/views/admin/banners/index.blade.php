@extends('layouts.admin')


@section('title','Quản lý Banner')


@section('content')


<div class="card">

<div class="card-header">

<h4>
Quản lý Banner
</h4>


<a href="{{route('Admin.banners.create')}}"
class="btn btn-primary">

<i class="fa fa-plus"></i>
Thêm banner

</a>


</div>



<div class="card-body">



<form>

<input

name="keyword"

value="{{$keyword}}"

class="form-control"

placeholder="Tìm kiếm tiêu đề...">


</form>




<table class="table mt-3">


<tr>

<th>ID</th>

<th>Ảnh</th>

<th>Tiêu đề</th>

<th>Loại</th>

<th>Trạng thái</th>

<th>Action</th>

</tr>



@foreach($banners as $item)


<tr>


<td>{{$item->id}}</td>


<td>

<img src="{{$item->hinh_anh}}"

width="100">

</td>


<td>{{$item->tieu_de}}</td>


<td>{{$item->loai_banner}}</td>


<td>

@if($item->trang_thai_hoat_dong)

<span class="badge bg-success">

Hoạt động

</span>

@else

<span class="badge bg-danger">

Ẩn

</span>

@endif

</td>



<td>


<a class="btn btn-info btn-sm"

href="{{route('Admin.banners.show',$item)}}">

Xem

</a>



<a class="btn btn-warning btn-sm"

href="{{route('Admin.banners.edit',$item)}}">

Sửa

</a>



<form

style="display:inline"

method="POST"

action="{{route('Admin.banners.destroy',$item)}}">


@csrf

@method('DELETE')


<button

onclick="return confirm('Xóa?')"

class="btn btn-danger btn-sm">

Xóa

</button>


</form>


</td>


</tr>


@endforeach


</table>



{{$banners->links()}}



</div>


</div>


@endsection