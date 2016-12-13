<?php

namespace Kanti;

use derRest\Generator\MazePrinter;
use derRest\Generator\Maze;

require "vendor/autoload.php";

MazePrinter::printToCli((new Maze(7, 7, 2))->generate()->getMaze());
MazePrinter::printToCli((new Maze(13, 7, 2))->generate()->getMaze());
MazePrinter::printToCli((new Maze(27, 43, 19))->generate()->getMaze());