<?php

namespace controllers;

require_once "repositories/CreateRepository.php";

use repositories\CreateRepository;

class CreateController {

    private $createRepository;

    public function __construct() {
        $this->createRepository = new CreateRepository();
    }

    public function create() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $titre = $_POST['titre'];
            $description = $_POST['description'];
            $image = $_POST['image'];
            $short_description = $_POST['short_description'];

            // Création du projet sans ID (car généré automatiquement en BDD)
            $result = $this->createRepository->CreateProjet($titre, $description, $image, $short_description);

            // Redirection si l'insertion est réussie
            if ($result) {
                header("Location: index.php?page=board");
                exit();
            }
        }

        $template = "create/create";
        require_once "views/layout.phtml";
    }
}