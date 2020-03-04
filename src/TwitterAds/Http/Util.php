<?php

namespace Hborras\TwitterAdsSDK\TwitterAds\Http;

abstract class Util {

  /**
   * Avoid parse_str() for HHVM compatibility
   * This implementation is not a complete sobstitute, but covers all the
   * requirements of the Twitter Cursor.
   *
   * @see hhvm.hack.disallow_dynamic_var_env_funcs
   * @param $query_string
   * @return array
   */
  public static function parseUrlQuery($query_string) {
    $query = array();
    $pairs = explode('&', $query_string);
    foreach ($pairs as $pair) {
      list($key, $value) = explode('=', $pair);
      $query[$key] = urldecode($value);
    }

    return $query;
  }
}
