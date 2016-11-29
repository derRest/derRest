<?php
declare(strict_types = 1);
namespace derRest\Database;

class DatabaseConnection extends \medoo
{
    const DATABASE_FILE = 'data/database.db';
    const INITIAL_DATABASE_FILE = 'data/initial_database.db';

    public function __construct(array $settings = null)
    {
        if (!file_exists(static::DATABASE_FILE)) {
            copy(static::INITIAL_DATABASE_FILE, static::DATABASE_FILE);
        }
        if ($settings === null) {
            $settings = [
                'database_type' => 'sqlite',
                'database_file' => static::DATABASE_FILE,
                'option' => [
                    \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION
                ]
            ];
        }
        parent::__construct($settings);
    }

    public function generateDefault(): DatabaseConnection
    {
        $this->query(
            'CREATE TABLE highscore ' .
            '( ' .
            'name TEXT, ' .
            'score INTEGER, ' .
            'level INTEGER, ' .
            'elapsedTime INTEGER, ' .
            'timestamp INTEGER ' .
            ') '
        );
        return $this;
    }
}