<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use App\Service\AvatarService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class AdminController extends Controller
{
    /** @var AvatarService */
    private $avatarService;

    public function __construct(AvatarService $avatarService)
    {
        $this->avatarService = $avatarService;
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|RedirectResponse
     */
    public function index(): View
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

    /**
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|RedirectResponse
     */
    public function userEdit($id): RedirectResponse
    {
        $user = User::query()->findOrFail($id);
        if (Gate::allows('user-edit', [self::class, $id])) {
            return view('user.edit', [
                'user' => $user
            ]);
        }
        return redirect()->route('index');
    }

    /**
     * @param Request $request
     * @param $id
     * @return RedirectResponse
     */
    public function userUpdate(Request $request, $id): RedirectResponse
    {
        $roles = [
            'name' => 'required|min:3|max:100|string'
        ];
        $request->validate($roles);

        if (!Gate::allows('user-update', [self::class, $id])) {
            return redirect()->route('index');
        }

        if ($request->hasFile('avatar')) {
            $this->avatarService->avatarStore($request);
        }

        User::query()->findOrFail($id)->update([
            'name' => $request->get('name')
        ]);

        return redirect()->back()->with([
            'success' => 'Данные обновленны!'
        ]);
    }
}
