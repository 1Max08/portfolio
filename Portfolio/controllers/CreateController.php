<?php
namespace controllers;

require_once "repositories/CreateRepository.php";
require_once "AbstractController.php";

use repositories\CreateRepository;

class CreateController extends AbstractController {
    private CreateRepository $createRepository;

    public function __construct() {
        $this->createRepository = new CreateRepository();
        $this->startSession();
        $this->requireLogin();
    }

    public function create(): void {
        $template = "create/create";

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $title = $_POST['titre'] ?? '';
            $description = $_POST['description'] ?? '';
            $image = $_POST['image'] ?? '';
            $shortDescription = $_POST['short_description'] ?? '';

            $success = $this->createRepository->createProjet($title, $description, $image, $shortDescription);

            if ($success) {
                header("Location: index.php?page=board");
                exit;
            } else {
                $error = "Impossible de créer le projet.";
            }
        }

        require_once "views/layout.phtml";
    }
}