<?php

namespace multidialogo\phpgsm7codec\component\GsmMessageCounterStrategy;

abstract class GsmMessageCounterStrategyBase implements GsmMessageCounterStrategy
{
    protected bool $presentAsOne;

    protected int $maxSplitMessageLength;

    protected int $maxConcatMessageLength;

    function __construct(int $maxMessageLength, ?int $maxConcatMessageLength = null)
    {
        $this->maxSplitMessageLength = $maxMessageLength;
        $this->maxConcatMessageLength = $maxConcatMessageLength;
        $this->presentAsOne = $maxConcatMessageLength != null;
    }

    public function execute(string $input): int
    {
        $inputLength = strlen($input);

        $maxMessageLength = $inputLength > $this->maxSplitMessageLength && $this->presentAsOne ?
            $this->maxConcatMessageLength :
            $this->maxSplitMessageLength;

        return ceil($inputLength / $maxMessageLength);
    }
}