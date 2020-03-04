<?php

namespace Hborras\TwitterAdsSDK\TwitterAds\Enum;

use InvalidArgumentException;

interface EnumInstanceInterface {

  /**
   * @return EnumInstanceInterface
   */
  public static function getInstance();

  /**
   * @return array
   */
  public function getArrayCopy();

  /**
   * @return array
   */
  public function getNames();

  /**
   * @return array
   */
  public function getValues();

  /**
   * @return array
   */
  public function getValuesMap();

  /**
   * @param string|int|float $name
   * @return mixed
   */
  public function getValueForName($name);

  /**
   * @param string|int|float $name
   * @return mixed
   * @throws InvalidArgumentException
   */
  public function assureValueForName($name);

  /**
   * @param string|int|float $name
   * @return bool
   */
  public function isValid($name);

  /**
   * @param string|int|float $name
   * @return void
   * @throws InvalidArgumentException
   */
  public function assureIsValid($name);

  /**
   * @param mixed $value
   * @return bool
   */
  public function isValidValue($value);

  /**
   * @param mixed $value
   * @throws InvalidArgumentException
   */
  public function assureIsValidValue($value);
}
