<?php

namespace multidialogo\phpgsm7codec\component;

use multidialogo\phpgsm7codec\component\GsmMessageCounterStrategy\GsmConcatMessageCounterStrategy;
use multidialogo\phpgsm7codec\component\GsmMessageCounterStrategy\GsmSplitMessageCounterStrategy;
use multidialogo\phpgsm7codec\component\GsmMessageCounterStrategy\GsmUnicodeConcatMessageCounterStrategy;
use multidialogo\phpgsm7codec\component\GsmMessageCounterStrategy\GsmUnicodeSplitMessageCounterStrategy;
use RuntimeException;

class GsmMessageCounter
{
    static $SUPPORTED_GSM_PROTOCOL_VERSIONS = [
        '03.38',
        '03.40',
    ];

    private $gsmProtocolVersion;

    function __construct(string $gsmProtocolVersion)
    {
        if (!in_array($gsmProtocolVersion, self::$SUPPORTED_GSM_PROTOCOL_VERSIONS)) {
            throw new RuntimeException(
                "Unsupported GSM protocol version {$gsmProtocolVersion}. Supported ones are: " .
                implode(' ', self::$SUPPORTED_GSM_PROTOCOL_VERSIONS)
            );
        }

        $this->gsmProtocolVersion = $gsmProtocolVersion;
    }

    public function getMessagesCount(string $input, bool $presentAsOne): int
    {
        $strategy = null;

        switch ($this->gsmProtocolVersion) {
            case '03.38':
            case '03.40':
                if (CharsetAnalyzer::isValidGSM7String($input)) {
                    $strategy = $presentAsOne ?
                        new GsmConcatMessageCounterStrategy() :
                        new GsmSplitMessageCounterStrategy();

                } else {
                    $strategy = $presentAsOne ?
                        new GsmUnicodeConcatMessageCounterStrategy() :
                        new GsmUnicodeSplitMessageCounterStrategy();

                }
                break;
        }

        return $strategy->execute($input);
    }
}