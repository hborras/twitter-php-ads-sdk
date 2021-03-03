<?php

namespace Hborras\TwitterAdsSDK\Tests;

use Hborras\TwitterAdsSDK\SignatureMethod;
use PHPUnit\Framework\TestCase;
use Hborras\TwitterAdsSDK\Consumer;
use Hborras\TwitterAdsSDK\Token;
use Hborras\TwitterAdsSDK\Request;

abstract class AbstractSignatureMethodTest extends TestCase
{
    protected $name;

    abstract public function getClass(): SignatureMethod;

    abstract protected function signatureDataProvider();

    public function testGetName(): void
    {
        self::assertEquals($this->name, $this->getClass()->getName());
    }

    /**
     * @dataProvider signatureDataProvider
     * @param $expected
     * @param $request
     * @param $consumer
     * @param $token
     */
    public function testBuildSignature($expected, $request, $consumer, $token): void
    {
        self::assertEquals($expected, $this->getClass()->buildSignature($request, $consumer, $token));
    }

    protected function getRequest()
    {
        return $this->getMockBuilder(Request::class)
            ->disableOriginalConstructor()
            ->getMock();
    }

    protected function getConsumer($key = null, $secret = null, $callbackUrl = null)
    {
        return $this->getMockBuilder(Consumer::class)
            ->setConstructorArgs(array($key, $secret, $callbackUrl))
            ->getMock();
    }

    protected function getToken($key = null, $secret = null)
    {
        return $this->getMockBuilder(Token::class)
            ->setConstructorArgs(array($key, $secret))
            ->getMock();
    }
}
