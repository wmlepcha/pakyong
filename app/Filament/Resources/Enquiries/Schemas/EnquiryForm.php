<?php

namespace App\Filament\Resources\Enquiries\Schemas;

use App\Models\Enquiry;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class EnquiryForm
{
    public static function configure(Schema $schema): Schema
    {
        $show = fn (string $label, string $field): Placeholder => Placeholder::make($field)->label($label)
            ->content(fn (?Enquiry $record): string => (string) (is_array($record?->{$field}) ? implode(', ', $record->{$field}) : ($record?->{$field} ?? '-')));

        return $schema->components([
            Section::make('Follow-up')->columns(2)->schema([
                Select::make('status')->options(Enquiry::STATUSES)->required(),
                Textarea::make('notes')->label('Private notes')->rows(3)->columnSpanFull(),
            ]),
            Section::make('What the visitor asked for')->columns(3)->schema([
                $show('Name', 'name'), $show('Phone', 'phone'), $show('Received', 'created_at'),
                $show('Destinations', 'destinations'), $show('Experience', 'tier'), $show('Package', 'package'),
                $show('Traveller', 'traveller'), $show('Season', 'season'), $show('Stay', 'stay'),
                $show('Start date', 'start_date'), $show('Days', 'days'), $show('Travellers', 'people'),
                $show('Budget per person (₹)', 'budget'),
            ]),
        ]);
    }
}
