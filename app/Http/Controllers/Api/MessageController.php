<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Message;
use App\Models\MessageRequest;
use Illuminate\Http\Request;
use App\Events\MessageSent;

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

        $senderId = auth()->id();
        $receiverId = $request->receiver_id;

        // Check if users can message each other
        $canMessage = $this->checkCanMessage($senderId, $receiverId);

        if (!$canMessage) {
            return response()->json([
                'message' => 'You cannot send messages to this user. Please send a message request first.'
            ], 403);
        }

        $message = Message::create([
            'sender_id'=> $senderId,
            'receiver_id'=> $receiverId,
            'message'=> $request->message
        ]);

        // Optional: broadcast event for real-time
        broadcast(new MessageSent($message))->toOthers();

        return response()->json($message);
    }

    // Check if users can message each other
    private function checkCanMessage($senderId, $receiverId)
    {
        // Check if message request exists and is accepted
        $request = MessageRequest::where(function ($query) use ($senderId, $receiverId) {
            $query->where('sender_id', $senderId)
                  ->where('receiver_id', $receiverId);
        })->orWhere(function ($query) use ($senderId, $receiverId) {
            $query->where('sender_id', $receiverId)
                  ->where('receiver_id', $senderId);
        })->where('status', 'accepted')->exists();

        if ($request) {
            return true;
        }

        // Check if they already have messages (existing conversation)
        $existingMessages = Message::where(function ($query) use ($senderId, $receiverId) {
            $query->where('sender_id', $senderId)
                  ->where('receiver_id', $receiverId);
        })->orWhere(function ($query) use ($senderId, $receiverId) {
            $query->where('sender_id', $receiverId)
                  ->where('receiver_id', $senderId);
        })->exists();

        return $existingMessages;
    }
}
