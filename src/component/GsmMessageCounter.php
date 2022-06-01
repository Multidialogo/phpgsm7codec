<?php

namespace multidialogo\phpgsm7codec\component;

use RuntimeException;

class GsmMessageCounter
{
    static array $SUPPORTED_GSM_PROTOCOL_VERSIONS = [
        '03.38',
        '03.40',
    ];

    static int $GSM7_MAX_SINGLE_MESSAGE_LENGTH = 160;
    static int $GSM7_MAX_CONCAT_MESSAGE_LENGTH = 153;
    static int $UNICODE_MAX_SINGLE_MESSAGE_LENGTH = 70;
    static int $UNICODE_MAX_CONCAT_MESSAGE_LENGTH = 67;

    private string $gsmProtocolVersion;

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
        $inputLength = strlen($input);
        $maxMessageLength = self::$GSM7_MAX_SINGLE_MESSAGE_LENGTH;

        switch ($this->gsmProtocolVersion) {
            case '03.38':
            case '03.40':
                if (CharsetAnalyzer::isValidGSM7String($input)) {
                    $maxMessageLength = $inputLength > self::$GSM7_MAX_SINGLE_MESSAGE_LENGTH && $presentAsOne ?
                        self::$GSM7_MAX_CONCAT_MESSAGE_LENGTH :
                        self::$GSM7_MAX_SINGLE_MESSAGE_LENGTH;

                } else {
                    $maxMessageLength = $inputLength > self::$UNICODE_MAX_SINGLE_MESSAGE_LENGTH && $presentAsOne ?
                        self::$UNICODE_MAX_CONCAT_MESSAGE_LENGTH :
                        self::$UNICODE_MAX_SINGLE_MESSAGE_LENGTH;

                }
                break;
        }

        return ceil($inputLength / $maxMessageLength);
    }
}