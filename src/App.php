<?php
declare(strict_types = 1);
namespace derRest;

use derRest\Routes\ApiRoutes;
use derRest\Routes\DeploymentRoutes;
use derRest\Routes\ErrorRoutes;
use derRest\Routes\HtmlRoutes;
use derRest\Routes\RoutesInterface;
use Klein\Klein;
use Klein\Request;

final class App
{
    /**
     * @var array
     */
    protected $config;

    public function dispatch()
    {
        $klein = new Klein(null, $this);

        /** @var RoutesInterface[] $routes */
        $routes = [
            new ApiRoutes($this),
            new DeploymentRoutes($this),
            new HtmlRoutes($this),
            new ErrorRoutes($this),
        ];

        foreach ($routes as $router) {
            $klein = $router->routes($klein);
        }

        $klein->dispatch($this->generateRequest());
    }

    public function generateRequest(): Request
    {
        $request = Request::createFromGlobals();
        $uri = $request->server()->get('REQUEST_URI');
        $dir = $this->getBasePathFromRequest($request);
        $request->server()->set('REQUEST_URI', substr($uri, strlen($dir)));
        return $request;
    }

    public function getBasePathFromRequest(Request $request): string
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
     * @return self
     */
    public function setConfig(array $config): self
    {
        $this->config = $config;
        return $this;
    }


}
