<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function login(Request $request) {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (Auth::attempt(['email'=>$request->email, 'password'=>$request->password])) {
            return response()->json([
                'msg'=>'Login successfully',
                'userStatus' => true,
                'userDetails' => Auth::user(),
            ]);
        } else {
            return response()->json(['msg'=>'Invalid credential'], 422);
        }
    }

    public function logout() {
        Auth::logout();
        return redirect('/');
    }
}
