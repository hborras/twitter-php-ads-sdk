<?php

namespace Hborras\TwitterAdsSDK;

use Exception;

/**
 * @author Hector Borras <hborrasaleixandre@gmail.com>
 */
class TwitterAdsException extends \Exception
{
    const BAD_REQUEST         = "BAD_REQUEST";
    const NOT_AUTHORIZED      = "NOT_AUTHORIZED";
    const FORBIDDEN           = "FORBIDDEN";
    const NOT_FOUND           = "NOT_FOUND";
    const RATE_LIMIT          = "RATE_LIMIT";
    const SERVER_ERROR        = "SERVER_ERROR";
    const SERVICE_UNAVAILABLE = "SERVICE_UNAVAILABLE";

    private $errors;

    public function __construct($message, $code, Exception $previous = null, $errors)
    {
        parent::__construct($message, $code, $previous);
        $this->errors = $errors;
    }

    /**
     * @return mixed
     */
    public function getErrors()
    {
        return $this->errors;
    }
}
