<?php

namespace Hborras\TwitterAdsSDK\Tests;

use Closure;
use Hborras\TwitterAdsSDK\Util\JsonDecoder;
use PHPUnit\Framework\TestCase;
use stdClass;

class JsonDecoderTest extends TestCase
{
    /**
     * @dataProvider jsonProvider
     * @param $input
     * @param $asArray
     * @param $expected
     */
    public function testDecode($input, $asArray, $expected)
    {
        $this->assertEquals($expected, JsonDecoder::decode($input, $asArray));
    }

    public function jsonProvider()
    {
        return array(
            array('[]', true, array()),
            array('[1,2,3]', true, array(1, 2, 3)),
            array('[{"id": 556179961825226750}]', true, array(array('id' => 556179961825226750))),
            array('[]', false, array()),
            array('[1,2,3]', false, array(1, 2, 3)),
            array(
                '[{"id": 556179961825226750}]',
                false,
                array(
                    $this->getClass(function ($object) {
                        $object->id = 556179961825226750;
                        return $object;
                    })
                )
            ),

        );
    }

    /**
     * @param Closure $callable $callable
     *
     * @return stdClass
     */
    private function getClass(Closure $callable)
    {
        $object = new stdClass();

        return $callable($object);
    }
}
