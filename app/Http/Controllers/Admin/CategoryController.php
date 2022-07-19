<?php

namespace App\Http\Controllers\Admin;

use App\Category;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    public function addCategory(Request $request) {
        // Validation
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'icon' => 'required'
        ]);
        
        if ($validator->fails()) {
            return response()->json(['errors'=>$validator->errors()]);
        }

        return Category::create([
            'name' => $request->name,
            'icon' => $request->icon
        ]);
    }

    public function getCategory() {
        $data = Category::orderBy('id', 'DESC')->get();
        return response()->json($data);
    }

    public function editCategory(Request $request) {
        // Validation
        $validator = Validator::make($request->all(), [
            'name' => 'required',
        ]);
        
        if ($validator->fails()) {
            return response()->json(['errors'=>$validator->errors()]);
        }
        
        return Category::where('id', $request->id)->update([
            'name' => $request->name,
        ]);
    }

    public function deleteCategory($id) {
        $category = Category::where('id', $id)->delete();
        return response()->json(['msg'=>'Deleted successfully']);
    }

    public function uploadImage(Request $request) {
        // Validation
        $request->validate([
            'file' => 'required|mimes:png,jpg,jpeg'
        ]);

        $file = $request->file;
        $file_name = time().'-'.$file->getClientOriginalName();
        $file->move(public_path('upload/category'), $file_name);
        return response()->json(['file_name'=>$file_name]);
    }
}
