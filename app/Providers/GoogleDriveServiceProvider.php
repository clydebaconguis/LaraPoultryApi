<?php

namespace App\Providers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\GoogleServiceProvider;

class GoogleDriveServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //    Storage::extend("google", function ($app, $config) {
        //         $client = new \Google\Client;
        //         $client->setClientId($config['clientId']);
        //         $client->setClientSecret($config['clientSecret']);
        //         $client->refreshToken($config['refreshToken']);
        //     });
    }
}
