<?php
declare(strict_types = 1);
namespace derRest\Routes;

use derRest\App;

abstract class AbstractRoutes implements RoutesInterface
{
    /**
     * @var App
     */
    protected $app;

    public function __construct(App $app)
    {
        $this->app = $app;
    }
}