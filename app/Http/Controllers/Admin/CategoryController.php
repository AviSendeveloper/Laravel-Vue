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
            'icon' => 'required',
        ]);
        
        if ($validator->fails()) {
            return response()->json(['errors'=>$validator->errors()]);
        }
        
        return Category::where('id', $request->id)->update([
            'name' => $request->name,
            'icon' => $request->icon,
        ]);
    }

    public function deleteCategory(Request $request) {
        $category = Category::where('id', $request->id)->first();
        $file_name = $category->icon;
        if ($file_name) {
            $deleteStatus = $this->deleteImageFromServer($file_name);
            if (!$deleteStatus) {
                return response()->json(['msg'=>'file '.$request->icon.' does not exist']);
            }
        }
        $category->delete();
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

    public function deleteImage(Request $request) {
        $request->validate([
            'icon' => 'required'
        ]);

        if ($request->has('editImage')) {
            Category::where('id', $request->id)->update([
                'icon' => '',
            ]);
        }

        $deleteStatus = $this->deleteImageFromServer($request->icon);

        if ($deleteStatus) {
            return response()->json(['success' => 'file '.$request->icon.' delete successfully'], 200);
        } else {
            return response()->json(['errors' => 'file '.$request->icon.' does not exist'], 422);
        }
    }

    public function deleteImageFromServer($filename) {
        $file_path = public_path('upload/category/').$filename;
        if (file_exists($file_path)) {
            unlink($file_path);
            return true;
        } else {
            return false;
        }
    }
}
