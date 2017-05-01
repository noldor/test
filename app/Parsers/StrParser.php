<?php
declare(strict_types=1);

namespace App\Parsers;

use Illuminate\Support\Collection;

class StrParser implements ParserInterface
{
    /**
     * @var string
     */
    private $content;

    /**
     * Object with all values.
     *
     * @var Collection
     */
    private $result;

    /**
     * Open tag.
     *
     * @var string
     */
    private $openTag;

    /**
     * Close tag.
     *
     * @var string
     */
    private $closeTag;

    /**
     * Allowed chars.
     *
     * @var string
     */
    private $goodChars = '+-1234567890';

    /**
     * StrParser constructor.
     *
     * @param string $content
     * @param string $openTag
     * @param string $closeTag
     */
    public function __construct(string $content, string $openTag = '{', string $closeTag = '}')
    {
        $this->content = $content;
        $this->openTag = $openTag;
        $this->closeTag = $closeTag;
        $this->result = new Collection();
    }

    /**
     * Parse content and find needles.
     *
     * @return \App\Parsers\ParserInterface
     */
    public function parse(): ParserInterface
    {
        $string = $this->content;
        while ($string !== false) {
            $start = mb_stripos($string, $this->openTag, 0, 'UTF-8') + 1;
            $end = mb_stripos($string, $this->closeTag, 0, 'UTF-8');
            $length = mb_strlen($string, 'UTF-8');

            if ($start === false || $end === false) {
                break;
            }

            if ($start > $end) {
                $string = mb_substr($string, $start - 1, $length - $start, 'UTF-8');
                continue;
            }

            $interval = mb_substr($string, $start, $end - $start, 'UTF-8');

            if (mb_stripos($interval, $this->openTag, 0, 'UTF-8') !== false) {
                $string = mb_substr($string, $start + 1, $length - $end, 'UTF-8');
                continue;
            }

            $nextChar = mb_substr($string, $start, 1, 'UTF-8');

            if (!$this->filterChar($nextChar)) {
                $string = mb_substr($string, $end, $length - $end, 'UTF-8');
                continue;
            }

            $needle = mb_substr($string, $start, $end - $start, 'UTF-8');

            $this->buildElement($needle);

            $string = mb_substr($string, $end, $length - $end, 'UTF-8');
        }

        return $this;
    }

    /**
     * Get all needles as array.
     *
     * @return Collection
     */
    public function getResult(): Collection
    {
        return clone $this->result;
    }

    /**
     * Make new element.
     *
     * @param $needle
     */
    private function buildElement($needle): void
    {
        $firstChar = mb_substr($needle, 0, 1, 'UTF-8');
        $otherChars = mb_substr($needle, 1, mb_strlen($needle, 'UTF-8'), 'UTF-8');

        if ($firstChar === '0' && empty($otherChars)) {
            $this->result->push('0');
        } else if (!empty($needle) && $this->filterChar($firstChar)) {
            if (ctype_digit($firstChar) && empty($otherChars)) {
                $this->result->push(ltrim($firstChar, '+'));
            } else if ((ctype_digit($otherChars))) {
                $this->result->push(ltrim($firstChar . $otherChars, '+'));
            }
        }
    }

    /**
     * Determine if char is allowed.
     *
     * @param string $char
     *
     * @return bool
     */
    private function filterChar(string $char): bool
    {
        return (mb_stripos($this->goodChars, $char, 0, 'UTF-8') !== false) ? true : false;
    }
}