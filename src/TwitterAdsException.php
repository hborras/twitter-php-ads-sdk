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
    public function __construct($errors)
    {
        parent::__construct(TwitterAdsException::BAD_REQUEST, 400, null, $errors);
    }
}

class NotAuthorized extends TwitterAdsException
{
    public function __construct($errors)
    {
        parent::__construct(TwitterAdsException::NOT_AUTHORIZED, 401, null, $errors);
    }
}

class Forbidden extends TwitterAdsException
{
    public function __construct($errors)
    {
        parent::__construct(TwitterAdsException::FORBIDDEN, 403, null, $errors);
    }
}

class NotFound extends TwitterAdsException
{
    public function __construct($errors)
    {
        parent::__construct(TwitterAdsException::NOT_FOUND, 404, null, $errors);
    }
}

class RateLimit extends TwitterAdsException
{
    private $retryAfter;
    private $resetAt;

    public function __construct($errors, $headers)
    {
        parent::__construct(TwitterAdsException::RATE_LIMIT, 429, null, $errors);
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
    public function __construct($errors)
    {
        parent::__construct(TwitterAdsException::SERVER_ERROR, 500, null, $errors);
    }
}

class ServiceUnavailable extends TwitterAdsException
{
    private $retryAfter;

    public function __construct($errors, $headers)
    {
        parent::__construct(TwitterAdsException::SERVICE_UNAVAILABLE, 503, null, $errors);
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


