<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\PostsController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\RankController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RulesController;

date_default_timezone_set('Asia/Ho_Chi_Minh');

Route::get('/', [
    HomeController::class,
    'index'
]);

Route::get('/about', function () {
    return view('about.about')->with('select', 'about');
});

Route::get('/profile', [
    AccountController::class,
    'index'
]);

Route::post('/logout', [
    AccountController::class,
    'logout'
]);

Route::get('/user/{username}', [
    AccountController::class,
    'otherUser'
]);

Route::post('/user/{username}/update', [
    AccountController::class,
    'updateUser'
]);

Route::post('/login', [
    AuthController::class,
    'login'
]);

Route::get('/login', [
    AuthController::class,
    'loginPage'
]);

Route::post('/register', [
    AuthController::class,
    'register'
]);

Route::get('/register', [
    AuthController::class,
    'registerPage'
]);

Route::get('/blog', [
    BlogController::class,
    'index'
]);

Route::get('/blog/{id}', [
    BlogController::class,
    'showPost'
])->where([ 'id' => '[0-9]' ]);

Route::post('/blog/{id}', [
    BlogController::class,
    'sendComment'
])->where([ 'id' => '[0-9]' ]);

Route::get('/rules', [
    RulesController::class,
    'index'
]);

Route::prefix('/admin')->group(function () {
    Route::get('/blog/create', [
        BlogController::class,
        'createPostGet'
    ]);
    
    Route::post('/blog/create', [
        BlogController::class,
        'createPost'
    ]);

    Route::get('/rank', [
        RankController::class,
        'index'
    ]);

    Route::post('/rank/create', [
        RankController::class,
        'create'
    ]);

    Route::post('/user/{username}/update', [
        AccountController::class,
        'updateUserAdmin'
    ]);

    Route::get('/rank/{rankId}', [
        rankController::class,
        'rankEdit'
    ])->where([ 'rankId' => '[0-9]+' ]);

    Route::post('/rank/{rankId}/delete', [
        rankController::class,
        'deleteRank'
    ])->where([ 'rankId' => '[0-9]+' ]);

    Route::post('/rules/add', [
        rulesController::class,
        'addRule'
    ]);

    Route::post('/rules/{id}/delete', [
        rulesController::class,
        'deleteRule'
    ])->where([ 'rankId' => '[0-9]+' ]);

    Route::post('/rank/{rankId}/toggle/{permissionId}', [
        rankController::class,
        'togglePermission'
    ])->where([ 'rankId' => '[0-9]+', 'permissionId' => '[0-9]+' ]);
});