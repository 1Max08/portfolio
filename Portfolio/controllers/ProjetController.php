<?php
namespace controllers;

require_once "repositories/ProjetRepository.php";
require_once "models/Projet.php";
require_once "AbstractController.php";

use repositories\ProjetRepository;
use models\Projet;

/**
 * Contrôleur responsable de l'affichage d'un projet spécifique.
 *
 * Fonctionnalités :
 * - Récupérer un projet par son identifiant
 * - Gérer les erreurs si le projet n'existe pas ou si aucun ID n'est fourni
 *
 * Hérite de AbstractController pour :
 * - La gestion des sessions
 * - Potentiellement la vérification d'authentification (selon AbstractController)
 */
class ProjetController extends AbstractController
{
    /**
     * Repository permettant l'accès aux données des projets.
     *
     * @var ProjetRepository
     */
    private ProjetRepository $projetRepository;

    /**
     * Constructeur du contrôleur.
     *
     * Initialise le repository des projets.
     */
    public function __construct()
    {
        $this->projetRepository = new ProjetRepository();
    }

    /**
     * Affiche un projet spécifique selon son identifiant.
     *
     * Fonctionnement :
     * - Vérifie si l'ID est fourni dans l'URL ($_GET['id'])
     * - Récupère le projet correspondant via le repository
     * - Définit un message d'erreur si le projet est introuvable
     * - Charge le template principal pour affichage
     *
     * @return void
     */
    public function projet(): void
    {
        $error = null;
        $projet = null;

        // Vérifie la présence de l'ID dans l'URL
        if (isset($_GET['id'])) {
            $id = intval($_GET['id']);
            $projet = $this->projetRepository->getProjetById($id);

            // Si aucun projet trouvé
            if (!$projet) {
                $error = "Projet introuvable.";
            }
        } else {
            $error = "Aucun projet sélectionné.";
        }

        // Template à charger
        $template = "projet/projet";

        // Chargement du layout principal
        require_once "views/layout.phtml";
    }
}