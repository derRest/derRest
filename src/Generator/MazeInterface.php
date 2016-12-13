<?php
namespace derRest\Generator;

use derRest\Generator;

/**
 * Interface MazeInterface
 * @package derRest
 */
interface MazeInterface
{
    const WHITE_SPACE = 0;
    const WALL = 1;
    const CANDY = 2;
    const PATH = 3;

    const DEFAULT_MAZE_HEIGHT = 15;
    const DEFAULT_MAZE_WIDTH = 15;
    const DEFAULT_CANDY_AMOUNT = 10;


    /**
     * __construct()
     *
     * Set Settings for the Maze
     *
     * @param int $x The width of the maze to generate; defaults to DEFAULT_MAZE_WIDTH
     * @param int $y The height of the maze to generate; defaults to DEFAULT_MAZE_HEIGHT
     * @param int $candyCount The count of the candies to generate; defaults to DEFAULT_CANDY_AMOUNT
     */
    public function __construct(int $x = self::DEFAULT_MAZE_WIDTH, int $y = self::DEFAULT_MAZE_HEIGHT, int $candyCount = self::DEFAULT_CANDY_AMOUNT);

    /**
     * generate()
     *
     * generate the maze
     *
     * @return \derRest\Generator\Maze
     */
    public function generate(): Generator\Maze;

    /**
     * getMaze()
     *
     * get the generated Maze as Array
     *
     * @return array
     */
    public function getMaze(): array;
}