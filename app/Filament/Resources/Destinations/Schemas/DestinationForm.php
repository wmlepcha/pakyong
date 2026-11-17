<?php

namespace App\Filament\Resources\Destinations\Schemas;

use App\Filament\Support\ImageUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class DestinationForm
{
    private const MONTHS = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];

    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Tabs::make('Destination')->columnSpanFull()->persistTabInQueryString()->tabs([
                Tab::make('Basics')->schema([
                    Section::make()->columns(2)->schema([
                        TextInput::make('name')->required()->maxLength(60)->live(onBlur: true)
                            ->afterStateUpdated(fn (?string $state, Set $set, ?string $old) => filled($state) ? $set('slug', Str::slug($state)) : null),
                        TextInput::make('slug')->required()->maxLength(80)->unique(ignoreRecord: true)->helperText('Used in the web address. Changing it breaks old links.'),
                        TextInput::make('region')->required()->datalist(['Sikkim', 'Darjeeling', 'Kalimpong'])->helperText('Groups destinations under a tab on the Destinations page.'),
                        TextInput::make('short')->label('Short name')->placeholder('East')->maxLength(30),
                        TextInput::make('tagline')->maxLength(120)->columnSpanFull(),
                        TextInput::make('places_line')->label('Card line')->placeholder('Gangtok, Tsomgo Lake, Nathula')->maxLength(100)->columnSpanFull(),
                        TextInput::make('base')->label('Base town'),
                        TextInput::make('days')->label('Usual length')->placeholder('3 to 4 days'),
                        TextInput::make('high')->label('Highest point'),
                        TextInput::make('elev')->label('Elevation note'),
                        Toggle::make('is_published')->label('Show on the site')->default(true)->inline(false),
                        TextInput::make('sort_order')->numeric()->default(0)->label('Order in lists'),
                    ]),
                ]),
                Tab::make('Photos and home tile')->schema([
                    Section::make()->columns(2)->schema([
                        ImageUpload::make('card_image', 'destinations', 1400)->label('Card photo')->required()
                            ->helperText('Used on the Destinations list, in the trip planner and as the home tile. Landscape works best.'),
                        ImageUpload::make('hero_image', 'destinations', 1800)->label('Page header photo (optional)')
                            ->helperText('Falls back to the card photo.'),
                        Toggle::make('home_tile')->label('Show as a home page tile')->inline(false)
                            ->helperText('The home page shows four tiles. Order 1 is the tall tile on the left, 2 and 3 are the small ones, 4 is the wide one.'),
                        TextInput::make('tile_order')->numeric()->minValue(1)->maxValue(4)->label('Tile position (1 to 4)'),
                    ]),
                ]),
                Tab::make('About')->schema([
                    Section::make()->schema([
                        Repeater::make('about')->label('Overview paragraphs')->simple(Textarea::make('text')->rows(3)->required())->addActionLabel('Add a paragraph')->reorderable(),
                        TagsInput::make('good_for')->label('Good for')->placeholder('Add and press enter'),
                        Textarea::make('permits')->rows(3)->label('Permits'),
                        Textarea::make('stay')->rows(3)->label('Where to stay'),
                    ]),
                ]),
                Tab::make('Best time')->schema([
                    Section::make('Month by month')->description('peak = best, good, wet = rain and landslide risk, cold = winter')->schema([
                        Grid::make(['default' => 2, 'sm' => 4, 'lg' => 6])->schema(collect(self::MONTHS)->map(
                            fn (string $m, int $i): Select => Select::make("calendar.$i")->label($m)->options(['peak' => 'Peak', 'good' => 'Good', 'wet' => 'Wet', 'cold' => 'Cold'])->default('good')->required()
                        )->all()),
                    ]),
                    Repeater::make('seasons')->label('Seasons')->columns(2)->maxItems(4)->itemLabel(fn (array $state): ?string => $state['name'] ?? null)->collapsible()->schema([
                        TextInput::make('name')->required(),
                        TextInput::make('months')->placeholder('March - May')->required(),
                        TextInput::make('temp')->label('Temperature')->placeholder('12-24°C'),
                        TextInput::make('mood')->label('One line'),
                        Textarea::make('text')->rows(3)->label('Description')->columnSpanFull(),
                        TagsInput::make('wear')->label('What to wear')->columnSpanFull(),
                    ]),
                ]),
                Tab::make('Places')->schema([
                    Repeater::make('places')->label('Places to visit')->columns(2)->collapsible()->collapsed()->itemLabel(fn (array $state): ?string => $state['name'] ?? null)->schema([
                        TextInput::make('name')->required(),
                        TextInput::make('type')->placeholder('Monastery, Lake, Viewpoint'),
                        Textarea::make('description')->rows(3)->columnSpanFull(),
                        TextInput::make('meta')->label('Distance or height')->columnSpanFull(),
                        ImageUpload::make('image', 'destinations/places', 1400)->label('Photo'),
                        Section::make('Photo credit (if required)')->collapsed()->columns(2)->schema([
                            TextInput::make('credit_author')->label('Author'),
                            TextInput::make('credit_license')->label('Licence'),
                            TextInput::make('credit_license_url')->label('Licence link')->url(),
                            TextInput::make('credit_page')->label('Source page')->url(),
                        ]),
                    ]),
                ]),
                Tab::make('Practical')->schema([
                    Repeater::make('getting')->label('Getting there')->columns(3)->itemLabel(fn (array $state): ?string => $state['route'] ?? null)->collapsible()->schema([
                        TextInput::make('route')->required(),
                        TextInput::make('time')->label('Time'),
                        Textarea::make('detail')->rows(2)->columnSpanFull(),
                    ]),
                    Repeater::make('itinerary')->label('Suggested plan (one row per day)')->simple(Textarea::make('text')->rows(2)->required())->addActionLabel('Add a day')->reorderable(),
                    Repeater::make('pack_always')->label('Always bring')->simple(TextInput::make('text')->required())->addActionLabel('Add an item')->reorderable(),
                    Repeater::make('tips')->label('Tips from the team')->simple(Textarea::make('text')->rows(2)->required())->addActionLabel('Add a tip')->reorderable(),
                    Repeater::make('faqs')->label('Questions about this place')->columns(1)->itemLabel(fn (array $state): ?string => $state['q'] ?? null)->collapsible()->schema([
                        TextInput::make('q')->label('Question')->required(),
                        Textarea::make('a')->label('Answer')->rows(3)->required(),
                    ]),
                ]),
                Tab::make('Search')->schema([
                    Section::make()->schema([
                        TextInput::make('seo_title')->label('Page title')->maxLength(70)->helperText('Leave blank to use "{name} travel guide".'),
                        Textarea::make('seo_description')->label('Search description')->rows(2)->maxLength(160),
                    ]),
                ]),
            ]),
        ]);
    }
}
