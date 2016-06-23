# dialonce-sdk-php

[![Circle CI](https://circleci.com/gh/dial-once/dialonce-sdk-php/tree/develop.svg?style=shield)](https://circleci.com/gh/dial-once/dialonce-sdk-php)
[![Coverage](http://badges.dialonce.io/?resource=dialonce-sdk-php&metrics=coverage)](http://sonar.dialonce.io/overview/coverage?id=dialonce-sdk-php)
[![Sqale](http://badges.dialonce.io/?resource=dialonce-sdk-php&metrics=sqale_rating)](http://sonar.dialonce.io/overview/debt?id=dialonce-sdk-php)

This git repository contains the Dial Once PHP SDK composer package.

# Installation

```bash
composer require dialonce/sdk
```

# Usage

## IVR
For all of the IVR exposed method usage, you will need to instanciate an Application object using your api key and secret:

```php
<?php
$application = new DialOnce\Application('API_KEY', 'API_SECRET');
```

The code above will generate a token by calling our API. If your script is not persistant in memory or if you don't have APC, you may want to use a previously fetched token directly:
```php
<?php
$application = new DialOnce\Application('API_TOKEN');
```

### Log a call step to Dial Once
To allow us to gather analytics, and provide you some important KPI info, we need to get some call steps from your IVR:

```php
<?php

$ivr = new DialOnce\IVR($application, $callerNumber, $calledNumber);

$ivr->log('call-start');
$ivr->log('call-end');
$ivr->log('call-error');
//etc.
```

`$application`: a `DialOnce\Application` object instance  
`$callerNumber`: a string, the caller phone number (inter. format with leading +)  
`$calledNumber`: a string, the IVR phone number that the user called (inter. format with leading +)

### Check if a caller is eligible to use the Dial Once service

```php
<?php
$ivr = new DialOnce\IVR($application, $callerNumber, $calledNumber);
if ( $ivr->isEligible() ) {

}
```
`$application`: a `DialOnce\Application` object instance  
`$callerNumber`: a string, the caller phone number (inter. format with leading +)  
`$calledNumber`: a string, the IVR phone number that the user called (inter. format with leading +)

### The user requested the Dial Once service

```php
<?php
$ivr = new DialOnce\IVR($application, $callerNumber, $calledNumber);
$ivr->serviceRequest();
```
`$application`: a `DialOnce\Application` object instance  
`$callerNumber`: a string, the caller phone number (inter. format with leading +)  
`$calledNumber`: a string, the IVR phone number that the user called (inter. format with leading +)

### Check if the caller uses a mobile phone

```php
<?php
$ivr = new DialOnce\IVR($application, $callerNumber, $calledNumber);
if ($ivr->isMobile()) {

}
```
`$application`: a `DialOnce\Application` object instance  
`$callerNumber`: a string, the caller phone number (inter. format with leading +)  
`$calledNumber`: a string, the IVR phone number that the user called (inter. format with leading +)