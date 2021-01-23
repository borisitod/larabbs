<?php

namespace App\Providers;

use ClickSendLib\ClickSendClient;
use Illuminate\Support\ServiceProvider;

class ClickSendServiceProvider extends ServiceProvider
{
    public function boot()
    {
        //
    }

    public function register()
    {
        $this->app->singleton(ClickSendClient::class, function ($app) {
            return new ClickSendClient(config('clicksend'));
        });

        $this->app->alias(ClickSendClient::class, 'clicksend');
    }
}
