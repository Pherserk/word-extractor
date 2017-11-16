<?php

namespace Pherserk\WordExtractor\component;

use Pherserk\Language\model\LanguageInterface;
use Pherserk\SignProvider\model\ClassifiedSign;
use Pherser\WordExtractor\model\UnclassifiedWord;

class WordExtractor
{
    /**
     * @param string $text
     * @param ClassifiedSign[] $uniqueClassifiedSigns
     * @param bool $unique
     * 
     * @return UnclassifiedWord[]
     */
    public static function extract(string $text, array $uniqueClassifiedSigns, bool $unique)
    {
        $classifiedSignsByType = static::rearrangeUniqueClassifiedSignsByType($uniqueClassifiedSigns);
        
        $breakTokens = [];
        foreach ($classifiedSignsByType as $type => $classifiedSigns) {
            foreach ($classifiedSigns as $classifiedSign) {
                switch ($type) {
                    case ClassifiedSign::SEPARATION_PUNCTATION_TYPE :
                    case ClassifiedSign::TERMINATION_PUNCTATION_TYPE :
                    case ClassifiedSign::EMPTY_TYPE :
                    case ClassifiedSign::WORD_TYPE :
                        $breakTokens[] = $classifiedSign;
                    break;
                }
            }
        }
 
        if (!$breakTokens) {
            return [$text];
        }
        
        $regexp = implode('|', $breakTokens);
    
        return preg_split("/$regexp/", $text);     
    } 

    private static function rearrangeUniqueClassifiedSignsByType(array $uniqueClassifiedSigns)
    {
        $results = [];

        foreach ($uniqueClassifiedSigns as $uniqueClassifiedSign) {
            $results[$uniqueClassifiedSign->getType()][] = $uniqueClassifiedSign->getSign();
        }

        return $results;
    }
}
