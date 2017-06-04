<?php
namespace Inkognitro\LumenRestSupport\Validation\Captcha;

use Inkognitro\LumenRestSupport\Contracts\Validation\CaptchaVerificator;

class GoogleReCaptchaVerificator implements CaptchaVerificator {

    /**
     * @var string
     */
    protected $clientId;

    /**
     * @var string
     */
    protected $clientSecret;

    /**
     * @var string
     */
    protected $validateTokenUri = 'https://www.google.com/recaptcha/api/siteverify';

    /**
    * @var string $clientId
    * @var string $clientSecret
    */
    public function __construct($clientId, $clientSecret){
        $this->clientId = $clientId;
        $this->clientSecret = $clientSecret;
    }

    /**
     * Sets client id of this service
     *
     * @var string $clientId
    */
    public function setClientId($clientId){
        $this->clientId = $clientId;
    }

    /**
     * Sets client secret of this service
     *
     * @var string $clientSecret
    */
    public function setClientSecret($clientSecret){
        $this->clientSecret = $clientSecret;
    }

    /**
     * Check if token is valid and the user is not a bot
     *
     * @var string $token
     * @return boolean
    */
    public function isTokenValid($token){
        $uri = $this->validateTokenUri;
        $curl = curl_init($uri);

        //define header settings
        curl_setopt($curl, CURLOPT_HTTPHEADER, [
            "Accept: application/json; charset=utf-8"
        ]);

        //collect post data
        $data = [
            'secret' => $this->clientSecret,
            'response' => $token
        ];

        //prepare and do request to google
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($curl, CURLINFO_HEADER_OUT, false);

        //response
        $jsonResponse = json_decode(curl_exec($curl));
        $curl_info = curl_getinfo($curl);
        $http_response_code = $curl_info['http_code'];
        $curl_error = curl_error($curl);
        curl_close($curl);

        //return
        if($jsonResponse->success == false || $curl_error || $http_response_code != 200){
            return false;
        }
        return true;
    }
}