<?php
// controllers/ChangeCompetenceController.php
// Contrôleur pour modifier une compétence (chargement, formulaire, mise à jour).
namespace controllers;

require_once "repositories/ChangeCompetenceRepository.php";
require_once "AbstractController.php";

use repositories\ChangeCompetenceRepository;

class ChangeCompetenceController extends AbstractController
{
    // Repository utilisé pour accéder aux données des compétences
    private ChangeCompetenceRepository $repo;

    // Constructeur : instancie le repository et vérifie la session/utilisateur
    public function __construct()
    {
        $this->repo = new ChangeCompetenceRepository();
        $this->startSession();
        $this->requireLogin();
    }

    // Point d'entrée pour l'édition d'une compétence
    public function changeCompetence(): void
    {
        // Variables initiales pour la vue
        $competence = null;
        $error = null;

        // Récupérer l'id depuis la querystring
        $id = (int) ($_GET['id'] ?? 0);
        // Si l'id est invalide ou la compétence introuvable, définir une erreur
        if (!$id || !($competence = $this->repo->getCompetenceById($id))) {
            $error = "Compétence introuvable.";
        }

        // Si le formulaire est soumis, tenter la mise à jour
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'] ?? '';
            $level = $_POST['level'] ?? '';

            // Appel au repository pour mettre à jour la compétence
            if ($this->repo->updateCompetence($id, $name, $level)) {
                // Redirection vers le dashboard si succès
                header("Location: index.php?page=board");
                exit;
            } else {
                // Message d'erreur en cas d'échec
                $error = "Impossible de modifier la compétence.";
            }
        }

        // Vue à charger
        $template = "changeCompetence/changeCompetence";
        require_once "views/layout.phtml";
    }

}