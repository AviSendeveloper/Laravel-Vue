<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
    public function addAdmin(Request $request) {
        // Validation
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'role_id' => 'required',
        ]);
        
        if ($validator->fails()) {
            return response()->json(['errors'=>$validator->errors()], 422);
        }

        // return $request->all();

        $password = bcrypt($request->password);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $password,
            'role_id' => $request->role_id,
        ]);

        $details = User::with('role')->where('id', $user->id)->first();

        return response()->json($details, 201);
    }

    public function getAdmin() {
        $data = User::with('role')->orderBy('id', 'DESC')->get();
        return response()->json($data);
    }

    public function editAdmin(Request $request) {
        // Validation
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'role_id' => 'required',
        ]);
        
        if ($validator->fails()) {
            return response()->json(['errors'=>$validator->errors()], 422);
        }
        
        User::where('id', $request->id)->update([
            'name' => $request->name,
            'email' => $request->email,
            'role_id' => $request->role_id,
        ]);

        $details = User::with('role')->where('id', $request->id)->first();

        return response()->json($details, 200);
    }

    public function deleteAdmin(Request $request) {
        $admin = User::where('id', $request->id)->delete();
        return response()->json(['msg'=>'Deleted successfully']);
    }
}
