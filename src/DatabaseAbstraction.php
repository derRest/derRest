<?php
declare(strict_types = 1);
namespace derRest;

class DatabaseAbstraction extends \medoo
{
    const DATABASE_FILE = 'data/database.db';
    const INITIAL_DATABASE_FILE = 'data/initial_database.db';

    public function __construct()
    {
        if (!file_exists(static::DATABASE_FILE)) {
            copy(static::INITIAL_DATABASE_FILE, static::DATABASE_FILE);
        }
        parent::__construct([
            'database_type' => 'sqlite',
            'database_file' => static::DATABASE_FILE,
            'option' => [
                \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION
            ]
        ]);
    }
}