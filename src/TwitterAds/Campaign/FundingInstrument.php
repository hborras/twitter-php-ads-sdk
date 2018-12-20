<?php

namespace Hborras\TwitterAdsSDK\TwitterAds\Campaign;

use Hborras\TwitterAdsSDK\TwitterAds\Analytics;
use Hborras\TwitterAdsSDK\TwitterAds\Fields\AnalyticsFields;


class FundingInstrument extends Analytics
{
    const RESOURCE_COLLECTION = 'accounts/{account_id}/funding_instruments';
    const RESOURCE            = 'accounts/{account_id}/funding_instruments/{id}';

    const ENTITY = 'FUNDING_INSTRUMENT';

    protected $id;
    protected $name;
    protected $cancelled;
    protected $credit_limit_local_micro;
    protected $currency;
    protected $description;
    protected $funded_amount_local_micro;
    protected $type;
    protected $created_at;
    protected $updated_at;
    protected $start_time;
    protected $end_time;
    protected $entity_status;
    protected $reasons_not_able_to_fund;
    protected $io_header;
    protected $able_to_fund;
    protected $credit_remaining_local_micro;
    protected $account_id;
    protected $deleted;

    /**
     * @param $metricGroups
     * @param array $params
     * @param bool $async
     * @return mixed
     */
    public function stats($metricGroups, $params = [], $async = false)
    {
        $params[AnalyticsFields::ENTITY] = AnalyticsFields::FUNDING_INSTRUMENT;
        return parent::stats($metricGroups, $params, $async);
    }


    /**
     * @return FundingInstrument
     */
    public function read()
    {
        $resource = str_replace(static::RESOURCE_REPLACE, $this->getTwitterAds()->getAccountId(), static::RESOURCE);
        $response = $this->getTwitterAds()->get($resource, []);

        return $this->fromResponse($response->getBody()->data);
    }

    /**
     * @param $response
     * @return array|FundingInstrument
     */
    public static function fromResponse($response)
    {
        if(is_array($response)){
            $fundingInstruments = [];
            foreach ($response as $item) {
                $fundingInstruments[] = self::createFromData($item);
            }
            return $fundingInstruments;
        } else {
            return self::createFromData($response);
        }
    }

    /**
     * @param $data
     * @return FundingInstrument
     */
    public static function createFromData($data)
    {
        $fundingInstrument = new FundingInstrument($data->id);
        $fundingInstrument->start_time = $data->start_time;
        $fundingInstrument->description = $data->description;
        $fundingInstrument->credit_limit_local_micro = $data->credit_limit_local_micro;
        $fundingInstrument->start_time = $data->start_time;
        $fundingInstrument->end_time = $data->end_time;
        $fundingInstrument->entity_status = $data->entity_status;
        $fundingInstrument->account_id = $data->account_id;
        $fundingInstrument->reasons_not_able_to_fund = $data->reasons_not_able_to_fund;
        $fundingInstrument->io_header = $data->io_header;
        $fundingInstrument->currency = $data->currency;
        $fundingInstrument->funded_amount_local_micro = $data->funded_amount_local_micro;
        $fundingInstrument->created_at = $data->created_at;
        $fundingInstrument->type = $data->type;
        $fundingInstrument->able_to_fund = $data->able_to_fund;
        $fundingInstrument->updated_at = $data->updated_at;
        $fundingInstrument->credit_remaining_local_micro = $data->credit_remaining_local_micro;
        $fundingInstrument->deleted = $data->deleted;

        return $fundingInstrument;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return mixed
     */
    public function getCancelled()
    {
        return $this->cancelled;
    }

    /**
     * @return mixed
     */
    public function getCreditLimitLocalMicro()
    {
        return $this->credit_limit_local_micro;
    }

    /**
     * @return mixed
     */
    public function getCurrency()
    {
        return $this->currency;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @return mixed
     */
    public function getFundedAmountLocalMicro()
    {
        return $this->funded_amount_local_micro;
    }

    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @return mixed
     */
    public function getCreatedAt()
    {
        return $this->created_at;
    }

    /**
     * @return mixed
     */
    public function getUpdatedAt()
    {
        return $this->updated_at;
    }

    /**
     * @return mixed
     */
    public function getDeleted()
    {
        return $this->deleted;
    }
}
