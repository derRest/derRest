<?php
require_once 'src/Maze.php';

$x = Maze::DEFAULT_MAZE_WIDTH;
$y = Maze::DEFAULT_MAZE_HEIGHT;
$candyCount = Maze::DEFAULT_CANDY_AMOUNT;

if (!empty($_GET['x']) && is_numeric($_GET['x'])) {
    $x = $_GET['x'];
}
if (!empty($_GET['y']) && is_numeric($_GET['y'])) {
    $y = $_GET['y'];
}

if (!empty($_GET['candyCount']) && is_numeric($_GET['candyCount'])) {
    $candyCount = $_GET['candyCount'];
}
$m = new Maze((int) $x, (int) $y, (int) $candyCount);

$m->generate();

echo json_encode($m->getMaze());

