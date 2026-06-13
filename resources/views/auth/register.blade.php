@extends('layouts.app')

@section('content')

<style>
*{
    margin:0;
    padding:0;
    box-sizing:border-box;
}

body{
    font-family:'Poppins',sans-serif;
    overflow-x:hidden;
}

.register-page{
    min-height:100vh;
    display:flex;
    background:url('https://images.unsplash.com/photo-1500530855697-b586d89ba3ee')
    center center/cover no-repeat;
    position:relative;
}

.register-page::before{
    content:'';
    position:absolute;
    inset:0;
    background:rgba(0,0,0,.5);
}

.left-side{
    flex:1;
    display:flex;
    align-items:center;
    justify-content:center;
    color:white;
    position:relative;
    z-index:2;
}

.brand{
    max-width:650px;
    padding:40px;
}

.brand h1{
    font-size:70px;
    font-weight:800;
    margin-bottom:15px;
}

.brand p{
    font-size:22px;
    opacity:.9;
}

.right-side{
    width:550px;
    background:rgba(255,255,255,.12);
    backdrop-filter:blur(20px);
    border-left:1px solid rgba(255,255,255,.15);
    position:relative;
    z-index:2;
    display:flex;
    align-items:center;
}

.register-card{
    width:100%;
    padding:50px;
}

.register-title{
    color:#fff;
    font-size:34px;
    font-weight:700;
    margin-bottom:10px;
}

.register-subtitle{
    color:rgba(255,255,255,.8);
    margin-bottom:30px;
}

.form-group{
    margin-bottom:18px;
}

.form-label{
    color:#fff;
    display:block;
    margin-bottom:8px;
    font-weight:500;
}

.form-control{
    width:100%;
    height:52px;
    border:none;
    border-radius:12px;
    padding:0 18px;
    background:rgba(255,255,255,.15);
    color:#fff;
    transition:.3s;
}

.form-control::placeholder{
    color:rgba(255,255,255,.7);
}

.form-control:focus{
    outline:none;
    background:rgba(255,255,255,.25);
    box-shadow:0 0 0 3px rgba(255,255,255,.15);
}

.btn-register{
    width:100%;
    height:55px;
    border:none;
    border-radius:12px;
    background:#fbbf24;
    color:#111827;
    font-size:16px;
    font-weight:700;
    cursor:pointer;
    transition:.3s;
}

.btn-register:hover{
    transform:translateY(-3px);
    box-shadow:0 15px 30px rgba(251,191,36,.4);
}

.text-danger{
    color:#fecaca;
    font-size:13px;
    margin-top:4px;
}

.alert{
    border-radius:12px;
}

.login-link{
    text-align:center;
    margin-top:20px;
    color:white;
}

.login-link a{
    color:#fbbf24;
    text-decoration:none;
    font-weight:600;
}

.login-link a:hover{
    text-decoration:underline;
}

@media(max-width:991px){
    .left-side{
        display:none;
    }

    .right-side{
        width:100%;
    }
}
</style>

<div class="register-page">

    <div class="left-side">
        <div class="brand">
            <h1>TravelLoula</h1>
            <p>
                Tạo tài khoản để bắt đầu hành trình khám phá
                những điểm đến tuyệt vời cùng TravelLoula.
            </p>
        </div>
    </div>

    <div class="right-side">

        <div class="register-card">

            <div class="register-title">
                Đăng ký tài khoản
            </div>

            <div class="register-subtitle">
                Chào mừng bạn đến với TravelLoula
            </div>

            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <form method="POST" action="{{ route('register.perform') }}">
                @csrf

                <div class="form-group">
                    <label class="form-label">Họ và tên</label>
                    <input type="text"
                           name="name"
                           class="form-control"
                           placeholder="Nhập họ tên"
                           value="{{ old('name') }}">
                    <div class="text-danger">{{ $errors->first('name') }}</div>
                </div>

                <div class="form-group">
                    <label class="form-label">Email</label>
                    <input type="email"
                           name="email"
                           class="form-control"
                           placeholder="Nhập email"
                           value="{{ old('email') }}">
                    <div class="text-danger">{{ $errors->first('email') }}</div>
                </div>

                <div class="form-group">
                    <label class="form-label">Mật khẩu</label>
                    <input type="password"
                           name="password"
                           class="form-control"
                           placeholder="Nhập mật khẩu">
                    <div class="text-danger">{{ $errors->first('password') }}</div>
                </div>

                <div class="form-group">
                    <label class="form-label">Điện thoại</label>
                    <input type="text"
                           name="phone"
                           class="form-control"
                           placeholder="Nhập số điện thoại"
                           value="{{ old('phone') }}">
                </div>

                <div class="form-group">
                    <label class="form-label">Địa chỉ</label>
                    <input type="text"
                           name="address"
                           class="form-control"
                           placeholder="Nhập địa chỉ"
                           value="{{ old('address') }}">
                </div>

                <button type="submit" class="btn-register">
                    ĐĂNG KÝ TÀI KHOẢN
                </button>

                <div class="login-link">
                    Đã có tài khoản?
                    <a href="{{ route('login') }}">
                        Đăng nhập ngay
                    </a>
                </div>

            </form>

        </div>

    </div>

</div>

@endsection
