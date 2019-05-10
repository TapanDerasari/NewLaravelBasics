<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Message;
use App\Events\MessageSent;

class MessagesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return auth()
            ->user()
            ->messages()
            ->where(function ($query) {
                $query->bySender(request()->input('sender_id'))
                    ->byReceiver(auth()->user()->id);
            })
            ->orWhere(function ($query) {
                $query->bySender(auth()->user()->id)
                    ->byReceiver(request()->input('sender_id'));
            })
            ->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $message = Message::create([
            'sender_id'   => $request->input('sender_id'),
            'receiver_id' => $request->input('receiver_id'),
            'message'     => $request->input('message'),
        ]);

        broadcast(new MessageSent($message));

        return $message->fresh();
    }
}
