<?php


namespace Hborras\TwitterAdsSDK\TwitterAds\Object;


use Hborras\TwitterAdsSDK\TwitterAds\ApiRequest;
use Hborras\TwitterAdsSDK\TwitterAds\Object\Fields\AccountFields;
use Hborras\TwitterAdsSDK\TwitterAds\Http\RequestInterface;
use Hborras\TwitterAdsSDK\TwitterAds\Object\Fields\CampaignFields;
use Hborras\TwitterAdsSDK\TwitterAds\TypeChecker;

final class Campaign extends AbstractCrudObject
{

    public static function getFieldsEnum()
    {
        return CampaignFields::getInstance();
    }

    public function getSelf($params = [], $pending = false)
    {
        $this->assureId();

        $paramTypes = [];
        $enums = [];

        $request = new ApiRequest(
            $this->api,
            $this->data['id'],
            RequestInterface::METHOD_GET,
            '/campaigns/',
            new Campaign(),
            'NODE',
            Campaign::getFieldsEnum()->getValues(),
            new TypeChecker($paramTypes, $enums)
        );
        $request->addParams($params);
        return $pending ? $request : $request->execute();
    }

    public function updateSelf($params = [], $pending = false)
    {
        $this->assureId();

        $paramTypes = [
            'name'  => 'string',
            'standard_delivery' => 'bool',
            'daily_budget_amount_local_micro' => 'int'
        ];
        $enums = [];

        $request = new ApiRequest(
            $this->api,
            $this->data['id'],
            RequestInterface::METHOD_PUT,
            '/campaigns/',
            new Campaign(),
            'NODE',
            Campaign::getFieldsEnum()->getValues(),
            new TypeChecker($paramTypes, $enums)
        );
        $request->addParams($params);
        return $pending ? $request : $request->execute();
    }
}