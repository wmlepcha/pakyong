<?php

namespace App\Filament\Resources\Faqs\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class FaqsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('question')->searchable()->limit(70)->wrap(),
                TextColumn::make('category.name')->badge()->sortable(),
                IconColumn::make('show_on_home')->label('Home')->boolean(),
                IconColumn::make('is_published')->label('Live')->boolean(),
            ])
            ->filters([SelectFilter::make('faq_category_id')->label('Category')->relationship('category', 'name')])
            ->defaultSort('sort_order')
            ->reorderable('sort_order')
            ->recordActions([EditAction::make()])
            ->toolbarActions([BulkActionGroup::make([DeleteBulkAction::make()])]);
    }
}
