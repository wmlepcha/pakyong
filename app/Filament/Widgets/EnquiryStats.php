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
            Stat::make('New trip enquiries', Enquiry::query()->where('status', 'new')->count())->description(Enquiry::query()->count().' in total')->descriptionIcon('heroicon-m-inbox')->icon('heroicon-o-map')->color('info'),
            Stat::make('New contact messages', ContactMessage::query()->where('status', 'new')->count())->description(ContactMessage::query()->count().' in total')->descriptionIcon('heroicon-m-inbox')->icon('heroicon-o-chat-bubble-left-right')->color('warning'),
            Stat::make('New ride requests', RideRequest::query()->where('status', 'new')->count())->description(RideRequest::query()->whereDate('pickup_date', '>=', today())->count().' upcoming pickups')->descriptionIcon('heroicon-m-calendar-days')->icon('heroicon-o-truck')->color('danger'),
            Stat::make('Published blog posts', Post::query()->where('is_published', true)->count())->icon('heroicon-o-newspaper')->color('success'),
        ];
    }
}
