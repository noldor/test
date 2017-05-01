<?php
declare(strict_types=1);

namespace Tests\Unit\Parsers;

use App\Parsers\RegexIteratorParser;
use Illuminate\Support\Collection;
use Tests\TestCase;

class RegexIteratorParserTest extends TestCase
{
    public function data()
    {
        return [
            [
                'source' => file_get_contents(__DIR__ . '/testData.txt'),
                'codes' => ['457', '98', '2', '12637', '89123789', '032', '0', '-2010']
            ]
        ];
    }

    public function testFormatToInt()
    {
        $parser = new RegexIteratorParser('', '');
        $class = new \ReflectionClass($parser);

        $method = $class->getMethod('formatToInt');
        $method->setAccessible(true);

        $this->assertSame(
            ['123', '-355', '645', '-64'],
            $method->invokeArgs($parser, [[[['+123', '-355', '645', '-64']]]])
        );
    }

    /**
     * @param string $source
     * @param array  $codes
     * @dataProvider data()
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
     * @dataProvider data()
     */
    public function testGetResult(string $source, array $codes)
    {
        $parser = new RegexIteratorParser($source);
        $parser->parse();

        $this->assertInstanceOf(Collection::class, $parser->getResult());
        $this->assertSame($codes, $parser->getResult()->toArray());
    }
}