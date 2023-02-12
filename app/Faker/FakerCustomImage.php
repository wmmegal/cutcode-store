<?php

namespace App\Faker;

use Faker\Provider\Base;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class FakerCustomImage extends Base
{
    public function customImage($dir = '')
    {
        if ( ! Storage::exists($dir)) {
            Storage::createDirectory($dir);
        }

        $from = base_path('tests/Fixtures/images/products/').rand(1, 9).'.jpg';
        $name = '/storage/images/'.$dir.'/'.Str::random(6).'.jpg';

        Storage::put(
            $name,
            $from
        );

        return $name;
    }

}
