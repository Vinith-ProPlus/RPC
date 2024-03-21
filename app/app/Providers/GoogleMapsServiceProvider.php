<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class GoogleMapsServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register()
    {
        $this->app->singleton('googlemaps', function ($app) {
            return new \GuzzleHttp\Client([
                'base_uri' => 'https://maps.googleapis.com/maps/api/',
                'query' => ['key' => env('GOOGLE_MAPS_API_KEY')],
            ]);
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
