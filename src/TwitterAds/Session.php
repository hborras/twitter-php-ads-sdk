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

  /** @var string  */
  protected $accountId;

    /**
     * Session constructor.
     * @param Consumer $consumer
     * @param Token $token
     * @param string $accountId
     */
    public function __construct(Consumer $consumer, Token $token, string $accountId = '')
    {
        $this->consumer = $consumer;
        $this->token = $token;
        $this->accountId = $accountId;
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
     * @return string
     */
    public function getAccountId(): string
    {
        return $this->accountId;
    }

    /**
     * @param string $accountId
     */
    public function setAccountId(string $accountId)
    {
        $this->accountId = $accountId;
    }

  /**
   * @return array
   */
  public function getRequestParameters() {
    return [];
  }
}
