<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


use controllers\AboutController;

require_once 'configs/settings.php';
require_once 'services/routing.php';

spl_autoload_register(function($classename){
    $path = str_replace('\\','/',$classename);
    $filename = $path.'.php';

    if(file_exists($filename)){
        include $filename;
    }
});

if (!isset($_GET['page'])) {
    $url = 'about';
} else {
    $url = $_GET['page'];
}

$routing = new Router($url);

$controller = $routing->getController();


switch ($url) {
    case 'about':
        $controller->about();
        break;
    
    case 'login':
        $controller->login();
        break;

    case 'logout':
        $controller->logout();
        break;
    
    case 'board':
        $controller->board();
        break;
    
    case 'projet':
        $controller->projet();
        break;
    
    case 'change':
        $controller->change();
        break;
        
    case 'create':
        $controller->create();
        break;
    
    default:
        $controller->error();
        break;
}
