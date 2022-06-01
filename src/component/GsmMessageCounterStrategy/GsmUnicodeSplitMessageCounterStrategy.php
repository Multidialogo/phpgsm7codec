<?php

namespace multidialogo\phpgsm7codec\component\GsmMessageCounterStrategy;

class GsmUnicodeSplitMessageCounterStrategy extends GsmMessageCounterStrategyBase
{
    function __construct()
    {
        parent::__construct(70);
    }
}