<?php
declare(strict_types=1);

namespace App\Parsers;

interface ParserInterface
{
    /**
     * Get results.
     *
     * @param int $type
     *
     * @return iterable
     */
    public function getResult(int $type): iterable;

    /**
     * Parse input source.
     *
     * @return \App\Parsers\ParserInterface
     */
    public function parse():self;
}