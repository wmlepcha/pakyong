<?php

namespace App\Filament\Resources\Experiences\Schemas;

use App\Filament\Support\ImageUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ExperienceForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Experience')->columns(2)->schema([
                TextInput::make('title')->required()->maxLength(60),
                Toggle::make('is_published')->label('Show on the site')->default(true)->inline(false),
                Textarea::make('description')->rows(2)->maxLength(160)->columnSpanFull(),
                ImageUpload::make('image', 'experiences', 1400)->required()->columnSpanFull(),
            ]),
        ]);
    }
}
