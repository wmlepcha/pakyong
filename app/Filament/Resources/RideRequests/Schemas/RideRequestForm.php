<?php

namespace App\Filament\Resources\RideRequests\Schemas;

use App\Models\Enquiry;
use App\Models\RideRequest;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class RideRequestForm
{
    public static function configure(Schema $schema): Schema
    {
        $show = fn (string $label, string $field): Placeholder => Placeholder::make($field)->label($label)
            ->content(fn (?RideRequest $r): string => (string) ($r?->{$field} instanceof \DateTimeInterface ? $r->{$field}->format('j M Y') : ($r?->{$field} ?? '-')));

        return $schema->components([
            Section::make('Follow-up')->columns(2)->schema([
                Select::make('status')->options(Enquiry::STATUSES)->required(),
                Textarea::make('notes')->label('Private notes')->rows(3)->columnSpanFull(),
            ]),
            Section::make('The ride')->columns(3)->schema([
                $show('Pickup', 'pickup_location'), $show('Drop', 'drop_location'), $show('Pickup district', 'pickup_district'),
                $show('Pickup date', 'pickup_date'), $show('Car type', 'car_type'), $show('Received', 'created_at'),
                $show('Name', 'name'), $show('WhatsApp', 'phone'),
            ]),
        ]);
    }
}
