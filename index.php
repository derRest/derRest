<?php
require_once 'src/Maze.php';

$x = Maze::DEFAULT_MAZE_WIDTH;
$y = Maze::DEFAULT_MAZE_HEIGHT;

if (!empty($_GET['x']) && is_numeric($_GET['x'])) {
    $x = $_GET['x'];
}
if (!empty($_GET['y']) && is_numeric($_GET['y'])) {
    $y = $_GET['y'];
}
$m = new Maze((int) $x, (int) $y);

$m->generate();

echo json_encode($m->getMaze());

