<?php
declare(strict_types = 1);
namespace derRest\Routes;

use Klein\Klein;

class DeploymentRoutes implements RoutesInterface
{
    public function routes(Klein $klein): Klein
    {
        $klein->respond(['GET', 'POST'], '/github.php', [$this, 'githubHook']);
        return $klein;
    }

    public function githubHook()
    {
        `git pull && composer install --no-dev && npm install`;
    }
}