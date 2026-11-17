<?php

namespace App\Filament\Resources\Posts\Tables;

use App\Models\Post;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class PostsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('image')->disk('public')->square()->size(56)->label(''),
                TextColumn::make('title')->searchable()->limit(60),
                TextColumn::make('category')->badge(),
                TextColumn::make('published_at')->date('j M Y')->sortable(),
                TextColumn::make('mins')->label('Read')->suffix(' min'),
                IconColumn::make('is_published')->label('Live')->boolean(),
            ])
            ->filters([SelectFilter::make('category')->options(fn (): array => Post::query()->distinct()->pluck('category', 'category')->all())])
            ->defaultSort('published_at', 'desc')
            ->recordActions([EditAction::make()])
            ->toolbarActions([BulkActionGroup::make([DeleteBulkAction::make()])]);
    }
}
