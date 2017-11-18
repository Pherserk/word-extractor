<?php

namespace Pherserk\WordExtractor\model;

use Pherserk\Word\model\WordInterface;

class UnclassifiedWord implements WordInterface
{
    const UNCLASSIFIED_TYPE = 'unclassified';

    private $word;

    public function __construct(string $word)
    {
        $this->word = $word;
    }

    public function getWord() : string
    {
        return $this->word;
    }

    public function getType() : string
    {
        return static::UNCLASSIFIED_TYPE;
    }
}

