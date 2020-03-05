<?php

namespace Hborras\TwitterAdsSDK\TwitterAds\Http;

use Hborras\TwitterAdsSDK\TwitterAds\Http\OAuth\OAuth;

interface RequestInterface {

  /**
   * @var string
   */
  const METHOD_DELETE = 'DELETE';

  /**
   * @var string
   */
  const METHOD_GET = 'GET';

  /**
   * @var string
   */
  const METHOD_POST = 'POST';

  /**
   * @var string
   */
  const METHOD_PUT = 'PUT';

  /**
   * @param Client $client
   */
  public function __construct(Client $client);

  /**
   * @return Client
   */
  public function getClient();

  /**
   * @return Headers
   */
  public function getHeaders();

  /**
   * @param Headers $headers
   */
  public function setHeaders(Headers $headers);

  /**
   * @return string
   */
  public function getProtocol();

  /**
   * @param string $protocol
   */
  public function setProtocol($protocol);

  /**
   * @return string
   */
  public function getDomain();

  /**
   * @param string $domain
   */
  public function setDomain($domain);

  /**
   * @param string $last_level_domain
   */
  public function setLastLevelDomain($last_level_domain);

  /**
   * @return string
   */
  public function getMethod();

  /**
   * @param string $method
   */
  public function setMethod($method);

  /**
   * @return string
   */
  public function getPath();

  /**
   * @param string $version
   */
  public function setVersion($version);

  /**
   * @return mixed
   */
  public function getVersion();

  /**
   * @param string $path
   */
  public function setPath($path);

  /**
   * @return Parameters
   */
  public function getQueryParams();

  /**
   * @param Parameters $params
   */
  public function setQueryParams(Parameters $params);

  /**
   * @return string
   */
  public function getUrl();

  /**
   * @return Parameters
   */
  public function getBodyParams();

  /**
   * @param Parameters $params
   */
  public function setBodyParams(Parameters $params);

  /**
   * @return Parameters
   */
  public function getFileParams();

  /**
   * @param Parameters $params
   */
  public function setFileParams(Parameters $params);

    /**
     * @return ResponseInterface
     */
    public function execute();

    /**
     * Required for Mocking request/response chaining
     * @return RequestInterface
     */
    public function createClone();

    /**
     * @return string
     */
    public function getSignatureBaseString();

    /**
     * @return string
     */
    public function getSignableParameters();

    /**
     * @return OAuth
     */
    public function getOAuth();
}
