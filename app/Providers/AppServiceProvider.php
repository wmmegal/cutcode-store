<?php

namespace App\Providers;

use App\Cart\CartManager;
use App\Cart\IdentityStorageContract;
use App\Cart\SessinIdentityStorage;
use App\Faker\FakerCustomImage;
use App\Http\Kernel;
use Carbon\CarbonInterval;
use DB;
use Faker\Factory;
use Faker\Generator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(Generator::class, function () {
            $faker = Factory::create();
            $faker->addProvider(new FakerCustomImage($faker));

            return $faker;
        });

        $this->app->bind(IdentityStorageContract::class, SessinIdentityStorage::class);
        $this->app->singleton(CartManager::class);
    }

    public function boot()
    {
        Model::shouldBeStrict(! app()->isProduction());

        if (app()->isProduction()) {
            DB::listen(function ($query) {
                if ($query->time > 100) {
                    logger()
                        ->channel('telegram')
                        ->debug('query longer than 100ms: '.$query->sql, $query->bindings);
                }
            });

            app(Kernel::class)->whenRequestLifecycleIsLongerThan(
                CarbonInterval::seconds(4),
                function () {
                    logger()
                        ->channel('telegram')
                        ->debug('whenRequestLifecycleIsLongerThan:'.request()->url());
                }
            );
        }
    }
}
