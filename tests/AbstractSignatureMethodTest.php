<?php

namespace Hborras\TwitterAdsSDK\Tests;

use Hborras\TwitterAdsSDK\SignatureMethod;
use PHPUnit\Framework\TestCase;

abstract class AbstractSignatureMethodTest extends TestCase
{
    protected $name;

    /**
     * @return SignatureMethod
     */
    abstract public function getClass();

    abstract protected function signatureDataProvider();

    public function testGetName()
    {
        $this->assertEquals($this->name, $this->getClass()->getName());
    }

    /**
     * @dataProvider signatureDataProvider
     * @param $expected
     * @param $request
     * @param $consumer
     * @param $token
     */
    public function testBuildSignature($expected, $request, $consumer, $token)
    {
        $this->assertEquals($expected, $this->getClass()->buildSignature($request, $consumer, $token));
    }

    protected function getRequest()
    {
        return $this->getMockBuilder('Hborras\TwitterAdsSDK\Request')
            ->disableOriginalConstructor()
            ->getMock();
    }

    protected function getConsumer($key = null, $secret = null, $callbackUrl = null)
    {
        return $this->getMockBuilder('Hborras\TwitterAdsSDK\Consumer')
            ->setConstructorArgs(array($key, $secret, $callbackUrl))
            ->getMock();
    }

    protected function getToken($key = null, $secret = null)
    {
        return $this->getMockBuilder('Hborras\TwitterAdsSDK\Token')
            ->setConstructorArgs(array($key, $secret))
            ->getMock();
    }
}
