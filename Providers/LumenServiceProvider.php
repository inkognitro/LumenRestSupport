<?php
namespace Inkognitro\LumenRestSupport\Providers;

use Illuminate\Support\ServiceProvider;

class LumenServiceProvider extends ServiceProvider {
	
    public function register()
    {
        $this->app->register('Inkognitro\LumenRestSupport\Providers\Validation\CaptchaServiceProvider');
        $this->app->register('Inkognitro\LumenRestSupport\Providers\Validation\RestValidatorServiceProvider');
    }

    public function boot(){

    }
}