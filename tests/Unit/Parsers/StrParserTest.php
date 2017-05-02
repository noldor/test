<?php
declare(strict_types=1);

namespace Tests\Unit\Parsers;

use App\Parsers\StrParser;
use Illuminate\Support\Collection;
use Tests\TestCase;

class StrParserTest extends TestCase
{
    /**
     * @var StrParser
     */
    private $parser;

    /**
     * @var \ReflectionClass
     */
    private $reflectionClass;

    public function setUp()
    {
        $this->parser = new StrParser('', '{', '}');
        $this->reflectionClass = new \ReflectionClass($this->parser);
    }

    public function data()
    {
        return [
            [
                'source' => file_get_contents(__DIR__ . '/testData.txt'),
                'codes' => ['457', '111', '98', '2', '12637', '89123789', '032', '0', '-2010', '12']
            ],
            [
                'source' => file_get_contents(__DIR__ . '/testDataEmpty.txt'),
                'codes' => []
            ]
        ];
    }

    public function testFilterChar()
    {
        $method = $this->reflectionClass->getMethod('filterChar');
        $method->setAccessible(true);

        $this->assertTrue($method->invokeArgs($this->parser, ['+']));
        $this->assertTrue($method->invokeArgs($this->parser, ['-']));
        $this->assertTrue($method->invokeArgs($this->parser, ['1']));
        $this->assertTrue($method->invokeArgs($this->parser, ['2']));
        $this->assertTrue($method->invokeArgs($this->parser, ['3']));
        $this->assertTrue($method->invokeArgs($this->parser, ['4']));
        $this->assertTrue($method->invokeArgs($this->parser, ['5']));
        $this->assertTrue($method->invokeArgs($this->parser, ['6']));
        $this->assertTrue($method->invokeArgs($this->parser, ['7']));
        $this->assertTrue($method->invokeArgs($this->parser, ['8']));
        $this->assertTrue($method->invokeArgs($this->parser, ['9']));
        $this->assertTrue($method->invokeArgs($this->parser, ['0']));

        $this->assertFalse($method->invokeArgs($this->parser, ['&']));
        $this->assertFalse($method->invokeArgs($this->parser, ['s']));
    }

    public function testBuildElement()
    {
        $result = $this->reflectionClass->getProperty('result');
        $result->setAccessible(true);

        $method = $this->reflectionClass->getMethod('buildElement');
        $method->setAccessible(true);

        $method->invokeArgs($this->parser, ['423']);
        $method->invokeArgs($this->parser, ['+12']);
        $method->invokeArgs($this->parser, ['-54']);
        $method->invokeArgs($this->parser, ['4243t43']);
        $method->invokeArgs($this->parser, ['646.56']);
        $method->invokeArgs($this->parser, ['324dep']);
        $method->invokeArgs($this->parser, ['43221']);
        $method->invokeArgs($this->parser, ['0']);
        $method->invokeArgs($this->parser, ['0123']);
        $method->invokeArgs($this->parser, ['+']);
        $method->invokeArgs($this->parser, ['+012']);
        $method->invokeArgs($this->parser, ['']);

        $this->assertSame(['423', '12', '-54', '43221', '0', '0123', '012'], $result->getValue($this->parser)->toArray());
    }

    /**
     * @param string $source
     * @param array  $codes
     * @dataProvider data()
     */
    public function testParse(string $source, array $codes)
    {
        $parser = new StrParser($source);
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
        $parser = new StrParser($source);
        $parser->parse();

        $this->assertInstanceOf(Collection::class, $parser->getResult());
        $this->assertSame($codes, $parser->getResult()->toArray());
    }
}