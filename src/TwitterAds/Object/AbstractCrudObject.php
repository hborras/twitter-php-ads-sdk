<?php

namespace Hborras\TwitterAdsSDK\TwitterAds\Object;

use Exception;
use Hborras\TwitterAdsSDK\TwitterAds\Api;
use Hborras\TwitterAdsSDK\TwitterAds\CursorBack;
use Hborras\TwitterAdsSDK\TwitterAds\Http\RequestInterface;
use Hborras\TwitterAdsSDK\TwitterAds\Http\ResponseInterface;
use InvalidArgumentException;

class AbstractCrudObject extends AbstractObject
{
    /**
     * @var string
     */
    const FIELD_ID = 'id';
    /**
     * @var string[] set of fields to read by default
     */
    protected static $defaultReadFields = array();
    /**
     * @var array set of fields that have been mutated
     */
    protected $changedFields = array();
    /**
     * @var Api instance of the Api used by this object
     */
    protected $api;
    /**
     * @var string ID of the adaccount this object belongs to
     */
    protected $parentId;

    /**
     * @param string $id Optional (do not set for new objects)
     * @param string $parent_id Optional, needed for creating new objects.
     * @param Api $api The Api instance this object should use to make calls
     * @deprecated deprecate constructor with null and parent_id
     */
    public function __construct($id = null, Api $api = null)
    {
        parent::__construct();

        // check that $id is an integer or a string integer or a string of
        // two integer connected by an underscore, like "123_456"
        $this->data[static::FIELD_ID] = $id;

        $this->api = static::assureApi($api);
    }

    /**
     * @param string $id
     * @return AbstractCrudObject
     */
    public function setId($id)
    {
        $this->data[static::FIELD_ID] = $id;
        return $this;
    }

    /**
     * @param Api $api The Api instance this object should use to make calls
     * @return AbstractCrudObject
     */
    public function setApi(Api $api)
    {
        $this->api = static::assureApi($api);
        return $this;
    }

    /**
     * @return string
     * @deprecated getEndpoint function is deprecated
     */
    protected function getEndpoint()
    {
        return null;
    }

    /**
     * @param Api|null $instance
     * @return Api
     * @throws InvalidArgumentException
     */
    protected static function assureApi(Api $instance = null)
    {
        $instance = $instance ?: Api::instance();
        if (!$instance) {
            throw new InvalidArgumentException(
                'An Api instance must be provided as argument or ' .
                'set as instance in the \FacebookAds\Api');
        }
        return $instance;
    }

    /**
     * @return string|null
     * @deprecated deprecate parent_id in AbstractCrudObject
     */
    public function getParentId()
    {
        $warning_message = sprintf('%s is being deprecated, please try not to use' .
            ' this in new code.', __FUNCTION__);
        trigger_error($warning_message, E_USER_DEPRECATED);
        return $this->parentId;
    }

    /**
     * @return string
     * @throws Exception
     */
    protected function assureId()
    {
        if (!$this->data[static::FIELD_ID]) {
            throw new Exception("field '" . static::FIELD_ID . "' is required.");
        }
        return (string)$this->data[static::FIELD_ID];
    }

    /**
     * @return Api
     */
    public function getApi()
    {
        return $this->api;
    }

    /**
     * Get the values which have changed
     *
     * @return array Key value pairs of changed variables
     */
    public function getChangedValues()
    {
        return $this->changedFields;
    }

    /**
     * Get the name of the fields that have changed
     *
     * @return array Array of changed field names
     */
    public function getChangedFields()
    {
        return array_keys($this->changedFields);
    }

    /**
     * Get the values which have changed, converting them to scalars
     */
    public function exportData()
    {
        $data = array();
        foreach ($this->changedFields as $key => $val) {
            $data[$key] = parent::exportValue($val);
        }
        return $data;
    }

    /**
     * @return void
     */
    protected function clearHistory()
    {
        $this->changedFields = array();
    }

    /**
     * @param string $name
     * @param mixed $value
     */
    public function __set($name, $value)
    {
        if (!array_key_exists($name, $this->data)
            || $this->data[$name] !== $value) {
            $this->changedFields[$name] = $value;
        }
        parent::__set($name, $value);
    }

    /**
     * @param string[] $fields
     */
    public static function setDefaultReadFields(array $fields = array())
    {
        static::$defaultReadFields = $fields;
    }

    /**
     * @return string[]
     */
    public static function getDefaultReadFields()
    {
        return static::$defaultReadFields;
    }

    /**
     * @return string
     * @throws Exception
     */
    protected function getNodePath()
    {
        return '/' . $this->assureId();
    }

    /**
     * @param array $fields
     * @param array $params
     * @param string $prototype_class
     * @param string|null $endpoint
     * @return ResponseInterface
     * @throws Exception
     */
    protected function fetchConnection(
        array $fields = array(),
        array $params = array(),
        $prototype_class,
        $endpoint = null)
    {
        $fields = implode(',', $fields ?: static::getDefaultReadFields());
        if ($fields) {
            $params['fields'] = $fields;
        }
        $endpoint = $this->assureEndpoint($prototype_class, $endpoint);
        return $this->getApi()->call(
            '/' . $this->assureId() . '/' . $endpoint,
            RequestInterface::METHOD_GET,
            $params);
    }

    /**
     * Read a single connection object
     *
     * @param string $prototype_class
     * @param array $fields Fields to request
     * @param array $params Additional filters for the reading
     * @param string|null $endpoint
     * @return AbstractObject
     * @throws Exception
     */
    protected function getOneByConnection(
        $prototype_class,
        array $fields = array(),
        array $params = array(),
        $endpoint = null)
    {
        $response = $this->fetchConnection(
            $fields, $params, $prototype_class, $endpoint);
        if (!$response->getContent()) {
            return null;
        }
        $object = new $prototype_class(
            null, null, $this->getApi());
        /** @var AbstractCrudObject $object */
        $object->setDataWithoutValidation($response->getContent());
        return $object;
    }

    /**
     * Read objects from a connection
     *
     * @param string $prototype_class
     * @param array $fields Fields to request
     * @param array $params Additional filters for the reading
     * @param string|null $endpoint
     * @return CursorBack
     * @throws Exception
     */
    protected function getManyByConnection(
        $prototype_class,
        array $fields = array(),
        array $params = array(),
        $endpoint = null)
    {
        $response = $this->fetchConnection(
            $fields, $params, $prototype_class, $endpoint);
        return new CursorBack(
            $response,
            new $prototype_class(null, null, $this->getApi()));
    }

    /**
     * @param string $job_class
     * @param array $fields
     * @param array $params
     * @return AbstractAsyncJobObject
     * @throws InvalidArgumentException
     * @throws Exception
     */
    protected function createAsyncJob(
        $job_class,
        array $fields = array(),
        array $params = array())
    {
        $object = new $job_class(null, $this->assureId(), $this->getApi());
        if (!$object instanceof AbstractAsyncJobObject) {
            throw new \InvalidArgumentException(
                "Class {$job_class} is not of type "
                . AbstractAsyncJobObject::className());
        }
        $params['fields'] = $fields;
        return $object->create($params);
    }

    /**
     * Delete objects.
     *
     * Used batch API calls to delete multiple objects at once
     *
     * @param string[] $ids Array or single Object ID to delete
     * @param Api $api Api Object to use
     * @return bool Returns true on success
     */
    public static function deleteIds(array $ids, Api $api = null)
    {
        $batch = array();
        foreach ($ids as $id) {
            $request = array(
                'relative_url' => '/' . $id,
                'method' => RequestInterface::METHOD_DELETE,
            );
            $batch[] = $request;
        }
        $api = static::assureApi($api);
        $response = $api->call(
            '/',
            RequestInterface::METHOD_POST,
            array('batch' => json_encode($batch)));
        foreach ($response->getContent() as $result) {
            if (200 != $result['code']) {
                return false;
            }
        }
        return true;
    }

    /**
     * Read function for the object. Convert fields and filters into the query
     * part of uri and return objects.
     *
     * @param mixed $ids Array or single object IDs
     * @param array $fields Array of field names to read
     * @param array $params Additional filters for the reading, in assoc
     * @param Api $api Api Object to use
     * @return CursorBack
     */
    public static function readIds(
        array $ids,
        array $fields = array(),
        array $params = array(),
        Api $api = null)
    {
        if (empty($fields)) {
            $fields = static::getDefaultReadFields();
        }
        if (!empty($fields)) {
            $params['fields'] = implode(',', $fields);
        }
        $params['ids'] = implode(',', $ids);
        $api = static::assureApi($api);
        $response = $api->call('/', RequestInterface::METHOD_GET, $params);
        $result = array();
        foreach ($response->getContent() as $data) {
            /** @var AbstractObject $object */
            $object = new static(null, null, $api);
            $object->setDataWithoutValidation((array)$data);
            $result[] = $object;
        }
        return $result;
    }
}
