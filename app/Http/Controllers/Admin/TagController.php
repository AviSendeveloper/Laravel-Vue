<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Tag;
use Illuminate\Support\Facades\Validator;

class TagController extends Controller
{
    public function addTag(Request $request) {
        // Validation
        $validator = Validator::make($request->all(), [
            'name' => 'required',
        ]);
        
        if ($validator->fails()) {
            return response()->json(['errors'=>$validator->errors()]);
        }

        return Tag::create([
            'name' => $request->name,
        ]);
    }

    public function getTag() {
        $data = Tag::orderBy('id', 'DESC')->get();
        return response()->json($data);
    }

    public function editTag(Request $request) {
        // Validation
        $validator = Validator::make($request->all(), [
            'name' => 'required',
        ]);
        
        if ($validator->fails()) {
            return response()->json(['errors'=>$validator->errors()]);
        }
        
        return Tag::where('id', $request->id)->update([
            'name' => $request->name,
        ]);
    }
}
