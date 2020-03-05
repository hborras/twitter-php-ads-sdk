<?php

namespace Hborras\TwitterAdsSDK\TwitterAds\Http\OAuth;

use Hborras\TwitterAdsSDK\TwitterAds\Http\Headers;
use Hborras\TwitterAdsSDK\TwitterAds\Http\OAuth\Signature\SignatureMethod;
use Hborras\TwitterAdsSDK\TwitterAds\Http\RequestInterface;
use Hborras\TwitterAdsSDK\TwitterAds\Http\Util;
use Hborras\TwitterAdsSDK\TwitterAds\SessionInterface;

class OAuth
{
    const VERSION = '1.0';

    /** @var string */
    private $nonce;

    /** @var int */
    private $timestamp;

    /** @var string */
    private $consumerKey;

    /** @var SignatureMethod */
    private $signatureMethod;

    /** @var string */
    private $bodyHash;

    /** @var string */
    private $token;

    /** @var string */
    private $signature;

    /**
     * OAuth constructor.
     * @param string $consumerKey
     * @param SignatureMethod $signatureMethod
     * @param null|string $token
     */
    public function __construct($consumerKey, $signatureMethod, $token = null)
    {
        $this->nonce = $this->generateNonce();
        $this->timestamp = time();
        $this->consumerKey = $consumerKey;
        $this->signatureMethod = $signatureMethod;

        if($token !== null){
            $this->token = $token;
        }
    }

    private function generateNonce()
    {
        return md5(microtime() . mt_rand());
    }

    public function buildSignature(RequestInterface $request, SessionInterface $session, array $params)
    {
        $this->signature = $this->signatureMethod->buildSignature($request, $params, $session->consumer(), $session->token());
    }

    public function toArray()
    {
        $oauth = [];
        $oauth['oauth_version'] = self::VERSION;
        $oauth['oauth_nonce'] = $this->nonce;
        $oauth['oauth_timestamp'] = $this->timestamp;
        $oauth['oauth_consumer_key'] = $this->consumerKey;
        $oauth['oauth_signature_method'] = $this->signatureMethod->getName();

        if($this->token != null){
            $oauth['oauth_token'] = $this->token;
        }

        if($this->bodyHash != null){
            $oauth['oauth_body_hash'] = $this->bodyHash;
        }

        return $oauth;
    }

    public function toHeader()
    {
        $result = [];
        $params = $this->toArray();
        $params['oauth_signature'] = $this->signature;
        $result['Authorization'] = 'OAuth';

        $first = true;
        foreach ($params as $k => $v) {
            $result['Authorization'] .= ($first) ? ' ' : ', ';
            $result['Authorization'] .= Util::urlencodeRfc3986($k) . '="' . Util::urlencodeRfc3986($v) . '"';
            $first = false;
        }

        return new Headers($result);
    }
}