@extends('layouts.admin_pro')


@section('content')


<div class="container-fluid">


    <div class="row justify-content-center">


        <div class="col-md-8">



            <div class="card shadow-lg border-0 rounded-4">



                <div class="card-header bg-primary text-white rounded-top-4">


                    <h4 class="mb-0">

                        <i class="fa fa-folder-open"></i>

                        Chi tiết danh mục

                    </h4>


                </div>




                <div class="card-body p-4">



                    <div class="text-center mb-4">


                        @if($danhMuc->hinh_anh)

                        <img src="{{$danhMuc->hinh_anh}}" class="img-fluid rounded-3 shadow" style="width:250px;height:180px;object-fit:cover;" alt="Hình ảnh danh mục">


                        @else


                        <img src="https://via.placeholder.com/250" class="img-fluid rounded-3 shadow">


                        @endif



                    </div>





                    <div class="mb-3">


                        <label class="fw-bold text-secondary">

                            Tên danh mục

                        </label>


                        <div class="fs-4 fw-semibold text-primary">

                            {{$danhMuc->ten_danh_muc}}

                        </div>


                    </div>







                    <div class="mb-3">


                        <label class="fw-bold text-secondary">

                            Mô tả

                        </label>


                        <p class="text-muted">

                            {{$danhMuc->mo_ta ?? 'Không có mô tả'}}

                        </p>


                    </div>







                    <div class="mb-3">


                        <label class="fw-bold text-secondary">

                            Trạng thái

                        </label>


                        <br>


                        @if($danhMuc->trang_thai == 'active')


                        <span class="badge bg-success px-3 py-2">

                            <i class="fa fa-check"></i>

                            Đang hoạt động

                        </span>


                        @else


                        <span class="badge bg-danger px-3 py-2">

                            <i class="fa fa-lock"></i>

                            Ngừng hoạt động

                        </span>


                        @endif



                    </div>




                    <div class="mt-4">


                        <a href="{{route('Admin.danh_mucs.index')}}" class="btn btn-secondary">


                            <i class="fa fa-arrow-left"></i>

                            Quay lại


                        </a>



                        <a href="{{route('Admin.danh_mucs.edit',$danhMuc)}}" class="btn btn-warning text-white">


                            <i class="fa fa-edit"></i>

                            Chỉnh sửa


                        </a>



                    </div>




                </div>


            </div>



        </div>


    </div>


</div>



@endsection
