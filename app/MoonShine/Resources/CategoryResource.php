<?php

namespace App\MoonShine\Resources;

use Illuminate\Database\Eloquent\Model;
use App\Models\Category;

use MoonShine\Decorations\Flex;
use MoonShine\Fields\Slug;
use MoonShine\Fields\SwitchBoolean;
use MoonShine\Fields\Text;
use MoonShine\Resources\Resource;
use MoonShine\Fields\ID;
use MoonShine\Actions\FiltersAction;

class CategoryResource extends Resource
{
    public static string $model = Category::class;

    public static string $title = 'Categories';

    public string $titleField = 'Title';

    public function fields(): array
    {
        return [
            ID::make()->sortable(),
            Flex::make([
                Text::make('Title'),
                Slug::make('Slug')
                    ->locked()
                    ->from('title')
                    ->hideOnIndex(),
            ]),
            SwitchBoolean::make('On home page')
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
