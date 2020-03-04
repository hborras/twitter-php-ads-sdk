<?php

namespace Hborras\TwitterAdsSDK\TwitterAds\Logger\CurlLogger;


use Hborras\TwitterAdsSDK\TwitterAds\Http\Parameters;

class JsonAwareParameters extends Parameters {

  /**
   * @param mixed $value
   * @return string
   */
  protected function exportNonScalar($value) {
    return JsonNode::factory($value)->encode();
  }
}
