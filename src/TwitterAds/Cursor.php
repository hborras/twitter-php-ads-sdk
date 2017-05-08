<?php
/**
 * Created by PhpStorm.
 * User: hborras
 * Date: 2/04/16
 * Time: 23:14.
 */
namespace Hborras\TwitterAdsSDK\TwitterAds;

use Hborras\TwitterAdsSDK\TwitterAds;

class Cursor implements \IteratorAggregate
{
    /** @var Resource  */
    private $resource;
    private $params;
    private $next_cursor = null;
    private $current_index = 0;
    private $total_count = 0;
    /** @var  array */
    private $collection;
    /** @var  TwitterAds */
    private $twitterAds;

    public function __construct(/* @noinspection PhpUnnecessaryFullyQualifiedNameInspection */
        \Hborras\TwitterAdsSDK\TwitterAds\Resource $resource, TwitterAds $twitterAds, $request, $params)
    {
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
     * @return Resource
     */
    public function first()
    {
        return $this->next();
    }

    /**
     * @return int
     */
    public function fetched()
    {
        return count($this->collection);
    }

    /**
     * @return Resource | 0
     */
    public function next()
    {
        if ($this->current_index < count($this->collection)) {
            $value = $this->collection[$this->current_index];
            ++$this->current_index;

            return $value;
        } elseif (!is_null($this->next_cursor)) {
            $this->fetchNext();

            return $this->next();
        } else {
            $this->current_index = 0;

            return 0;
        }
    }

    /**
     * @param array $params
     * @return Cursor
     */
    public function fetchNext($params = [])
    {
        $params['cursor'] = $this->next_cursor;
        switch ($this->getTwitterAds()->getMethod()) {
            case 'GET':
                $response = $this->getTwitterAds()->get($this->getTwitterAds()->getResource(), $params);
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
     */
    public function fromResponse($request)
    {
        $this->next_cursor = isset($request->next_cursor) ? $request->next_cursor : null;
        if (isset($request->total_count)) {
            $this->total_count = intval($request->total_count);
        }
        foreach ($request->data as $item) {
            if (method_exists($this->resource, 'fromResponse')) {
                $obj = new $this->resource();
                $this->collection[] = $obj->fromResponse($item);
            } else {
                $this->collection[] = $item;
            }
        }

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getIterator()
    {
        return new \ArrayIterator($this->collection);
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
}
