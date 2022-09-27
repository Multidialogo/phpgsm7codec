<?php

namespace multidialogo\phpgsm7codec\tests\component;

use multidialogo\phpgsm7codec\component\GsmMessageCounter;
use PHPUnit\Framework\TestCase;

class GsmMessageCounterTest extends TestCase
{
    /**
     * @dataProvider provideInput
     */
    public function testGetMessageCount(string $gsmProtocolVersion, string $input, bool $presentAsOne, int $expectedMessageCount)
    {
        $gsmMessageCounter = new GsmMessageCounter($gsmProtocolVersion);
        static::assertEquals($expectedMessageCount, $gsmMessageCounter->getMessagesCount($input, $presentAsOne));
    }

    public function provideInput(): array
    {
        return [
            [
                '03.38',
                "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore " .
                "et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut " .
                "aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse " .
                "cillum dolore eu fugiato.",
                false,
                2,
            ],
            [
                '03.40',
                "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore " .
                "et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut " .
                "aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse " .
                "cillum dolore eu fugiato.",
                false,
                2,
            ],
            [
                '03.38',
                "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore " .
                "et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut " .
                "aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse " .
                "cillum dolore eu fugiato.",
                true,
                3,
            ],
            [
                '03.40',
                "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore " .
                "et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut " .
                "aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse " .
                "cillum dolore eu fugiato.",
                true,
                3,
            ],
            [
                '03.38',
                "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore " .
                "et dolore magna aliqua. Ut enim ad min°",
                false,
                2,
            ],
            [
                '03.40',
                "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore " .
                "et dolore magna aliqua. Ut enim ad min°",
                false,
                2,
            ],
            [
                '03.38',
                "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore " .
                "et dolore magna aliqua. Ut enim ad min°",
                true,
                3,
            ],
            [
                '03.40',
                "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore " .
                "et dolore magna aliqua. Ut enim ad min°",
                true,
                3,
            ],
            [
                '03.38',
                "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore " .
                "et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut " .
                "aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in. €",
                true,
                2,
            ],
            [
                '03.40',
                "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore " .
                "et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut " .
                "aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in. €",
                true,
                2,
            ],
        ];
    }
}