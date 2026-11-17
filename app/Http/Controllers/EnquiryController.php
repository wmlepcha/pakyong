<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEnquiryRequest;
use App\Models\Enquiry;
use Illuminate\Http\JsonResponse;

class EnquiryController extends Controller
{
    /**
     * Stores a trip planner enquiry. The browser opens WhatsApp itself, so this only records the lead.
     */
    public function store(StoreEnquiryRequest $request): JsonResponse
    {
        // A filled honeypot or an instant submit means a bot: answer as if it worked, store nothing.
        if ($request->filled('website') || ((int) $request->input('elapsed', 5000)) < 2000) {
            return response()->json(['ok' => true], 201);
        }

        $data = $request->validated();

        Enquiry::create([
            'name' => $data['name'], 'phone' => $data['phone'], 'destinations' => $data['destinations'], 'tier' => $data['tier'],
            'traveller' => $data['traveller'], 'season' => $data['season'], 'start_date' => $data['start_date'], 'days' => $data['days'],
            'people' => $data['people'], 'budget' => $data['budget'] ?? null, 'stay' => $data['stay'], 'package' => $data['package'] ?? null,
        ]);

        return response()->json(['ok' => true], 201);
    }
}
