<?php

namespace multidialogo\phpgsm7codec\tests\component;

use PHPUnit\Framework\TestCase;
use multidialogo\phpgsm7codec\component\CharsetAnalyzer;

class CharsetAnalyzerTest extends TestCase
{
    /**
     * @dataProvider provideInputWithExtraCodecChars
     */
    public function testCountExtraCodecChars(string $input, int $extraCodecCount): void
    {
        static::assertEquals($extraCodecCount, CharsetAnalyzer::countExtraCodecChars($input));
    }

    public function provideInputWithExtraCodecChars(): array
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