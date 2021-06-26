<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;

class AdminController extends AvatarController
{
    public function index()
    {
        if (Gate::allows('has-admin', [self::class])) {
            $postPublished = Post::query()->where('published', '=', 1)->get();
            $postNoPublished = Post::query()->where('published', '=', 0)->get();
            $users = User::all();
            return \view('admin.index', [
                'postPublished' => $postPublished,
                'postNoPublished' => $postNoPublished,
                'users' => $users
            ]);
        }
        return redirect()->route('index');
    }

    /**
     * @param int $id
     * @return RedirectResponse
     */
    public function published(int $id): RedirectResponse
    {
        if (Gate::allows('has-admin', [self::class])) {
            Post::query()
                ->findOrFail($id)
                ->update([
                    'published' => true
                ]);

            return redirect()->back();
        }
        return redirect()->route('index');
    }

    /**
     * @param int $id
     * @return RedirectResponse
     */
    public function cancellationOfPublication(int $id): RedirectResponse
    {
        if (!Gate::allows('has-admin', [self::class])) {
            return redirect()->route('index');
        }
        $post = Post::query()->findOrFail($id);

        Storage::disk('public')->delete($post->image);
        $post->delete();

        return redirect()->back();
    }

    public function userEdit($id)
    {
        $user = User::query()->findOrFail($id);
        if (Gate::allows('user-edit', [self::class, $id])) {
            return view('user.edit', [
                'user' => $user
            ]);
        }
        return redirect()->route('index');
    }

    public function userUpdate(Request $request, $id)
    {
        $roles = [
            'name' => 'required|min:3|max:100|string'
        ];
        $request->validate($roles);

        if (!Gate::allows('user-update', [self::class, $id])) {
            return redirect()->route('index');
        }

        if ($request->hasFile('avatar')) {
            $this->avatarStore($request);
        }

        User::query()->findOrFail($id)->update([
            'name' => $request->get('name')
        ]);

        return redirect()->back()->with([
            'success' => 'Данные обновленны!'
        ]);
    }
}
