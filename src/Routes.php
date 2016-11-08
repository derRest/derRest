<?php
declare(strict_types = 1);
namespace derRest;

use derRest\Database\DatabaseConnection;
use derRest\Generator\Maze;
use Klein\Klein;
use Klein\Request;
use Klein\Response;
use derRest\Functions\phtml;

final class Routes
{
    /**
     * @var array
     */
    protected $config;

    public function routes(Klein $klein): Klein
    {
        $klein->respond(['GET', 'POST'], '/github.php', function (Request $request, Response $response) {
            `git pull && composer install && npm install`;
        });
        $klein->respond('GET', '/', function (Request $request, Response $response) {
            $response->body(phtml::phtml('frontend/html/game.phtml', [
                'baseUrl' => $this->getBasePathFromRequest($request),
            ]));
        });
        $klein->respond('GET', '/Highscore', function (Request $request, Response $response) {
            $db = new DatabaseConnection;
            $response->body(phtml::phtml('frontend/html/highscore.phtml', [
                'baseUrl' => $this->getBasePathFromRequest($request),
                'scores' => $db->select('highscore', '*', ['ORDER' => ['score' => 'DESC'], 'LIMIT' => 200,])
            ]));
        });
        $klein->respond('POST', '/api/highscore', function (Request $request, Response $response) {
            $json = json_decode($request->body());
            if ($json && isset($json->name) && isset($json->score) && isset($json->level) && isset($json->elapsedTime)) {
                $db = new DatabaseConnection;
                $db->insert('highscore', [
                    'name' => $json->name,
                    'score' => $json->score,
                    'level' => $json->level,
                    'elapsedTime' => $json->elapsedTime,
                    'timestamp' => time(),
                ]);
                //save things
                $response->json(['message' => 'saved']);
            } else {
                $response->json(['error' => true]);
            }
        });
        $klein->respond('GET', '/api/highscore', function (Request $request, Response $response) {

            $db = new DatabaseConnection;
            $result = $db->select('highscore', '*', [
                'ORDER' => ['score' => 'DESC'],
                'LIMIT' => 10,
            ]);
            $response->json($result);
        });
        $klein->respond('GET', '/api/highscore/clear', function (Request $request, Response $response) {
            if (file_exists("data/database.db")) {
                unlink("data/database.db");
            }
            $response->redirect($this->getBasePathFromRequest($request), 302);
        });
        $klein->respond('GET', '/api/maze', function (Request $request, Response $response) {

            $x = Maze::DEFAULT_MAZE_WIDTH;
            $y = Maze::DEFAULT_MAZE_HEIGHT;
            $candyCount = Maze::DEFAULT_CANDY_AMOUNT;

            if (!empty($_GET['x']) && is_numeric($_GET['x'])) {
                $x = (int)$_GET['x'];
            }
            if (!empty($_GET['y']) && is_numeric($_GET['y'])) {
                $y = (int)$_GET['y'];
            }
            if (!empty($_GET['candyCount']) && is_numeric($_GET['candyCount'])) {
                $candyCount = (int)$_GET['candyCount'];
            }
            $m = new Maze($x, $y, $candyCount);
            $resultData = $m->generate()->getMaze();
            $response->json($resultData);
        });
        $klein->onHttpError(function ($code, Klein $router) {
            echo $code;
            echo "<pre>If this is wrong, please edit the config.json and adjust the BasePath</pre>";
            echo "<pre>BasePath (config): " . print_r($this->config['BasePath'], true) . "</pre>";
            echo "<pre>BasePath (used): " . print_r($this->getBasePathFromRequest($router->request()), true) . "</pre>";
        });

        return $klein;
    }

    public function dispatch()
    {
        $klein = new Klein();

        $klein = $this->routes($klein);

        $klein->dispatch($this->generateRequest());
    }

    protected function generateRequest(): Request
    {
        $request = Request::createFromGlobals();
        $uri = $request->server()->get('REQUEST_URI');
        $dir = $this->getBasePathFromRequest($request);
        $request->server()->set('REQUEST_URI', substr($uri, strlen($dir)));
        return $request;
    }

    protected function getBasePathFromRequest(Request $request): string
    {
        if (isset($this->config['BasePath']) && is_string($this->config['BasePath'])) {
            return '/' . trim(trim($this->config['BasePath']), '/');
        }
        $scriptFilename = $request->server()->get('SCRIPT_FILENAME');
        $documentRoot = $request->server()->get('DOCUMENT_ROOT');
        $dir = dirname(substr($scriptFilename, strlen($documentRoot)));
        if ($dir == '.' || $dir == '..') {
            $dir = '';
        }
        return $dir;
    }

    /**
     * @return array
     */
    public function getConfig(): array
    {
        return $this->config;
    }

    /**
     * @param array $config
     * @return Routes
     */
    public function setConfig(array $config): self
    {
        $this->config = $config;
        return $this;
    }


}
