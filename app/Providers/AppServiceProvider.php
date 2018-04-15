<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use SpotifyWebAPI\Session;
use SpotifyWebAPI\SpotifyWebAPI;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        app()->bind(SpotifyWebAPI::class, function() {
            $token = cache()->remember('spotify_token', 50, function() {
                $session = new Session(
                    config('services.spotify.client_id'),
                    config('services.spotify.client_secret'),
                    config('services.spotify.redirect_url')
                );
                $session->requestCredentialsToken();
                return $session->getAccessToken();
            });
            $api = new SpotifyWebAPI();

            $api->setAccessToken($token);
            return $api;
        });
    }
}
