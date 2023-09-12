<?php

namespace App\MoonShine\Resources;

use Illuminate\Database\Eloquent\Model;
use App\Models\Brand;

use MoonShine\Decorations\Block;
use MoonShine\Decorations\Column;
use MoonShine\Decorations\Grid;
use MoonShine\Fields\Image;
use MoonShine\Fields\Slug;
use MoonShine\Fields\SwitchBoolean;
use MoonShine\Fields\Text;
use MoonShine\Resources\Resource;
use MoonShine\Fields\ID;
use MoonShine\Actions\FiltersAction;

class BrandResource extends Resource
{
    public static string $model = Brand::class;

    public static string $title = 'Brands';

    public string $titleField = 'title';

    public function fields(): array
    {
        return [
            ID::make()->sortable(),

            Grid::make([
                Column::make([
                    Text::make('Title'),
                    Slug::make('Slug')
                        ->locked()
                        ->from('title')
                        ->hideOnIndex(),
                    SwitchBoolean::make('On home page')
                ])->columnSpan(8),

                Column::make([
                    Image::make('Thumbnail')
                        ->hideOnIndex()
                ])->columnSpan(4),
            ]),


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
