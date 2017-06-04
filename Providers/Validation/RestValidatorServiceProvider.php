<?php
namespace Inkognitro\LumenRestSupport\Providers\Validation;

use Illuminate\Support\ServiceProvider;
use Inkognitro\LumenRestSupport\Validation\RestValidator;

class RestValidatorServiceProvider extends ServiceProvider {
	
    public function boot(){
		//use RestValidator: Validation codes included in message bag
		\Validator::resolver(function($translator, $data, $rules, $messages){
            return new RestValidator($translator, $data, $rules, $messages);
        });
    }
	
}