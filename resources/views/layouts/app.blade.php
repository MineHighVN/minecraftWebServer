<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="{{ asset('/storage/css/index.css') }}"/>
    <link rel="stylesheet" href="{{ asset('/storage/css/navbar.css') }}" />
    <link rel="stylesheet" href="{{ asset('/storage/css/footer.css') }}" />
    <link rel="icon" href="{{ asset("/storage/image/logo.png") }}" />

    <script src="{{ asset('/storage/javascript/navbar.js') }}"></script>

    @yield('header')

    <title>{{ env('SERVER_TITLE') }}</title>
</head>
<body>
    <div class="container">
        @include('layouts.header')
        <div class="body">
            @yield('content')
        </div>
    </div>
    @include('layouts.footer')
</body>
</html>