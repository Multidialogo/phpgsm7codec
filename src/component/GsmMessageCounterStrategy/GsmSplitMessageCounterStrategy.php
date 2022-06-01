<?php

namespace multidialogo\phpgsm7codec\component\GsmMessageCounterStrategy;

class GsmSplitMessageCounterStrategy extends GsmMessageCounterStrategyBase
{
    function __construct()
    {
        parent::__construct(160);
    }
}