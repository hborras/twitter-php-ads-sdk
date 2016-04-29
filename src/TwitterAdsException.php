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

class BadRequest extends TwitterAdsException
{
    public function __construct($message, $code, Exception $previous = null, $errors)
    {
        parent::__construct($message, $code, null, $errors);
    }
}

class NotAuthorized extends TwitterAdsException
{
    public function __construct($message, $code, Exception $previous = null, $errors)
    {
        parent::__construct($message, $code, null, $errors);
    }
}

class Forbidden extends TwitterAdsException
{
    public function __construct($message, $code, Exception $previous = null, $errors)
    {
        parent::__construct($message, $code, null, $errors);
    }
}

class NotFound extends TwitterAdsException
{
    public function __construct($message, $code, Exception $previous = null, $errors)
    {
        parent::__construct($message, $code, null, $errors);
    }
}

class RateLimit extends TwitterAdsException
{
    private $retryAfter;
    private $resetAt;

    public function __construct($message, $code, Exception $previous = null, $errors, $headers)
    {
        parent::__construct($message, $code, null, $errors);
        $this->retryAfter = $headers['retry-after'];
        $this->resetAt = $headers['rate_limit_reset'];
    }

    /**
     * @return mixed
     */
    public function getRetryAfter()
    {
        return $this->retryAfter;
    }

    /**
     * @return mixed
     */
    public function getResetAt()
    {
        return $this->resetAt;
    }
}

class ServerError extends TwitterAdsException
{
    public function __construct($message, $code, Exception $previous = null, $errors)
    {
        parent::__construct($message, $code, null, $errors);
    }
}

class ServiceUnavailable extends TwitterAdsException
{
    private $retryAfter;

    public function __construct($message, $code, Exception $previous = null, $errors, $headers)
    {
        parent::__construct($message, $code, null, $errors);
        $this->retryAfter = $headers['retry-after'];
    }

    /**
     * @return mixed
     */
    public function getRetryAfter()
    {
        return $this->retryAfter;
    }
}


