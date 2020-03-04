<?php


namespace Hborras\TwitterAdsSDK\TwitterAds\Object;


use Hborras\TwitterAdsSDK\TwitterAds\ApiRequest;
use Hborras\TwitterAdsSDK\TwitterAds\Object\Fields\AccountFields;
use Hborras\TwitterAdsSDK\TwitterAds\Http\RequestInterface;
use Hborras\TwitterAdsSDK\TwitterAds\TypeChecker;

final class Account extends AbstractCrudObject
{

    public static function getFieldsEnum()
    {
        return AccountFields::getInstance();
    }

    public function getSelf($fields = [], $params = [], $pending = false)
    {
        $this->assureId();

        $paramTypes = [];
        $enums = [];

        $request = new ApiRequest(
            $this->api,
            $this->data['id'],
            RequestInterface::METHOD_GET,
            '/',
            new Account(),
            'NODE',
            Account::getFieldsEnum()->getValues(),
            new TypeChecker($paramTypes, $enums)
        );
        $request->addParams($params);
        $request->addFields($fields);
        return $pending ? $request : $request->execute();
    }
}