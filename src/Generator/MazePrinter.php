<?php
declare(strict_types = 1);
namespace derRest\Generator;

/**
 * Class MazePrinter
 * @package derRest
 */
class MazePrinter
{
    const WHITE_SPACE = 0;
    const WALL = 1;
    const CANDY = 2;

    public static function printToCli(array $mazeArray)
    {
        $symbols = [
            static::WHITE_SPACE => ' ',
            static::WALL => '#',
            static::CANDY => 'o',
        ];

        echo PHP_EOL;
        foreach ($mazeArray as $mazeLine) {
            foreach ($mazeLine as $item) {
                echo $symbols[$item] . '';
            }
            echo PHP_EOL;
        }
    }
}