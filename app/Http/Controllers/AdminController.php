<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AdminController extends Controller
{
    public function index()
    {
        if (Auth::user()->hasRole('admin')) {
            $posts = Post::all();
            $postNoPublished = Post::query()->where('published', '=', 0)->get();
            $users = User::all();
            return \view('admin.index',[
                'posts' => $posts,
                'postNoPublished' => $postNoPublished,
                'users' => $users
            ]);
        }
        return redirect()->route('index');
    }
}
