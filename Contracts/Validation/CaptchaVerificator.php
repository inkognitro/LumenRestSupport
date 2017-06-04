<?php
namespace Inkognitro\LumenRestSupport\Contracts\Validation;

interface CaptchaVerificator{
    public function setClientId($clientId);
    public function setClientSecret($clientSecret);
    public function isTokenValid($token);
}