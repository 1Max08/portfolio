<?php
namespace controllers;

require_once "repositories/ChangeRepository.php";
require_once "AbstractController.php";

use repositories\ChangeRepository;
use models\Project;

class ChangeController extends AbstractController {
    private ChangeRepository $changeRepository;

    public function __construct() {
        $this->changeRepository = new ChangeRepository();
        $this->startSession();
        $this->requireLogin();
    }

    public function change(): void {
        $template = "change/change";
        $error = null;

        // Vérification de l'ID du projet
        if (!isset($_GET['id'])) {
            header("Location: index.php?page=board");
            exit;
        }

        $id = (int)$_GET['id'];

        // Récupération du projet en objet Project
        $project = $this->changeRepository->getProjetById($id);

        if (!$project) {
            $error = "Projet introuvable.";
            require_once "views/layout.phtml";
            exit;
        }

        // Traitement du formulaire
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Mise à jour de l'objet Project
            $project->title = $_POST['titre'] ?? '';
            $project->description = $_POST['description'] ?? '';
            $project->image = $_POST['image'] ?? '';
            $project->short_description = $_POST['short_description'] ?? '';

            // Mise à jour en base
            $success = $this->changeRepository->updateProjet(
                $id,
                $project->title,
                $project->description,
                $project->image,
                $project->short_description
            );

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