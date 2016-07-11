<?php

namespace DialOnce;

/**
 * Class IVR
 *
 * @package DialOnce
 */
class IVR
{
    /**
     * The caller phone number
     * @var [string]
     */
    private $caller;
    /**
     * The called phone number
     * @var [type]
     */
    private $called;
    /**
     * The current used Dial Once Application for this session
     * @var [type]
     */
    private $app;

    /**
     * IVR Object, used to perform action when user do some actions on the IVR
     * @param Application $app    DialOnce\Application object, propertly initialized
     * @param [string]      $caller The phone number of the caller (inter. format, with leading +)
     * @param [string]      $called The phone number called by the user (inter. format with leading +)
     */
    public function __construct(Application $app, $caller, $called)
    {
        $this->app = $app;
        $this->caller = $caller;
        $this->called = $called;
    }

    /**
     * Save a log for the current call to Dial Once
     * @param  string $type (can be call-start, call-end, answer-get-sms, etc.)
     */
    public function log($type = 'call-start')
    {
        API::post('ivr/log', array(
            'type' => $type,
            'caller' => $this->caller,
            'called' => $this->called
        ), $this->app->getAccessToken());
    }

    /**
     * Check if caller phone number is a mobile phone number
     * @param  string (optional) $cultureISO the culture of the caller phone number (if not in international format)
     * @return boolean True/False based on the user phone number
     */
    public function isMobile($cultureISO = '')
    {
        $isMobile = API::get('phoneNumbers/isMobile', array(
            'number' => $this->caller,
            'cultureISO' => $cultureISO
        ), $this->app->getAccessToken());

        return json_decode($isMobile)->mobile;
    }

    /**
     * Check if you should ask for the user to use or not the Dial Once service
     * @return boolean True/False based on the user Eligibility
     */
    public function isEligible()
    {
        $isEligible = API::get('ivr/isEligible', array(
            'caller' => $this->caller,
            'called' => $this->called
        ), $this->app->getAccessToken());

        return json_decode($isEligible)->eligible;
    }

    /**
     * You should call this method if user asked to use the Dial Once service
     */
    public function serviceRequest()
    {
        API::post('ivr/serviceRequest', array(
            'caller' => $this->caller,
            'called' => $this->called
        ), $this->app->getAccessToken());
    }
}