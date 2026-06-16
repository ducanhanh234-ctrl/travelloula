@extends('layouts.admin')

@section('title','Quản lý Danh Mục')

@section('content')

<div class="container-fluid">


<div class="card shadow border-0 rounded-4">


<div class="card-header bg-primary text-white rounded-top-4 d-flex justify-content-between align-items-center">


<h4 class="mb-0">

<i class="fa fa-folder"></i>

Quản lý danh mục

</h4>



<a href="{{route('Admin.danh_mucs.create')}}"

class="btn btn-light text-primary fw-bold">


<i class="fa fa-plus"></i>

Thêm danh mục


</a>


</div>





<div class="card-body p-4">





<form method="GET"

class="mb-4">


<div class="row">


<div class="col-md-6">


<div class="input-group">


<input

class="form-control"

name="keyword"

value="{{$keyword}}"

placeholder="🔍 Tìm kiếm danh mục...">



<button

class="btn btn-primary"

type="submit">


Tìm kiếm


</button>


</div>


</div>


</div>



</form>







<div class="table-responsive">


<table class="table table-hover align-middle">


<thead class="table-light">


<tr>


<th width="80">

ID

</th>


<th>

Tên danh mục

</th>


<th>

Mô tả

</th>


<th>

Trạng thái

</th>


<th width="250">

Thao tác

</th>


</tr>


</thead>





<tbody>



@foreach($danhMucs as $item)



<tr>



<td>


<span class="badge bg-secondary">

{{$item->id}}

</span>


</td>





<td>


<h6 class="mb-0 text-primary">


{{$item->ten_danh_muc}}


</h6>


</td>







<td>


@if($item->mo_ta)


{{$item->mo_ta}}


@else


<span class="text-muted">

Không có mô tả

</span>


@endif



</td>







<td>



@if($item->trang_thai == 'active')


<span class="badge bg-success px-3 py-2">


<i class="fa fa-check"></i>

Hoạt động


</span>


@else


<span class="badge bg-danger px-3 py-2">


<i class="fa fa-lock"></i>

Ẩn


</span>


@endif



</td>









<td>



<a

href="{{route('Admin.danh_mucs.show',$item)}}"

class="btn btn-info btn-sm text-white">


<i class="fa fa-eye"></i>

Xem


</a>





<a

href="{{route('Admin.danh_mucs.edit',$item)}}"

class="btn btn-warning btn-sm text-white">


<i class="fa fa-edit"></i>

Sửa


</a>







<form

style="display:inline"

method="POST"

action="{{route('Admin.danh_mucs.destroy',$item)}}">


@csrf

@method('DELETE')



<button

onclick="return confirm('Bạn có chắc muốn xóa?')"

class="btn btn-danger btn-sm">


<i class="fa fa-trash"></i>

Xóa


</button>


</form>




</td>



</tr>



@endforeach




</tbody>



</table>



</div>






<div class="mt-3">


{{$danhMucs->links()}}


</div>






</div>



</div>



</div>



@endsection