<?php

namespace App\Models;

use Database\Factories\EnquiryFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Enquiry extends Model
{
    /** @use HasFactory<EnquiryFactory> */
    use HasFactory;

    public const STATUSES = ['new' => 'New', 'contacted' => 'Contacted', 'booked' => 'Booked', 'closed' => 'Closed'];

    protected $guarded = [];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return ['destinations' => 'array', 'start_date' => 'date'];
    }

    public function whatsappMessages(): MorphMany
    {
        return $this->morphMany(WhatsappMessage::class, 'messageable')->latest();
    }

    /**
     * A short sentence about the trip, used in the WhatsApp reply template.
     */
    public function summary(): string
    {
        return collect([
            implode(', ', $this->destinations ?? []),
            $this->days ? $this->days.' days' : null,
            $this->start_date ? 'from '.$this->start_date->format('j M Y') : null,
            $this->people ? $this->people.' '.($this->people === 1 ? 'traveller' : 'travellers') : null,
        ])->filter()->implode(', ');
    }
}
