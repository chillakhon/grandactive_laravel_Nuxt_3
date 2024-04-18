<?php

namespace App\Http\Controllers;

use App\Events\MessageEvent;
use Illuminate\Http\Request;

class Message extends Controller
{
    public function index() {
        $messages = \App\Models\Message::with('sender','receiver','adv');
        return response()->json($messages->get());
    }
    public function store(Request $request) {

        $message = \App\Models\Message::create($request->all());

        event(new MessageEvent(
            $request->input('text'),
            $request->input('sender_id'),
            $request->input('receiver_id'),
            $request->input('adv_id')
        ));

        return response()->json($message);


    }

//    public function chatMessage(Request $request) {
//        event(new MessageEvent($request->input('username'), $request->input('message'),));
//        return $request;
//    }
}
