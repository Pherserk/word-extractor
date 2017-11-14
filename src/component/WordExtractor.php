<?php

namespace Pherserk\WordExtractor\component;

use Pherserk\Language\model\LanguageInterface;
use Pherserk\SignProvider\model\ClassifiedSign;
use Pherser\WordExtractor\model\UnclassifiedWord;

class WordExtractor
{
    /**
     * @param string $text
     * @param ClassifiedSign[] $classifiedSigns
     * @param bool $unique
     * 
     * @return UnclassifiedWord[]
     */
    public static function extract(string $text, array $classifiedSigns, bool $unique)
    {
    
    } 
}
