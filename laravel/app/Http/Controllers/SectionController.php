<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SectionController extends Controller
{
    public function index(){
        $sections = \App\Models\Section::all();
        return response()->json($sections);
    }
}
