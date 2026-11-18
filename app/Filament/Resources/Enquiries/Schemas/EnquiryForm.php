<?php

namespace App\Filament\Resources\Enquiries\Schemas;

use App\Filament\Support\StatusNotes;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\View as ViewComponent;
use Filament\Schemas\Schema;

class EnquiryForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->columns(1)->components([
            ViewComponent::make('filament.enquiry-summary'),
            Section::make('Follow-up')->columns(2)->schema([
                StatusNotes::statusField(),
                ...StatusNotes::fields(),
            ]),
        ]);
    }
}
