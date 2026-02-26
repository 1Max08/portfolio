<?php

// Affiche toutes les erreurs pour le développement
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

use controllers\AboutController;

// Fichiers de configuration et routage
require_once 'configs/settings.php';
require_once 'services/routing.php';

// Permet de charger automatiquement les classes à partir de leur namespace
spl_autoload_register(function ($classname) {
    // Remplace les backslashes des namespaces par des slashes pour correspondre aux dossiers
    $path = str_replace('\\', '/', $classname);
    $filename = $path . '.php';

    // Inclut le fichier si il existe
    if (file_exists($filename)) {
        include $filename;
    }
});

// Si aucun paramètre `page` n'est présent, on prend 'about' par défaut
$url = $_GET['page'] ?? 'about';

$routing = new Router($url);

// Récupère l'objet controller correspondant à la page
$controller = $routing->getController();


// Utilise un switch sur la variable $url pour exécuter la bonne méthode du controller
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
        // Page non reconnue → affiche l'erreur 404
        $controller->error();
        break;
}