<?php

namespace Hborras\TwitterAdsSDK\TwitterAds\Errors;

use Exception;
use Hborras\TwitterAdsSDK\TwitterAdsException;

class BadRequest extends TwitterAdsException
{
    public function __construct($message, $code, Exception $previous = null, $errors)
    {
        parent::__construct($message, $code, null, $errors);
    }
}
