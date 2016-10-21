<?php

namespace Kanti;

use derRest\Generator\Maze;

require "vendor/autoload.php";

Maze::printToCli((new Maze(7, 7, 2))->generate()->getMaze());
Maze::printToCli((new Maze(13, 7, 2))->generate()->getMaze());