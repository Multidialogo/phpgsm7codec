<?php

namespace multidialogo\phpgsm7codec\component\GsmMessageCounterStrategy;

class GsmConcatMessageCounterStrategy extends GsmMessageCounterStrategyBase
{
    function __construct()
    {
        parent::__construct(160, 153);
    }
}