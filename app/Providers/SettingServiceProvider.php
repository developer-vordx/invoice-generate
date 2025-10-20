<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use App\Models\Setting;

class SettingServiceProvider extends ServiceProvider
{
    public function boot()
    {
        if (Schema::hasTable('settings')) {
            // Cache forever (until manually cleared)
            $settings = cache()->rememberForever('app_settings', function () {
                return Setting::first();
            });

            if ($settings) {
                View::share('globalSettings', $settings);

                config([
                    'settings' => $settings->toArray(),
                ]);
            }
        }
    }

    public function register()
    {
        //
    }
}
