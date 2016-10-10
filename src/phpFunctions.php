<?php
declare(strict_types = 1);
namespace derRest;

/**
 * @param string $fileName
 * @param string[] $vars
 * @return string
 */
function phtml(string $fileName, array $vars = []):string
{
    ob_start();
    extract($vars, EXTR_SKIP);
    /** @noinspection PhpIncludeInspection */
    require $fileName;
    return trim(ob_get_clean());
}