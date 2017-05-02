<?php
declare(strict_types=1);

namespace Tests\Unit\Parsers;

use App\Parsers\TextParser;
use Illuminate\Support\Collection;
use Tests\TestCase;

class TextParserTest extends TestCase
{
    /**
     * @var TextParser
     */
    private $parser;

    /**
     * @var \ReflectionClass
     */
    private $reflectionClass;

    public function setUp()
    {
        $this->parser = new TextParser('', '{', '}');
        $this->reflectionClass = new \ReflectionClass($this->parser);
    }

    public function data()
    {
        return [
            [
                'source' => file_get_contents(__DIR__ . '/testData.txt'),
                'codes' => ['457', '111', '98', '2', '12637', '89123789', '032', '0', '-2010']
            ],
            [
                'source' => file_get_contents(__DIR__ . '/testDataEmpty.txt'),
                'codes' => []
            ]
        ];
    }

    public function testIsOpenTag()
    {
        $method = $this->reflectionClass->getMethod('isOpenTag');
        $method->setAccessible(true);

        $this->assertTrue($method->invokeArgs($this->parser, ['{']));
        $this->assertFalse($method->invokeArgs($this->parser, ['%']));
    }

    public function testIsCloseTag()
    {
        $method = $this->reflectionClass->getMethod('isCloseTag');
        $method->setAccessible(true);

        $this->assertTrue($method->invokeArgs($this->parser, ['}']));
        $this->assertFalse($method->invokeArgs($this->parser, ['%']));
    }

    public function testBuildElement()
    {
        $property = $this->reflectionClass->getProperty('currentElement');
        $property->setAccessible(true);

        $isOpen = $this->reflectionClass->getProperty('isOpen');
        $isOpen->setAccessible(true);
        $isOpen->setValue($this->parser, true);

        $method = $this->reflectionClass->getMethod('buildElement');
        $method->setAccessible(true);

        $method->invokeArgs($this->parser, ['+']);
        $method->invokeArgs($this->parser, ['1']);
        $method->invokeArgs($this->parser, ['2']);
        $method->invokeArgs($this->parser, ['3']);
        $method->invokeArgs($this->parser, ['4']);

        $this->assertTrue($isOpen->getValue($this->parser));
        $this->assertSame('+1234', $property->getValue($this->parser));
        $property->setValue($this->parser, null);

        $method->invokeArgs($this->parser, ['-']);
        $method->invokeArgs($this->parser, ['1']);
        $method->invokeArgs($this->parser, ['2']);
        $method->invokeArgs($this->parser, ['3']);
        $method->invokeArgs($this->parser, ['4']);

        $this->assertTrue($isOpen->getValue($this->parser));
        $this->assertSame('-1234', $property->getValue($this->parser));

        $method->invokeArgs($this->parser, ['-']);
        $method->invokeArgs($this->parser, ['1']);
        $method->invokeArgs($this->parser, ['2']);
        $method->invokeArgs($this->parser, ['%']);

        $this->assertFalse($isOpen->getValue($this->parser));
        $this->assertNull($property->getValue($this->parser));
    }

    public function testPushElement()
    {
        $property = $this->reflectionClass->getProperty('currentElement');
        $property->setAccessible(true);

        $result = $this->reflectionClass->getProperty('result');
        $result->setAccessible(true);

        $method = $this->reflectionClass->getMethod('pushElement');
        $method->setAccessible(true);

        $property->setValue($this->parser, '+1234');
        $method->invokeArgs($this->parser, []);

        $property->setValue($this->parser, '987');
        $method->invokeArgs($this->parser, []);

        $property->setValue($this->parser, null);
        $method->invokeArgs($this->parser, []);

        $property->setValue($this->parser, '-675');
        $method->invokeArgs($this->parser, []);

        $property->setValue($this->parser, '342');
        $method->invokeArgs($this->parser, []);

        $property->setValue($this->parser, null);

        $this->assertSame(['1234', '987', '-675', '342'], iterator_to_array($result->getValue($this->parser)));
    }

    /**
     * @param string $source
     * @param array  $codes
     * @dataProvider data()
     */
    public function testParse(string $source, array $codes)
    {
        $parser = new TextParser($source);
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
        $parser = new TextParser($source);
        $parser->parse();

        $this->assertInstanceOf(Collection::class, $parser->getResult());
        $this->assertSame($codes, $parser->getResult()->toArray());
    }
}