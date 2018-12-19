<?php

namespace Hborras\TwitterAdsSDK\TwitterAds;

use Hborras\TwitterAdsSDK\TwitterAds\Errors\BatchLimitExceeded;

class Batch extends Analytics
{
    const RESOURCE_BATCH = '';

    const OPERATION_TYPE = 'operation_type';
    const OPERATION_TYPE_CREATE = 'Create';
    const OPERATION_TYPE_UPDATE = 'Update';
    const OPERATION_TYPE_DELETE = 'Delete';

    const PARAMS = 'params';
    const ENTITY_TYPE = '';
    const BATCH_SIZE = 0;

    /** @var Resource[] */
    protected $batch = [];

    /**
     * @return mixed
     */
    public function saveBatch()
    {
        $body = [];

        /** @var Resource $item */
        foreach ($this->batch as $item) {
            $itemJson = [];
            $itemJson[self::PARAMS] = $item->toParams();

            if(!$item->getId()){
                $itemJson[self::OPERATION_TYPE] = self::OPERATION_TYPE_CREATE;
            } else if($item->getToDelete()){
                $itemJson[self::OPERATION_TYPE] = self::OPERATION_TYPE_DELETE;
            } else {
                $itemJson[self::OPERATION_TYPE] = self::OPERATION_TYPE_UPDATE;
                $itemJson[self::PARAMS][static::ENTITY_TYPE.'_id'] = $item->getId();
            }

            $body[] = $itemJson;
        }
        $resource = str_replace(static::RESOURCE_REPLACE, $this->getTwitterAds()->getAccountId(), static::RESOURCE_BATCH);
        $headers = [
            'Content-Type: application/json'
        ];
        $params = ['batch' => json_encode($body)];
        $response = $this->getTwitterAds()->post($resource, $params, $headers);

        return $this->fromBatchResponse($response->getBody()->data);
    }

    public function addBatch(Resource $data)
    {
        $this->assureBatchSize();

        $this->batch[] = $data;
    }

    /**
     * Assures the batch is not over the batch size limit.
     *
     * @param $batch |null
     *
     * @return array $batch|$this->batch
     */
    public function assureBatchSize($batch = null)
    {
        if (count($batch ?: $this->batch) < static::BATCH_SIZE) {
            return $batch ?: $this->batch;
        }

        throw new BatchLimitExceeded(sprintf(
            'Cannot add data to batch. Max size is %s',
            static::BATCH_SIZE
        ));
    }
}
