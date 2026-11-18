<?php

namespace App\Filament\Resources\ContactMessages\Schemas;

use App\Filament\Support\StatusNotes;
use App\Models\ContactMessage;
use Filament\Forms\Components\Placeholder;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ContactMessageForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->columns(1)->components([
            Section::make('Message')->columns(3)->schema([
                Placeholder::make('name')->content(fn (?ContactMessage $record): string => (string) $record?->name),
                Placeholder::make('phone')->content(fn (?ContactMessage $record): string => (string) $record?->phone),
                Placeholder::make('created_at')->label('Received')->content(fn (?ContactMessage $record): string => (string) $record?->created_at?->format('j M Y, g:i a')),
                Placeholder::make('message')->content(fn (?ContactMessage $record): string => (string) $record?->message)->columnSpanFull(),
            ]),
            Section::make('Follow-up')->columns(2)->schema([
                StatusNotes::statusField(),
                ...StatusNotes::fields(),
            ]),
        ]);
    }
}
