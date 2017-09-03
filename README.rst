Getting Started |Build Status| |Scrutinizer Status|
---------------------------------------------------

Installation
''''''''''''

.. code:: bash

    # installing the latest signed release
    composer require hborras/twitter-php-ads-sdk

Breaking Changes
''''''''''''''''

This new version includes some breaking changes that make incompatible with the previous library.

I've tried to make it easier to use it, you now only needs to instantiate one time the API class, and you can forget
about it. Before you needed to move it across all your classes and made the code more difficult


Future changes
''''''''''''''''

Implement Twitter Ads API v2

Quick Start
'''''''''''

.. code:: php

    const CONSUMER_KEY = 'your consumer key';
    const CONSUMER_SECRET = 'your consumer secret';
    const ACCESS_TOKEN = 'access token';
    const ACCESS_TOKEN_SECRET = 'access token secret';
    const ACCOUNT_ID = 'account id';


    // Create Twitter Ads Api Instance
    $api = TwitterAds::init(CONSUMER_KEY, CONSUMER_SECRET, ACCESS_TOKEN, ACCESS_TOKEN_SECRET);

    $accounts = $api->getAccounts();
    // load up the account instance, campaign and line item
    $account = new Account(ACCOUNT_ID);
    $account->read();
    $campaigns = $account->getCampaigns('', [CampaignFields::COUNT => 1]);
    $campaigns->setUseImplicitFetch(false);
    $campaignsData = [];

    // Create your campaign
    $campaign = new Campaign();
    $campaign->setAccount($account);
    $campaign->setFundingInstrumentId($account->getFundingInstruments()->first()->getId());
    $campaign->setDailyBudgetAmountLocalMicro(1000000);
    $campaign->setName("My first campaign");
    $campaign->setPaused(false);
    $campaign->setStartTime(new \DateTime());
    $campaign->save();

    // Automatic fetch from API when collection arrives to end:
    $campaign->setUseImplicitFetch(true);

    // Default fetch from API when collection arrives to end (GLOBAL):
    Cursor::setDefaultUseImplicitFetch(true);

    // Disable it
    Cursor::setDefaultUseImplicitFetch(false);

    // Async stats
    $stats = $lineItem->stats(
        [
            AnalyticsFields::METRIC_GROUPS_BILLING,
            AnalyticsFields::METRIC_GROUPS_MOBILE_CONVERSION,
            AnalyticsFields::METRIC_GROUPS_ENGAGEMENT,
        ],
        [
            AnalyticsFields::START_TIME => $date[0],
            AnalyticsFields::END_TIME => $date[1],
            AnalyticsFields::GRANULARITY => Enumerations::GRANULARITY_TOTAL,
            AnalyticsFields::PLACEMENT => Enumerations::PLACEMENT_ALL_ON_TWITTER
        ], true
    );
    
    // Sync stats, set parameter to false, or not include it
    $stats = $lineItem->stats(
        [
           AnalyticsFields::METRIC_GROUPS_BILLING,
            AnalyticsFields::METRIC_GROUPS_MOBILE_CONVERSION,
            AnalyticsFields::METRIC_GROUPS_ENGAGEMENT,
        ],
        [
            AnalyticsFields::START_TIME => $date[0],
            AnalyticsFields::END_TIME => $date[1],
            AnalyticsFields::GRANULARITY => Enumerations::GRANULARITY_TOTAL,
            AnalyticsFields::PLACEMENT => Enumerations::PLACEMENT_ALL_ON_TWITTER
        ], false
    );
    
Field Constants
---------------

    Now, there are able Fields classes for every included class to make easier filter and create data
    .. code:: php
    AnalyticsFields::GRANULARITY -> 'granularity'
    AnalyticsFields::PLACEMENT -> 'placement'
    .
    .
    .


Development
-----------

If you’d like to contribute to the project or try an unreleased
development version of this project locally, you can do so quite easily
by following the examples below.

.. code:: bash

    # clone the repository
    git clone git@github.com:hborras/twitter-php-ads-sdk.git
    cd twitter-php-ads-sdk

    # install dependencies
    composer install

License
-------

The MIT License (MIT)

Copyright (c) 2016 Hector Borras

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NON INFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
SOFTWARE.

.. |Build Status| image:: https://travis-ci.org/hborras/twitter-php-ads-sdk.svg?branch=master
:target: https://travis-ci.org/hborras/twitter-php-ads-sdk
.. |Scrutinizer Status| image:: https://scrutinizer-ci.com/g/hborras/twitter-php-ads-sdk/badges/quality-score.png?b=master
:target: https://scrutinizer-ci.com/g/hborras/twitter-php-ads-sdk