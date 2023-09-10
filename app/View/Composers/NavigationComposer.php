<?php

namespace App\View\Composers;

use App\Menu\Menu;
use App\Menu\MenuItem;
use Illuminate\View\View;

class NavigationComposer
{
    public function compose(View $view): void
    {
        $menu = Menu::make()
                    ->add(MenuItem::make(route('home'), 'Home'))
                    ->add(MenuItem::make(route('catalog'), 'Catalog'));

        $view->with('menu', $menu);
    }
}
