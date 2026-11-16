<?php

namespace App\Http\Controllers;

use App\Models\Conversation;
use App\Enums\ConversationStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    // Display conversations belonging to the logged-in user
    public function index()
    {
        $userId = Auth::id();

        abort_unless($userId, 401);

        $conversations = Conversation::with(['customer', 'agent'])
            ->where(function ($query) use ($userId) {
                $query->where('customer_id', $userId)
                    ->orWhere('agent_id', $userId);
            })
            ->orderByDesc('last_message_at')
            ->get();

        return response()->json($conversations);
    }

    // Create a new conversation
    public function store(Request $request)
    {
        $userId = Auth::id();

        abort_unless($userId, 401);

        $validated = $request->validate([
            'subject' => 'required|string|max:255',
        ]);

        $conversation = Conversation::create([
            'customer_id' => $userId,
            'subject' => $validated['subject'],
            'status' => ConversationStatus::Pending,
            'last_message_at' => now(),
        ]);

        return response()->json([
            'message' => 'Conversation created successfully.',
            'conversation' => $conversation,
        ], 201);
    }

    // Display one conversation
    public function show(Conversation $conversation)
    {
        $userId = Auth::id();

        abort_unless($userId, 401);

        $this->authorizeParticipant($conversation, $userId);

        return response()->json(
            $conversation->load([
                'customer',
                'agent',
                'messages.sender'
            ])
        );
    }

    // Retrieve messages for the chat window
    public function messages(Conversation $conversation)
    {
        $userId = Auth::id();

        abort_unless($userId, 401);

        $this->authorizeParticipant($conversation, $userId);

        $messages = $conversation->messages()
            ->with('sender')
            ->orderBy('id')
            ->get();

        return response()->json($messages);
    }

    // Send a message
    public function sendMessage(
        Request $request,
        Conversation $conversation
    ) {
        $userId = Auth::id();

        abort_unless($userId, 401);

        $this->authorizeParticipant($conversation, $userId);

        abort_unless(
            $conversation->status !== ConversationStatus::Resolved,
            403,
            'This conversation has been resolved.'
        );

        $validated = $request->validate([
            'body' => 'required|string|max:5000',
        ]);

        $message = $conversation->messages()->create([
            'sender_id' => $userId,
            'body' => $validated['body'],
        ]);

        $conversation->update([
            'last_message_at' => now(),
        ]);

        if ($conversation->agent_id === $userId) {
            $conversation->update([
                'status' => ConversationStatus::Active,
            ]);
        }

        return response()->json([
            'message' => 'Message sent successfully.',
            'data' => $message->load('sender'),
        ], 201);
    }

    // Resolve a conversation
    public function resolve(Conversation $conversation)
    {
        $userId = Auth::id();

        abort_unless($userId, 401);

        $this->authorizeParticipant($conversation, $userId);

        $conversation->update([
            'status' => ConversationStatus::Resolved,
            'resolved_at' => now(),
        ]);

        return response()->json([
            'message' => 'Conversation resolved successfully.',
        ]);
    }

    // Check whether the logged-in user belongs to this conversation
    private function authorizeParticipant(
        Conversation $conversation,
        int $userId
    ): void {
        abort_unless(
            $conversation->customer_id === $userId ||
            $conversation->agent_id === $userId,
            403,
            'You are not authorized to access this conversation.'
        );
    }
}
