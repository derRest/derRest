<?php
declare(strict_types = 1);
namespace derRest\Generator;

/**
 * Class MazePrinter
 * @package derRest
 */

class MazePrinter
{
    public static function printToCli(array $mazeArray)
    {
        $symbols = [
            MazeInterface::WHITE_SPACE => ' ',
            MazeInterface::WALL => '#',
            MazeInterface::CANDY => 'o',
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