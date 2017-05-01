<?php
declare(strict_types=1);

namespace App\Parsers;

use Illuminate\Support\Collection;

interface ParserInterface
{
    /**
     * Get results.
     *
     * @return Collection
     */
    public function getResult(): Collection;

    /**
     * Parse input source.
     *
     * @return \App\Parsers\ParserInterface
     */
    public function parse():self;
}