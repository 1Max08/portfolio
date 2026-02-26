<?php
namespace controllers;

require_once "repositories/BoardRepository.php";
require_once "repositories/MessageRepository.php";
require_once "repositories/ExperienceRepository.php";
require_once "AbstractController.php";

use repositories\BoardRepository;
use repositories\MessageRepository;
use repositories\ExperienceRepository;

/**
 * Contrôleur du tableau de bord (Back-office).
 *
 * Ce contrôleur gère :
 * - La mise à jour du profil
 * - L'ajout et la suppression de compétences
 * - La suppression de projets
 * - La gestion des messages (lecture / suppression)
 * - La suppression des expériences
 *
 * Il nécessite que l'utilisateur soit authentifié.
 */
class BoardController extends AbstractController
{
    /**
     * Repository pour la gestion du profil, projets et compétences.
     *
     * @var BoardRepository
     */
    private BoardRepository $boardRepository;

    /**
     * Repository pour la gestion des messages.
     *
     * @var MessageRepository
     */
    private MessageRepository $messageRepository;

    /**
     * Constructeur du contrôleur.
     *
     * Initialise les repositories.
     * Démarre la session.
     * Vérifie que l'utilisateur est connecté.
     */
    public function __construct()
    {
        $this->boardRepository = new BoardRepository();
        $this->messageRepository = new MessageRepository();
        $this->startSession();
        $this->requireLogin();
    }

    /**
     * Méthode principale du tableau de bord.
     *
     * Gère :
     * - Les requêtes POST (création / modification)
     * - Les requêtes GET (suppression / actions spécifiques)
     * - La récupération des données pour affichage
     *
     * @return void
     */
    public function board(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            /**
             * Mise à jour du profil utilisateur
             */
            if (isset($_POST['updateProfil'])) {
                $introduction = $_POST['introduction'] ?? '';
                $description = $_POST['description'] ?? '';
                $profilImage = $_POST['profil_image'] ?? '';

                $this->boardRepository->updateProfil(
                    $introduction,
                    $description,
                    $profilImage
                );

                // Redirection pour éviter la resoumission du formulaire
                header("Location: index.php?page=board");
                exit;
            }

            /**
             * Ajout d'une compétence
             */
            if (isset($_POST['addCompetence'])) {
                $name = $_POST['competence_name'] ?? '';
                $level = $_POST['competence_level'] ?? '';

                $this->boardRepository->addCompetence($name, $level);

                header("Location: index.php?page=board");
                exit;
            }
        }

        /**
         * Suppression d'une compétence
         */
        if (isset($_GET['deleteCompetence'])) {
            $this->boardRepository->deleteCompetence((int) $_GET['deleteCompetence']);
            header("Location: index.php?page=board");
            exit;
        }

        /**
         * Suppression d'un projet
         */
        if (isset($_GET['deleteProject'])) {
            $this->boardRepository->deleteProjet((int) $_GET['deleteProject']);
            header("Location: index.php?page=board");
            exit;
        }

        /**
         * Marquer un message comme lu
         */
        if (isset($_GET['readMessage'])) {
            $this->messageRepository->markAsRead((int) $_GET['readMessage']);
            header("Location: index.php?page=board");
            exit;
        }

        /**
         * Supprimer un message
         */
        if (isset($_GET['deleteMessage'])) {
            $this->messageRepository->delete((int) $_GET['deleteMessage']);
            header("Location: index.php?page=board");
            exit;
        }

        /**
         * Suppression d'une expérience
         */
        if (isset($_GET['deleteExperience'])) {
            $expRepo = new ExperienceRepository();
            $expRepo->deleteExperience((int) $_GET['deleteExperience']);
            header("Location: index.php?page=board");
            exit;
        }

        // Profil utilisateur
        $profil = $this->boardRepository->getProfil();

        // Liste des projets
        $projects = $this->boardRepository->getProjet();

        // Liste des compétences
        $competences = $this->boardRepository->getCompetences();

        // Liste des messages
        $messages = $this->messageRepository->getAll();

        // Liste des expériences
        $experienceRepo = new ExperienceRepository();
        $experiences = $experienceRepo->getExperience();

        /**
         * Chargement de la vue
         */
        $template = "board/board";
        require_once "views/layout.phtml";
    }
}