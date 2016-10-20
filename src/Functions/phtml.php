<?php
declare(strict_types = 1);
namespace derRest\Functions;

class phtml
{
    /**
     * @param string $fileName
     * @param string[] $vars
     * @param string $layout
     * @return string
     */
    public static function phtml(string $fileName, array $vars = [], string $layout = 'frontend/html/layout.phtml'):string
    {
        ob_start();
        extract($vars, EXTR_SKIP);
        /** @noinspection PhpIncludeInspection */
        require $fileName;
        $output = trim(ob_get_clean());
        if ($layout) {
            $vars['body'] = $output;
            $output = static::phtml($layout, $vars, '');
        }
        return $output;
    }
}