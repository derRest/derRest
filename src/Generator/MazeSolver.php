<?php

namespace derRest\Generator;

/**
 * Class MazeSolver
 * @package derRest
 */
class MazeSolver {
	private $sizex;
	private $sizey;
	private $maze;
	private $visitedLocations = [];
	private $mazeDistanced;
	private $stack = [];

	public function __construct($sizex, $sizey, $candies, $maze = null) {
		if (is_null($maze)) {
			$maze = new Maze($sizey, $sizex, $candies);
			$maze = $maze->generate()->getMaze();
		}
		$this->setMaze($maze);
		$this->goThroughMaze();
	}

	public function setMaze($maze) {
		$this->maze = $maze;
		$this->mazeDistanced = $this->maze;
		$this->sizex = count($maze);
		$this->sizey = count($maze[0]);
	}

	/**
	 * @param int $xcoord starting point X, default is 1
	 * @param int $ycoord starting point Y, default is 1
	 */
	public function goThroughMaze($xcoord = 1, $ycoord = 1) {
		$this->stack[] = [$xcoord, $ycoord];
		while ($coord = array_shift($this->stack)) {
			$xcoord = $coord[0];
			$ycoord = $coord[1];
			if (in_array($xcoord.":".$ycoord, $this->visitedLocations)) {
				continue;
			}
			$this->visitedLocations[] = $xcoord.":".$ycoord;
			$neighbours = $this->getNeighbours($xcoord, $ycoord);
			$distance = [];
			foreach ($neighbours as $value) {
				if ($value == 'w') {
					$posval = $this->mazeDistanced[$xcoord-1][$ycoord];
					if ($posval == 0 || $posval == 2) {
						$this->stack[] = [$xcoord-1, $ycoord];
					}
					if ($posval >= 3) {
						$distance[] = $posval;
					}
				}
				if ($value == 'e') {
					$posval = $this->mazeDistanced[$xcoord+1][$ycoord];
					if ($posval == 0 || $posval == 2) {
						$this->stack[] = [$xcoord+1, $ycoord];
					}
					if ($posval >= 3) {
						$distance[] = $posval;
					}
				}
				if ($value == 's') {
					$posval = $this->mazeDistanced[$xcoord][$ycoord+1];
					if ($posval == 0 || $posval == 2) {
						$this->stack[] = [$xcoord, $ycoord+1];
					}
					if ($posval >= 3) {
						$distance[] = $posval;
					}
				}
				if ($value == 'n') {
					$posval = $this->mazeDistanced[$xcoord][$ycoord-1];
					if ($posval == 0 || $posval == 2) {
						$this->stack[] = [$xcoord, $ycoord-1];
					}
					if ($posval >= 3) {
						$distance[] = $posval;
					}
				}
			}
			$thisvalue = isset($distance[0]) ? $distance[0] : 2;
			foreach ($distance as $value) {
			 	if ($value < $thisvalue)
			 		$thisvalue = $value;
			}
			$this->mazeDistanced[$xcoord][$ycoord] = ++$thisvalue;
		}
	}

	/**
	 * Gets all possible neighours of a point
	 * @param int $xcoord x coordinate of that point
	 * @param int $ycoord y coordinate of that point
	 * @return array possible directions (west, east, south and north)
	 */
	public function getNeighbours($xcoord, $ycoord) {
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

	/**
	 * checks whether the maze is solvable or not
	 * @return bool valid or not valid, that is here the question
	 */
	public function isValid() {
		return $this->mazeDistanced[$this->sizex-1][$this->sizey-1] > 2 ? true : false;
	}

	/**
	 * Determines the shortest path through the labyrinth
	 * @return bool|array returns either false if no path could be found 
	 * or an array over the best x and y coordinates
	 */
	public function getShortestPath() {
		if (!$this->isValid()) return false;
		$bestxy = [
			$this->sizex-1,
			$this->sizey-1,
		];
		$path = [];
		$distance = $this->mazeDistanced[$bestxy[0]][$bestxy[1]];
		while ($distance != 3) {
			$tmpcoord = $bestxy;
			if (in_array(($bestxy[0]-1).":".$bestxy[1], $this->visitedLocations)) {
				$tmpdis = $this->mazeDistanced[($bestxy[0]-1)][$bestxy[1]];
				$tmpdis = $tmpdis < $distance ? $tmpdis : $distance;
				if ($tmpdis < $distance) {
					$distance = $tmpdis;
					$tmpcoord = [($bestxy[0]-1), $bestxy[1]];
				}
			}
			if (in_array(($bestxy[0]+1).":".$bestxy[1], $this->visitedLocations)) {
				$tmpdis = $this->mazeDistanced[($bestxy[0]+1)][$bestxy[1]];
				if ($tmpdis < $distance) {
					$distance = $tmpdis;
					$tmpcoord = [($bestxy[0]+1), $bestxy[1]];
				}	
			}
			if (in_array($bestxy[0].":".($bestxy[1]-1), $this->visitedLocations)) {
				$tmpdis = $this->mazeDistanced[$bestxy[0]][($bestxy[1]-1)];
				if ($tmpdis < $distance) {
					$distance = $tmpdis;
					$tmpcoord = [$bestxy[0], ($bestxy[1]-1)];
				}
			}
			if (in_array($bestxy[0].":".($bestxy[1]+1), $this->visitedLocations)) {
				$tmpdis = $this->mazeDistanced[$bestxy[0]][($bestxy[1]+1)];
				if ($tmpdis < $distance) {
					$distance = $tmpdis;
					$tmpcoord = [$bestxy[0], ($bestxy[1]+1)];
				}
			}
			$bestxy = $tmpcoord;
			$path[] = $bestxy;
		}
		return $path;
	}

	public function printMazeSolution() {
		$pathbool = $this->drawPathIntoMaze();
		foreach ($this->mazeDistanced as $key => $value) {
			foreach ($value as $key2 => $value2) {
				$print = $value2;
				if (is_int($value2) && $value2 > 2 && $pathbool)
					$print = " ";
				if ($value2 == '*')
					$print = "*";
				if ($value2 == 1)
					$print = "#";
				echo $print;
			}
			echo "\n";
		}
	}

	public function drawPathIntoMaze() {
		$path = $this->getShortestPath();
		if ($path === false) return false;
		foreach ($path as $coord) {
			$this->mazeDistanced[$coord[0]][$coord[1]] = "*";
		}
		return true;
	}
}
