<?php


namespace Hborras\TwitterAdsSDK\TwitterAds\Object;


use Hborras\TwitterAdsSDK\TwitterAds\ApiRequest;
use Hborras\TwitterAdsSDK\TwitterAds\Object\Fields\AdAccountFields;
use Hborras\TwitterAdsSDK\TwitterAds\Http\RequestInterface;
use Hborras\TwitterAdsSDK\TwitterAds\TypeChecker;

final class AdAccount extends AbstractCrudObject
{

    public static function getFieldsEnum()
    {
        return AdAccountFields::getInstance();
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
            '/',
            new AdAccount(),
            'NODE',
            AdAccount::getFieldsEnum()->getValues(),
            new TypeChecker($paramTypes, $enums)
        );
        $request->addParams($params);
        return $pending ? $request : $request->execute();
    }
}