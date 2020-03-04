<?php

namespace Hborras\TwitterAdsSDK\TwitterAds\Http\Adapter;

use Hborras\TwitterAdsSDK\TwitterAds\Http\Client;
use Hborras\TwitterAdsSDK\TwitterAds\Http\RequestInterface;
use Hborras\TwitterAdsSDK\TwitterAds\Http\ResponseInterface;

interface AdapterInterface {

  /**
   * @param Client $client
   */
  public function __construct(Client $client);

  /**
   * @return Client
   */
  public function getClient();

  /**
   * @return string
   */
  public function getCaBundlePath();

  /**
   * @return \ArrayObject
   */
  public function getOpts();

  /**
   * @param \ArrayObject $opts
   * @return void
   */
  public function setOpts(\ArrayObject $opts);

  /**
   * @param RequestInterface $request
   * @return ResponseInterface
   */
  public function sendRequest(RequestInterface $request);
}
