<?php

namespace App\Providers\Filament;

use App\Filament\Pages\Auth\Login;
use App\Http\Controllers\WhatsappLogController;
use App\Http\Middleware\AdminResponseHeaders;
use Filament\Auth\MultiFactor\App\AppAuthentication;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Navigation\NavigationGroup;
use Filament\Pages\Dashboard;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\PreventRequestForgery;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\Support\Facades\Route;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->viteTheme('resources/css/filament/admin/theme.css')
            ->path(config('app.admin_path'))
            ->login(Login::class)
            ->profile(isSimple: false)
            ->multiFactorAuthentication([
                AppAuthentication::make()->recoverable(),
            ], isRequired: true)
            ->darkMode(false)
            ->brandName('The Himalio Travels')
            ->brandLogo(asset('images/brand/himalio-logo-green-600.webp'))
            ->brandLogoHeight('2.75rem')
            ->favicon(asset('favicon-32.png'))
            ->colors([
                'primary' => [
                    50 => '#f4f6ec', 100 => '#e9edd6', 200 => '#d3dbb1', 300 => '#b3c07f', 400 => '#8d9f55',
                    500 => '#6c7e3b', 600 => '#44532e', 700 => '#37432a', 800 => '#2d3a22', 900 => '#242d1c', 950 => '#141a0f',
                ],
                'gray' => Color::hex('#6f7560'),
            ])
            ->font('Hanken Grotesk')
            ->navigationGroups([
                NavigationGroup::make('Content'),
                NavigationGroup::make('Enquiries'),
                NavigationGroup::make('Settings'),
            ])
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\Filament\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\Filament\Pages')
            ->pages([
                Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\Filament\Widgets')
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                PreventRequestForgery::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
                AdminResponseHeaders::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ])
            ->authenticatedRoutes(function (): void {
                Route::post('whatsapp-log', [WhatsappLogController::class, 'store'])->name('whatsapp-log');
            });
    }
}
