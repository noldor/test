<?php
declare(strict_types=1);

namespace App\Parsers;

class Converter
{
    /**
     * Const to set return type of results as Iterator
     */
    public const AS_ITERATOR = 2;

    /**
     * Const to set return type of results as array.
     */
    public const AS_ARRAY = 1;

    /**
     * @var string
     */
    private $content;

    /**
     * Converter constructor.
     *
     * @param string $content
     */
    public function __construct(string $content)
    {
        $this->content = $content;
    }

    /**
     * Get available parser.
     *
     * @return \App\Parsers\ParserInterface
     */
    public function factory(): ParserInterface
    {
        if (class_exists(\RegexIterator::class)) {
            return new RegexIteratorParser($this->content);
        } else {
            return new TextParser($this->content);
        }
    }
}