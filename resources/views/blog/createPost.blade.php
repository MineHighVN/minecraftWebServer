@extends ('layouts.app')
@section ('header')
<link rel="stylesheet" href="{{ asset('/storage/css/blog.css') }}"/>
@endsection
@section('content')

<div class="createPostContainer">
    <h1 class="createPostTitle">Tạo bài viết mới</h1>
    
    <div class="errorBox">
        @unless (empty($errors->all()))
            <div class="message error">{{ $errors->all()[0] }}</div>
        @endunless
    </div>
    
    <div class="createPost">
        <form method="POST">
            @csrf
            <input name="title" type="text" placeholder="Tiêu đề bài viết" />
            <textarea name="content" placeholder="Nội dung bài viết"></textarea>
            <button>Đăng bài</button>
        </form>
    </div>
</div>


@endsection