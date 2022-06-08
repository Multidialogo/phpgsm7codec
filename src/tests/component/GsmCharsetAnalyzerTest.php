<?php

namespace multidialogo\phpgsm7codec\tests\component;

use PHPUnit\Framework\TestCase;
use multidialogo\phpgsm7codec\component\GsmCharsetAnalyzer;

class GsmCharsetAnalyzerTest extends TestCase
{
    /**
     * @dataProvider provideInputWithExtraCodecChars
     */
    public function testCountExtraCodecChars(string $protocolVersion, string $input, int $extraCodecCount): void
    {
        $analyzer = new GsmCharsetAnalyzer($protocolVersion);

        static::assertEquals($extraCodecCount, $analyzer->countExtraCodecChars($input));
    }

    public function provideInputWithExtraCodecChars(): array
    {
        return [
            [
                '03.38',
                'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore " .
                "et dolore magna aliqua.',
                0,
            ],
            [
                '03.38',
                'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore " .
                "et dolore magna aliqua°',
                1,
            ],
        ];
    }
}