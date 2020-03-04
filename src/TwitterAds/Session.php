<?php

namespace Hborras\TwitterAdsSDK\TwitterAds;

class Session implements SessionInterface {

  /**
   * @var Consumer
   */
  protected $consumer;

  /**
   * @var Token
   */
  protected $token;

    /**
     * Session constructor.
     * @param Consumer $consumer
     * @param Token $token
     */
    public function __construct(Consumer $consumer, Token $token)
    {
        $this->consumer = $consumer;
        $this->token = $token;
    }

    /**
     * @return Consumer
     */
    public function consumer(): Consumer
    {
        return $this->consumer;
    }

    /**
     * @return Token
     */
    public function token(): Token
    {
        return $this->token;
    }

  /**
   * @return array
   */
  public function getRequestParameters() {
    return [];
  }
}
