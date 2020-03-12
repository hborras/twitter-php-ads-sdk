<?php


namespace Hborras\TwitterAdsSDK\TwitterAds;


use ArrayAccess;
use Countable;
use Hborras\TwitterAdsSDK\TwitterAds\Http\RequestInterface;
use Hborras\TwitterAdsSDK\TwitterAds\Http\ResponseInterface;
use Hborras\TwitterAdsSDK\TwitterAds\Http\Util;
use Hborras\TwitterAdsSDK\TwitterAds\Object\AbstractCrudObject;
use Hborras\TwitterAdsSDK\TwitterAds\Object\AbstractObject;
use InvalidArgumentException;
use Iterator;

class Cursor implements Iterator, Countable, arrayaccess
{
    /**
     * @var ResponseInterface
     */
    protected $response;

    /**
     * @var Api
     */
    protected $api;

    /**
     * @var AbstractObject[]
     */
    protected $objects = array();

    /**
     * @var int|null
     */
    protected $indexLeft;

    /**
     * @var int|null
     */
    protected $indexRight;

    /**
     * @var int|null
     */
    protected $position;

    /**
     * @var AbstractObject
     */
    protected $objectPrototype;

    /**
     * @var bool
     */
    protected static $defaultUseImplicitFetch = false;

    /**
     * @var bool
     */
    protected $useImplicitFetch;

    public function __construct(
        ResponseInterface $response,
        AbstractObject $object_prototype,
        Api $api = null)
    {
        $this->response = $response;
        $this->objectPrototype = $object_prototype;
        $this->api = $api !== null ? $api : Api::instance();
        $this->appendResponse($response);
    }

    /**
     * @param array $object_data
     * @return AbstractObject
     */
    protected function createObject(array $object_data)
    {
        $object = clone $this->objectPrototype;
        $object->setDataWithoutValidation($object_data);
        if ($object instanceof AbstractCrudObject) {
            $object->setApi($this->api);
        }
        return $object;
    }

    /**
     * @param ResponseInterface $response
     * @return array
     * @throws InvalidArgumentException
     */
    protected function assureResponseData(ResponseInterface $response)
    {
        $content = $response->getContent();

        // First, check if the content contains data
        if (isset($content['data']) && is_array($content['data'])) {
            $data = $content['data'];

            // If data is an object wrap the object into an array
            if ($this->isJsonObject($data)) {
                $data = array($data);
            }
            return $data;
        }
        throw new InvalidArgumentException("Malformed response data");
    }

    private function isJsonObject($object)
    {
        if (!is_array($object)) {
            return false;
        }

        // Consider an empty array as not object
        if (empty($object)) {
            return false;
        }

        // A json object is represented by a map instead of a pure list
        return array_keys($object) !== range(0, count($object) - 1);
    }

    /**
     * @param ResponseInterface $response
     */
    protected function prependResponse(ResponseInterface $response)
    {
        $this->response = $response;
        $data = $this->assureResponseData($response);
        if (empty($data)) {
            return;
        }

        $left_index = $this->indexLeft;
        $count = count($data);
        $position = $count - 1;
        for ($i = $left_index - 1; $i >= $left_index - $count; $i--) {
            $this->objects[$i] = $this->createObject($data[$position--]);
            --$this->indexLeft;
        }
    }

    /**
     * @param ResponseInterface $response
     */
    protected function appendResponse(ResponseInterface $response)
    {
        $this->response = $response;
        $data = $this->assureResponseData($response);
        if (empty($data)) {
            return;
        }

        if ($this->indexRight === null) {
            $this->indexLeft = 0;
            $this->indexRight = -1;
            $this->position = 0;
        }

        $this->indexRight += count($data);

        foreach ($data as $object_data) {
            $this->objects[] = $this->createObject($object_data);
        }
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
     * @param bool $use_implicit_fetch
     */
    public function setUseImplicitFetch($use_implicit_fetch)
    {
        $this->useImplicitFetch = $use_implicit_fetch;
    }

    /**
     * @return string|null
     */
    public function getNextCursor()
    {
        $content = $this->getLastResponse()->getContent();
        return isset($content['next_cursor'])
            ? $content['next_cursor']
            : null;
    }

    /**
     * @return RequestInterface
     */
    protected function createUndirectionalizedRequest()
    {
        return $this->getLastResponse()->getRequest()->createClone();
    }

    /**
     * @return string|null
     */
    public function getNext()
    {
        $nextCursor = $this->getNextCursor();
        if ($nextCursor !== null) {
            $request = $this->createUndirectionalizedRequest();
            $request->getQueryParams()->offsetSet('cursor', $nextCursor);
            return $request->getUrl();
        }

        return null;
    }

    /**
     * @param string $url
     * @return RequestInterface
     */
    protected function createRequestFromUrl($url)
    {
        $components = parse_url($url);
        $request = $this->getLastResponse()->getRequest()->createClone();
        $request->setDomain($components['host']);
        $query = isset($components['query'])
            ? Util::parseUrlQuery($components['query'])
            : array();
        $request->getQueryParams()->enhance($query);

        return $request;
    }

    /**
     * @return RequestInterface|null
     */
    public function createAfterRequest()
    {
        $url = $this->getNext();
        return $url !== null ? $this->createRequestFromUrl($url) : null;
    }

    public function fetchAfter()
    {
        $request = $this->createAfterRequest();
        if (!$request) {
            return;
        }

        $request->signRequest($this->api->getSession(), $request->getQueryParams()->getArrayCopy());
        $this->appendResponse($request->execute());
    }

    /**
     * @param bool $ksort
     * @return AbstractObject[]
     */
    public function getArrayCopy($ksort = false)
    {
        if ($ksort) {
            // Sort the main array to improve best case performance in future
            // invocations
            ksort($this->objects);
        }

        return $this->objects;
    }

    /**
     * @return ResponseInterface
     */
    public function getLastResponse()
    {
        return $this->response;
    }

    /**
     * @return int
     */
    public function getIndexLeft()
    {
        return $this->indexLeft;
    }

    /**
     * @return int
     */
    public function getIndexRight()
    {
        return $this->indexRight;
    }

    public function rewind()
    {
        $this->position = $this->indexLeft;
    }

    public function end()
    {
        $this->position = $this->indexRight;
    }

    /**
     * @param int $position
     */
    public function seekTo($position)
    {
        $position = array_key_exists($position, $this->objects) ? $position : null;
        $this->position = $position;
    }

    /**
     * @return AbstractObject|bool
     */
    public function current()
    {
        return isset($this->objects[$this->position])
            ? $this->objects[$this->position]
            : false;
    }

    /**
     * @return int
     */
    public function key()
    {
        return $this->position;
    }

    public function next()
    {
        if ($this->position == $this->getIndexRight()) {
            if ($this->getUseImplicitFetch()) {
                $this->fetchAfter();
                if ($this->position == $this->getIndexRight()) {
                    $this->position = null;
                } else {
                    ++$this->position;
                }
            } else {
                $this->position = null;
            }
        } else {
            ++$this->position;
        }
    }

    /**
     * @return bool
     */
    public function valid()
    {
        return isset($this->objects[$this->position]);
    }

    /**
     * @return int
     */
    public function count()
    {
        return count($this->objects);
    }

    /**
     * @param mixed $offset
     * @param mixed $value
     */
    public function offsetSet($offset, $value)
    {
        if ($offset === null) {
            $this->objects[] = $value;
        } else {
            $this->objects[$offset] = $value;
        }
    }

    /**
     * @param mixed $offset
     * @return bool
     */
    public function offsetExists($offset)
    {
        return isset($this->objects[$offset]);
    }

    /**
     * @param mixed $offset
     */
    public function offsetUnset($offset)
    {
        unset($this->objects[$offset]);
    }

    /**
     * @param mixed $offset
     * @return mixed
     */
    public function offsetGet($offset)
    {
        return isset($this->objects[$offset]) ? $this->objects[$offset] : null;
    }
}