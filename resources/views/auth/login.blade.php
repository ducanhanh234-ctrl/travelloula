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
    overflow:hidden;
}

.login-page{
    min-height:100vh;
    display:flex;
    background:url('https://images.unsplash.com/photo-1507525428034-b723cf961d3e')
    center center/cover no-repeat;
    position:relative;
}

.login-page::before{
    content:'';
    position:absolute;
    inset:0;
    background:rgba(0,0,0,.45);
}

.left-side{
    flex:1;
    display:flex;
    align-items:center;
    justify-content:center;
    color:#fff;
    position:relative;
    z-index:2;
}

.brand{
    max-width:600px;
    padding:40px;
}

.brand h1{
    font-size:70px;
    font-weight:800;
    margin-bottom:15px;
    letter-spacing:2px;
}

.brand p{
    font-size:22px;
    opacity:.9;
}

.right-side{
    width:500px;
    background:rgba(255,255,255,.12);
    backdrop-filter:blur(20px);
    border-left:1px solid rgba(255,255,255,.15);
    display:flex;
    align-items:center;
    justify-content:center;
    position:relative;
    z-index:2;
}

.login-card{
    width:100%;
    padding:50px;
}

.login-title{
    color:#fff;
    font-size:35px;
    font-weight:700;
    margin-bottom:10px;
}

.login-subtitle{
    color:rgba(255,255,255,.8);
    margin-bottom:35px;
}

.form-group{
    margin-bottom:20px;
}

.form-label{
    display:block;
    color:#fff;
    margin-bottom:8px;
    font-weight:500;
}

.form-control{
    width:100%;
    height:55px;
    border:none;
    border-radius:12px;
    padding:0 20px;
    background:rgba(255,255,255,.15);
    color:#fff;
    font-size:15px;
}

.form-control::placeholder{
    color:rgba(255,255,255,.7);
}

.form-control:focus{
    outline:none;
    background:rgba(255,255,255,.22);
    box-shadow:0 0 0 3px rgba(255,255,255,.15);
}

.btn-login{
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

.btn-login:hover{
    transform:translateY(-3px);
    box-shadow:0 15px 30px rgba(251,191,36,.4);
}

.text-danger{
    color:#fecaca;
    font-size:13px;
    margin-top:5px;
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

<div class="login-page">

    <div class="left-side">
        <div class="brand">
            <h1>TravelLoula</h1>
            <p>
                Khám phá thế giới cùng những hành trình
                đẳng cấp và trải nghiệm đáng nhớ.
            </p>
        </div>
    </div>

    <div class="right-side">

        <div class="login-card">

            <div class="login-title">
                Đăng nhập
            </div>

            <div class="login-subtitle">
                Hệ thống quản trị TravelLoula
            </div>

            @if ($errors->any())
                <div class="alert alert-danger" style="margin-bottom:20px;">
                    @foreach ($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            @endif

            <form method="POST" action="{{ route('login.perform') }}">
                @csrf

                <div class="form-group">
                    <label class="form-label">Email</label>
                    <input
                        type="email"
                        name="email"
                        class="form-control"
                        placeholder="Nhập email"
                        value="{{ old('email') }}"
                    >
                    <div class="text-danger">
                        {{ $errors->first('email') }}
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Mật khẩu</label>
                    <input
                        type="password"
                        name="password"
                        class="form-control"
                        placeholder="Nhập mật khẩu"
                    >
                    <div class="text-danger">
                        {{ $errors->first('password') }}
                    </div>
                </div>

                <button type="submit" class="btn-login">
                    ĐĂNG NHẬP
                </button>

            </form>

        </div>

    </div>

</div>
@endsection
