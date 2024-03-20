<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Subcategory;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index(){
        $categories = \App\Models\Category::with('subcategory')->get();
        return response()->json($categories);
    }

}
