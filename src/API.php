<?php

namespace DialOnce;

if (!empty($_ENV['DIALONCE_API_URL'])) {
    API::$API_URL = $_ENV['DIALONCE_API_URL'];
}

class API
{
    /**
     * The Dial Once API URL
     * @var string
     */
    static $API_URL = 'https://api.dial-once.com/';

    /**
     * Perform a POST request against the Dial Once API
     * @param  [string] $path    The URL to query
     * @param  [array] $params ["key" => "value"] array to use as parameters
     * @param  [string(opt.)] $token  a token used to auth yourself to the API. See DialOnce\Application class to grab a token
     * @return [string]       The API answer (as string)
     */
    static function post($path, $params, $token = NULL)
    {
        $ch = curl_init(API::$API_URL.$path);

        curl_setopt($ch, CURLOPT_POST, count($params));
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($params));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        if (!empty($token)) {
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization: Bearer '.$token));
        }

        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    }

    /**
     * [get description]
     * @param  [string] $path    The URL to query
     * @param  [array] $params ["key" => "value"] array to use as parameters
     * @param  [string(opt.)] $token  a token used to auth yourself to the API. See DialOnce\Application class to grab a token
     * @return [string]       The API answer (as string)
     */
    static function get($path, $params, $token = NULL)
    {
        $ch = curl_init(API::$API_URL.$path.'/?'.http_build_query($params));

        if (!empty($token)) {
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization: Bearer '.$token));
        }

        curl_setopt_array($ch, array(CURLOPT_RETURNTRANSFER => 1));

        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    }
}