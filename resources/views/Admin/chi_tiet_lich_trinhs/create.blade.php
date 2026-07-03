@extends('Layouts.admin')

@section('content')

<div class="container-fluid">

    <div class="card shadow">

        <div class="card-header">

            <h4>

                <i class="fas fa-plus-circle"></i>

                Thêm hoạt động

            </h4>

        </div>

        <div class="card-body">

            <form action="{{ route('Admin.chi_tiet_lich_trinhs.store',$lichTrinh->id) }}"
                method="POST">

                @csrf

                <div class="row">

                    <div class="col-md-3">

                        <label>Giờ bắt đầu</label>

                        <input
                            type="time"
                            name="gio_bat_dau"
                            class="form-control"
                            required>

                    </div>

                    <div class="col-md-3">

                        <label>Giờ kết thúc</label>

                        <input
                            type="time"
                            name="gio_ket_thuc"
                            class="form-control">

                    </div>

                    <div class="col-md-6">

                        <label>Tiêu đề</label>

                        <input
                            type="text"
                            name="tieu_de"
                            class="form-control"
                            required>

                    </div>

                </div>

                <div class="mt-3">

                    <label>Nội dung</label>

                    <textarea
                        name="noi_dung"
                        rows="5"
                        class="form-control"></textarea>

                </div>

                <div class="mt-3">

                    <label>Thứ tự</label>

                    <input
                        type="number"
                        name="thu_tu"
                        value="0"
                        class="form-control">

                </div>

                <div class="mt-4">

                    <button class="btn btn-success">

                        <i class="fas fa-save"></i>

                        Lưu

                    </button>

                    <a
                        href="{{ route('Admin.chi_tiet_lich_trinhs.index',$lichTrinh->id) }}"
                        class="btn btn-secondary">

                        Quay lại

                    </a>

                </div>

            </form>

        </div>

    </div>

</div>

@endsection