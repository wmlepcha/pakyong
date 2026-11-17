<?php

namespace App\Filament\Resources\Faqs\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class FaqForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Question')->columns(2)->schema([
                Select::make('faq_category_id')->label('Category')->relationship('category', 'name')->required()->preload()
                    ->createOptionForm([TextInput::make('name')->required()]),
                TextInput::make('sort_order')->numeric()->default(0)->label('Order inside the category'),
                TextInput::make('question')->required()->maxLength(160)->columnSpanFull(),
                Textarea::make('answer')->required()->rows(5)->columnSpanFull(),
                TextInput::make('link_label')->label('Link text (optional)')->maxLength(60),
                TextInput::make('link_url')->label('Link address (optional)')->maxLength(200),
                Toggle::make('show_on_home')->label('Show on the home page')->inline(false),
                Toggle::make('is_published')->label('Show on the site')->default(true)->inline(false),
            ]),
        ]);
    }
}
