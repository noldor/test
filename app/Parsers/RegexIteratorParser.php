<?php
declare(strict_types=1);

namespace App\Parsers;

use Illuminate\Support\Collection;

class RegexIteratorParser implements ParserInterface
{
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
     * @return Collection
     */
    public function getResult(): Collection
    {
        return new Collection($this->result);
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
            $this->result = $this->format($sourceCodes);
        }

        return $this;
    }

    /**
     * Format array of string
     *
     * @param array $sourceCodes
     *
     * @return array
     */
    private function format(array $sourceCodes)
    {
        $codes = [];
        foreach ($sourceCodes[0][0] as $code) {
            $codes[] = ltrim($code, '+');
        }

        return $codes;
    }
}