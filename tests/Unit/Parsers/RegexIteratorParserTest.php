<?php
declare(strict_types=1);

namespace Tests\Unit\Parsers;

use App\Parsers\RegexIteratorParser;
use Tests\TestCase;

class RegexIteratorParserTest extends TestCase
{
    public function testData()
    {
        return [
            [
                'source' => file_get_contents(__DIR__ . '/testData.txt'),
                'codes' => [457, 98, 2, 12637, 89123789, -2010]
            ]
        ];
    }

    public function testFormatToInt()
    {
        $parser = new \App\Parsers\RegexIteratorParser('', '');
        $class = new \ReflectionClass($parser);

        $method = $class->getMethod('formatToInt');
        $method->setAccessible(true);

        $this->assertSame(
            [123, -355, 645, -64],
            $method->invokeArgs($parser, [[[['+123', '-355', '645', '-64']]]])
        );
    }

    /**
     * @param string $source
     * @param array  $codes
     * @dataProvider testData()
     */
    public function testParse(string $source, array $codes)
    {
        $parser = new RegexIteratorParser($source);
        $class = new \ReflectionClass($parser);

        $result = $class->getProperty('result');
        $result->setAccessible(true);

        $parser->parse();

        $this->assertSame($codes, $result->getValue($parser));
    }

    /**
     * @param string $source
     * @param array  $codes
     * @dataProvider testData()
     */
    public function testGetResult(string $source, array $codes)
    {
        $parser = new RegexIteratorParser($source);
        $parser->parse();

        $this->assertInstanceOf(\ArrayIterator::class, $parser->getResult(RegexIteratorParser::AS_ITERATOR));
        $this->assertSame($codes, $parser->getResult(RegexIteratorParser::AS_ARRAY));
    }
}