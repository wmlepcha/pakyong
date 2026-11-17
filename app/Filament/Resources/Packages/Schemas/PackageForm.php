<?php

namespace App\Filament\Resources\Packages\Schemas;

use App\Filament\Support\ImageUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class PackageForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Trip card')->columns(2)->schema([
                TextInput::make('title')->required()->maxLength(80)->columnSpanFull(),
                TextInput::make('duration')->label('Length')->placeholder('6N / 7D')->maxLength(20),
                Toggle::make('is_published')->label('Show on the site')->default(true)->inline(false),
                ImageUpload::make('image', 'packages', 1200)->required()->columnSpanFull(),
                Repeater::make('bullets')->label('What is included')->simple(TextInput::make('text')->required()->maxLength(80))
                    ->addActionLabel('Add a line')->reorderable()->defaultItems(3)->columnSpanFull(),
            ]),
        ]);
    }
}
