<?php

namespace Hborras\TwitterAdsSDK\TwitterAds\Http\Adapter\Curl;

interface CurlInterface {

  /**
   * @return resource
   */
  public function getHandle();

  /**
   * @return int
   */
  public function errno();

  /**
   * @return string
   */
  public function error();

  /**
   * @param string $string
   * @return bool|string
   */
  public function escape($string);

  /**
   * @return mixed
   */
  public function exec();

  /**
   * @param int $opt
   * @return mixed
   */
  public function getInfo($opt = 0);

  /**
   * @return void
   */
  public function init();

  /**
   * @param int $bitmask
   * @return int
   */
  public function pause($bitmask);

  /**
   * @param $filepath
   * @return string|\CurlFile
   */
  public function preparePostFileField($filepath);

  /**
   * @return void
   */
  public function reset();

  /**
   * @param array $opts
   */
  public function setoptArray(array $opts);

  /**
   * @param int $option
   * @param mixed $value
   * @return bool
   */
  public function setopt($option, $value);

  /**
   * @param $string
   * @return string
   */
  public function unescape($string);

  /**
   * @param int $age
   * @return array
   */
  public static function version($age);
}
