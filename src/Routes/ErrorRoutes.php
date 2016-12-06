<?php
declare(strict_types = 1);
namespace derRest\Routes;

use Klein\Klein;

class ErrorRoutes extends AbstractRoutes
{
    public function routes(Klein $klein): Klein
    {
        $klein->onHttpError([$this, 'error']);
        return $klein;
    }

    public function error($code, Klein $klein)
    {
        echo $code;
        echo "<pre>If this is wrong, please edit the config.json and adjust the BasePath</pre>";
        echo "<pre>BasePath (config): " . print_r($this->app->getConfig()['BasePath'], true) . "</pre>";
        echo "<pre>BasePath (used): " . print_r($this->app->getBasePathFromRequest($klein->request()), true) . "</pre>";
    }
}