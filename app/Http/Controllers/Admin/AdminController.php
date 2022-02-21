<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminController extends Controller
{
    /**
     * @return View
     */
    public function index(): View
    {
        $users = User::get();

        return view('admin.index',[
            'users' => $users
        ]);
    }
}
