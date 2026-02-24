<?php
namespace controllers;

require_once "repositories/CreateRepository.php";
require_once "AbstractController.php";

use repositories\CreateRepository;

class CreateController extends AbstractController {

    private $createRepository;

    public function __construct() {
        $this->createRepository = new CreateRepository();
    }

    public function create() {
        $this->requireLogin();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $titre = $_POST['titre'];
            $description = $_POST['description'];
            $image = $_POST['image'];
            $short_description = $_POST['short_description'];

            $result = $this->createRepository->CreateProjet($titre, $description, $image, $short_description);

            if ($result) {
                header("Location: index.php?page=board");
                exit();
            } else {
                $error = "Impossible de créer le projet.";
            }
        }

        $template = "create/create";
        require_once "views/layout.phtml";
    }
}