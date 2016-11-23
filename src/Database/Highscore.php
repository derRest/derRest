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
            'name' => htmlspecialchars($json->name),
            'score' => (int) $json->score,
            'level' => (int) $json->level,
            'elapsedTime' => (float) $json->elapsedTime,
            'timestamp' => time(),
        ]);
    }
}
