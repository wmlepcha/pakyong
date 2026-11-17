<?php

namespace App\Filament\Resources\RideRequests;

use App\Filament\Resources\RideRequests\Pages\EditRideRequest;
use App\Filament\Resources\RideRequests\Pages\ListRideRequests;
use App\Filament\Resources\RideRequests\Schemas\RideRequestForm;
use App\Filament\Resources\RideRequests\Tables\RideRequestsTable;
use App\Models\RideRequest;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class RideRequestResource extends Resource
{
    protected static ?string $model = RideRequest::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedTruck;

    protected static string|UnitEnum|null $navigationGroup = 'Enquiries';

    protected static ?string $navigationLabel = 'Ride requests';

    protected static ?int $navigationSort = 3;

    public static function getNavigationBadge(): ?string
    {
        $count = RideRequest::query()->where('status', 'new')->count();

        return $count ? (string) $count : null;
    }

    public static function canCreate(): bool
    {
        return false;
    }

    public static function form(Schema $schema): Schema
    {
        return RideRequestForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return RideRequestsTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListRideRequests::route('/'),
            'edit' => EditRideRequest::route('/{record}/edit'),
        ];
    }
}
