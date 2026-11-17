<?php

namespace App\Filament\Resources\ContactMessages\Tables;

use App\Filament\Actions\ReplyOnWhatsappAction;
use App\Models\Enquiry;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class ContactMessagesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('created_at')->label('Received')->since()->sortable(),
                TextColumn::make('name')->searchable()->weight('semibold'),
                TextColumn::make('phone')->searchable()->copyable(),
                TextColumn::make('message')->limit(70)->wrap(),
                TextColumn::make('status')->badge()->formatStateUsing(fn (string $state): string => Enquiry::STATUSES[$state] ?? $state)
                    ->color(fn (string $state): string => ['new' => 'warning', 'contacted' => 'info', 'booked' => 'success', 'closed' => 'gray'][$state] ?? 'gray'),
            ])
            ->filters([SelectFilter::make('status')->options(Enquiry::STATUSES)])
            ->defaultSort('created_at', 'desc')
            ->recordActions([ReplyOnWhatsappAction::make()->iconButton()->tooltip('Reply on WhatsApp'), EditAction::make()])
            ->toolbarActions([BulkActionGroup::make([DeleteBulkAction::make()])]);
    }
}
