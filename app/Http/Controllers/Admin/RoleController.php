<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RoleController extends Controller
{
    public function addRole(Request $request) {
        // Validation
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'isAdmin' => 'required',
        ]);
        
        if ($validator->fails()) {
            return response()->json(['errors'=>$validator->errors()], 422);
        }

        return Role::create([
            'name' => $request->name,
            'isAdmin' => $request->isAdmin,
        ]);
    }

    public function getRole() {
        $data = Role::orderBy('id', 'DESC')->get();
        return response()->json($data);
    }

    public function editRole(Request $request) {
        // Validation
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'isAdmin' => 'required',
        ]);
        
        if ($validator->fails()) {
            return response()->json(['errors'=>$validator->errors()], 422);
        }
        
        return Role::where('id', $request->id)->update([
            'name' => $request->name,
            'isAdmin' => $request->isAdmin,
        ]);
    }

    public function deleteRole(Request $request) {
        $Role = Role::where('id', $request->id)->delete();
        return response()->json(['msg'=>'Deleted successfully']);
    }
}
