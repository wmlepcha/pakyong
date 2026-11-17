<?php

namespace App\Http\Controllers;

use App\Models\ContactMessage;
use App\Models\Enquiry;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class WhatsappLogController extends Controller
{
    /**
     * Notes a WhatsApp message sent from the admin and marks the record as contacted.
     */
    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'type' => ['required', 'in:enquiry,contact'],
            'id' => ['required', 'integer'],
            'body' => ['required', 'string', 'max:1000'],
        ]);

        $record = ($data['type'] === 'enquiry' ? Enquiry::class : ContactMessage::class)::findOrFail($data['id']);
        $record->whatsappMessages()->create(['user_id' => $request->user()->id, 'body' => $data['body']]);

        if ($record->status === 'new') {
            $record->update(['status' => 'contacted']);
        }

        return response()->json(['ok' => true]);
    }
}
