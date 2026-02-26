<?php
namespace controllers;

require_once "repositories/ExperienceRepository.php";
require_once "models/Experience.php";
require_once "AbstractController.php";

use repositories\ExperienceRepository;
use models\Experience;

/**
 * Contrôleur responsable de l'affichage d'une expérience.
 *
 * Fonctionnalités :
 * - Récupérer et afficher une expérience spécifique
 * - Gérer les erreurs si l'expérience n'existe pas ou si aucun ID n'est fourni
 *
 * Hérite de AbstractController pour :
 * - Gestion de session
 * - Potentielle vérification d'authentification (selon AbstractController)
 */
class ExperienceController extends AbstractController
{
    /**
     * Repository permettant l'accès aux données des expériences.
     *
     * @var ExperienceRepository
     */
    private ExperienceRepository $experienceRepository;

    /**
     * Constructeur du contrôleur.
     *
     * Initialise le repository des expériences.
     */
    public function __construct()
    {
        $this->experienceRepository = new ExperienceRepository();
    }

    /**
     * Affiche une expérience spécifique selon son identifiant.
     *
     * Fonctionnement :
     * - Vérifie si l'ID est fourni dans l'URL ($_GET['id'])
     * - Récupère l'expérience correspondante via le repository
     * - Définit un message d'erreur si l'expérience est introuvable
     * - Charge le template principal pour affichage
     *
     * @return void
     */
    public function experience(): void
    {
        $error = null;
        $experience = null;

        // Vérifie la présence de l'ID dans l'URL
        if (isset($_GET['id'])) {
            $id = intval($_GET['id']);
            $experience = $this->experienceRepository->getExperienceById($id);

            // Si aucune expérience trouvée
            if (!$experience) {
                $error = "Experience introuvable.";
            }
        } else {
            $error = "Aucune experience sélectionnée.";
        }

        // Template à charger
        $template = "experience/experience";

        // Chargement du layout principal
        require_once "views/layout.phtml";
    }
}