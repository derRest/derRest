<?php
namespace derRest\Test;

use derRest\Database\DatabaseConnection;
use derRest\Database\Highscore;

class HighscoreTest extends \PHPUnit_Framework_TestCase
{
    public function testSave()
    {
        $highscore = new Highscore((new DatabaseConnection([
            'database_type' => 'sqlite',
            'database_file' => ':memory:',
            'option' => [
                \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION
            ]
        ]))->generateDefault());
        $highscore->addHighscore((object)[
            'name' => 'Testing-Kanti',
            'score' => '2999',
            'level' => '1',
            'elapsedTime' => '23.1234',
        ]);
        $result = $highscore->getHighscore(99);

        $this->assertCount(1, $result);
        $this->assertEquals('Testing-Kanti', $result[0]['name']);
        $this->assertEquals('2999', $result[0]['score']);
        $this->assertEquals('1', $result[0]['level']);
        $this->assertEquals('23.1234', $result[0]['elapsedTime']);
    }
}
