<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    public function comments () {
        return $this->hasMany(Comment::class, 'postId', 'id')->orderBy('created_at', 'desc');
    }

    public function author () {
        return $this->hasOne(User::class, 'id', 'userId');
    }
}
