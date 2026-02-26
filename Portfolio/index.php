<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

use controllers\AboutController;

require_once 'configs/settings.php';
require_once 'services/routing.php';

spl_autoload_register(function ($classname) {
    $path = str_replace('\\', '/', $classname);
    $filename = $path . '.php';

    if (file_exists($filename)) {
        include $filename;
    }
});

$url = $_GET['page'] ?? 'about';

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

    case 'experience':
        $controller->experience();
        break;

    case 'createExperience':
        $controller->createExperience();
        break;

    case 'changeExperience':
        $controller->changeExperience();
        break;

    case 'change':
        $controller->change();
        break;

    case 'changeCompetence':
        $controller->changeCompetence();
        break;

    case 'create':
        $controller->create();
        break;

    default:
        $controller->error();
        break;
}