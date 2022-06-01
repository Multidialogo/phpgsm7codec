<?php

namespace multidialogo\phpgsm7codec\component\GsmMessageCounterStrategy;

class GsmUnicodeConcatMessageCounterStrategy extends GsmMessageCounterStrategyBase
{
    function __construct()
    {
        parent::__construct(70, 67);
    }
}