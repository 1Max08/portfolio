<?php

namespace controllers;

class ErrorController {
    
    public function error(){
        $template = "error/404";
        require_once "views/layout.phtml";
    }
}