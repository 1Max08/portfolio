<?php
namespace controllers;

require_once "repositories/ProjetRepository.php";
require_once "models/Projet.php";
require_once "AbstractController.php";

use repositories\ProjetRepository;
use models\Projet;

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
            $projet = $this->projetRepository->getProjetById($id);

            if (!$projet) {
                $error = "Projet introuvable.";
            }
        } else {
            $error = "Aucun projet sélectionné.";
        }

        $template = "projet/projet";
        require_once "views/layout.phtml";
    }
}