<?php
namespace controllers;

require_once "repositories/ChangeRepository.php";
require_once "AbstractController.php";

use repositories\ChangeRepository;
use models\Projet;

/**
 * Contrôleur permettant la modification d'un projet existant.
 *
 * Responsabilités :
 * - Vérifier que l'utilisateur est authentifié
 * - Récupérer un projet via son ID
 * - Afficher le formulaire pré-rempli
 * - Traiter la modification du projet
 * - Rediriger vers le tableau de bord après succès
 */
class ChangeController extends AbstractController
{
    /**
     * Repository responsable de l'accès aux données des projets.
     *
     * @var ChangeRepository
     */
    private ChangeRepository $changeRepository;

    /**
     * Constructeur du contrôleur.
     *
     * - Initialise le repository
     * - Démarre la session
     * - Vérifie que l'utilisateur est connecté
     */
    public function __construct()
    {
        $this->changeRepository = new ChangeRepository();
        $this->startSession();
        $this->requireLogin();
    }

    /**
     * Méthode principale de modification d'un projet.
     *
     * Fonctionnement :
     * 1. Vérifie la présence d'un ID en GET
     * 2. Récupère le projet correspondant
     * 3. Si POST → met à jour les données
     * 4. Recharge la vue avec éventuel message d'erreur
     *
     * @return void
     */
    public function change(): void
    {
        // Template associé à la vue
        $template = "change/change";

        // Variable permettant d'afficher un message d'erreur dans la vue
        $error = null;

        if (!isset($_GET['id'])) {
            // Si aucun ID n'est fourni, redirection vers le board
            header("Location: index.php?page=board");
            exit;
        }

        // Conversion sécurisée en entier
        $id = (int) $_GET['id'];

        $project = $this->changeRepository->getProjetById($id);

        // Si aucun projet trouvé → erreur
        if (!$project) {
            $error = "Projet introuvable.";
            require_once "views/layout.phtml";
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            // Mise à jour des propriétés de l'objet Projet
            $project->title = $_POST['titre'] ?? '';
            $project->description = $_POST['description'] ?? '';
            $project->image = $_POST['image'] ?? '';
            $project->short_description = $_POST['short_description'] ?? '';

            // Appel du repository pour sauvegarder les modifications
            $success = $this->changeRepository->updateProjet(
                $id,
                $project->title,
                $project->description,
                $project->image,
                $project->short_description
            );

            // Si succès → redirection vers le tableau de bord
            if ($success) {
                header("Location: index.php?page=board");
                exit;
            } else {
                // Sinon message d'erreur
                $error = "Impossible de modifier le projet.";
            }
        }

        /**
         * Chargement de la vue
         */
        require_once "views/layout.phtml";
    }
}