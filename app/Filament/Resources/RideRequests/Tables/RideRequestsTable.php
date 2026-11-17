<?php

namespace App\Filament\Resources\RideRequests\Tables;

use App\Filament\Actions\ReplyOnWhatsappAction;
use App\Models\Enquiry;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class RideRequestsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('created_at')->label('Received')->since()->sortable(),
                TextColumn::make('name')->searchable()->weight('semibold'),
                TextColumn::make('phone')->label('WhatsApp')->searchable()->copyable(),
                TextColumn::make('pickup_location')->label('Pickup')->description(fn ($record): string => $record->pickup_district)->searchable()->wrap(),
                TextColumn::make('drop_location')->label('Drop')->searchable()->wrap(),
                TextColumn::make('pickup_date')->date('j M Y')->label('Date')->sortable(),
                TextColumn::make('car_type')->badge()->label('Car'),
                TextColumn::make('status')->badge()->formatStateUsing(fn (string $state): string => Enquiry::STATUSES[$state] ?? $state)
                    ->color(fn (string $state): string => ['new' => 'warning', 'contacted' => 'info', 'booked' => 'success', 'closed' => 'gray'][$state] ?? 'gray'),
            ])
            ->filters([SelectFilter::make('status')->options(Enquiry::STATUSES), SelectFilter::make('car_type')->label('Car')->options(['4 seater' => '4 seater', '7 seater' => '7 seater'])])
            ->defaultSort('pickup_date')
            ->recordActions([ReplyOnWhatsappAction::make()->iconButton()->tooltip('Reply on WhatsApp'), EditAction::make()])
            ->toolbarActions([BulkActionGroup::make([DeleteBulkAction::make()])]);
    }
}
