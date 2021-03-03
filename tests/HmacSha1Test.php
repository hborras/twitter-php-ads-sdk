<?php

namespace Hborras\TwitterAdsSDK\Tests;

use Hborras\TwitterAdsSDK\HmacSha1;
use Hborras\TwitterAdsSDK\SignatureMethod;

class HmacSha1Test extends AbstractSignatureMethodTest
{
    protected $name = 'HMAC-SHA1';

    public function getClass(): SignatureMethod
    {
        return new HmacSha1();
    }

    public function signatureDataProvider(): array
    {
        return [
            [
                '5CoEcoq7XoKFjwYCieQvuzadeUA=',
                $this->getRequest(), $this->getConsumer(), $this->getToken()
            ],
            [
                'EBw0gHngam3BTx8kfPfNNSyKem4=',
                $this->getRequest(),
                $this->getConsumer('key', 'secret'),
                $this->getToken()
            ],
            [
                'kDsHFZzws2a5M6cAQjfpdNBo+v8=',
                $this->getRequest(),
                $this->getConsumer('key', 'secret'),
                $this->getToken('key', 'secret')
            ],
            [
                'EBw0gHngam3BTx8kfPfNNSyKem4=',
                $this->getRequest(), $this->getConsumer('key', 'secret'), null
            ],
        ];
    }
}
