<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('welcome');
    }

    /**
     * @return View
     */
    public function posts(): View
    {
        $posts = Post::with('user')->get();
        return view('index', [
            'posts' => $posts
        ]);
    }

    /**
     * @return View
     */
    public function getMyPosts(): View
    {
        $posts = User::find(Auth::id())->posts;

        return \view('user.index', ['posts' => $posts]);
    }

    public function avatarStore(Request $request, $id = null)
    {
        $request->validate([
            'avatar' => [
             'required',
                'mimes:jpeg,jpg,png,gif|required|max:10000'
            ]
        ]);

        $path = $request->file('avatar')->store('avatars','public');
        if (is_null($id)){
            if ($path){
                User::find(auth()->id())->update([
                    'avatar' => $path
                ]);

                return redirect()->back()->with([
                    'success' => 'Аватар изменен!'
                ]);
            }
            return redirect()->back()->withErrors([
                'errors' => 'Ошибка при измении аватарки'
            ]);
        }else{
            if ($request->user()->can('isAdmin')){
                User::find($id)->update([
                   'avatar' => $path
                ]);

                return redirect()->back();
            }
        }

    }
}
