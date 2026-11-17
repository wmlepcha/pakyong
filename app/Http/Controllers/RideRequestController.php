<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRideRequest;
use App\Models\RideRequest;
use Illuminate\Http\JsonResponse;

class RideRequestController extends Controller
{
    /**
     * Stores a ride request. The browser opens WhatsApp itself, so this only records it.
     */
    public function store(StoreRideRequest $request): JsonResponse
    {
        if ($request->filled('website') || ((int) $request->input('elapsed', 5000)) < 2000) {
            return response()->json(['ok' => true], 201);
        }

        RideRequest::create($request->safe()->only(['name', 'phone', 'pickup_location', 'drop_location', 'pickup_district', 'pickup_date', 'car_type']));

        return response()->json(['ok' => true], 201);
    }
}
