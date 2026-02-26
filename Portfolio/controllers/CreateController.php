<?php
namespace controllers;

require_once "repositories/CreateRepository.php";
require_once "AbstractController.php";
require_once "models/Projet.php";

use repositories\CreateRepository;
use models\Projet;

/**
 * Contrôleur responsable de la création d'un projet.
 *
 * Rôle :
 * - Afficher le formulaire de création
 * - Instancier un objet Projet
 * - Persister le projet en base via le repository
 *
 * Hérite de AbstractController pour :
 * - La gestion des sessions
 * - La vérification d'authentification
 */
class CreateController extends AbstractController
{
    /**
     * Repository utilisé pour gérer la persistance des projets.
     *
     * @var CreateRepository
     */
    private CreateRepository $createRepository;

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
        $this->createRepository = new CreateRepository();
        $this->startSession();
        $this->requireLogin();
    }

    /**
     * Gère la création d'un nouveau projet.
     *
     * Fonctionnement :
     * - Si requête GET → affiche le formulaire
     * - Si requête POST → crée un objet Projet
     * - Tente de l'enregistrer en base
     * - Redirige vers le tableau de bord en cas de succès
     *
     * @return void
     */
    public function create(): void
    {
        $template = "create/create";
        $error = null;

        // Vérifie si le formulaire a été soumis
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            // Création de l'objet métier Projet
            $project = new Projet(
                null, // id null car nouveau projet
                $_POST['titre'] ?? '',
                $_POST['description'] ?? '',
                $_POST['short_description'] ?? '',
                $_POST['image'] ?? ''
            );

            // Tentative d'insertion en base
            $success = $this->createRepository->createProjet($project);

            if ($success) {
                // Redirection vers le tableau de bord après création
                header("Location: index.php?page=board");
                exit;
            } else {
                $error = "Impossible de créer le projet.";
            }
        }

        // Chargement du layout principal
        require_once "views/layout.phtml";
    }
}