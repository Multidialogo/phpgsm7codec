<?php

namespace multidialogo\phpgsm7codec\component\GsmMessageCounterStrategy;

interface GsmMessageCounterStrategy
{
    public function execute(string $input) : int;
}

