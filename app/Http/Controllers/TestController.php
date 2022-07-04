<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TestController extends Controller
{
    public function test() {
        return response()->json([
            'name' => 'Developer',
        ]);
    }

    public function fetchTags(Request $request) {
        return $request;
    }
}
