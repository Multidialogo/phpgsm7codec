<?php

namespace multidialogo\phpgsm7codec\component;

use RuntimeException;

class GsmMessageCounter
{
    static $SUPPORTED_GSM_PROTOCOL_VERSIONS = [
        '03.38',
        '03.40',
    ];

    static $GSM7_MAX_SINGLE_MESSAGE_LENGTH = 160;
    static $GSM7_MAX_CONCAT_MESSAGE_LENGTH = 153;
    static $UNICODE_MAX_SINGLE_MESSAGE_LENGTH = 70;
    static $UNICODE_MAX_CONCAT_MESSAGE_LENGTH = 67;

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
        $result = 0;
        $inputLength = strlen($input);

        // FIXME : implement strategy pattern
        switch ($this->gsmProtocolVersion) {
            case '03.38':
            case '03.40':
                if (CharsetAnalyzer::isValidGSM7String($input)) {
                    if ($inputLength > self::$GSM7_MAX_SINGLE_MESSAGE_LENGTH && $presentAsOne) {
                        $maxMessageLength = self::$GSM7_MAX_CONCAT_MESSAGE_LENGTH;
                    } else {
                        $maxMessageLength = self::$GSM7_MAX_SINGLE_MESSAGE_LENGTH;
                    }
                } else {
                    if ($inputLength > self::$UNICODE_MAX_SINGLE_MESSAGE_LENGTH && $presentAsOne) {
                        $maxMessageLength = self::$UNICODE_MAX_CONCAT_MESSAGE_LENGTH;
                    } else {
                        $maxMessageLength = self::$UNICODE_MAX_SINGLE_MESSAGE_LENGTH;
                    }
                }
                $result = ceil($inputLength / $maxMessageLength);
                break;
        }

        return $result;
    }
}