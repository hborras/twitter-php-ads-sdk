<?php

namespace Hborras\TwitterAds\Tests;

use Hborras\TwitterAds\SignatureMethod;

abstract class AbstractSignatureMethodTest extends \PHPUnit_Framework_TestCase
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
     */
    public function testBuildSignature($expected, $request, $consumer, $token)
    {
        $this->assertEquals($expected, $this->getClass()->buildSignature($request, $consumer, $token));
    }

    protected function getRequest()
    {
        return $this->getMockBuilder('Hborras\TwitterAds\Request')
            ->disableOriginalConstructor()
            ->getMock();
    }

    protected function getConsumer($key = null, $secret = null, $callbackUrl = null)
    {
        return $this->getMockBuilder('Hborras\TwitterAds\Consumer')
            ->setConstructorArgs(array($key, $secret, $callbackUrl))
            ->getMock();
    }

    protected function getToken($key = null, $secret = null)
    {
        return $this->getMockBuilder('Hborras\TwitterAds\Token')
            ->setConstructorArgs(array($key, $secret))
            ->getMock();
    }
}
