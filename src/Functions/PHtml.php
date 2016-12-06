<?php
declare(strict_types = 1);
namespace derRest\Functions;

class PHtml
{
    /**
     * @var string
     */
    protected $output;

    /**
     * @param string $fileName
     * @param string[] $vars
     * @param string $layout
     */
    public function __construct(string $fileName, array $vars = [], string $layout = 'frontend/html/layout.phtml')
    {
        ob_start();
        extract($vars, EXTR_SKIP);
        /** @noinspection PhpIncludeInspection */
        require $fileName;
        $this->output = trim(ob_get_clean());
        if ($layout) {
            $vars['body'] = $this->output;
            $this->output = (string)new static($layout, $vars, '');
        }
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->output;
    }
}