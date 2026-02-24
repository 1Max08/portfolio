<?php
namespace controllers;

require_once "repositories/ChangeRepository.php";
require_once "AbstractController.php";

use repositories\ChangeRepository;

class ChangeController extends AbstractController {
    private ChangeRepository $changeRepository;

    public function __construct() {
        $this->changeRepository = new ChangeRepository();
        $this->startSession();
        $this->requireLogin();
    }

    public function change(): void {
        $template = "change/change";

        if (!isset($_GET['id'])) {
            header("Location: index.php?page=board");
            exit;
        }

        $id = (int)$_GET['id'];
        $project = $this->changeRepository->getProjetById($id);

        if (!$project) {
            $error = "Projet introuvable.";
            require_once "views/layout.phtml";
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $title = $_POST['titre'] ?? '';
            $description = $_POST['description'] ?? '';
            $image = $_POST['image'] ?? '';
            $shortDescription = $_POST['short_description'] ?? '';

            $success = $this->changeRepository->updateProjet($id, $title, $description, $image, $shortDescription);

            if ($success) {
                header("Location: index.php?page=board");
                exit;
            } else {
                $error = "Impossible de modifier le projet.";
            }
        }

        require_once "views/layout.phtml";
    }
}