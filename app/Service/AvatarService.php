<?php

namespace App\Service;

use App\Models\Avatar;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AvatarService
{
    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function avatarStore(Request $request): RedirectResponse
    {
        $roles = [
            'avatar' => 'required | mimes:jpeg,png,jpg | max:2048',
        ];
        $request->validate($roles);
        $avatarPath = $request->file('avatar')->store('avatar', 'public');

        try {
            $avatar = Avatar::query()->where('user_id','=', Auth::id())->firstOrFail();
            Storage::disk('public')->delete($avatar->avatar);
            $avatar->update([
                'avatar' => $avatarPath
            ]);
        }catch (ModelNotFoundException $exception){
            $avatar = new Avatar();
            $avatar->user_id = $request->user()->id;
            $avatar->avatar = $avatarPath;
            $avatar->save();
        }

        return redirect()->back();
    }
}
