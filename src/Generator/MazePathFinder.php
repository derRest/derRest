<?php
declare(strict_types = 1);
namespace derRest\Generator;

/**
* pathfinder class for maze
* @package derRest
*/
class MazePathFinder extends MazeSolver
{
    private $distance;
    /**
     * Determines the shortest path through the labyrinth.
     * This works by iterating through all calculated distances within the labyrinth
     * until the starting point is reached
     * 
     * @param array $startingPoint set the point from where to calculate the best path
     * @param array $maze maze-array with calculated distances
     * @param array $visitedLocations array with all visited locations
     * @return bool|array returns either false if no path could be found 
     * or an array over the best x and y coordinates
     */
    public function getShortestPath(array $startingPoint, array $maze, array $visitedLocations) {
        if (!$this->isValid($maze)) return false;
        $bestxy = $startingPoint;
        $path = [];
        $this->distance = $maze[$bestxy[0]][$bestxy[1]];
        while ($this->distance !== 3) {
            $bestxy = $this->getBestCoordinate($bestxy[0], $bestxy[1], $maze, $visitedLocations);
            $path[] = $bestxy;
        }
        return $path;
    }

    /**
     * this method returns the best neighbor of a given coordinate.
     * It checks all four surrounding cells and returns the one
     * with the smallest distance to a calculated point
     * 
     * @param int $xcoord x coordinate
     * @param int $ycoord y coordinate
     * @param array $maze maze with calculated distances
     * @param array $visitedLocations array with all visited locations
     * @return array the best xy-coordinate
     */
    public function getBestCoordinate(int $xcoord,int $ycoord, array $maze, array $visitedLocations): array {
        $tmpcoord = [$xcoord, $ycoord];
        foreach ($this->getDirectionValues() as $dir) {
            $tmpx = $xcoord+$dir[0];
            $tmpy = $ycoord+$dir[1];
            if (in_array($tmpx.":".$tmpy, $visitedLocations)) {
                $tmpdis = $maze[$tmpx][$tmpy];
                $tmpdis = $tmpdis < $this->distance ? $tmpdis : $this->distance;
                if ($tmpdis < $this->distance) {
                    $this->distance = $tmpdis;
                    $tmpcoord = [$tmpx, $tmpy];
                }
            }
        }
        return $tmpcoord;
    }
}
