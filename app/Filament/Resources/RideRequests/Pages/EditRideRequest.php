<?php

namespace App\Filament\Resources\RideRequests\Pages;

use App\Filament\Actions\ReplyOnWhatsappAction;
use App\Filament\Resources\RideRequests\RideRequestResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditRideRequest extends EditRecord
{
    protected static string $resource = RideRequestResource::class;

    protected function getHeaderActions(): array
    {
        return [ReplyOnWhatsappAction::make(), DeleteAction::make()];
    }
}
