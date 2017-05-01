<?php
declare(strict_types=1);

namespace App\Parsers;

class Converter
{
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
        } else if (extension_loaded('mbstring')) {
            return new StrParser($this->content);
        } else {
            return new TextParser($this->content);
        }
    }
}