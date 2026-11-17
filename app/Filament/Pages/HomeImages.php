<?php

namespace App\Filament\Pages;

use App\Filament\Support\ImageUpload;
use App\Models\SiteSetting;
use BackedEnum;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use UnitEnum;

class HomeImages extends Page
{
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedPhoto;

    protected static string|UnitEnum|null $navigationGroup = 'Content';

    protected static ?string $navigationLabel = 'Home page images';

    protected static ?string $title = 'Home page images';

    protected static ?int $navigationSort = 2;

    protected string $view = 'filament.pages.home-images';

    /** @var array<string, mixed>|null */
    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill(SiteSetting::current()->only(['hero_image', 'hero_alt', 'place_image', 'place_alt']));
    }

    public function form(Schema $schema): Schema
    {
        return $schema->statePath('data')->components([
            Section::make('Top of the home page')->description('The big photo behind "Sikkim, planned by people who live here."')->columns(2)->schema([
                ImageUpload::make('hero_image', 'home', 2000)->label('Hero photo')->required()->helperText('Wide photos work best (at least 1600 px). Text sits on the left, so keep that side calm.'),
                TextInput::make('hero_alt')->label('Photo description (alt text)')->maxLength(140),
            ]),
            Section::make('"Travel with a sense of place" section')->columns(2)->schema([
                ImageUpload::make('place_image', 'home', 1400)->label('Section photo')->required(),
                TextInput::make('place_alt')->label('Photo description (alt text)')->maxLength(140),
            ]),
        ]);
    }

    public function save(): void
    {
        SiteSetting::current()->update($this->form->getState());

        Notification::make()->title('Home page images saved')->success()->send();
    }
}
