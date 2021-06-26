<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class MainController extends Controller
{
    /** @return View */
    public function index(): View
    {
        $posts = Post::query()->where('published', '=', 1)->paginate(12);

        return view('index',
            [
                'posts' => $posts
            ]);
    }

    /** @return View */
    public function create(): View
    {
        return \view('posts.create');
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        $roles = [
            'title' => 'required|string|min:5|max:255',
            'description' => 'required|string:10|max:2000',
            'image' => 'required|mimes:jpeg,png,jpg|max:2048',
        ];
        $request->validate($roles);

        $image = $request->file('image')->store('images', 'public');
        try {
            DB::transaction(function () use ($request, $image) {
                $post = new Post();
                $post->title = $request->get('title');
                $post->description = $request->get('description');
                $post->user_id = Auth::id();
                $post->image = $image;
                $post->save();
                DB::commit();
            });
        } catch (\Exception $exception) {
            Storage::disk('public')->delete($image);
            DB::rollBack();
            return \redirect()->back()
                ->withErrors(['errors' => 'Проверте правильность введенных данных.']);
        }

        return \redirect()->back('201')
            ->with(['success' => 'Пост отправлен на проверку администратору.']);
    }

    /**
     * @param int $id
     * @return View
     */
    public function show(int $id): View
    {
        $post = Post::query()->findOrFail($id);

        return \view('posts.show',
            [
                'post' => $post
            ]);
    }

    /**
     * @param int $id
     * @return RedirectResponse
     */
    public function delete(int $id): RedirectResponse
    {
        if (Gate::allows('delete', Post::find($id))) {
            $post = Post::query();
            Storage::disk('public')->delete($post->findOrFail($id)->image);
            $post->delete();

            return redirect()->route('index');
        }

        return redirect()->route('index');
    }

    public function edit(int $id)
    {
        $post = Post::find($id);

        if (Gate::allows('edit', $post)) {
            return \view('posts.edit', [
                'post' => $post
            ]);
        }
        return redirect()->route('index');

    }

    /**
     * @param Request $request
     * @param int $id
     * @return RedirectResponse
     */
    public function update(Request $request, int $id): RedirectResponse
    {
        $roles = [
            'title' => 'required|string|min:5|max:255',
            'description' => 'required|string:10|max:2000',
            'image' => 'mimes:jpeg,png,jpg|max:2048',
        ];
        $request->validate($roles);

        $post = Post::query()->findOrFail($id);
        if (!Gate::allows('update', $post)) {
            return redirect()->back();
        }

        if ($request->hasFile('image')) {
            Storage::disk('public')->delete($post->image);
            $imagePath = $request->file('image')->store('images', 'public');
            $post->update([
                'image' => $imagePath
            ]);
        }

        $post->update([
            'title' => $request->get('title'),
            'description' => $request->get('description')
        ]);

        return redirect()->back()
            ->with(['success' => 'Обновления прошло успешно!']);
    }
}
