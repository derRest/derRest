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

    public function numToSymbol($num) {
        $symbols = [
            MazeInterface::WHITE_SPACE => ' ',
            MazeInterface::WALL => '#',
            MazeInterface::CANDY => 'o',
            MazeInterface::PATH => '*',
        ];
        return $symbols[$num];
    }

    public function printToCli(array $maze): string
    {
        $print = "";
        foreach ($maze as $mazeLine) {
            foreach ($mazeLine as $item) {
                $print .= $this->numToSymbol($item);
            }
            $print .= '\n';
        }
        return $print;
    }

    public function printMazeSolution(array $maze, array $path = null): string {
        if (!is_null($path)) {
            $maze = $this->drawPathIntoMaze($path, $maze);
        }
        $print = "";
        foreach ($maze as $value) {
            foreach ($value as $value2) {
                $symbol = $value2;
                if (is_int($value2) && $value2 > 2) {
                    $symbol = $this->numToSymbol(0);
                }
                if ($value2 == '*') {
                    $symbol = $this->numToSymbol(3);
                }
                if ($value2 == 1) {
                    $symbol = $this->numToSymbol($value2);
                }
                $print .= $symbol;
            }
            $print .= "\n";
        }
        return $print;
    }

    public function drawPathIntoMaze($path, array $maze): array {
        if ($path === false) return [];
        foreach ($path as $coord) {
            $maze[$coord[0]][$coord[1]] = $this->numToSymbol(3);
        }
        return $maze;
    }
}
