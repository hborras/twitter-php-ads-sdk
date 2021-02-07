<?php

namespace Hborras\TwitterAdsSDK\Tests;

use Hborras\TwitterAdsSDK\Consumer;
use PHPUnit\Framework\TestCase;

class ConsumerTest extends TestCase
{
    public function testToString(): void
    {
        $key = uniqid('', true);
        $secret = uniqid('', true);
        $consumer = new Consumer($key, $secret);

        self::assertEquals("Consumer[key=$key,secret=$secret]", $consumer->__toString());
    }
}
