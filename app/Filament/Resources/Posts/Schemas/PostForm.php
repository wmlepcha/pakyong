<?php

namespace App\Filament\Resources\Posts\Schemas;

use App\Filament\Support\ImageUpload;
use App\Models\Post;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class PostForm
{
    /**
     * @return array<string, string>
     */
    private static function categories(): array
    {
        $names = array_merge(['Destinations', 'Itineraries', 'Planning', 'Food and culture'], Post::query()->distinct()->pluck('category')->all());

        return collect($names)->unique()->mapWithKeys(fn (string $name): array => [$name => $name])->all();
    }

    public static function configure(Schema $schema): Schema
    {
        return $schema->columns(1)->components([
            Grid::make(['default' => 1, 'lg' => 3])->schema([
                Group::make([
                    Section::make('Write your post')->schema([
                        TextInput::make('title')->required()->maxLength(120)->live(onBlur: true)->placeholder('e.g. Five days in North Sikkim')
                            ->extraInputAttributes(['class' => 'text-lg'])
                            ->afterStateUpdated(fn (?string $state, Set $set, string $operation) => $operation === 'create' && filled($state) ? $set('slug', Str::slug($state)) : null),
                        Textarea::make('intro')->label('Opening paragraph')->rows(4)->required()->placeholder('The first thing readers see under the title.'),
                        Textarea::make('excerpt')->label('Short summary')->rows(2)->maxLength(200)->placeholder('One or two lines for the blog list and Google.')
                            ->helperText('Up to 200 characters.'),
                    ]),
                    Section::make('The article')->description('Split the post into parts, like chapters. Each part has a heading and the text under it. The headings also become the "On this page" links readers can tap to jump around.')->schema([
                        Repeater::make('sections')->hiddenLabel()->defaultItems(1)->itemNumbers()->reorderableWithButtons()->cloneable(false)->addActionLabel('Add another part')
                            ->itemLabel(fn (array $state): string => filled($state['heading'] ?? null) ? $state['heading'] : 'Untitled part')
                            ->schema([
                                TextInput::make('heading')->label('Heading')->required()->maxLength(100)->placeholder('e.g. Getting there'),
                                Textarea::make('paragraphs')->label('Text under this heading')->required()->rows(8)->autosize()
                                    ->placeholder("Write the first paragraph.\n\nLeave a blank line to start a new paragraph.")
                                    ->formatStateUsing(fn ($state): string => is_array($state) ? implode("\n\n", $state) : (string) $state)
                                    ->dehydrateStateUsing(fn ($state): array => array_values(array_filter(array_map('trim', preg_split('/\R{2,}/', trim((string) $state)))))),
                            ]),
                    ]),
                ])->columnSpan(['lg' => 2]),
                Group::make([
                    Section::make('Publish')->schema([
                        Toggle::make('is_published')->label('Show on the website')->helperText('Off keeps it as a draft.'),
                        DatePicker::make('published_at')->label('Publish date')->default(now())->required(),
                    ]),
                    Section::make('Cover photo')->schema([
                        ImageUpload::make('image', 'blog', 1600)->label('Photo')->required(),
                        TextInput::make('image_alt')->label('Describe the photo')->maxLength(140)->placeholder('e.g. Yumthang valley in spring'),
                    ]),
                    Section::make('Details')->schema([
                        Select::make('category')->required()->options(fn (): array => self::categories())->searchable()
                            ->createOptionForm([TextInput::make('name')->label('New category')->required()->maxLength(40)])
                            ->createOptionUsing(fn (array $data): string => $data['name']),
                        TextInput::make('slug')->label('Web address')->required()->maxLength(120)->unique(ignoreRecord: true)->prefix('/blog/')
                            ->helperText('Made from the title. Changing it later breaks old links.'),
                    ]),
                    Section::make('For search engines')->collapsed()->schema([
                        Textarea::make('seo_description')->label('Search description')->rows(3)->maxLength(160)->helperText('Optional. Up to 160 characters.'),
                        DatePicker::make('updated_on')->label('Last updated')->helperText('Optional. Shows an "Updated" date on the post.'),
                    ]),
                ])->columnSpan(['lg' => 1]),
            ])->columnSpanFull(),
        ]);
    }
}
