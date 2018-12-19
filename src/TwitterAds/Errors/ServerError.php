<?php

namespace Hborras\TwitterAdsSDK\TwitterAds\Errors;

use Exception;
use Hborras\TwitterAdsSDK\TwitterAdsException;

class ServerError extends TwitterAdsException
{
    public function __construct($message, $code, $errors)
    {
        parent::__construct($message, $code, null, $errors);
    }
}
