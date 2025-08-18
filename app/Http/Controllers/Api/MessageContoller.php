<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Mail\Events\MessageSent;

class MessageController extends Controller
{
    // Fetch all messages between logged-in user and another user
    public function getMessages($userId)
    {
        $messages = Message::where(function($q) use ($userId){
            $q->where('sender_id', auth()->id())
              ->where('receiver_id', $userId);
        })->orWhere(function($q) use ($userId){
            $q->where('sender_id', $userId)
              ->where('receiver_id', auth()->id());
        })->orderBy('created_at','asc')->get();

        return response()->json($messages);
    }

    // Send message to another user
    public function sendMessage(Request $request)
    {
        $request->validate([
            'receiver_id'=>'required|exists:users,id',
            'message'=>'required|string'
        ]);

        $message = Message::create([
            'sender_id'=>auth()->id(),
            'receiver_id'=>$request->receiver_id,
            'message'=>$request->message
        ]);

        // Optional: broadcast event for real-time
        broadcast(new MessageSent($message))->toOthers();

        return response()->json($message);
    }
}
