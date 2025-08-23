<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\MessageRequest;
use App\Models\Message;
use Illuminate\Http\Request;

class MessageRequestController extends Controller
{
    // Send message request
    public function sendRequest(Request $request)
    {
        $request->validator([
            'receiver_id' => 'required|exists:users,id',
        ]);

        $senderId = auth()->id();
        $receiverId = $request->receiver_id;

        // Check if request already exists
        $existingRequest = MessageRequest::where(function ($query) use ($senderId, $receiverId) {
            $query->where('sender_id', $senderId)
                ->where('receiver_id', $receiverId);
        })->orWhere(function ($query) use ($senderId, $receiverId) {
            $query->where('sender_id', $receiverId)
                ->where('receiver_id', $senderId);
        })->first();

        if ($existingRequest) {
            return response()->json([
                'message' => 'Request already exists',
                'status' => $existingRequest->status
            ], 422);
        }

        // Check if they already have messages (existing conversation)
        $existingMessages = Message::where(function ($query) use ($senderId, $receiverId) {
            $query->where('sender_id', $senderId)
                ->where('receiver_id', $receiverId);
        })->orWhere(function ($query) use ($senderId, $receiverId) {
            $query->where('sender_id', $receiverId)
                ->where('receiver_id', $senderId);
        })->exists();

        if ($existingMessages) {
            // Auto-accept for existing conversations
            $messageRequest = MessageRequest::create([
                'sender_id' => $senderId,
                'receiver_id' => $receiverId,
                'status' => 'accepted'
            ]);
        } else {
            // Create new pending request
            $messageRequest = MessageRequest::create([
                'sender_id' => $senderId,
                'receiver_id' => $receiverId,
                'status' => 'pending'
            ]);
        }

        return response()->json([
            'message' => $existingMessages ? 'Request auto-accepted due to existing conversation' : 'Message request sent successfully',
            'request' => $messageRequest
        ], 200);
    }

    // Accept message request
    public function acceptRequest($id)
    {
        $messageRequest = MessageRequest::where('id', $id)
            ->where('receiver_id', auth()->id())
            ->where('status', 'pending')
            ->first();

        if (!$messageRequest) {
            return response()->json(['message' => 'Request not found'], 404);
        }

        $messageRequest->update(['status' => 'accepted']);

        return response()->json([
            'message' => 'Message request accepted',
            'request' => $messageRequest
        ], 200);
    }

    // Reject message request
    public function rejectRequest($id)
    {
        $messageRequest = MessageRequest::where('id', $id)
            ->where('receiver_id', auth()->id())
            ->where('status', 'pending')
            ->first();

        if (!$messageRequest) {
            return response()->json(['message' => 'Request not found'], 404);
        }

        $messageRequest->update(['status' => 'rejected']);

        return response()->json([
            'message' => 'Message request rejected',
            'request' => $messageRequest
        ]);
    }

    // Get received pending requests
    public function getReceivedRequests()
    {
        $requests = MessageRequest::with('sender')
            ->where('receiver_id', auth()->id())
            ->where('status', 'pending')
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json($requests);
    }

    // Get sent requests
    public function getSentRequests()
    {
        $requests = MessageRequest::with('receiver')
            ->where('sender_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json($requests);
    }

    // Check if users can message each other
    public function canMessage($userId)
    {
        $currentUserId = auth()->id();

        // Check if request exists and is accepted
        $request = MessageRequest::where(function ($query) use ($currentUserId, $userId) {
            $query->where('sender_id', $currentUserId)
                ->where('receiver_id', $userId);
        })->orWhere(function ($query) use ($currentUserId, $userId) {
            $query->where('sender_id', $userId)
                ->where('receiver_id', $currentUserId);
        })->where('status', 'accepted')->exists();

        return response()->json(['can_message' => $request]);
    }

    // Get accepted users (friends / allowed chat users)
    public function getAcceptedUsers()
    {
        $userId = auth()->id();

        $requests = MessageRequest::with(['sender', 'receiver'])
            ->where(function ($query) use ($userId) {
                $query->where('sender_id', $userId)
                    ->orWhere('receiver_id', $userId);
            })
            ->where('status', 'accepted')
            ->get();

        // Format so we only return the "other" user
        $acceptedUsers = $requests->map(function ($request) use ($userId) {
            return $request->sender_id === $userId ? $request->receiver : $request->sender;
        });

        return response()->json($acceptedUsers);
    }
}
