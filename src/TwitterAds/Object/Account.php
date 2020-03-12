<?php


namespace Hborras\TwitterAdsSDK\TwitterAds\Object;


use Hborras\TwitterAdsSDK\TwitterAds\ApiRequest;
use Hborras\TwitterAdsSDK\TwitterAds\Http\RequestInterface;
use Hborras\TwitterAdsSDK\TwitterAds\Object\Fields\AccountFields;
use Hborras\TwitterAdsSDK\TwitterAds\Object\Fields\StatsFields;
use Hborras\TwitterAdsSDK\TwitterAds\Object\Values\EntityValues;
use Hborras\TwitterAdsSDK\TwitterAds\Object\Values\PlacementValues;
use Hborras\TwitterAdsSDK\TwitterAds\Object\Values\StatsGranularityValues;
use Hborras\TwitterAdsSDK\TwitterAds\Object\Values\StatsMetricGroupsValues;
use Hborras\TwitterAdsSDK\TwitterAds\TypeChecker;

final class Account extends AbstractCrudObject
{

    public static function getFieldsEnum()
    {
        return AccountFields::getInstance();
    }

    public function getSelf($params = [], $pending = false)
    {
        $this->assureId();

        $paramTypes = [];
        $enums = [];

        $this->api->updateAccountId($this->data['id']);

        $request = new ApiRequest(
            $this->api,
            $this->data['id'],
            RequestInterface::METHOD_GET,
            '',
            new Account(),
            'NODE',
            Account::getFieldsEnum()->getValues(),
            new TypeChecker($paramTypes, $enums)
        );
        $request->addParams($params);
        return $pending ? $request : $request->execute();
    }

    public function getCampaigns($params = [], $pending = false)
    {
        $this->assureId();

        $paramsTypes = [
            'campaign_ids' => 'list<string>',
            'count' => 'int',
            'funding_instrument_ids' => 'list<string>',
            'q' => 'string',
            'sort_by' => 'string',
            'with_deleted' => 'bool',
            'with_draft' => 'bool',
            'with_total_count' => 'bool'
        ];
        $enums = [];

        $request = new ApiRequest(
            $this->api,
            '',
            RequestInterface::METHOD_GET,
            '/campaigns',
            new Campaign(),
            'EDGE',
            Campaign::getFieldsEnum()->getValues(),
            new TypeChecker($paramsTypes, $enums)
        );
        $request->addParams($params);
        return $pending ? $request : $request->execute();
    }

    public function getStats($params = [], $pending = false)
    {
        $this->assureId();

        $paramsTypes = [
            'start_time' => 'datetime',
            'end_time' => 'datetime',
            'granularity' => 'granularity',
            'metric_groups' => 'list<metric_groups>',
            'placement' => 'placement',
            'entity' => 'entity',
        ];

        $enums = [
            'entity' => EntityValues::getInstance()->getValues(),
            'granularity' => StatsGranularityValues::getInstance()->getValues(),
            'metric_groups' => StatsMetricGroupsValues::getInstance()->getValues(),
            'placement' => PlacementValues::getInstance()->getValues()
        ];

        $params[StatsFields::ENTITY] = EntityValues::ACCOUNT;

        $request = new ApiRequest(
            $this->api,
            '',
            RequestInterface::METHOD_GET,
            '/stats',
            new Stats(),
            'EDGE',
            Stats::getFieldsEnum()->getValues(),
            new TypeChecker($paramsTypes, $enums)
        );
        $request->addParams($params);
        return $pending ? $request : $request->execute();
    }
}