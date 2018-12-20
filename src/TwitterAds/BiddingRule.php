<?php

namespace Hborras\TwitterAdsSDK\TwitterAds;


class BiddingRule
{

    /** @var string */
    private $currency;

    /** @var int */
    private $minimumCpeBidLocalMicro;

    /** @var int */
    private $maximumCpeBidLocalMicro;

    /** @var int */
    private $minimumDenomination;

    public function __construct(string $currency, int $minimumCpeBidLocalMicro, int $maximumCpeBidLocalMicro,
                                int $minimumDenomination)
    {
        $this->currency = $currency;
        $this->minimumCpeBidLocalMicro = $minimumCpeBidLocalMicro;
        $this->maximumCpeBidLocalMicro = $maximumCpeBidLocalMicro;
        $this->minimumDenomination = $minimumDenomination;
    }


    /**
     * @param array $response
     * @return BiddingRule[]
     */
    public static function fromResponse(array $response)
    {
        $biddingRules = [];

        foreach ($response as $item) {
            $currency = $item->currency;
            $minimumCpeBidLocalMicro = $item->minimum_cpe_bid_local_micro;
            $maximumCpeBidLocalMicro = $item->maximum_cpe_bid_local_micro;
            $minimumDenomination = $item->minimum_denomination;

            $biddingRule = new BiddingRule($currency, $minimumCpeBidLocalMicro, $maximumCpeBidLocalMicro,
                $minimumDenomination);

            $biddingRules[] = $biddingRule;

        }
        return $biddingRules;
    }

    /**
     * @return string
     */
    public function currency() : string
    {
        return $this->currency;
    }

    /**
     * @return int
     */
    public function minimumCpeBidLocalMicro(): int
    {
        return $this->minimumCpeBidLocalMicro;
    }

    /**
     * @return int
     */
    public function maximumCpeBidLocalMicro(): int
    {
        return $this->maximumCpeBidLocalMicro;
    }

    /**
     * @return int
     */
    public function minimumDenomination(): int
    {
        return $this->minimumDenomination;
    }
}