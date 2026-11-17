<?php

namespace App\Http\Controllers;

use App\Models\ContactMessage;
use App\Models\Enquiry;
use App\Models\RideRequest;
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
            'type' => ['required', 'in:enquiry,contact,ride'],
            'id' => ['required', 'integer'],
            'body' => ['required', 'string', 'max:1000'],
        ]);

        $record = (['enquiry' => Enquiry::class, 'contact' => ContactMessage::class, 'ride' => RideRequest::class][$data['type']])::findOrFail($data['id']);
        $record->whatsappMessages()->create(['user_id' => $request->user()->id, 'body' => $data['body']]);

        if ($record->status === 'new') {
            $record->update(['status' => 'contacted']);
        }

        return response()->json(['ok' => true]);
    }
}
