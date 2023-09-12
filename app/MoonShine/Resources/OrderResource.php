<?php

namespace App\MoonShine\Resources;

use App\Enums\OrderStatuses;
use App\Models\Order\Order;
use Illuminate\Database\Eloquent\Model;

use MoonShine\Decorations\Column;
use MoonShine\Decorations\Grid;
use MoonShine\Fields\BelongsTo;
use MoonShine\Fields\Enum;
use MoonShine\Fields\HasMany;
use MoonShine\Fields\HasOne;
use MoonShine\Fields\Number;
use MoonShine\Fields\Text;
use MoonShine\Resources\Resource;
use MoonShine\Fields\ID;
use MoonShine\Actions\FiltersAction;

class OrderResource extends Resource
{
    public static string $model = Order::class;

    public static string $title = 'Orders';

    public static array $with = ['orderCustomer'];

    protected string $routeAfterSave = 'edit';


    public function fields(): array
    {
        return [
            ID::make()
                ->sortable(),
            Grid::make([
                Column::make([
                    Enum::make('Status')->attach(OrderStatuses::class),
                    BelongsTo::make('Delivery type', resource: 'title')
                        ->hideOnIndex(),
                    BelongsTo::make('Payment method', resource: 'title')
                        ->hideOnIndex(),
                ])->columnSpan(8),
                Column::make([
                    HasOne::make('Order Customer', resource: 'name')
                        ->fields([
                            Text::make('Name'),
                            Text::make('Phone'),
                            Text::make('Email'),
                            Text::make('City'),
                            Text::make('Address')
                        ])
                        ->fullPage()
                        ->hideOnIndex()
                ])->columnSpan(4)
            ]),
            HasMany::make('Order items')
                ->fields([
                    BelongsTo::make('Product')
                        ->searchable(),
                    Number::make('Price', resource: function ($item) {
                        return $item->price->raw();
                    }),
                    Number::make('Quantity')
                ])
                ->removable()
                ->hideOnIndex()

        ];
    }

    public function rules(Model $item): array
    {
        return [];
    }

    public function search(): array
    {
        return ['id'];
    }

    public function filters(): array
    {
        return [];
    }

    public function actions(): array
    {
        return [
            FiltersAction::make(trans('moonshine::ui.filters')),
        ];
    }
}
