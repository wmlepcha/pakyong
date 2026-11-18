<?php

namespace App\Filament\Resources\Enquiries\Tables;

use App\Filament\Actions\ReplyOnWhatsappAction;
use App\Models\Enquiry;
use Filament\Actions\BulkAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Collection;

class EnquiriesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('created_at')->label('Received')->since()->sortable(),
                TextColumn::make('name')->searchable()->weight('semibold'),
                TextColumn::make('phone')->searchable()->copyable(),
                TextColumn::make('destinations')->badge()->separator(',')->state(fn (Enquiry $record): array => $record->destinations ?? []),
                TextColumn::make('start_date')->date('j M Y')->label('Start'),
                TextColumn::make('days')->suffix(' days'),
                TextColumn::make('people')->label('People'),
                TextColumn::make('package')->placeholder('-')->toggleable(),
                TextColumn::make('status')->badge()->formatStateUsing(fn (string $state): string => Enquiry::STATUSES[$state] ?? $state)
                    ->color(fn (string $state): string => ['new' => 'warning', 'contacted' => 'info', 'booked' => 'success', 'closed' => 'gray'][$state] ?? 'gray'),
            ])
            ->filters([SelectFilter::make('status')->options(Enquiry::STATUSES)])
            ->defaultSort('created_at', 'desc')
            ->recordActions([ReplyOnWhatsappAction::make()->iconButton()->tooltip('Reply on WhatsApp'), EditAction::make()])
            ->toolbarActions([BulkActionGroup::make([
                BulkAction::make('mark_contacted')->label('Mark as contacted')->action(fn (Collection $records) => $records->each->update(['status' => 'contacted'])),
                BulkAction::make('mark_closed')->label('Mark as closed')->action(fn (Collection $records) => $records->each->update(['status' => 'closed'])),
                DeleteBulkAction::make(),
            ])]);
    }
}
