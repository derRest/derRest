<?php
declare(strict_types = 1);
namespace derRest\Database;

class Highscore
{
    /**
     * @var DatabaseConnection
     */
    protected $databaseConnection;

    public function __construct(DatabaseConnection $databaseConnection = null)
    {
        $this->databaseConnection = $databaseConnection;
        if ($this->databaseConnection === null) {
            $this->databaseConnection = new DatabaseConnection;
        }
    }

    public function getHighscore(int $limit)
    {
        return $this->databaseConnection->select('highscore', '*', [
            'ORDER' => ['score' => 'DESC'],
            'LIMIT' => $limit
        ]);
    }

    public function addHighscore($json)
    {
        $this->databaseConnection->insert('highscore', [
            'name' => htmlspecialchars($json->name),
            'score' => (int)$json->score,
            'level' => (int)$json->level,
            'elapsedTime' => (float)$json->elapsedTime,
            'timestamp' => time(),
        ]);
    }
}
