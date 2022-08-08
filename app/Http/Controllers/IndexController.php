<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IndexController extends Controller
{
    public function index(Request $request)
    {
        $req_path = $request->path();
        $user = Auth::user();

        if (Auth::check()) {
            if ($req_path == 'login') {
                return "Hi";
                return redirect()->back();
            }
        } else {
            return redirect('/');
        }
        
        return view('welcome');

        return $this->checkPermission($user, $req_path);
    }

    public function checkPermission($user, $path)
    {
        return $user->role->permission;
    }
}
