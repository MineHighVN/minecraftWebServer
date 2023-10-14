<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Post;
use App\Models\Comment;

use DB;

include __DIR__ . '/../Utils/getTime.php';

class BlogController extends Controller {
    private $permRequired = 1;

    public function index (Request $request) {
        $posts = Post::orderBy('posts.created_at', 'desc')->join('users', 'users.id', 'posts.userId')->limit(10)->get();

        return view('blog.blog', [
            'select' => 'blog',
            'posts' => $posts,
            'postPermission' => $request->user()?->checkPerm($this->permRequired)
        ]);
    }

    private function getPost ($id) {
        $post = Post::where('posts.id', $id)->join('users', 'users.id', 'posts.userId')
        ->select('users.username', 'posts.content', 'posts.title',
        DB::raw(formatTime("posts.created_at")))->first();

        $comments = DB::table('comments')->where('comments.postId', $id)->leftJoin('users', 'users.id', 'comments.userId')
        ->select('comments.content', 'users.username', 'comments.created_at',

        DB::raw(formatTime("comments.created_at")))->orderBy('created_at', 'desc')->get();

        return [ 'post' => $post, 'comments' => $comments ];
    }
    
    public function showPost ($id) {
        $user = Auth::user();

        return view ('blog.showPost', [ 'select' => 'blog', 'user' => $user, 'post' => Post::find($id) ]);
    }

    public function sendComment (Request $request, $id) {
        if (!Auth::check()) redirect('/');
        
        $user = Auth::user();

        $request->validate([
            'content' => 'required'
        ], [
            'content.required' => 'Bình luận không được để trống'
        ]);

        $postExists = Post::where('id', $id)->first();

        $content = $request->input('content');

        if ($postExists) {
            $comment = new Comment;
            $comment->userId = $user->id;
            $comment->postId = $postExists->id;
            $comment->content = $content;
            $comment->save();
        }

        return back();
    }

    public function createPostGet(Request $request) {
        if (!Auth::check()) return redirect('/');

        if(!$request->user()->checkPerm($this->permRequired)) return back();
        
        return view('blog.createPost')->with('select', 'blog');
    }

    public function createPost(Request $request) {
        $user = $request->user();
        
        if (!$user) return redirect('/');

        if(!$user->checkPerm($this->permRequired)) return back();

        $title = $request->title;
        $content = $request->content;

        $request->validate([
            'title' => 'required|max:60',
            'content' => 'required'
        ], [
            'title.max' => 'Tiêu đề được vượt không quá 60 kí tự',
            'title.required' => 'Tiêu đề bài viết là bắt buộc',
            'content.required' => 'Nội dung bài viết là bắt buộc'
        ]);

        $post = new Post;
        $post->userId = $user->id;
        $post->title = $title;
        $post->content = $content;
        $post->save();

        return back();
    }
}