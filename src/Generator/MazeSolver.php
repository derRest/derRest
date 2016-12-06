<?php

namespace derRest\Generator;

/**
 * Class MazeSolver
 * @package derRest
 */
class MazeSolver {
    protected $sizex;
    protected $sizey;
    protected $maze;
    protected $visitedLocations = [];
    protected $mazeDistanced;
    protected $stack = [];

    /**
     *  
     * @param int $sizex labyrinth width
     * @param int $sizey labyrinth height
     * @param int $candies candies within the labyrinth
     */
    public function __construct(int $sizex, int $sizey, int $candies, array $maze = null) {
        if (is_null($maze)) {
            $maze = new Maze($sizey, $sizex, $candies);
            $maze = $maze->generate()->getMaze();
        }
        $this->setMaze($maze);
        $this->calculateAllPaths([1,1]);
    }

    public function calculateAllPaths($startingPoint) {
        $this->goThroughMaze($startingPoint[0], $startingPoint[1]);
    }

    public function getMazeWidth(array $maze = null): int {
        return is_null($maze) ? $this->sizex-1 : count($maze)-1;
    }

    public function getMazeHeight(array $maze = null): int {
        return is_null($maze) ? $this->sizey-1 : count($maze[0])-1;
    }

    public function setMaze(array $maze) {
        $this->maze = $maze;
        $this->sizex = count($maze);
        $this->sizey = count($maze[0]);
    }

    public function getMaze(): array {
        return $this->maze;
    }

    public function getCalculatedMazes() {
        return $this->mazeDistanced;
    }

    /**
     * @param int $xcoord starting point X, default is 1
     * @param int $ycoord starting point Y, default is 1
     */
    public function goThroughMaze($xcoord = 1, $ycoord = 1) {
        $this->stack[] = [$xcoord, $ycoord];
        $mazeDistanceCalc = $this->maze;
        $visitedLocations = [];
        while ($coord = array_shift($this->stack)) {
            $xcoord = $coord[0];
            $ycoord = $coord[1];
            if (in_array($xcoord.":".$ycoord, $visitedLocations)) {
                continue;
            }
            $visitedLocations[] = $xcoord.":".$ycoord;
            $neighbours = $this->getNeighbours($xcoord, $ycoord);
            $distance = [];
            foreach ($neighbours as $value) {
                $direction = $this->mapDirectionToValue($value);
                $tmpx = $xcoord + $direction[0];
                $tmpy = $ycoord + $direction[1];
                $posval = $mazeDistanceCalc[$tmpx][$tmpy];
                if ($posval == 0 || $posval == 2) {
                    $this->stack[] = [$tmpx, $tmpy];
                }
                if ($posval >= 3) {
                    $distance[] = $posval;
                }
            }
            $thisvalue = isset($distance[0]) ? $distance[0] : 2;
            foreach ($distance as $value) {
                if ($value < $thisvalue)
                    $thisvalue = $value;
            }
            $mazeDistanceCalc[$xcoord][$ycoord] = ++$thisvalue;
        }
        $this->mazeDistanced[] = [
            "distance" => $mazeDistanceCalc,
            "locations" => $visitedLocations,
        ];

    }

    public function getDirectionValues(): array {
        return [
            "w" => [-1, 0],
            "e" => [1, 0],
            "s" => [0, 1],
            "n" => [0, -1],
        ];
    }

    public function mapDirectionToValue(string $direction): array {
        return $this->getDirectionValues()[$direction];
    }

    /**
     * Gets all possible neighours of a point
     * @param int $xcoord x coordinate of that point
     * @param int $ycoord y coordinate of that point
     * @return array possible directions (west, east, south and north)
     */
    public function getNeighbours(int $xcoord, int $ycoord) {
        $result = [];
        if (($xcoord-1) >= 0) {
            $result["w"] = $this->maze[($xcoord-1)][$ycoord];
        }
        if (($xcoord+1) < $this->sizex) {
            $result["e"] = $this->maze[($xcoord+1)][$ycoord];   
        }
        if (($ycoord-1) >= 0) {
            $result["n"] = $this->maze[$xcoord][($ycoord-1)];
        }
        if (($ycoord+1) < $this->sizey) {
            $result["s"] = $this->maze[$xcoord][($ycoord+1)];
        }
        $neighbours = [];
        foreach ($result as $key => $neighbour) {
            if ($neighbour == 0 || $neighbour == 2) {
                $neighbours[] = $key;
            }
        }
        return $neighbours;
    }

    public function validateMazes(): bool {
        foreach ($this->mazeDistanced as $maze) {
            if (!$this->isValid($maze["distance"])) {
                return false;
            }
        } 
        return true;
    }

    /**
     * checks whether the maze is solvable or not
     * @param array $maze maze with calculated distances
     * @return bool valid or not valid, that is here the question
     */
    public function isValid(array $maze): bool {
        return $maze[
                $this->getMazeWidth($maze)
            ][
                $this->getMazeHeight($maze)
            ] > 2 ? true : false;
    }
}
