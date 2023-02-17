<?php

namespace Core\Lib;

class View
{
    private ?string $layout;
    private ?string $title;
    private string $content;
    private array $variables;

    public function __construct($content)
    {
        $this->layout = null;
        $this->title = null;
        $this->content = $content;
        $this->variables = [];
    }

    public static function make($content)
    {
        return new View($content);
    }

    public function layout($layout)
    {
        $this->layout = $layout;
        return $this;
    }

    public function title($title)
    {
        $this->title = $title;
        return $this;
    }

    public function with($variables)
    {
        $this->variables = $variables;
        return $this;
    }

    public function render()
    {
        extract($this->variables);
        if ($this->layout)
        {
            $title = $this->title;
            $content = $this->content;
            require_once __DIR__ . "/../../resources/views/" . $this->layout . ".php";
        }
        else
        {
            require_once __DIR__ . "/../../resources/views/" . $this->content . ".php";
        }
    }
}