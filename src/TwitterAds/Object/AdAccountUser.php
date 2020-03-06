<?php


namespace Hborras\TwitterAdsSDK\TwitterAds\Object;


use Hborras\TwitterAdsSDK\TwitterAds\ApiRequest;
use Hborras\TwitterAdsSDK\TwitterAds\Object\Fields\AdAccountFields;
use Hborras\TwitterAdsSDK\TwitterAds\Http\RequestInterface;
use Hborras\TwitterAdsSDK\TwitterAds\TypeChecker;

final class AdAccountUser extends AbstractCrudObject
{

    public static function getFieldsEnum()
    {
        return AdAccountFields::getInstance();
    }

    public function getAdAccounts($params = [], $pending = false)
    {
        $paramTypes = [];
        $enums = [];

        $request = new ApiRequest(
            $this->api,
            $this->data['id'],
            RequestInterface::METHOD_GET,
            '',
            new AdAccount(),
            'EDGE',
            AdAccount::getFieldsEnum()->getValues(),
            new TypeChecker($paramTypes, $enums)
        );
        $request->addParams($params);
        return $pending ? $request : $request->execute();
    }
}