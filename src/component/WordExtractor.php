<?php

namespace Pherserk\WordExtractor\component;

use Pherserk\Language\model\LanguageInterface;
use Pherserk\SignExtractor\component\SignExtractor;
use Pherserk\SignProvider\model\ClassifiedSign;
use Pherserk\WordExtractor\model\UnclassifiedWord;

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
       
	$breakWords = [];
        $breakTokens = [];
        foreach ($classifiedSignsByType as $type => $classifiedSigns) {
            foreach ($classifiedSigns as $classifiedSign) {
                switch ($type) {
                    case ClassifiedSign::SEPARATION_PUNCTATION_TYPE :
                    case ClassifiedSign::TERMINATION_PUNCTATION_TYPE :
                    case ClassifiedSign::EMPTY_TYPE :
                        $breakTokens[] = "\\$classifiedSign";
                    break;
                    
                    case ClassifiedSign::WORD_TYPE :
	                $breakWords[] = $classifiedSign;
                    break;
                }
            }
        }
 
        if (!$breakTokens && !$breakWords) {
            return [$text];
        }        

        $regexp = implode('|', $breakTokens);
    
        $words = preg_split("/$regexp/u", $text);
        
	$extractedWords = [];
        foreach ($words as $word) {
            $wordChars = SignExtractor::extract($word, false);
            $foundWordChars = false;
            
            if ($breakWords) {
                $breakWordsAsString = implode('', $breakWords);
                foreach ($wordChars as $wordChar) {
                    $sign = $wordChar->getSign();
                    if (FALSE !== mb_strpos($breakWordsAsString, $sign)) {
                        $foundWordChars = true;
                        $extractedWords[] = new UnclassifiedWord($sign);
                    }
                }    
            }

            if (!$foundWordChars && !empty($word)) {
		$extractedWords[] = new UnclassifiedWord($word);
            } 
        }       

	return $extractedWords; 
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
