<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    public function createPost(Request $request) {
        $incomingFields = $request->validate([
            'title' => 'required',
            'body' => 'required'
        ]);

        $incomingFields['title'] = strip_tags($incomingFields['title']);
        $incomingFields['body'] = strip_tags($incomingFields['body']);

        $incomingFields['user_id'] = Auth::user()->id;

        Post::create($incomingFields);

        return redirect('/');
    }

    public function showEditScreen(Post $post) {
        if (Auth::id() === $post->user_id) {
            return view('edit-post', ['post' => $post]);
        } else {
            return redirect('/');
        }
    }

    public function sendEdit(Post $post, Request $request) {
        if (Auth::id() !== $post->user_id) {
            return redirect('/');
        }

        $incomingFields = $request->validate([
            'title'=> 'required',
            'body'=> 'required'
        ]);

        $incomingFields['title'] = strip_tags($incomingFields['title']);
        $incomingFields['body'] = strip_tags($incomingFields['body']);

        $post->update($incomingFields);
        return redirect('/');
    }

    public function deletePost(Post $post) {
        if (Auth::id() === $post->user_id) {
            $post->delete();
        }
        
        return redirect('/');
    }
}
