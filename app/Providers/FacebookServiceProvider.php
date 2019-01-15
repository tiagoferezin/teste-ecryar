<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class FacebookServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(Facebook::class, function ($app) {
            $config = config('services.facebook');
            return new Facebook([
                'app_id' => '356321788489607',
                'app_secret' => '70d8add9f5005fd814ece322955dd159',
                'default_graph_version' => 'v3.2',
            ]);
        });
    }
}
