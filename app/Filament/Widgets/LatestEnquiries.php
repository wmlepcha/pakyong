<?php

namespace App\Filament\Widgets;

use App\Filament\Resources\Enquiries\EnquiryResource;
use App\Models\Enquiry;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;

class LatestEnquiries extends TableWidget
{
    protected static ?string $heading = 'Latest trip enquiries';

    protected int|string|array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(Enquiry::query()->latest()->limit(8))
            ->paginated(false)
            ->columns([
                TextColumn::make('created_at')->label('Received')->since(),
                TextColumn::make('name')->weight('semibold'),
                TextColumn::make('phone'),
                TextColumn::make('destinations')->badge()->state(fn (Enquiry $record): array => $record->destinations ?? []),
                TextColumn::make('status')->badge()->formatStateUsing(fn (string $state): string => Enquiry::STATUSES[$state] ?? $state),
            ])
            ->recordUrl(fn (Enquiry $record): string => EnquiryResource::getUrl('edit', ['record' => $record]));
    }
}
