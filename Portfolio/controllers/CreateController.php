<?php
namespace controllers;

require_once "repositories/CreateRepository.php";
require_once "AbstractController.php";
require_once "models/Project.php";

use repositories\CreateRepository;
use models\Project;

class CreateController extends AbstractController {
    private CreateRepository $createRepository;

    public function __construct() {
        $this->createRepository = new CreateRepository();
        $this->startSession();
        $this->requireLogin();
    }

    public function create(): void {
        $template = "create/create";
        $error = null;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $project = new Project(
                null,
                $_POST['titre'] ?? '',
                $_POST['description'] ?? '',
                $_POST['short_description'] ?? '',
                $_POST['image'] ?? ''
            );

            $success = $this->createRepository->createProjet($project);

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