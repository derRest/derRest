<?php
declare(strict_types = 1);
namespace derRest\Database;

class Highscore
{   
    public function getHighscore($limit) {
        return (new DatabaseConnection)->select('highscore', '*', [
            'ORDER' => ['score' => 'DESC'],
            'LIMIT' => $limit
        ]);
    }

    public function addHighscore($json) {
    	(new DatabaseConnection)->insert('highscore', [
            'name' => $json->name,
            'score' => $json->score,
            'level' => $json->level,
            'elapsedTime' => $json->elapsedTime,
            'timestamp' => time(),
        ]);
    }
}