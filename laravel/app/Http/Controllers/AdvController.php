<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdvController extends Controller
{
    public function index(){
        return view('adv.index');
    }

    public function store(Request $request){

        return $request;
    }
}
