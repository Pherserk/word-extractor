<?php

namespace Pherserk\WordExtractor\test\component;

use Pherserk\SignProvider\model\ClassifiedSign;
use Pherserk\WordExtractor\component\WordExtractor;
use Pherserk\WordExtractor\model\UnclassifiedWord;
use PHPUnit\Framework\TestCase;

class WordExtractorTest extends TestCase
{
    /**
     *@dataProvider provideData
     */
    public function testExtract(string $text, array $uniqueClassifiedSigns, bool $unique, array $expectedWords)
    {
        $extractedWords = WordExtractor::extract($text, $uniqueClassifiedSigns, $unique);

        static::assertEquals($expectedWords, $extractedWords);
    }

    public function provideData()
    {
        return [
            [
                'This is a test',
                [
                    new ClassifiedSign('T', ClassifiedSign::LETTER_TYPE),
                    new ClassifiedSign('h', ClassifiedSign::LETTER_TYPE),
                    new ClassifiedSign('i', ClassifiedSign::LETTER_TYPE),
                    new ClassifiedSign('s', ClassifiedSign::LETTER_TYPE),
                    new ClassifiedSign(' ', ClassifiedSign::EMPTY_TYPE),
                    new ClassifiedSign('a', ClassifiedSign::LETTER_TYPE),
                    new ClassifiedSign('t', ClassifiedSign::LETTER_TYPE),
                    new ClassifiedSign('e', ClassifiedSign::LETTER_TYPE),
                ],
                true,
                [
                    new UnclassifiedWord('This'),
                    new UnclassifiedWord('is'), 
		    new UnclassifiedWord('a'), 
                    new UnclassifiedWord('test'),
                ],
            ],
            [
                '这是一个考验',
                [
                    new ClassifiedSign('这', ClassifiedSign::WORD_TYPE),
                    new ClassifiedSign('是', ClassifiedSign::WORD_TYPE),
                    new ClassifiedSign('一', ClassifiedSign::WORD_TYPE),
                    new ClassifiedSign('个', ClassifiedSign::WORD_TYPE),
                    new ClassifiedSign('考', ClassifiedSign::WORD_TYPE),
                    new ClassifiedSign('验', ClassifiedSign::WORD_TYPE),
                ],
                true,
                [
                    new UnclassifiedWord('这'), 
                    new UnclassifiedWord('是'), 
                    new UnclassifiedWord('一'), 
                    new UnclassifiedWord('个'), 
                    new UnclassifiedWord('考'),
                    new UnclassifiedWord('验'),
                ],
            ],
            [
              "这是一个测试。\n这是另一个。",
              [
                    new ClassifiedSign('这', ClassifiedSign::WORD_TYPE),
                    new ClassifiedSign('是', ClassifiedSign::WORD_TYPE),
                    new ClassifiedSign('一', ClassifiedSign::WORD_TYPE),
                    new ClassifiedSign('个', ClassifiedSign::WORD_TYPE),
                    new ClassifiedSign('测', ClassifiedSign::WORD_TYPE),
                    new ClassifiedSign('试', ClassifiedSign::WORD_TYPE),
                    new ClassifiedSign('。', ClassifiedSign::WORD_TYPE),
                    new ClassifiedSign("\n", ClassifiedSign::EMPTY_TYPE),
                    new ClassifiedSign('另', ClassifiedSign::WORD_TYPE),
              ],
              true,
              [
		    new UnclassifiedWord('这'), 
		    new UnclassifiedWord('是'), 
		    new UnclassifiedWord('一'), 
                    new UnclassifiedWord('个'), 
                    new UnclassifiedWord('测'), 
                    new UnclassifiedWord('试'), 
                    new UnclassifiedWord('。'), 
                    new UnclassifiedWord('另'),
	      ]
            ]
	];
    }
}
