<?php
declare(strict_types = 1);
namespace derRest\Routes;

use derRest\Database\Highscore;
use derRest\Functions\PHtml;
use Klein\Klein;
use Klein\Request;
use Klein\Response;

class HtmlRoutes extends AbstractRoutes
{

    public function routes(Klein $klein): Klein
    {
        $klein->respond('GET', '/', function (Request $request, Response $response) {
            $response->body((string)new PHtml('frontend/html/game.phtml', [
                'baseUrl' => $this->app->getBasePathFromRequest($request),
            ]));
        });
        $klein->respond('GET', '/Highscore', function (Request $request, Response $response) {
            $score = (new Highscore)->getHighscore(200);
            $response->body((string)new PHtml('frontend/html/highscore.phtml', [
                'baseUrl' => $this->app->getBasePathFromRequest($request),
                'scores' => $score
            ]));
        });
        return $klein;
    }
}