<?php

namespace App\Filament\Widgets;

use App\Models\ContactMessage;
use App\Models\Enquiry;
use App\Models\Post;
use App\Models\RideRequest;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class EnquiryStats extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('New trip enquiries', Enquiry::query()->where('status', 'new')->count())->description(Enquiry::query()->count().' in total')->color('warning'),
            Stat::make('New contact messages', ContactMessage::query()->where('status', 'new')->count())->description(ContactMessage::query()->count().' in total')->color('warning'),
            Stat::make('New ride requests', RideRequest::query()->where('status', 'new')->count())->description(RideRequest::query()->whereDate('pickup_date', '>=', today())->count().' upcoming pickups')->color('warning'),
            Stat::make('Published blog posts', Post::query()->where('is_published', true)->count())->color('success'),
        ];
    }
}
