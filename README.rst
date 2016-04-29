Getting Started |Build Status| |Scrutinizer Status|
---------------------------------------------------

Installation
''''''''''''

.. code:: bash

    # installing the latest signed release
    NOT AVAILABLE NOW

Quick Start
'''''''''''

.. code:: php

    const CONSUMER_KEY = 'your consumer key';
    const CONSUMER_SECRET = 'your consumer secret';
    const ACCESS_TOKEN = 'access token';
    const ACCESS_TOKEN_SECRET = 'access token secret';
    const ACCOUNT_ID = 'account id';

    // Create twitter ads client
    $twitterAds = new TwitterAds(CONSUMER_KEY,CONSUMER_SECRET,ACCESS_TOKEN,ACCESS_TOKEN_SECRET);

    // Retrieve account information
    $account = $twitterAds->getAccounts(ACCOUNT_ID);

    // Create your campaign
    $campaign = new Campaign();
    $campaign->setAccount($account);
    $campaign->setFundingInstrumentId($account->getFundingInstruments()->first()->getId());
    $campaign->setDailyBudgetAmountLocalMicro(1000000);
    $campaign->setName("My first campaign");
    $campaign->setPaused(false);
    $campaign->setStartTime(new \DateTime());
    $campaign->save();


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
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
SOFTWARE.

.. |Build Status| image:: https://travis-ci.org/hborras/twitter-php-ads-sdk.svg?branch=master
:target: https://travis-ci.org/hborras/twitter-php-ads-sdk.svg
.. |Scrutinizer Status| image:: https://scrutinizer-ci.com/g/hborras/twitter-php-ads-sdk/badges/quality-score.png?b=master
:target: https://scrutinizer-ci.com/g/hborras/twitter-php-ads-sdk/badges/quality-score.png