<?php

namespace Pherserk\WordExtractor\test\component;

use Pherserk\SignProvider\model\ClassifiedSign;
use Pherserk\WordExtractor\component\WordExtractor;
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
                ['This', 'is', 'a', 'test',],
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
                ['这', '是', '一', '个' , '考' ,'验',],
            ],
	];
    }
}
