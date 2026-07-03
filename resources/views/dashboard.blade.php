<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
</head>

<body class="p-10">

    <h1>🎉 Bạn đã đăng nhập thành công!</h1>

    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit">Đăng xuất</button>
    </form>

</body>

</html>
