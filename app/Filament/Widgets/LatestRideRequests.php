<?php

namespace App\Filament\Widgets;

use App\Filament\Resources\RideRequests\RideRequestResource;
use App\Models\Enquiry;
use App\Models\RideRequest;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;

class LatestRideRequests extends TableWidget
{
    protected static ?string $heading = 'Latest ride requests';

    protected int|string|array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(RideRequest::query()->latest()->limit(8))
            ->paginated(false)
            ->columns([
                TextColumn::make('created_at')->label('Received')->since(),
                TextColumn::make('name')->weight('semibold'),
                TextColumn::make('phone')->label('WhatsApp'),
                TextColumn::make('pickup_location')->label('Pickup')->description(fn (RideRequest $record): string => $record->pickup_district)->wrap(),
                TextColumn::make('drop_location')->label('Drop')->wrap(),
                TextColumn::make('pickup_date')->label('Date')->date('j M Y'),
                TextColumn::make('car_type')->label('Car')->badge(),
                TextColumn::make('status')->badge()->formatStateUsing(fn (string $state): string => Enquiry::STATUSES[$state] ?? $state),
            ])
            ->recordUrl(fn (RideRequest $record): string => RideRequestResource::getUrl('edit', ['record' => $record]));
    }
}
