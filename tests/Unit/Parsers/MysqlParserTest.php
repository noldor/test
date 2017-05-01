<?php
declare(strict_types=1);

namespace Tests\Unit\Parsers;

use App\Parsers\MysqlParser;
use Illuminate\Support\Collection;
use Tests\TestCase;

class MysqlParserTest extends TestCase
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

    /**
     * @param string $source
     * @param array  $codes
     * @dataProvider data()
     */
    public function testParse(string $source, array $codes)
    {
        $parser = new MysqlParser($source);
        $class = new \ReflectionClass($parser);

        $result = $class->getProperty('result');
        $result->setAccessible(true);

        $parser->parse();

        $this->assertSame($codes, $result->getValue($parser)->toArray());
    }

    /**
     * @param string $source
     * @param array  $codes
     * @dataProvider data()
     */
    public function testGetResult(string $source, array $codes)
    {
        $parser = new MysqlParser($source);
        $parser->parse();

        $this->assertInstanceOf(Collection::class, $parser->getResult());
        $this->assertSame($codes, $parser->getResult()->toArray());
    }
}