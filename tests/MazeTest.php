<?php
namespace derRest\Test;

use derRest\Generator\Maze;
use derRest\Generator\MazeSolver;
use derRest\Generator\MazePathFinder;
use derRest\Generator\MazePrinter;

class MazeTest extends \PHPUnit_Framework_TestCase
{

    public function testHeightAndWidth1()
    {
        //alles tut
        $array = array(
            [3, 3],
            [3, 5],
            [5, 3]
        );
        foreach ($array as $n) {
            new Maze($n[0], $n[1], 1);
        }
    }

    public function testHeightAndWidth2()
    {
        //gerade Zahlen
        $array = array(
            [2, 2],
            [2, 3],
            [3, 2]
        );
        foreach ($array as $n) {
            try {
                new Maze($n[0], $n[1], 1);
                $this->fail("Zahl, die nicht akzeptiert werden sollte, wurde akzeptiert.");
            } catch (\InvalidArgumentException $e) {
                $this->assertInstanceOf(\InvalidArgumentException::class, $e);
            }
        }
    }

    public function testHeightAndWidth3()

    {
        //zu kleine Zahlen
        $array = array(
            [1, 3],
            [3, 1],
            [1, 1],
            [1, -1],
            [-1, 1],
            [3, -1],
            [-1, 3],
            [-1, -1]
        );
        foreach ($array as $n) {
            try {
                new Maze($n[0], $n[1], 1);
                $this->fail("Zahl, die nicht akzeptiert werden sollte, wurde akzeptiert.");
            } catch (\InvalidArgumentException $e) {
                $this->assertInstanceOf(\InvalidArgumentException::class, $e);
            }

        }
    }

    public function testValidChars()
    {
        /*
         * Testet mehrere Labyrinthe (Maze) ob nur valide Zeichen vorhanden sind. Sprich Leerzeichen, Candy's und Wände.
         */
        $sizesArray = [
            [7, 7, 1],
            [9, 5, 1],
            [5, 9, 1],
            [5, 11, 1],
            [11, 5, 1],
        ];
        foreach ($sizesArray as $size) {
            //Mehrere Arrays prüfen mit unterschiedlicher Größe
            $maze = (new Maze($size[0], $size[1], $size[2]))->generate()->getMaze();

            $wSpaceCount = 0;
            $wallCount = 0;
            $candyCount = 0;
            $wrongCount = 0;

            //Jede Zeile des Arrays durchgehen
            foreach ($maze as $mazeLine) {
                //Jedes Zeichen pro Reihe durchgehen und zählen
                foreach ($mazeLine as $cell) {
                    switch ($cell) {
                        case Maze::CANDY:
                            $candyCount++;
                            break;
                        case Maze::WALL:
                            $wallCount++;
                            break;
                        case Maze::WHITE_SPACE:
                            $wSpaceCount++;
                            break;
                        default:
                            $wrongCount++;
                            $this->fail("Nicht erkanntes zeichen: " . $cell);
                    }
                }
            }
            //Möglichkeit: Einbau eines Zählers möglich, um auf Anzahl der Wände usw. prüfen zu können
            //$this->assertEquals($wrongCount, 0); //Reduntant
        }
    }

    public function testSolvable()
    {
        $xcoordinate = rand(3, 51) * 2 + 1; // to make it always odd
        $ycoordinate = rand(3, 51) * 2 + 1;
        $candies = rand(3, 10);
        $mazeSolver = new MazePathFinder($xcoordinate, $ycoordinate, $candies);
        foreach ($mazeSolver->getCalculatedMazes() as $mazes) {
            $path = $mazeSolver->getShortestPath(
                [
                    $mazeSolver->getMazeWidth($mazes["distance"]),
                    $mazeSolver->getMazeHeight($mazes["distance"]),
                ],
                $mazes["distance"],
                $mazes["locations"]
            );
            // $printer = new MazePrinter();
            // echo $printer->printMazeSolution($mazes["distance"], $path);
        }
        $this->assertEquals($mazeSolver->validateMazes(), true);
    }

    public function testPrintMaze() {
        $mazeSolver = new MazeSolver(11, 11, 3);
        foreach ($mazeSolver->getCalculatedMazes() as $mazes) {
            $printer = new MazePrinter();
            $this->assertNotEquals($printer->printToCli($mazeSolver->getMaze()), "");
        }
    }

    public function testPrintMazeSolver() {
        $mazeSolver = new MazePathFinder(11, 11, 3);
        foreach ($mazeSolver->getCalculatedMazes() as $mazes) {
            $path = $mazeSolver->getShortestPath(
                [
                    $mazeSolver->getMazeWidth($mazes["distance"]),
                    $mazeSolver->getMazeHeight($mazes["distance"]),
                ],
                $mazes["distance"],
                $mazes["locations"]
            );
            $printer = new MazePrinter();
            $this->assertNotEquals($printer->printMazeSolution($mazes["distance"], $path), []);
        }
    }

    public function testCandyCount1()
    {
        $array = [
            [5, 5, 1],
            [9, 9, 2],
            [15, 13, 4],
            [43, 43, 170]
        ];
        foreach ($array as $row) {

            //Test for correct amount of candies
            $maze = new Maze($row[0], $row[1], $row[2]);
            $maze = $maze->generate()->getMaze();

            $candyCount = 0;
            foreach ($maze as $mazeLine) {
                foreach ($mazeLine as $cell) {
                    if ($cell === Maze::CANDY) {
                        $candyCount++;
                    }
                }
            }
            $this->assertEquals($row[2], $candyCount);
        }
    }

    public function testCandyCount2()
    {
        $array = [
            [5, 5, 500],
            [9, 9, 999],
            [15, 13, 1334],
            [43, 43, 17000]
        ];
        foreach ($array as $row) {
            //more than max candies
            $maze = new Maze($row[0], $row[1], $row[2]);
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
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testCandyCount3()
    {
        //negative number of candies
        $maze = new Maze(15, 15, -5);
    }

    public function testMazeChanging()
    {
        $sizesArray = [
            [7, 7],
            [9, 5],
            [5, 9],
            [5, 11],
            [11, 5],
        ];
        foreach ($sizesArray as $size) {
            $maze1 = (new Maze($size[0], $size[1], 1))->generate()->getMaze();
            $maze2 = (new Maze($size[0], $size[1], 1))->generate()->getMaze();

            $this->assertNotEquals($maze1, $maze2);
        }
    }
}
