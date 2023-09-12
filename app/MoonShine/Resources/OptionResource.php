<?php

namespace App\MoonShine\Resources;

use Illuminate\Database\Eloquent\Model;
use App\Models\Option;

use MoonShine\Fields\HasMany;
use MoonShine\Fields\Text;
use MoonShine\Resources\Resource;
use MoonShine\Fields\ID;
use MoonShine\Actions\FiltersAction;

class OptionResource extends Resource
{
    public static string $model = Option::class;

    public static string $title = 'Options';

    public string $titleField = 'title';

    public function fields(): array
    {
        return [
            ID::make()->sortable(),
            Text::make('Title'),
            HasMany::make('Option Values')
                ->fields([
                    ID::make(),
                    Text::make('Value', 'title')->required(),
                ])
                ->fullPage()
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
