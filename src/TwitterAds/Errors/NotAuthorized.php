<?php

namespace Hborras\TwitterAdsSDK\TwitterAds\Errors;

use Hborras\TwitterAdsSDK\TwitterAdsException;

class NotAuthorized extends TwitterAdsException
{
    public function __construct($message, $code, $errors)
    {
        parent::__construct($message, $code, null, $errors);
    }
}
