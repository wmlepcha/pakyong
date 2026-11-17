<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreContactMessageRequest;
use App\Models\ContactMessage;
use Illuminate\Http\JsonResponse;

class ContactMessageController extends Controller
{
    /**
     * Stores a contact page message. The browser opens WhatsApp itself, so this only records it.
     */
    public function store(StoreContactMessageRequest $request): JsonResponse
    {
        if ($request->filled('website') || ((int) $request->input('elapsed', 5000)) < 2000) {
            return response()->json(['ok' => true], 201);
        }

        ContactMessage::create($request->safe()->only(['name', 'phone', 'message']));

        return response()->json(['ok' => true], 201);
    }
}
