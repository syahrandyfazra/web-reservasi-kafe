<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $publicStoragePath = public_path('storage');
        $appStoragePath = storage_path('app/public');

        if (!is_dir($publicStoragePath) && is_dir($appStoragePath) && !is_link($publicStoragePath)) {
            try {
                symlink($appStoragePath, $publicStoragePath);
            } catch (\Throwable $e) {
                // Ignore if the symlink cannot be created in this environment.
            }
        }
    }
}
