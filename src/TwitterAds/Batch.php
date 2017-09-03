<?php

namespace Hborras\TwitterAdsSDK\TwitterAds;

use Hborras\TwitterAdsSDK\TwitterAds;
use Hborras\TwitterAdsSDK\TwitterAds\Resource;
use Hborras\TwitterAdsSDK\TwitterAds\Account;
use Hborras\TwitterAdsSDK\Arrayable;
use Hborras\TwitterAdsSDK\TwitterAds\Errors\BatchLimitExceeded;

abstract class Batch extends Resource
{
    private $batch = [];
    private $batchSize;
    private $account;

    public function __construct(TwitterAds $twitterAds = null, $batchSize = 10, $batch = [])
    {
        parent::__construct('', $twitterAds);
        $this->batchSize = $batchSize;
        $this->batch = $this->assureBatchSize($batch);
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        //Always use POST request by setting the ID to null
        return null;
    }

    public function getAccount()
    {
        return $this->account;
    }

    /**
     * {@inheritdoc}
     */
    public function toParams()
    {
        $data = [];

        foreach ($this->batch as $member) {
            $data[] = $member->toArray();
        }

        return json_encode($data);
    }

    public function getBatch()
    {
        return $this->batch;
    }

    public function add(Arrayable $data)
    {
        $this->assureBatchSize();

        $this->batch[] = $data;
    }

    /**
     * Assures the batch is not over the batch size limit.
     *
     * @param $batch |null
     *
     * @throws BatchLimitExceeded when the batch is full
     * @return $batch|$this->batch
     */
    public function assureBatchSize($batch = null)
    {
        if (count($batch ?: $this->batch) < $this->batchSize) {
            return $batch ?: $this->batch;
        }

        throw new BatchLimitExceeded(sprintf(
            'Cannot add data to batch. Max size is %s',
            $this->batchSize
        ));
    }
}
