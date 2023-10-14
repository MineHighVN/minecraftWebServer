@extends ('layouts.app')
@section ('header')
<link rel="stylesheet" href="{{ asset('/storage/css/blog.css') }}"/>
@endsection
@section('content')

@if ($postPermission)
    <div class="createPostBox">
        <a class="createPostRedirect" href="/admin/blog/create">Xin chào bạn! Hãy viết gì đi chứ!</a>
    </div>
@endif
<div class="blogContainer">
    @foreach ($posts as $post)
        <a href="{{ URL("/blog/{$post->id}") }}">
            <div class="title"><h1>{{ $post->title }}</h1></div>
            <div class="authorWCreatedAt">
                <div class="author"><span><i class="fa-regular fa-user"></i> Tác giả: {{ $post->author->username }}</span></div>
                <div class="createdAt">Thời gian {{ $post->created_at }}</div>
            </div>
            <div class="description"><span>{!! nl2br(htmlspecialchars(substr($post->content, 0, 100))) !!} @if (strlen($post->content) > 100) <b>...Đọc thêm</b> @endif</span></div>
        </a>
    @endforeach
</div>

@endsection