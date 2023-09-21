<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class RefreshCommand extends Command
{

    protected $signature = 'shop:refresh';
    protected $description = 'Refresh';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(): int
    {
        if (app()->isProduction()) {
            return self::FAILURE;
        }

        $this->call('cache:clear');

        Storage::disk('public')->deleteDirectory('images/products');
        Storage::disk('public')->deleteDirectory('images/brands');

        $this->call('migrate:fresh', [
            '--seed' => true
        ]);

        return self::SUCCESS;
    }
}
