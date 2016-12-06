<?php
declare(strict_types = 1);
namespace derRest\Routes;

use derRest\Database\Highscore;
use derRest\Generator\Maze;
use Klein\Klein;
use Klein\Request;
use Klein\Response;

class ApiRoutes extends AbstractRoutes
{
    public function routes(Klein $klein): Klein
    {
        $klein->respond('POST', '/api/highscore', [$this, 'highscorePOST']);
        $klein->respond('GET', '/api/highscore', [$this, 'highscoreGET']);
        $klein->respond(['GET', 'DELETE'], '/api/highscore/clear', [$this, 'highscoreClear']);
        $klein->respond('GET', '/api/maze', [$this, 'maze']);
        return $klein;
    }

    public function highscorePOST(Request $request, Response $response)
    {
        $json = json_decode($request->body());
        $response->json(['error' => true]);
        if ($json && isset($json->name) && isset($json->score) && isset($json->level) && isset($json->elapsedTime)) {
            (new Highscore)->addHighscore($json);
            $response->json(['message' => 'saved']);
        }
    }

    public function highscoreGET(Request $request, Response $response)
    {
        $result = (new Highscore)->getHighscore((int)$request->param('limit', 10));
        $response->json($result);
    }

    public function highscoreClear(Request $request, Response $response)
    {
        if (file_exists("data/database.db")) {
            unlink("data/database.db");
        }
        $response->redirect($this->app->getBasePathFromRequest($request), 302);
    }

    public function maze(Request $request, Response $response)
    {
        $xCord = (int)$request->param('x', Maze::DEFAULT_MAZE_WIDTH);
        $yCord = (int)$request->param('y', Maze::DEFAULT_MAZE_HEIGHT);
        $candyCount = (int)$request->param('candyCount', Maze::DEFAULT_CANDY_AMOUNT);

        $maze = new Maze($xCord, $yCord, $candyCount);
        $resultData = $maze->generate()->getMaze();
        $response->json($resultData);
    }
}
