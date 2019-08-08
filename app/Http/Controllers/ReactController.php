<?php

namespace App\Http\Controllers;

use App\Http\Middleware\CensorSwearwords;
use App\Message;
use App\User;
use Psy\Util\Json;
use Illuminate\Http\Request;

class ReactController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['setMessages','getMessages']);
    }

    public function index(){

        $my_id = auth()->id();

        $users = User::whereNotIn('id',[$my_id])->get();

        $receiver_id = session('receiver_id',0);

        $messages =  Message::whereIn('sender_id',[$my_id,$receiver_id])
            ->whereIn('receiver_id',[$my_id,$receiver_id])
            ->with(['sender','receiver'])
            ->get();



        return view('react.index',['users'=>$users, 'messages'=>$messages, 'receiver_id'=>$receiver_id]);
    }

    public function getMessages($receiver_id){
        $my_id = auth()->id();

        $messages =  Message::whereIn('sender_id',[$my_id,$receiver_id])
            ->whereIn('receiver_id',[$my_id,$receiver_id])
            ->with(['sender','receiver'])
            ->get();

        session(['receiver_id' => $receiver_id]);

        return $messages;
    }

    public function setMessages($receiver_id){

        $validated = request()->validate([
            'sender_id' => ['required'],
            'receiver_id' => ['required'],
            'messageText' => ['required']
        ]);

        Message::create($validated);

        $my_id = auth()->id();

        $messages =  Message::whereIn('sender_id',[$my_id,$receiver_id])
            ->whereIn('receiver_id',[$my_id,$receiver_id])
            ->with(['sender','receiver'])
            ->get();

        return $messages;
    }
}
