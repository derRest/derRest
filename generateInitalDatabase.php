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
    'score' => 20,
    'level' => 1,
    'elapsedTime' => 15,
    'timestamp' => 1475762432,
]);
$db->insert('highscore', [
    'name' => 'B',
    'score' => 17,
    'level' => 1,
    'elapsedTime' => 24,
    'timestamp' => 1475762431,
]);
$db->insert('highscore', [
    'name' => 'C',
    'score' => 10,
    'level' => 1,
    'elapsedTime' => 31,
    'timestamp' => 1475762430,
]);
$db->insert('highscore', [
    'name' => 'D',
    'score' => 9,
    'level' => 1,
    'elapsedTime' => 39,
    'timestamp' => 1475762429,
]);
