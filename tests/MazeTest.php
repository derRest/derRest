<?php
namespace derRest\Test;

use derRest\Generator\Maze;

class MazeTest extends \PHPUnit_Framework_TestCase
{
    public function testHeightAndWidth1()
    {

    }

    public function testHeightAndWidth2()
    {

    }

    public function testHeightAndWidth3()
    {

    }

    public function testValidChars()
    {

    }

    public function testSolvable()
    {

    }

    public function testCandyCount1()
    {
        //Test for correct amount of candies
        $maze = new Maze(15,15,5);
        $maze = $maze->generate()->getMaze();

        $candyCount = 0;
        foreach ($maze as $mazeLine) {
            foreach ($mazeLine as $cell) {
                if ($cell === Maze::CANDY) {
                    $candyCount++;
                }
            }
        }

        $this->assertEquals(5, $candyCount);
    }

    public function testCandyCount2()
    {
        //more then max candies
        $maze = new Maze(15,15,5000);
        $maze = $maze->generate()->getMaze();

        $candyCount = 0;
        foreach ($maze as $mazeLine) {
            foreach ($mazeLine as $cell) {
                if ($cell === Maze::CANDY) {
                    $candyCount++;
                }
            }
        }

        $whitespaceCount = 0;
        foreach ($maze as $mazeLine) {
            foreach ($mazeLine as $cell) {
                if ($cell === Maze::WHITE_SPACE) {
                    $whitespaceCount++;
                }
            }
        }

        $this->assertEquals(0, $whitespaceCount);
        $this->assertGreaterThanOrEqual(1, $candyCount);
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testCandyCount3()
    {
        //negative number of candies
        $maze = new Maze(15,15,-5);
    }

    public function testMazeChanging()
    {

    }
}
