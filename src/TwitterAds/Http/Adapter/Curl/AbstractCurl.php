<?php

namespace Hborras\TwitterAdsSDK\TwitterAds\Http\Adapter\Curl;

abstract class AbstractCurl implements CurlInterface {

  /**
   * @var resource
   */
  protected $handle;

  /**
   * @throws \RuntimeException
   */
  public function __construct() {
    if (!extension_loaded('curl')) {
      throw new \RuntimeException("Extension curl not loaded");
    }
  }

  public function __clone() {
    $this->handle = curl_copy_handle($this->handle);
  }

  public function __destruct() {
    if (is_resource($this->handle)) {
      curl_close($this->handle);
    }
  }

  /**
   * @return resource
   */
  public function getHandle() {
    return $this->handle;
  }

  /**
   * @return int
   */
  public function errno() {
    return curl_errno($this->handle);
  }

  /**
   * @return string
   */
  public function error() {
    return curl_error($this->handle);
  }

  /**
   * @return mixed
   */
  public function exec() {
    return curl_exec($this->handle);
  }

  /**
   * @param int $opt
   * @return mixed
   */
  public function getInfo($opt = 0) {
    return curl_getinfo($this->handle, $opt);
  }

  /**
   * @return void
   */
  public function init() {
    $this->handle = $this->handle ?: curl_init();
  }

  /**
   * @param array $opts
   */
  public function setoptArray(array $opts) {
    curl_setopt_array($this->handle, $opts);
  }

  /**
   * @param int $option
   * @param mixed $value
   * @return bool
   */
  public function setopt($option, $value) {
    return curl_setopt($this->handle, $option, $value);
  }

  /**
   * @param int $age
   * @return array
   */
  public static function version($age) {
    return curl_version($age);
  }
}
