<?php 

$world = 'World';
if (isset($_GET["name"])) {
    $world = $_GET["name"];	
}

echo 'Hello ' . strtolower($world) . '!';

echo '<br>';
echo '<br>';
echo phpversion();
