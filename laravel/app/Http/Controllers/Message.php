<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Message extends Controller
{
    public function index() {
        $messages = \App\Models\Message::with('sender','receiver','adv');
        return response()->json($messages->get());
    }
    public function store(Request $request) {
        $message = \App\Models\Message::create($request->all());
        return response()->json($message);
    }
}
