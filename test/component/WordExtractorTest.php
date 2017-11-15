<?php

namespace Pherserk\WordExtractor\test\component;

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
                ],
                true,
                ['This', 'is', 'a', 'test',],
            ],
            [
                '这是一个考验',
                [
                ],
                true,
                ['这', '是', '一', '个' , '考' ,'验',],
            ],
	];
    }
}
