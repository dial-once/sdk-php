<?php

namespace DialOnce;

/**
 * Class Application
 *
 * @package DialOnce
 */
class Application
{
    private $token = '';

    /**
     * Application class represents a Dial Once Application (IVR app, SDK, js-tag...)
     * @param [string] $key     The Application key
     * @param [string] $secret  The Application secret
     */
    public function __construct($key, $secret = NULL) {

        if ($secret === NULL) {
            $this->token = new \StdClass();
            $this->token->access_token = $key;
            return;
        }

        $this->token = json_decode(API::post('oauth/token/', array(
            'grant_type' => 'client_credentials',
            'client_id' => $key,
            'client_secret' => $secret
          )));

        //if there is a status, it means that the server rejected our request
        if (isset($this->token->status)) {
            throw new \Exception("Invalid API Key / Secret", 1);
        }
    }

    /**
     * Accessor to internal token string variable
     * @return [string] The access token string
     */
    public function getAccessToken() {
        return $this->token->access_token;
    }
}