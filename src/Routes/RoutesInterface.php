<?php
declare(strict_types = 1);
namespace derRest\Routes;

use Klein\Klein;

interface RoutesInterface
{
    public function routes(Klein $klein): Klein;
}