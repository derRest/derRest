<?php 

$world = 'Server';
if (isset($_GET["name"])) {
    $world = $_GET["name"];	
}

echo 'Hello ' . strtolower($world) . '!';

echo '<br>';
echo '<br>';
echo phpversion();

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
echo '<pre>';

$start = getTime();
$m->generate();
$finish = getTime();
$total_time = round(($finish - $start), 4);

$m->display();
echo '</pre>';
echo '<p>This ' . $x . 'x' . $y . ' maze was generated in ' . $total_time . ' seconds.</p>';

function getTime()
{
    $time = explode(' ', microtime());
    $time = $time[1] + $time[0];
    return $time;
} //end getTime

?>
<html>
<head>
<title>Some Page</title>
</head>
</html>
