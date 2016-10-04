<?php 

$world = 'World';
if (!is_null($_GET["name"])) {
    $world = $_GET["name"];	
}

echo 'Hello ' . strtolower($world) . '!';

echo '<br>';
echo phpversion();
