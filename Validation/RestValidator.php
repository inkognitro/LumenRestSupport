<?php
namespace Inkognitro\LumenRestSupport\Validation;

use Illuminate\Support\MessageBag;
use Illuminate\Validation\Validator;

class RestValidator extends Validator {
    /**
     * Add a failed rule and error message to the collection.
     *
     * @param  string  $attribute
     * @param  string  $rule
     * @param  array   $parameters
     * @return void
     */
    protected function addFailure($attribute, $rule, $parameters) {
        $message = $this->getMessage($attribute, $rule);
        $message = $this->makeReplacements($message, $attribute, $rule, $parameters);
        $customMessage = new MessageBag();
        $customMessage->merge(['code' => strtolower($rule)]);
        $customMessage->merge(['message' => $message]);
        $this->messages->add($attribute, $customMessage);

        $this->failedRules[$attribute][$rule] = $parameters;
    }
}