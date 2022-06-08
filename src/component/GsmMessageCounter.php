<?php

namespace multidialogo\phpgsm7codec\component;

use RuntimeException;

class GsmMessageCounter
{
    static int $GSM7_MAX_SINGLE_MESSAGE_LENGTH = 160;
    static int $GSM7_MAX_CONCAT_MESSAGE_LENGTH = 153;
    static int $UNICODE_MAX_SINGLE_MESSAGE_LENGTH = 70;
    static int $UNICODE_MAX_CONCAT_MESSAGE_LENGTH = 67;

    private GsmCharsetAnalyzer $charsetAnalyzer;

    public function __construct(string $gsmProtocolVersion)
    {
        if (!in_array($gsmProtocolVersion, ProtocolRegistry::VERSIONS)) {
            throw new RuntimeException(
                "Unsupported GSM protocol version {$gsmProtocolVersion}. Supported ones are: " .
                implode(' ', ProtocolRegistry::VERSIONS)
            );
        }

        $this->charsetAnalyzer = new GsmCharsetAnalyzer($gsmProtocolVersion);
    }

    public function getMessagesCount(string $input, bool $presentAsOne): int
    {
        $inputLength = strlen($input);

        if (0 === $this->charsetAnalyzer->countExtraCodecChars($input)) {
            $maxMessageLength = $inputLength > self::$GSM7_MAX_SINGLE_MESSAGE_LENGTH && $presentAsOne ?
                self::$GSM7_MAX_CONCAT_MESSAGE_LENGTH :
                self::$GSM7_MAX_SINGLE_MESSAGE_LENGTH;

        } else {
            $maxMessageLength = $inputLength > self::$UNICODE_MAX_SINGLE_MESSAGE_LENGTH && $presentAsOne ?
                self::$UNICODE_MAX_CONCAT_MESSAGE_LENGTH :
                self::$UNICODE_MAX_SINGLE_MESSAGE_LENGTH;
        }

        return ceil($inputLength / $maxMessageLength);
    }
}