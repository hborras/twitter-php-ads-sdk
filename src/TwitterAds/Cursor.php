<?php
/**
 * Created by PhpStorm.
 * User: hborras
 * Date: 2/04/16
 * Time: 23:14.
 */
namespace Hborras\TwitterAdsSDK\TwitterAds;

class Cursor
{
    private $account;
    /** @var resource  */
    private $resource;
    private $params;
    private $next_cursor = null;
    private $current_index = 0;
    private $total_count = 0;
    /** @var  array */
    private $collection;

    public function __construct(/* @noinspection PhpUnnecessaryFullyQualifiedNameInspection */
        \Hborras\TwitterAdsSDK\TwitterAds\Resource $resource, Account $account, $request, $params)
    {
        $this->resource = $resource;
        $this->account = $account;
        $this->params = $params;
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
     * @return mixed
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
     * @return Resource
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
     * @return Cursor
     */
    public function fetchNext()
    {
        $params['cursor'] = $this->next_cursor;
        switch ($this->account->getTwitterAds()->getMethod()) {
            case 'GET':
                $response = $this->account->getTwitterAds()->get($this->account->getTwitterAds()->getResource(), $params);
            break;
            case 'POST':
                $response = $this->account->getTwitterAds()->post($this->account->getTwitterAds()->getResource(), $params);
            break;
            case 'PUT':
                $response = $this->account->getTwitterAds()->put($this->account->getTwitterAds()->getResource(), $params);
            break;
            case 'DELETE':
                $response = $this->account->getTwitterAds()->delete($this->account->getTwitterAds()->getResource(), $params);
            break;
            default:
                $response = $this->account->getTwitterAds()->get($this->account->getTwitterAds()->getResource(), $params);
            break;
        }

        return $this->fromResponse($response);
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
                if ($this->resource instanceof Account) {
                    $obj = new $this->resource($this->account->getTwitterAds());
                } else {
                    $obj = new $this->resource();
                }
                $obj->setAccount($this->account);
                $this->collection[] = $obj->fromResponse($item);
            } else {
                $this->collection[] = $item;
            }
        }

        return $this;
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
     * @return Account
     */
    public function getAccount()
    {
        return $this->account;
    }

    /**
     * @param Account $account
     */
    public function setAccount($account)
    {
        $this->account = $account;
    }
}
