<?php
require "vendor/autoload.php";

if(file_exists(\derRest\Database\DatabaseConnection::DATABASE_FILE)){
    unlink(\derRest\Database\DatabaseConnection::DATABASE_FILE);
}
if(file_exists(\derRest\Database\DatabaseConnection::INITIAL_DATABASE_FILE)){
    unlink(\derRest\Database\DatabaseConnection::INITIAL_DATABASE_FILE);
}
$db = new medoo([
    'database_type' => 'sqlite',
    'database_file' => \derRest\Database\DatabaseConnection::INITIAL_DATABASE_FILE
]);
$db->query(
    'CREATE TABLE highscore ' .
    '( ' .
    'name TEXT, ' .
    'score INTEGER, ' .
    'level INTEGER, ' .
    'elapsedTime INTEGER, ' .
    'timestamp INTEGER ' .
    ') '
);
$db->insert('highscore', [
    'name' => 'A',
    'score' => 1000,
    'level' => 10,
    'elapsedTime' => 120,
    'timestamp' => 1475762432,
]);
$db->insert('highscore', [
    'name' => 'B',
    'score' => 500,
    'level' => 5,
    'elapsedTime' => 240,
    'timestamp' => 1475762431,
]);
$db->insert('highscore', [
    'name' => 'C',
    'score' => 250,
    'level' => 2,
    'elapsedTime' => 300,
    'timestamp' => 1475762430,
]);
$db->insert('highscore', [
    'name' => 'D',
    'score' => 100,
    'level' => 1,
    'elapsedTime' => 500,
    'timestamp' => 1475762429,
]);
