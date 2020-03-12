<?php


namespace Hborras\TwitterAdsSDK\TwitterAds\Object;


use Hborras\TwitterAdsSDK\TwitterAds\ApiRequest;
use Hborras\TwitterAdsSDK\TwitterAds\Object\Fields\AccountFields;
use Hborras\TwitterAdsSDK\TwitterAds\Http\RequestInterface;
use Hborras\TwitterAdsSDK\TwitterAds\TypeChecker;

final class AccountUser extends AbstractCrudObject
{

    public static function getFieldsEnum()
    {
        return AccountFields::getInstance();
    }

    public function getAdAccounts($params = [], $pending = false)
    {
        $paramTypes = [
            'account_ids' => 'list<string>',
            'count' => 'int',
            'funding_instrument_ids' => 'list<string>',
            'cursor' => 'string',
            'q' => 'string',
            'sort_by' => 'string',
            'with_deleted' => 'bool',
            'with_draft' => 'bool',
            'with_total_count' => 'bool'
        ];
        $enums = [];

        $request = new ApiRequest(
            $this->api,
            $this->data['id'],
            RequestInterface::METHOD_GET,
            '',
            new Account(),
            'EDGE',
            Account::getFieldsEnum()->getValues(),
            new TypeChecker($paramTypes, $enums)
        );
        $request->addParams($params);
        return $pending ? $request : $request->execute();
    }
}