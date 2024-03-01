<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;

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
        $dev_url = env('DEV_APP_URL');
        $localnet_url = env('LOCALNET_APP_URL');
        $public_url = env('PUBLIC_APP_URL');
        
        $request = request();
        $host_url = parse_url($request->url(), PHP_URL_HOST);
        $host_port = parse_url($request->url(), PHP_URL_PORT);
        
        if ($host_url == 'localhost') {
            URL::forceRootUrl($dev_url);
        }

        if ($host_url == '192.168.31.138') {
            URL::forceRootUrl($localnet_url);
        }

        if ($host_url == '103.90.67.83') {
            URL::forceRootUrl($public_url);
        }
    }
}
