<?php

namespace App\Faker;

use Faker\Provider\Base;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class FakerCustomImage extends Base
{
    public function customImage(string $fixturesDir, string $storageDir)
    {
        if ( ! Storage::exists($storageDir)) {
            Storage::createDirectory($storageDir);
        }

        $file = $this->generator->file(
            base_path("tests/Fixtures/images/$fixturesDir"),
            Storage::path($storageDir),
            false
        );

        return '/storage/'.trim($storageDir, '/').'/'.$file;
    }

}
