<?php

use App\Models\Post;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;

// Basic Routing

Route::get('/', function () {
    // $posts = Post::all(); //get all posts from db
    // $posts = Post::where('user_id', Auth::id())->get(); //get posts where user_id in post == the id of user in Auth

    $posts = [];

    if (Auth::check()) {
        $posts = Auth::user()->posts()->latest()->get(); //get latest posts from current logged in user via Auth
    }

    return view('home', ['posts' => $posts]);
});

// User Controller

Route::post('/register', [UserController::class, 'register']);

Route::post('/logout', [UserController::class, 'logout']);

Route::post('/login', [UserController::class, 'login']);

// Post Controller

Route::post('/create-post', [PostController::class, 'createPost']);

Route::get('/edit-post/{post}', [PostController::class, 'showEditScreen']);

Route::put('/edit-post/{post}', [PostController::class, 'sendEdit']);

Route::delete('/delete-post/{post}', [PostController::class, 'deletePost']);