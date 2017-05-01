<?php
declare(strict_types=1);

namespace App\Parsers;

class RegexIteratorParser implements ParserInterface
{
    /**
     * Const to set return type of results as array.
     */
    public const AS_ARRAY = 1;

    /**
     * Const to set return type of results as Iterator
     */
    public const AS_ITERATOR = 2;

    /**
     * @var string
     */
    private $regex;

    /**
     * @var \ArrayIterator
     */
    private $sourceIterator;

    /**
     * @var array
     */
    private $result = [];

    /**
     * RegexIteratorParser constructor.
     *
     * @param string $content
     * @param string $regex
     */
    public function __construct(string $content, string $regex = '/(?<={)[+-]?[0-9]+(?=})/')
    {
        $this->regex = $regex;
        $this->sourceIterator = new \ArrayIterator([$content]);
    }

    /**
     * Get results array or Iterator.
     *
     * @param int $type
     *
     * @return iterable
     */
    public function getResult(int $type = self::AS_ITERATOR): iterable
    {
        if ($type === self::AS_ARRAY) {
            return $this->result;
        } else {
            return new \ArrayIterator($this->result);
        }
    }

    /**
     * Parse content and find needles.
     *
     * @return \App\Parsers\ParserInterface
     */
    public function parse(): ParserInterface
    {
        $sourceCodes = iterator_to_array(new \RegexIterator($this->sourceIterator, $this->regex, \RegexIterator::ALL_MATCHES));

        if (!empty($sourceCodes)) {
            $this->result = $this->formatToInt($sourceCodes);
        }

        return $this;
    }

    /**
     * Format array of string to integers.
     *
     * @param array $sourceCodes
     *
     * @return array
     */
    private function formatToInt(array $sourceCodes)
    {
        $codes = [];
        foreach ($sourceCodes[0][0] as $code) {
            $codes[] = intval($code);
        }

        return $codes;
    }
}