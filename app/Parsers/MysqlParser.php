<?php
declare(strict_types=1);

namespace App\Parsers;

use Illuminate\Container\Container;
use Illuminate\Database\Connection;
use Illuminate\Foundation\Application;
use Illuminate\Support\Collection;

class MysqlParser implements ParserInterface
{
    /**
     * @var string
     */
    private $content;

    /**
     * @var string
     */
    private $regex;

    /**
     * @var \Illuminate\Support\Collection
     */
    private $result;

    /**
     * MysqlParser constructor.
     *
     * @param string $content
     * @param string $regex
     */
    public function __construct(string $content, string $regex = '/(?<={)[+-]?[0-9]+(?=})/')
    {
        $this->content = $content;
        $this->regex = $regex;
        $this->result = new Collection();
    }

    /**
     * Get results array or Iterator.
     *
     * @return Collection
     */
    public function getResult(): Collection
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
        $db = Application::getInstance()->make(Connection::class);
        $db->unprepared("SET NAMES 'utf8';SET CHARACTER SET 'utf8';");
        $data = $db->selectOne("select preg(?, ?) as data", [$this->content, $this->regex]);

        $preparedData = ltrim($data->data, '#');

        $token = strtok($preparedData, "#");
        while ($token !== false) {
            $this->result->push(ltrim($token, '+'));
            $token = strtok('#');
        }

        return $this;
    }
}