<?php
namespace derRest;

require 'vendor/autoload.php';

use Whoops\Handler\PrettyPageHandler;
use Whoops\Run;

$whoops = new Run;
$whoops->pushHandler(new PrettyPageHandler);
$whoops->register();

(new Routes)->dispatch();