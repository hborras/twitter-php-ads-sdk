<?php

namespace Hborras\TwitterAdsSDK\TwitterAds;

use Iterator;
use Exception;
use Countable;
use arrayaccess;
use ArrayIterator;
use Hborras\TwitterAdsSDK\TwitterAds;

class Cursor implements Iterator, Countable, arrayaccess
{
    /** @var Resource */
    private $resource;
    private $params;
    private $next_cursor = null;
    private $current_index = 0;
    private $total_count = 0;
    /** @var  array */
    private $collection;
    /** @var  TwitterAds */
    private $twitterAds;

    /**
     * @var int|null
     */
    protected $indexLeft;

    /**
     * @var int|null
     */
    protected $indexRight;

    /**
     * @var bool
     */
    protected static $defaultUseImplicitFetch = false;

    /**
     * @var bool
     */
    protected $useImplicitFetch;

    public function __construct(/* @noinspection PhpUnnecessaryFullyQualifiedNameInspection */
        Resource $resource,
        TwitterAds $twitterAds,
        $request,
        $params
    ) {
        $this->resource = $resource;
        $this->params = $params;
        $this->twitterAds = $twitterAds;
        $this->fromResponse($request);
    }

    /**
     * @return bool
     */
    public function isExhausted()
    {
        return is_null($this->next_cursor) ? true : false;
    }

    /**
     * @return integer
     */
    public function count()
    {
        return max($this->total_count, count($this->collection));
    }

    /**
     * @return int
     */
    public function fetched()
    {
        return count($this->collection);
    }

    /**
     * @return void 0
     * @throws Errors\BadRequest
     * @throws Errors\Forbidden
     * @throws Errors\NotAuthorized
     * @throws Errors\NotFound
     * @throws Errors\RateLimit
     * @throws Errors\ServerError
     * @throws Errors\ServiceUnavailable
     * @throws \Hborras\TwitterAdsSDK\TwitterAdsException
     */
    public function next()
    {
        if ($this->current_index == $this->getIndexRight() && !is_null($this->next_cursor)) {
            if ($this->getUseImplicitFetch()) {
                $this->fetchNext();
                if ($this->current_index == $this->getIndexRight()) {
                    $this->current_index = null;
                } else {
                    ++$this->current_index;
                }
            } else {
                $this->current_index = null;
            }
        } else {
            ++$this->current_index;
        }
    }

    /**
     * @param array $params
     * @return Cursor
     * @throws Errors\BadRequest
     * @throws Errors\Forbidden
     * @throws Errors\NotAuthorized
     * @throws Errors\NotFound
     * @throws Errors\RateLimit
     * @throws Errors\ServerError
     * @throws Errors\ServiceUnavailable
     * @throws \Hborras\TwitterAdsSDK\TwitterAdsException
     */
    public function fetchNext($params = [])
    {
        $requestParams = $this->params;
        if (count($params) > 0) {
            foreach ($params as $key => $value) {
                $requestParams[$key] = $value;
            }
        }
        $requestParams['cursor'] = $this->next_cursor;
        switch ($this->getTwitterAds()->getMethod()) {
            case 'GET':
                $response = $this->getTwitterAds()->get($this->getTwitterAds()->getResource(), $requestParams);
                break;
            case 'POST':
                $response = $this->getTwitterAds()->post($this->getTwitterAds()->getResource(), $params);
                break;
            case 'PUT':
                $response = $this->getTwitterAds()->put($this->getTwitterAds()->getResource(), $params);
                break;
            case 'DELETE':
                $response = $this->getTwitterAds()->delete($this->getTwitterAds()->getResource());
                break;
            default:
                $response = $this->getTwitterAds()->get($this->getTwitterAds()->getResource(), $params);
                break;
        }

        return $this->fromResponse($response->getBody());
    }

    /**
     * @param $request
     * @return $this
     * @throws Exception
     */
    public function fromResponse($request)
    {
        $this->next_cursor = isset($request->next_cursor) ? $request->next_cursor : null;
        if (isset($request->total_count)) {
            $this->total_count = intval($request->total_count);
        }
        foreach ($request->data as $item) {
            if (method_exists($this->resource, 'fromResponse')) {
                /** @var Resource $obj */
                $obj = new $this->resource();
                $this->collection[] = $obj->fromResponse($item);
            } else {
                $this->collection[] = $item;
            }
        }

        if ($this->indexRight === null) {
            $this->indexLeft = 0;
            $this->indexRight = -1;
            $this->current_index = 0;
        }

        $this->indexRight += count($request->data);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getIterator()
    {
        return new ArrayIterator($this->collection);
    }

    /**
     * @return array
     */
    public function getCollection()
    {
        return $this->collection;
    }

    /**
     * @param array $collection
     */
    public function setCollection($collection)
    {
        $this->collection = $collection;
    }

    /**
     * @return TwitterAds
     */
    public function getTwitterAds()
    {
        return $this->twitterAds;
    }

    /**
     * @param TwitterAds $twitterAds
     */
    public function setTwitterAds($twitterAds)
    {
        $this->twitterAds = $twitterAds;
    }

    /**
     * Return the current element
     * @link http://php.net/manual/en/iterator.current.php
     * @return mixed Can return any type.
     * @since 5.0.0
     */
    public function current()
    {
        return isset($this->collection[$this->current_index])
            ? $this->collection[$this->current_index]
            : false;
    }

    /**
     * Return the key of the current element
     * @link http://php.net/manual/en/iterator.key.php
     * @return mixed scalar on success, or null on failure.
     * @since 5.0.0
     */
    public function key()
    {
        return $this->current_index;
    }

    /**
     * Checks if current position is valid
     * @link http://php.net/manual/en/iterator.valid.php
     * @return boolean The return value will be casted to boolean and then evaluated.
     * Returns true on success or false on failure.
     * @since 5.0.0
     */
    public function valid()
    {
        return isset($this->collection[$this->current_index]);
    }

    /**
     * Rewind the Iterator to the first element
     * @link http://php.net/manual/en/iterator.rewind.php
     * @return void Any returned value is ignored.
     * @since 5.0.0
     */
    public function rewind()
    {
        $this->current_index = $this->current_index--;
    }

    /**
     * Whether a offset exists
     * @link http://php.net/manual/en/arrayaccess.offsetexists.php
     * @param mixed $offset <p>
     * An offset to check for.
     * </p>
     * @return boolean true on success or false on failure.
     * </p>
     * <p>
     * The return value will be casted to boolean if non-boolean was returned.
     * @since 5.0.0
     */
    public function offsetExists($offset)
    {
        return isset($this->collection[$offset]);
    }

    /**
     * Offset to retrieve
     * @link http://php.net/manual/en/arrayaccess.offsetget.php
     * @param mixed $offset <p>
     * The offset to retrieve.
     * </p>
     * @return mixed Can return all value types.
     * @since 5.0.0
     */
    public function offsetGet($offset)
    {
        return isset($this->collection[$offset]) ? $this->collection[$offset] : null;
    }

    /**
     * Offset to set
     * @link http://php.net/manual/en/arrayaccess.offsetset.php
     * @param mixed $offset <p>
     * The offset to assign the value to.
     * </p>
     * @param mixed $value <p>
     * The value to set.
     * </p>
     * @return void
     * @since 5.0.0
     */
    public function offsetSet($offset, $value)
    {
        if ($offset === null) {
            $this->collection[] = $value;
        } else {
            $this->collection[$offset] = $value;
        }
    }

    /**
     * Offset to unset
     * @link http://php.net/manual/en/arrayaccess.offsetunset.php
     * @param mixed $offset <p>
     * The offset to unset.
     * </p>
     * @return void
     * @since 5.0.0
     */
    public function offsetUnset($offset)
    {
        unset($this->collection[$offset]);
    }

    /**
     * @return bool
     */
    public static function getDefaultUseImplicitFetch()
    {
        return static::$defaultUseImplicitFetch;
    }

    /**
     * @param bool $use_implicit_fetch
     */
    public static function setDefaultUseImplicitFetch($use_implicit_fetch)
    {
        static::$defaultUseImplicitFetch = $use_implicit_fetch;
    }

    /**
     * @return bool
     */
    public function getUseImplicitFetch()
    {
        return $this->useImplicitFetch !== null
            ? $this->useImplicitFetch
            : static::$defaultUseImplicitFetch;
    }

    /**
     * @param bool $useImplicitFetch
     */
    public function setUseImplicitFetch($useImplicitFetch)
    {
        $this->useImplicitFetch = $useImplicitFetch;
    }

    /**
     * @return int|null
     */
    public function getIndexLeft()
    {
        return $this->indexLeft;
    }

    /**
     * @return int|null
     */
    public function getIndexRight()
    {
        return $this->indexRight;
    }

    /**
     * @return mixed
     */
    public function getParams()
    {
        return $this->params;
    }
    /**
     * @param mixed $params
     */
    public function setParams($params)
    {
        $this->params = $params;
    }
}
