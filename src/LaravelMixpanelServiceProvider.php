<?php

namespace Mobiverse\LaravelMixpanel;

use hisorange\BrowserDetect\Parser;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;
use Mobiverse\LaravelMixpanel\Events\MixpanelEvent;
use Mobiverse\LaravelMixpanel\Listeners\MixpanelEventListener;

/**
 * @package Mobiverse\LaravelAsteriskAri
 * Laravel Asterisk ARI service provider class
 */
class LaravelMixpanelServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(
            'browser-detect',
            function ($app) {
                return new Parser(
                    $app->make('cache'),
                    $app->make('request'),
                        $app->make('config')['browser-detect'] ?? []
                );
            }
        );
        $this->app->singleton('mixpanel', LaravelMixpanel::class);
    }

    /**
     * Boot the service provider.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPublishables();

        $this->registerEventsAndListeners();
    }

    private function registerPublishables(): void
    {
        $this->publishes(
            [
                __DIR__ . '/../config/laravel-mixpanel.php' => config_path('laravel-mixpanel.php'),
            ],
            'laravel-mixpanel-config'
        );
    }

    private function registerEventsAndListeners(): void
    {
        Event::listen(
            MixpanelEvent::class,
            MixpanelEventListener::class
        );
    }
}
