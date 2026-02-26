<?php
namespace controllers;

require_once "repositories/ExperienceRepository.php";
require_once "AbstractController.php";
require_once "models/Experience.php";

use repositories\ExperienceRepository;
use models\Experience;

/**
 * Contrôleur responsable de la création d'une expérience.
 *
 * Responsabilités :
 * - Afficher le formulaire de création d'une expérience
 * - Instancier un objet métier Experience
 * - Enregistrer l'expérience via le repository
 *
 * Hérite de AbstractController pour :
 * - La gestion des sessions
 * - La vérification d'authentification utilisateur
 */
class CreateExperienceController extends AbstractController
{
    /**
     * Repository permettant l'accès aux données des expériences.
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
     * - La vérification que l'utilisateur est connecté
     */
    public function __construct()
    {
        $this->repo = new ExperienceRepository();
        $this->startSession();
        $this->requireLogin();
    }

    /**
     * Gère la création d'une nouvelle expérience.
     *
     * Fonctionnement :
     * - Si requête GET → affiche le formulaire
     * - Si requête POST :
     *      - Instancie un objet Experience
     *      - Tente de l'enregistrer en base
     *      - Redirige vers le tableau de bord en cas de succès
     *
     * @return void
     */
    public function createExperience(): void
    {
        $template = "createExperience/createExperience";
        $error = null;

        // Vérifie si le formulaire a été soumis
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            // Création de l'objet métier Experience
            $experience = new Experience(
                null, // id null car nouvelle expérience
                $_POST['title'] ?? '',
                $_POST['description'] ?? '',
                $_POST['short_description'] ?? '',
                $_POST['image'] ?? ''
            );

            // Tentative d'insertion en base de données
            $success = $this->repo->createExperience($experience);

            if ($success) {
                // Redirection après création réussie
                header("Location: index.php?page=board");
                exit;
            } else {
                $error = "Impossible de créer l'expérience.";
            }
        }

        // Chargement du layout principal
        require_once "views/layout.phtml";
    }
}