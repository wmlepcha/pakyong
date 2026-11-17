<?php

namespace App\Filament\Actions;

use App\Models\ContactMessage;
use App\Models\Enquiry;
use App\Models\RideRequest;
use App\Support\Whatsapp;
use Filament\Actions\Action;
use Filament\Support\Icons\Heroicon;
use Illuminate\Database\Eloquent\Model;

/**
 * Opens a message box prefilled for the visitor. The "Send on WhatsApp" button is a plain link
 * (so browsers never block it); clicking it also logs the message and marks the record contacted.
 */
class ReplyOnWhatsappAction
{
    public static function make(): Action
    {
        return Action::make('whatsapp')
            ->label('Reply on WhatsApp')
            ->icon(Heroicon::OutlinedChatBubbleLeftRight)
            ->color('success')
            ->modalHeading(fn (Model $record): string => 'Message '.$record->name)
            ->modalWidth('lg')
            ->modalSubmitAction(false)
            ->modalCancelActionLabel('Close')
            ->modalContent(fn (Model $record) => view('filament.actions.whatsapp-reply', [
                'record' => $record,
                'type' => match (true) {
                    $record instanceof Enquiry => 'enquiry', $record instanceof RideRequest => 'ride', default => 'contact'
                },
                'number' => Whatsapp::number($record->phone),
                'text' => self::template($record),
                'logUrl' => route('filament.admin.whatsapp-log'),
                'history' => $record->whatsappMessages()->limit(5)->get(),
            ]));
    }

    private static function template(Model $record): string
    {
        $brand = config('site.brand');

        if ($record instanceof RideRequest) {
            return "Hi {$record->name}, thank you for booking a ride with {$brand}. We have your request for {$record->summary()}. ";
        }

        if ($record instanceof ContactMessage) {
            return "Hi {$record->name}, thank you for getting in touch with {$brand}. ";
        }

        return "Hi {$record->name}, thank you for your enquiry with {$brand}"
            .($record instanceof Enquiry && $record->summary() !== '' ? ' about '.$record->summary() : '')
            .'. ';
    }
}
