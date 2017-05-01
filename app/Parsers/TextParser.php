<?php
declare(strict_types=1);

namespace App\Parsers;

use Illuminate\Support\Collection;
use SplTempFileObject;

class TextParser implements ParserInterface
{
    /**
     * Const to determine plus sign.
     */
    private const PLUS = '+';

    /**
     * Const to determine minus sign.
     */
    private const MINUS = '-';

    /**
     * Const to set return type of results as array.
     */
    public const AS_ARRAY = 1;

    /**
     * Const to set return type of results as Iterator
     */
    public const AS_ITERATOR = 2;

    /**
     * Object with file.
     *
     * @var \SplFileObject
     */
    private $file;

    /**
     * Object with all values.
     *
     * @var Collection
     */
    private $result;

    /**
     * Current element that we build.
     *
     * @var null|string
     */
    private $currentElement = null;

    /**
     * Used to determine that we start build element.
     *
     * @var bool
     */
    private $isOpen;

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
     * Parser constructor.
     *
     * @param string $content
     * @param string $openTag  string to determine start of needle.
     * @param string $closeTag string to determine end of needle.
     */
    public function __construct(string $content, string $openTag = '{', string $closeTag = '}')
    {
        $this->file = new SplTempFileObject();
        // Write content to temporary file.
        $this->file->fwrite($content);
        // Go to beginning of file.
        $this->file->rewind();
        $this->result = new Collection();
        $this->openTag = $openTag;
        $this->closeTag = $closeTag;
    }

    /**
     * Get all needles as array.
     *
     * @return Collection
     */
    public function getResult():Collection
    {
        return clone $this->result;
    }

    /**
     * Parse content and find needles.
     *
     * @return \App\Parsers\ParserInterface
     */
    public function parse(): ParserInterface
    {
        // Set current char as empty string for first iteration.
        $char = '';

        while ($this->file->valid()) {
            if ($this->isOpenTag($char)) {
                $this->isOpen = true;
                // Move to next char, because we do not need open tag in element.
                $char = $this->file->fgetc();
            }

            if ($this->isCloseTag($char)) {
                $this->isOpen = false;
                $this->pushElement();
            }

            if ($this->isOpen) {
                $this->buildElement($char);
            }

            $char = $this->file->fgetc();
        }

        return $this;
    }

    /**
     * Push new element to result list and unset current element.
     *
     * @return void
     */
    private function pushElement(): void
    {
        if (!is_null($this->currentElement)) {
            $this->result->push(intval($this->currentElement));
            $this->currentElement = null;
        }
    }

    /**
     * Build new element after open tag.
     *
     * @param string $char
     *
     * @return void
     */
    private function buildElement(string $char): void
    {
        if (is_null($this->currentElement) && ($char === self::PLUS || $char === self::MINUS)) {
            $this->currentElement = $char;
        } else if (ctype_digit($char)) {
            $this->currentElement .= $char;
        } else {
            $this->isOpen = false;
            $this->currentElement = null;
        }
    }

    /**
     * @param string $char
     *
     * @return bool
     */
    private function isOpenTag(string $char): bool
    {
        return ($char === $this->openTag) ? true : false;
    }

    /**
     * Determine if current char is open tag
     *
     * @param $char
     *
     * @return bool
     */
    private function isCloseTag(string $char): bool
    {
        return ($char === $this->closeTag) ? true : false;
    }
}