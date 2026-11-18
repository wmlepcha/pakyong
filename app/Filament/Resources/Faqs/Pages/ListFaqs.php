<?php

namespace App\Filament\Resources\Faqs\Pages;

use App\Filament\Resources\Faqs\FaqResource;
use App\Models\Faq;
use App\Models\FaqCategory;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Filament\Schemas\Components\Tabs\Tab;
use Illuminate\Database\Eloquent\Builder;

class ListFaqs extends ListRecords
{
    protected static string $resource = FaqResource::class;

    protected function getHeaderActions(): array
    {
        return [CreateAction::make()];
    }

    /**
     * One tab per FAQ category, with a count, so each group is managed on its own.
     *
     * @return array<string, Tab>
     */
    public function getTabs(): array
    {
        $tabs = ['all' => Tab::make('All')->badge(Faq::query()->count())];

        foreach (FaqCategory::query()->orderBy('sort_order')->withCount('faqs')->get() as $category) {
            $tabs['category-'.$category->id] = Tab::make($category->name)
                ->badge($category->faqs_count)
                ->modifyQueryUsing(fn (Builder $query): Builder => $query->where('faq_category_id', $category->id));
        }

        return $tabs;
    }
}
