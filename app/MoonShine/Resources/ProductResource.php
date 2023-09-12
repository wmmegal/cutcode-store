<?php

namespace App\MoonShine\Resources;

use Illuminate\Database\Eloquent\Model;
use App\Models\Product;

use MoonShine\Decorations\Block;
use MoonShine\Decorations\Collapse;
use MoonShine\Decorations\Column;
use MoonShine\Decorations\Grid;
use MoonShine\Fields\BelongsTo;
use MoonShine\Fields\BelongsToMany;
use MoonShine\Fields\Image;
use MoonShine\Fields\Json;
use MoonShine\Fields\NoInput;
use MoonShine\Fields\Number;
use MoonShine\Fields\Slug;
use MoonShine\Fields\SwitchBoolean;
use MoonShine\Fields\Text;
use MoonShine\Fields\TinyMce;
use MoonShine\Resources\Resource;
use MoonShine\Fields\ID;
use MoonShine\Actions\FiltersAction;

class ProductResource extends Resource
{
    public static string $model = Product::class;

    public static string $title = 'Products';

    public string $titleField = 'title';

    protected string $routeAfterSave = 'edit';

    public function fields(): array
    {
        return [
            ID::make()->sortable(),
            Grid::make([
                Column::make([
                    Block::make([
                        Text::make('Title'),
                        Slug::make('Slug')
                            ->locked()
                            ->from('title')
                            ->hideOnIndex(),
                        NoInput::make('Link', resource: function () {
                            return 'View product';
                        })->link(fn($item) => $item->id ? route('product', $item) : '', blank: true)
                            ->hideOnIndex()
                        ,
                        Number::make('Price', resource: function () {
                            return $this->getItem()?->price->raw();
                        })
                            ->expansion('cents')
                            ->sortable(),
                        Number::make('Quantity')
                            ->hideOnIndex(),
                        TinyMce::make('Text')
                            ->hideOnIndex(),
                        Collapse::make('Properties/Options', [
                            Json::make('Properties', 'json_properties')
                                ->keyValue()
                                ->hideOnIndex(),
                            BelongsToMany::make('Option Values', resource: 'title')
                                ->asyncSearch('title', asyncSearchValueCallback: function ($option) {
                                    return $option->title;
                                })
                                ->hideOnIndex(),
                        ]),

                    ])
                ])->columnSpan('8'),
                Column::make([
                    Block::make([
                        Image::make('Thumbnail')
                            ->required()
                            ->hideOnIndex()
                            ->removable(),
                        SwitchBoolean::make('On home page'),
                        BelongsToMany::make('Categories')
                            ->hideOnIndex(),
                        BelongsTo::make('Brand')
                            ->hideOnIndex()
                    ])
                ])->columnSpan('4')
            ])
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
