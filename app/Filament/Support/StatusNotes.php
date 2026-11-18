<?php

namespace App\Filament\Support;

use App\Models\Enquiry;
use Filament\Actions\Action;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\ToggleButtons;
use Filament\Notifications\Notification;
use Filament\Schemas\Components\Actions;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class StatusNotes
{
    /**
     * Status pills: the chosen one becomes the record's status and the target of the next note; ones with a note leave the row.
     */
    public static function statusField(): ToggleButtons
    {
        return ToggleButtons::make('status')->label('Status')->inline()->colors(Enquiry::STATUS_COLORS)
            ->options(fn (Get $get): array => self::free($get))->hidden(fn (Get $get): bool => self::free($get) === [])
            ->helperText('Pick a status, write a note and add it. A status with a note moves down to the list.')->columnSpanFull();
    }

    /**
     * Statuses that do not have a note yet.
     *
     * @return array<string, string>
     */
    private static function free(Get $get): array
    {
        $used = collect($get('status_notes') ?? [])->pluck('status')->all();

        return array_diff_key(Enquiry::STATUSES, array_flip($used));
    }

    /**
     * Pick a status, write a note, add it; notes already added are listed below and leave the picker.
     * Adding saves straight away; edits and deletes in the list apply on Save changes.
     *
     * @return array<int, mixed>
     */
    public static function fields(): array
    {
        $full = fn (Get $get): bool => self::free($get) === [];

        return [
            Textarea::make('new_note')->hiddenLabel()->placeholder('Write the note here')->rows(3)->maxLength(1000)
                ->dehydrated(false)->hidden($full)->columnSpanFull(),
            Actions::make([
                Action::make('addNote')->label('Add note')->icon('heroicon-m-plus')
                    ->action(function (Get $get, Set $set, ?Model $record): void {
                        $text = trim((string) $get('new_note'));
                        $status = (string) $get('status');

                        $taken = collect($get('status_notes') ?? [])->contains('status', $status);

                        if (! $record || $text === '' || ! isset(Enquiry::STATUSES[$status]) || $taken) {
                            Notification::make()->title('Pick a status without a note and write the note first')->warning()->send();

                            return;
                        }

                        $notes = $get('status_notes') ?? [];
                        $notes[(string) Str::uuid()] = ['status' => $status, 'note' => $text];

                        $record->update(['status' => $status, 'status_notes' => array_values($notes)]);
                        $set('status_notes', $notes);
                        $set('new_note', null);

                        Notification::make()->title('Note added')->success()->send();
                    }),
            ])->key('noteActions')->hidden($full)->columnSpanFull(),
            Repeater::make('status_notes')->hiddenLabel()->columnSpanFull()
                ->schema([
                    Hidden::make('status'),
                    Textarea::make('note')->hiddenLabel()->required()->rows(2)->maxLength(1000),
                ])
                ->itemLabel(fn (array $state): string => Enquiry::STATUSES[$state['status'] ?? ''] ?? 'Note')
                ->addable(false)
                ->reorderable(false)
                ->defaultItems(0),
        ];
    }
}
