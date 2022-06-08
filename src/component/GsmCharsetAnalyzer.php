<?php

namespace multidialogo\phpgsm7codec\component;

class GsmCharsetAnalyzer
{
    private array $alphabet;

    public function __construct(string $protocolVersion)
    {
        // FIXME: a better loading approach would be more secure...

        $this->alphabet = require(__DIR__ . "/alphabet/{$protocolVersion}.php");
    }

    public function countExtraCodecChars(string $input): int
    {
        $len = mb_strlen($input, 'UTF-8');
        $count = 0;

        for ($i = 0; $i < $len; $i++) {
            if (!in_array(mb_substr($input, $i, 1, 'UTF-8'), $this->alphabet)) {
                $count++;
            }
        }

        return $count;
    }
}