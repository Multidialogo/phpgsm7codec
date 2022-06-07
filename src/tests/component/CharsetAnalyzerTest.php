<?php

namespace multidialogo\phpgsm7codec\tests\component;

use multidialogo\phpgsm7codec\component\CharsetAnalyzer;
use PHPUnit\Framework\TestCase;

class CharsetAnalyzerTest extends TestCase
{
    /**
     * @dataProvider provideInputWithExtraCodecChars
     */
    public function testCountExtraCodecChars($input, $extraCodecCount)
    {
        static::assertEquals($extraCodecCount, CharsetAnalyzer::countExtraCodecChars($input));
    }

    public function provideInputWithExtraCodecChars()
    {
        return [
            [
                'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore " .
                "et dolore magna aliqua.',
                0,
            ],
            [
                'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore " .
                "et dolore magna aliqua°',
                1,
            ],
        ];
    }
}