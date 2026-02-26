<?php
namespace controllers;

require_once "repositories/ExperienceRepository.php";
require_once "AbstractController.php";

use repositories\ExperienceRepository;

/**
 * Contrôleur responsable de la modification d'une expérience.
 *
 * Gère :
 * - La récupération d'une expérience existante
 * - L'affichage du formulaire de modification
 * - La mise à jour en base de données
 *
 * Hérite de AbstractController pour :
 * - La gestion de session
 * - La vérification d'authentification
 */
class ChangeExperienceController extends AbstractController
{
    /**
     * Repository permettant d'accéder aux données des expériences.
     *
     * @var ExperienceRepository
     */
    private ExperienceRepository $repo;

    /**
     * Constructeur du contrôleur.
     *
     * Initialise :
     * - Le repository
     * - La session utilisateur
     * - La vérification de connexion
     */
    public function __construct()
    {
        $this->repo = new ExperienceRepository();
        $this->startSession();
        $this->requireLogin();
    }

    /**
     * Gère la modification d'une expérience.
     *
     * Étapes :
     * 1. Vérifie la présence de l'id dans l'URL
     * 2. Récupère l'expérience correspondante
     * 3. Si méthode POST → met à jour l'expérience
     * 4. Redirige vers le tableau de bord en cas de succès
     *
     * @return void
     */
    public function changeExperience(): void
    {
        // Template utilisé pour l'affichage
        $template = "changeExperience/changeExperience";
        $error = null;

        // Vérifie si un id est fourni dans l'URL
        if (!isset($_GET['id'])) {
            header("Location: index.php?page=board");
            exit;
        }

        // Sécurisation : cast en entier
        $id = (int) $_GET['id'];

        // Récupération de l'expérience
        $experience = $this->repo->getExperienceById($id);

        // Si aucune expérience trouvée
        if (!$experience) {
            $error = "Experience introuvable.";
            require_once "views/layout.phtml";
            exit;
        }

        // Si le formulaire est soumis
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            // Récupération des données du formulaire
            $title = $_POST['title'] ?? '';
            $description = $_POST['description'] ?? '';
            $image = $_POST['image'] ?? '';
            $short_description = $_POST['short_description'] ?? '';

            // Mise à jour en base
            $success = $this->repo->updateExperience(
                $id,
                $title,
                $description,
                $image,
                $short_description
            );

            // Si succès → redirection
            if ($success) {
                header("Location: index.php?page=board");
                exit;
            } else {
                $error = "Impossible de modifier l'expérience.";
            }
        }

        // Affichage de la vue
        require_once "views/layout.phtml";
    }
}