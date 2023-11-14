<?php

namespace Mobiverse\LaravelMixpanel\Tests;

use Illuminate\Support\Facades\Config;
use Mobiverse\LaravelMixpanel\LaravelMixpanelServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

/**
 * @package Mobiverse\LaravelMixpanel
 * Class TestCase
 */
class TestCase extends Orchestra
{
    protected function setUp(): void
    {
        parent::setUp();
    }

    /**
     * add the package provider
     *
     * @param $app
     * @return array
     */
    protected function getPackageProviders($app)
    {
        return [
            LaravelMixpanelServiceProvider::class,
        ];
    }

    /**
     * Define environment setup.
     *
     * @param  \Illuminate\Foundation\Application  $app
     * @return void
     */
    protected function getEnvironmentSetUp($app): void
    {
        $app['config']->set(
            'laravel-mixpanel',
            [
                'host' => env("MIXPANEL_HOST"),
                'token' => env('MIXPANEL_TOKEN'),
                'enable-default-tracking' => true,
                'consumer' => 'socket',
                'connect-timeout' => 2,
                'timeout' => 2,
                "data_callback_class" => null,
            ]
        );
    }
}
