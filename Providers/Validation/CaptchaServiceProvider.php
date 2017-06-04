<?php
namespace Inkognitro\LumenRestSupport\Providers\Validation;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;
use Inkognitro\LumenRestSupport\Contracts\Validation\CaptchaVerificator;
use Inkognitro\LumenRestSupport\Validation\Captcha\GoogleReCaptchaVerificator;

class CaptchaServiceProvider extends ServiceProvider {
	
    public function register()
    {
        $this->app->singleton(CaptchaVerificator::class, function($app){
            return new GoogleReCaptchaVerificator(env('CAPTCHA_CLIENT_ID'), env('CAPTCHA_CLIENT_SECRET'));
        });
    }

    public function boot(){
        //extend validator with captcha validation
        Validator::extend(
            'captcha',
            function($attribute, $value, $parameters){
                return app(CaptchaVerificator::class)->isTokenValid($value);
            },
            'The :attribute field is not valid.'
        );
    }
	
}