@extends ('layouts.app')
@section ('header')
<link rel="stylesheet" href="{{ asset('/storage/css/post.css') }}"/>
@endsection
@section ('content')

@if (isset($post))
<div class="postContainer">
    <h1>{{ $post->title }}</h1>
    
    <div>
        <div class="postInformation">
            <div class="author">{{ $post->author->username }}</div>
            <div class="createdAt">{{ $post->created_at }}</div>
        </div>
        
        <div class="content">
            {!! nl2br(htmlspecialchars($post->content)) !!}
        </div>
    </div>
    
    @if(isset($user))
        <h3>Hãy để lại bình luận</h3>
        @if (!empty($errors->all()))
            <div class="message error">
                {{ $errors->all()[0] }}
            </div>
        @endif
        <div>
            <form method="POST" class="commentContainer">
                @csrf
                <textarea name="content" class="commentBox" placeholder="Bình luận dưới tên {{ $user->username }}"></textarea>
                <div class="sendComment">
                    <button>Gửi</button>
                </div>
            </form>
        </div>
    @else
        <div class="message error">
            Bạn cần phải đăng nhập để bình luận
        </div>
    @endif
    <h3>Bình luận</h3>
    <div class="userComments">
        @foreach($post->comments as $comment)
            <div>
                <div class="commentInformation">
                    <div class="author"><a href="{{ URL("/user/{$comment->author?->username}") }}" }}>{{ $comment->author?->username ?? "Tài khoản không tồn tại" }}</a></div>
                    <div class="createdAt">{{ $comment->created_at }}</div>
                </div>
                <div class="content">{{ $comment->content }}</div>
            </div>
        @endforeach
    </div>
</div>
@else

<div class="message error">Không tìm thấy bài viết</div>

@endif

@endsection
