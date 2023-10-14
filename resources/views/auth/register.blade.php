@extends('layouts.auth.auth')
@section('content')
<div><i class="fa-solid fa-user"></i><input value="{{ old('username') }}" placeholder="Tên đăng nhập" name='username'/></div>
<div><i class="fa-solid fa-lock"></i><input placeholder="Mật khẩu" name='password' type="password"/></div>
<div><i class="fa-solid fa-lock"></i><input placeholder="Nhập lại mật khẩu" name='re-password' type="password"/></div>
@endsection