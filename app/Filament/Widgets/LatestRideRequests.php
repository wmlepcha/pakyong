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
                TextColumn::make('name')->weight('semibold')->icon('heroicon-m-user-circle')->iconColor('gray'),
                TextColumn::make('phone')->label('WhatsApp')->icon('heroicon-m-phone')->iconColor('success'),
                TextColumn::make('pickup_location')->label('Route')->icon('heroicon-m-map-pin')->iconColor('warning')
                    ->description(fn (RideRequest $record): string => '→ '.$record->drop_location)->wrap(),
                TextColumn::make('pickup_district')->label('District')->badge()->color('gray')->formatStateUsing(fn (string $state): string => strtoupper($state)),
                TextColumn::make('pickup_date')->label('Pickup')->date('j M Y')->weight('semibold')
                    ->description(fn (RideRequest $record): string => $record->pickup_date->isToday() ? 'Today' : ($record->pickup_date->isTomorrow() ? 'Tomorrow' : $record->pickup_date->diffForHumans()))
                    ->color(fn (RideRequest $record): ?string => $record->pickup_date->isToday() || $record->pickup_date->isTomorrow() ? 'danger' : null),
                TextColumn::make('car_type')->label('Car')->badge()->icon('heroicon-m-truck')->color('primary'),
                TextColumn::make('status')->badge()->color(fn (string $state): string => Enquiry::STATUS_COLORS[$state] ?? 'gray')->formatStateUsing(fn (string $state): string => Enquiry::STATUSES[$state] ?? $state),
            ])
            ->recordUrl(fn (RideRequest $record): string => RideRequestResource::getUrl('edit', ['record' => $record]));
    }
}
