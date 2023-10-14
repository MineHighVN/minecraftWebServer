@extends('layouts.app')

@section ('header')
<link rel="stylesheet" href="{{ URL('/storage/css/home.css') }}" />
<script>
    const serverIP = "{{ env('SERVER_IP') }}"
</script>
<script src="{{ asset('/storage/javascript/home.js') }}"></script>
@endsection

@section('content')
<div class="home">
    @if ($permsCount)
        <div class="adminPanel">
            <h3>ADMIN PANEL</h3>
            <div class="option">
                <a href="{{ URL('/admin/rank/') }}">Quản lí rank</a>
                <a href="{{ URL('/admin/blog/create') }}">Tạo bài viết</a>
                <a href="{{ URL('/rules') }}">Quản lí luật chung</a>
            </div>
        </div>
    @endif
    <div class="homeBody">
        <div class="serverInformation">
            
        </div>
    </div>
</div>
@endsection