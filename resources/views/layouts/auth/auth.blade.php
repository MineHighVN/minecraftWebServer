<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel='stylesheet' href='{{ asset('/storage/css/auth.css') }}' />
    <link rel='stylesheet' href='{{ asset('/storage/css/index.css') }}' />
    <link rel="icon" href="{{ asset("/storage/image/logo.png") }}" />
    <title>{{ $title }}</title>
</head>
<body>
    <?php $authText = $type === 'login' ? "Đăng nhập" : "Đăng ký" ?>
    <div class="back"><a href='/'><i class="fa-solid fa-arrow-left"></i></a></div>
    <form method="POST">
        @csrf
        <div class="authContainer">
            <div class="authBox">
                <div class="authLeft">
                    <div>
                        <h1>{{ $authText }}</h1>
                        <h2>Trở thành thành viên của {{ env('SERVER_IP') }}</h2>
                    </div>
                    <div class="messageBox">
                        @if ($errors->all())
                            <div class="message error">{{ $errors->all()[0] }}</div>
                        @endunless
                        @if (isset($successMsg) && !$errors->all())
                            <div class="message success">{{ $successMsg }}</div>
                        @endif
                    </div>
                    <div class="authInput">
                        @yield('content')
                    </div>
                </div>
                <div class="authRight">
                    <div><button class="authButton">{{ $authText }}</button></div>
                    <div>Bạn {{ $type === 'login' ? 'chưa' : 'đã' }} có tài khoản? <a href='{{ URL($type === 'login' ? '/register' : '/login') }}'>{{ $type === 'login' ? "Đăng ký" : "Đăng nhập" }}</a></div>
                </div>
            </div>
        </div>
    </form>
</body>
</html>