<?php

namespace App\Models;

use Database\Factories\RideRequestFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class RideRequest extends Model
{
    /** @use HasFactory<RideRequestFactory> */
    use HasFactory;

    protected $guarded = [];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return ['pickup_date' => 'date', 'status_notes' => 'array'];
    }

    public function whatsappMessages(): MorphMany
    {
        return $this->morphMany(WhatsappMessage::class, 'messageable')->latest();
    }

    /**
     * A short sentence about the ride, used in the WhatsApp reply template.
     */
    public function summary(): string
    {
        return "a {$this->car_type} from {$this->pickup_location} to {$this->drop_location} on ".$this->pickup_date->format('j M Y');
    }
}
