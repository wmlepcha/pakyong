<?php

namespace App\Filament\Resources\Destinations\Tables;

use App\Models\Destination;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class DestinationsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('card_image')->disk('public')->square()->size(56)->label(''),
                TextColumn::make('name')->searchable()->sortable(),
                TextColumn::make('region')->badge(),
                TextColumn::make('days'),
                IconColumn::make('home_tile')->label('Home tile')->boolean(),
                IconColumn::make('is_published')->label('Live')->boolean(),
            ])
            ->filters([SelectFilter::make('region')->options(fn (): array => Destination::query()->distinct()->pluck('region', 'region')->all())])
            ->defaultSort('sort_order')
            ->reorderable('sort_order')
            ->recordActions([EditAction::make()])
            ->toolbarActions([BulkActionGroup::make([DeleteBulkAction::make()])]);
    }
}
