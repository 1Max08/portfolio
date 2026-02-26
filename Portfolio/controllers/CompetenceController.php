<?php
namespace controllers;

require_once "repositories/CompetenceRepository.php";
require_once "AbstractController.php";

use repositories\CompetenceRepository;

/**
 * Contrôleur responsable de la gestion des compétences.
 *
 * Fonctionnalités :
 * - Affichage de la liste des compétences
 * - Ajout d'une nouvelle compétence
 * - Suppression d'une compétence
 *
 * Hérite de AbstractController pour :
 * - La gestion des sessions
 * - La vérification d'authentification
 */
class CompetenceController extends AbstractController
{
    /**
     * Repository permettant l'accès aux données des compétences.
     *
     * @var CompetenceRepository
     */
    private CompetenceRepository $competenceRepository;

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
        $this->competenceRepository = new CompetenceRepository();
        $this->startSession();
        $this->requireLogin();
    }

    /**
     * Affiche la liste de toutes les compétences.
     *
     * Récupère les données via le repository
     * puis charge la vue correspondante.
     *
     * @return void
     */
    public function list(): void
    {
        $competences = $this->competenceRepository->getAll();
        $template = "competence/list";
        require_once "views/layout.phtml";
    }

    /**
     * Gère l'ajout d'une nouvelle compétence.
     *
     * - Si la requête est en POST : tente d'ajouter la compétence
     * - En cas de succès : redirection vers la liste
     * - En cas d'échec : affiche un message d'erreur
     *
     * @return void
     */
    public function add(): void
    {
        $error = null;

        // Vérifie si le formulaire a été soumis
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            // Récupération des données du formulaire
            $name = $_POST['name'] ?? '';
            $level = $_POST['level'] ?? '';

            // Tentative d'insertion en base de données
            if (!$this->competenceRepository->add($name, $level)) {
                $error = "Impossible d'ajouter la compétence.";
            } else {
                // Redirection en cas de succès
                header("Location: index.php?page=competences");
                exit;
            }
        }

        // Chargement du template d'ajout
        $template = "competence/add";
        require_once "views/layout.phtml";
    }

    /**
     * Supprime une compétence par son identifiant.
     *
     * @param int $id Identifiant de la compétence à supprimer
     * @return void
     */
    public function delete(int $id): void
    {
        $this->competenceRepository->delete($id);

        // Redirection après suppression
        header("Location: index.php?page=competences");
        exit;
    }
}