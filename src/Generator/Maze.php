<?php
declare(strict_types = 1);
namespace derRest\Generator;

/**
 * Class Maze
 * @package derRest
 */
class Maze implements MazeInterface
{
    protected $cells = array();
    protected $walls = array();
    protected $eqClasses = array();
    protected $remainingClasses = 0;
    protected $xCoordinate = 0;
    protected $yCoordinate = 0;
    protected $cellCount = 0;
    protected $wallCount = 0;
    protected $candyCount = 10;
    protected $counter = 0;

    /**
     * __construct()
     *
     * Class constructor. This sets the height and width of the maze then calls
     * buildBaseMaze() to initialize the arrays.
     *
     * @param int $xCoordinate The width of the maze to generate; defaults to DEFAULT_MAZE_WIDTH
     * @param int $yCoordinate The height of the maze to generate; defaults to DEFAULT_MAZE_HEIGHT
     * @param int $candyCount The count of the candies to generate; defaults to DEFAULT_CANDY_AMOUNT
     */
    public function __construct(int $xCoordinate = self::DEFAULT_MAZE_WIDTH, int $yCoordinate = self::DEFAULT_MAZE_HEIGHT, int $candyCount = self::DEFAULT_CANDY_AMOUNT)
    {
        if (($xCoordinate % 2) === 0 || ($yCoordinate % 2) === 0 || $xCoordinate <= 0 || $yCoordinate <= 0) {
            throw new \InvalidArgumentException("x AND y only odd numbers above 0 are allowed");
        }
        if ($candyCount < 0) {
            throw new \InvalidArgumentException("candyCount must be positive");
        }
        $this->xCoordinate = (int)($xCoordinate / 2);
        $this->yCoordinate = (int)($yCoordinate / 2);
        $this->candyCount = $candyCount;

        $this->buildBaseMaze();
    }


    /**
     * generate()
     *
     * Magic! This method uses the union/find algorithm to determine whether
     * two adjacent rooms are in the same set. If they are not, it performs
     * a union by knocking out the wall between them. Once all cells in the
     * maze are in the same set, the maze is complete and there exists a
     * path from every cell in the maze to every other cell.
     *
     * @return self
     */
    public function generate():self
    {
        while ($this->disjointCellsExist()) {
            $cell = $this->getRandomCell();
            $wall = $this->getRandomInnerWall($cell);
            $neighor = $this->getNeighboringCell($cell, $wall);

            if (!$this->checkConnected($cell, $neighor)) {
                $this->removeWall($wall);
                $this->connect($cell, $neighor);
            }
        }
        return $this;
    }


    /**
     * @return array
     */
    public function getMaze():array
    {
        $result = [];
        // Each row is 2 character lines high, including top border, then add 1 for
        // bottom border of the maze
        $printRows = (2 * $this->yCoordinate) + 1;

        $currWall = 0;
        for ($iFor = 0; $iFor < $printRows; $iFor++) {
            $tmp = [];
            if ($iFor % 2 == 0) {
                // Printing a top border
                for ($jFor = 0; $jFor < $this->xCoordinate; $jFor++) {
                    // Top-left corner does not need top-left divider; needs a space
                    // to line everything up, though.
                    $tmp[] = static::WALL;
                    $tmp[] = getWallType($currWall++);
                }
                // Bottom-right corner does not need bottom-right divider
                $tmp[] = $iFor != ($printRows - 1) ? static::WALL : static::WHITE_SPACE;
            } else {
                // Printing the cell itself
                for ($jFor = 0; $jFor < $this->xCoordinate; $jFor++) {
                    $tmp[] = getWallType($currWall++);
                    $tmp[] = static::WHITE_SPACE;
                }
                // Print the right wall if needed
                $tmp[] = getWallType($currWall++);
            }
            $result[] = $tmp;
        }
        $result[0][0] = $result[0][1] = $result[1][0] = static::WALL;
        $this->checkCandyMax($result);
        while ($this->counter < $this->candyCount) {
            $rand1 = rand(0, count($result) - 1);
            $rand2 = rand(0, count($result[0]) - 1);
            if ($result[$rand1][$rand2] == 0) {
                $result[$rand1][$rand2] = 2;
                $this->counter++;
            }
        }
        return $result;
    }

    /**
     * 
     * @param int $currentWall 
     * @return int
     */
    protected function getWallType($currentWall):int {
        return $this->walls[$currentWall] == 1 ? static::WALL : static::WHITE_SPACE;
    }

    protected function checkCandyMax(array $maze){
        $count = 0;
        foreach ($maze as $mazeLine){
            foreach ($mazeLine as $cell){
                if($cell === static::WHITE_SPACE){
                    $count++;
                }
            }
        }
        if ($count < $this->candyCount){
            $this->candyCount = $count;
        }
    }


    /**
     * buildBaseMaze()
     *
     * Initializes the grid of cells/rooms in the maze. To start, all cells
     * are in their own equivalence class. Also initializes all walls as
     * visible. Finally, knock out the walls in the upper-left and
     * bottom-right corners.
     *
     * @return self
     */
    protected function buildBaseMaze():self
    {
        $this->cellCount = $this->xCoordinate * $this->yCoordinate;
        $this->wallCount = ($this->xCoordinate * ($this->yCoordinate + 1)) 
            + ($this->yCoordinate * ($this->xCoordinate + 1));
        $this->remainingClasses = $this->cellCount;

        // Set all the walls to be on to start
        for ($iFor = 0; $iFor < $this->wallCount; $iFor++) {
            $this->walls[$iFor] = 1;
        }

        // Initialize the cells to be independent of one another
        for ($iFor = 0; $iFor < $this->cellCount; $iFor++) {
            $this->cells[$iFor] = ['idx' => $iFor, 'parent' => NULL,];
            $this->eqClasses[$iFor] = $iFor;
        }

        // Remove top-left corner walls
        $this->removeWall(0);
        $this->removeWall($this->xCoordinate);

        // Remove bottom-right corner walls
        $this->removeWall($this->wallCount - ($this->xCoordinate + 1));
        $this->removeWall($this->wallCount - 1);
        return $this;
    }


    /**
     * checkConnected()
     *
     * The find portion of the union/find algorithm, this checks whether the
     * specified cells have the same equivalence class (i.e. whether they)
     * are connected within the maze.
     *
     * @param array $classOne
     * @param array $classTwo
     * @return bool Whether two cells have the same equivalence class.
     */
    protected function checkConnected(array $classOne, array $classTwo):bool
    {
        return $this->eqClasses[$classOne['idx']] == $this->eqClasses[$classTwo['idx']];
    }


    /**
     * connect()
     *
     * Using the union portion of the union/find algorithm, this method
     * connects two cells/rooms in the maze. It gets the equivalence class
     * of classOne and sets classTwo's parent to classOne's root parent. It then sets the
     * equivalence class of all cells that matched classTwo's old class to equal
     * classOne's equivalence class.
     *
     * @param array $classOne
     * @param array $classTwo
     * @return self
     */
    protected function connect(array $classOne, array $classTwo):self
    {
        // The root parent of classOne is its equivalence class.
        $temp1 = $this->cells[$this->eqClasses[$classOne['idx']]];
        $temp1['parent'] = $classTwo['idx'];

        $oldClass = $this->eqClasses[$temp1['idx']];
        $newClass = $this->eqClasses[$classTwo['idx']];

        for ($iFor = 0; $iFor < $this->cellCount; $iFor++) {
            if ($this->eqClasses[$iFor] == $oldClass) {
                $this->eqClasses[$iFor] = $newClass;
            }
        }

        $this->remainingClasses--;
        return $this;
    }


    /**
     * removeWall()
     *
     * Set the specified wall to invisible.
     *
     * @param int $idx
     * @return self
     */
    protected function removeWall(int $idx):self
    {
        $this->walls[$idx] = 0;
        return $this;
    }


    /**
     * getRandomCell()
     *
     * Pick a cell at random within the maze. This is the first step during
     * the generation process.
     *
     * @return array A random cell in the maze.
     */
    protected function getRandomCell():array
    {
        $idx = rand(0, $this->cellCount - 1);
        return $this->cells[$idx];
    }


    /**
     * getRandomInnerWall()
     *
     * Given a particular cell/room in the maze, pick one of its inner walls
     * at random. An inner wall is one that is adjacent to another cell/room
     * in the maze and not part of the outer border of the overall grid.
     *
     * @param array $cell
     * @return int The index of a random inner wall adjacent to the room.
     * @throws \Exception
     */
    protected function getRandomInnerWall(array $cell):int
    {
        // Determine which row the cell is in
        $row = floor($cell['idx'] / $this->xCoordinate);
        // Wall index for the north
        $northX = (int)($cell['idx'] + ($row * $this->xCoordinate) + $row);
        while (true) {
            switch (rand(1, 4)) {
                case 1:
                    if (!$cell['idx'] < $this->xCoordinate) {
                        return $northX;
                    }
                case 2:
                    if (!$cell['idx'] >= ($this->cellCount - $this->xCoordinate)) {
                        return $northX + $this->xCoordinate; // west
                    }
                case 3:
                    if (!$cell['idx'] % $this->xCoordinate == ($this->xCoordinate - 1)) {
                        return $northX + $this->xCoordinate + 1; // east
                    }
                case 4:
                    if (!$cell['idx'] % $this->xCoordinate == 0) {
                        return $northX + (2 * $this->xCoordinate) + 1; // south
                    }
            }
        }
        throw new \Exception('internal error');
    }


    /**
     * getNeighboringCell()
     *
     * Given a cell and a wall, this method determines which room is on the
     * other side of said wall.
     *
     * @param array $c
     * @param int $wall
     * @return array Returns a pointer to the cell on the other side of the
     *               wall.
     * @throws \Exception
     */
    protected function getNeighboringCell(array $cell, int $wall):array
    {
        // Determine which row the cell is in
        $row = floor($cell['idx'] / $this->xCoordinate);

        // Wall index for north
        $north = $cell['idx'] + ($row * $this->xCoordinate) + $row;

        switch ($wall) {
            case ($north):
                return $this->cells[$cell['idx'] - $this->xCoordinate]; // north
            case ($north + $this->xCoordinate):
                return $this->cells[$cell['idx'] - 1]; // west
            case ($north + $this->xCoordinate + 1):
                return $this->cells[$cell['idx'] + 1]; // east
            case ($north + (2 * $this->xCoordinate) + 1):
                return $this->cells[$cell['idx'] + $this->xCoordinate]; // south
        }

        throw new \Exception('Internal Error');
    }


    /**
     * disjointCellsExist()
     *
     * This method checks how many equivalence classes remain. The number of
     * equivalence classes represents how many disjoint sets of cells there
     * are. Initially it is equal to the number of cells in the maze. Each
     * time a wall is knocked out, two sets become connected, so the total
     * number of disjoint sets is reduced by one. Once the number of sets
     * reaches 1, it means that all cells in the maze are connected to all
     * other cells by at least one path.
     *
     * @return bool Whether any disjoint cells still exist
     */
    protected function disjointCellsExist():bool
    {
        return $this->remainingClasses > 1;
    }

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