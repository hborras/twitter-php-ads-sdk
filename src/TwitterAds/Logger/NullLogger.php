<?php

namespace Hborras\TwitterAdsSDK\TwitterAds\Logger;


use Hborras\TwitterAdsSDK\TwitterAds\Http\RequestInterface;
use Hborras\TwitterAdsSDK\TwitterAds\Http\ResponseInterface;

class NullLogger implements LoggerInterface {

  /**
   * @param string $level
   * @param string $message
   * @param array $context
   */
  public function log($level, $message, array $context = array()) {

  }

  /**
   * @param string $level
   * @param RequestInterface $request
   * @param array $context
   */
  public function logRequest(
    $level, RequestInterface $request, array $context = array()) {

  }

  /**
   * @param string $level
   * @param ResponseInterface $response
   * @param array $context
   */
  public function logResponse(
    $level, ResponseInterface $response, array $context = array()) {

  }
}
