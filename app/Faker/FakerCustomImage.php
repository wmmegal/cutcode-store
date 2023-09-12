<?php

namespace App\Faker;

use Faker\Provider\Base;
use Illuminate\Support\Facades\Storage;

class FakerCustomImage extends Base
{
    public function customImage(string $fixturesDir, string $storageDir): string
    {
        if ( ! Storage::exists($storageDir)) {
            Storage::createDirectory($storageDir);
        }

        $file = $this->generator->file(
            base_path("tests/Fixtures/images/$fixturesDir"),
            Storage::path($storageDir),
            false
        );

        return trim($storageDir, '/').'/'.$file;
    }

}
