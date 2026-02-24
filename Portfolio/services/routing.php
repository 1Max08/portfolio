<?php

declare(strict_types=1);

class Router {
    private $controller;

    public function __construct($page) {
        if (array_key_exists($page, AVAILABLE_ROUTES)) {
            $this->controller = AVAILABLE_ROUTES[$page];
        } else {
            $this->controller = 'ErrorController';
        }
    }

    public function getController(): object {
        $instance = "controllers\\" . $this->controller;
        return new $instance();
    }
}