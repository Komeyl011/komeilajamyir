<?php

namespace App\Providers\Filament;

use App\Filament\Pages\EditProfile;
use CodeWithDennis\FilamentThemeInspector\FilamentThemeInspectorPlugin;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Navigation\MenuItem;
use Filament\Pages;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Assets\Js;
use Filament\Support\Colors\Color;
use Filament\Support\Facades\FilamentAsset;
use Filament\Support\Facades\FilamentView;
use Filament\View\PanelsRenderHook;
use Filament\Widgets;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class TimmyPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        // Add FontAwesome script to load its icons
        FilamentView::registerRenderHook(
            PanelsRenderHook::BODY_END,
            fn () => '<script src="https://kit.fontawesome.com/57a53d4203.js" crossorigin="anonymous"></script>',
        );

        return $panel
            ->default()
            ->id('timmy')
            ->path('timmy')
            ->login()
            ->profile()
            ->userMenuItems([
                'profile' => MenuItem::make()->url(fn (): string => EditProfile::getUrl())
            ])
            ->brandLogo(fn() => view('vendor.filament.components.brand.brand'))
            ->brandName(__('main.hero-name'))
            ->colors([
                'primary' => [
                    50 => '239, 246, 255',
                    100 => '219, 234, 254',
                    200 => '191, 219, 254',
                    300 => '147, 197, 253',
                    400 => '96, 165, 250',
                    500 => '59, 130, 246',
                    600 => '37, 99, 235',
                    700 => '29, 78, 216',
                    800 => '30, 64, 175',
                    900 => '30, 58, 138',
                    950 => '23, 37, 84',
                ],
                'secondary' => [
                    50 => '249, 250, 251',
                    100 => '243, 244, 246',
                    200 => '229, 231, 235',
                    300 => '209, 213, 219',
                    400 => '156, 163, 175',
                    500 => '107, 114, 128',
                    600 => '75, 85, 99',
                    700 => '55, 65, 81',
                    800 => '31, 41, 55',
                    900 => '17, 24, 39',
                    950 => '3, 7, 18',
                ],
                'accent' => [
                    50 => '236, 253, 245',
                    100 => '209, 250, 229',
                    200 => '167, 243, 208',
                    300 => '110, 231, 183',
                    400 => '52, 211, 153',
                    500 => '16, 185, 129',
                    600 => '5, 150, 105',
                    700 => '4, 120, 87',
                    800 => '6, 95, 70',
                    900 => '6, 78, 59',
                    950 => '2, 44, 34',
                ],
                'warning' => [
                    50 => '255, 251, 235',
                    100 => '254, 243, 199',
                    200 => '253, 230, 138',
                    300 => '252, 211, 77',
                    400 => '251, 191, 36',
                    500 => '245, 158, 11',
                    600 => '217, 119, 6',
                    700 => '180, 83, 9',
                    800 => '146, 64, 14',
                    900 => '120, 53, 15',
                    950 => '69, 26, 3',
                ],
                'danger' => [
                    50 => '255, 241, 242',
                    100 => '255, 228, 230',
                    200 => '254, 205, 211',
                    300 => '253, 164, 175',
                    400 => '251, 113, 133',
                    500 => '244, 63, 94',
                    600 => '225, 29, 72',
                    700 => '190, 18, 60',
                    800 => '159, 18, 57',
                    900 => '136, 19, 55',
                    950 => '76, 5, 25',
                ],
                'background' => [
                    50 => '249, 250, 251',
                    100 => '243, 244, 246',
                    200 => '229, 231, 235',
                    300 => '209, 213, 219',
                    400 => '156, 163, 175',
                    500 => '107, 114, 128',
                    600 => '75, 85, 99',
                    700 => '55, 65, 81',
                    800 => '31, 41, 55',
                    900 => '17, 24, 39',
                ],
                'cyan' => Color::Cyan,
                'lime' => Color::Lime,
            ])
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->pages([
                Pages\Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')
            ->widgets([
                Widgets\AccountWidget::class,
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ])
            ->plugins([
                FilamentThemeInspectorPlugin::make()
                    ->toggle()
                    ->disabled(fn () => ! app()->hasDebugModeEnabled())
            ])
            ->viteTheme('resources/css/filament/timmy/theme.css');
    }
}
