<?php
namespace controllers;

require_once "repositories/ProjetRepository.php";
require_once "models/Project.php";
require_once "AbstractController.php";

use repositories\ProjetRepository;
use models\Project;

class ProjetController extends AbstractController {

    private ProjetRepository $projetRepository;

    public function __construct() {
        $this->projetRepository = new ProjetRepository();
    }

    public function projet() {
        $error = null;
        $projet = null;

        if (isset($_GET['id'])) {
            $id = intval($_GET['id']);
            $projetData = $this->projetRepository->getProjetById($id);

            if ($projetData) {
                $projet = new Project(
                    $projetData['id'],
                    $projetData['titre'],
                    $projetData['description'] ?? '',
                    $projetData['short_description'] ?? '',
                    $projetData['image'] ?? ''
                );
            } else {
                $error = "Projet introuvable.";
            }
        } else {
            $error = "Aucun projet sélectionné.";
        }

        $template = "projet/projet";
        require_once "views/layout.phtml";
    }
}