<?php

namespace App\Filament\Resources\Posts\Schemas;

use App\Filament\Support\ImageUpload;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class PostForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Post')->columns(2)->schema([
                TextInput::make('title')->required()->maxLength(120)->live(onBlur: true)->columnSpanFull()
                    ->afterStateUpdated(fn (?string $state, Set $set, string $operation) => $operation === 'create' && filled($state) ? $set('slug', Str::slug($state)) : null),
                TextInput::make('slug')->required()->maxLength(120)->unique(ignoreRecord: true)->helperText('The web address of the post. Changing it breaks old links.'),
                TextInput::make('category')->required()->datalist(['Destinations', 'Itineraries', 'Planning', 'Food and culture']),
                Textarea::make('excerpt')->rows(2)->maxLength(200)->helperText('Shown on cards and in search results.')->columnSpanFull(),
                Textarea::make('intro')->rows(3)->required()->label('Opening paragraph')->columnSpanFull(),
            ]),
            Section::make('Cover photo')->columns(2)->schema([
                ImageUpload::make('image', 'blog', 1600)->label('Photo')->required(),
                TextInput::make('image_alt')->label('Photo description (alt text)')->maxLength(140),
            ]),
            Section::make('Body')->schema([
                Repeater::make('sections')->label('Sections')->itemLabel(fn (array $state): ?string => $state['heading'] ?? null)->collapsible()->schema([
                    TextInput::make('heading')->required()->maxLength(100),
                    Repeater::make('paragraphs')->simple(Textarea::make('text')->rows(4)->required())->addActionLabel('Add a paragraph')->reorderable()->defaultItems(1),
                ])->addActionLabel('Add a section'),
            ]),
            Section::make('Publishing')->columns(2)->schema([
                Toggle::make('is_published')->label('Published')->inline(false),
                DatePicker::make('published_at')->label('Publish date')->default(now())->required(),
                DatePicker::make('updated_on')->label('Last updated (optional)')->helperText('Shows an "Updated" date on the post.'),
                Textarea::make('seo_description')->label('Search description (optional)')->rows(2)->maxLength(160)->columnSpanFull(),
            ]),
        ]);
    }
}
