<?php

namespace App\Providers;

use App\MoonShine\Resources\BrandResource;
use App\MoonShine\Resources\CategoryResource;
use App\MoonShine\Resources\OptionResource;
use App\MoonShine\Resources\OrderResource;
use App\MoonShine\Resources\ProductResource;
use App\MoonShine\Resources\SeoResource;
use Illuminate\Support\ServiceProvider;
use MoonShine\MoonShine;
use MoonShine\Menu\MenuGroup;
use MoonShine\Menu\MenuItem;
use MoonShine\Resources\MoonShineUserResource;
use MoonShine\Resources\MoonShineUserRoleResource;

class MoonShineServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        app(MoonShine::class)->menu([
            MenuGroup::make('moonshine::ui.resource.system', [
                MenuItem::make('moonshine::ui.resource.admins_title', MoonShineUserResource::class)
                    ->translatable()
                    ->icon('users'),
                MenuItem::make('moonshine::ui.resource.role_title', MoonShineUserRoleResource::class)
                    ->translatable()
                    ->icon('bookmark'),
            ])->translatable(),

            MenuItem::make('Categories', CategoryResource::class),
            MenuItem::make('Brands', BrandResource::class),
            MenuItem::make('Options', OptionResource::class),
            MenuItem::make('Products', ProductResource::class),
            MenuItem::make('Orders', OrderResource::class),
            MenuItem::make('Seo', SeoResource::class),
        ]);
    }
}
