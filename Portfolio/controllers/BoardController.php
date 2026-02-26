<?php
namespace controllers;

require_once "repositories/BoardRepository.php";
require_once "repositories/MessageRepository.php";
require_once "repositories/ExperienceRepository.php";
require_once "AbstractController.php";

use repositories\BoardRepository;
use repositories\MessageRepository;
use repositories\ExperienceRepository;

class BoardController extends AbstractController {

    private BoardRepository $boardRepository;
    private MessageRepository $messageRepository;

    public function __construct() {
        $this->boardRepository = new BoardRepository();
        $this->messageRepository = new MessageRepository();
        $this->startSession();
        $this->requireLogin();
    }
    
    public function board(): void {

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            if (isset($_POST['updateProfil'])) {
                $introduction = $_POST['introduction'] ?? '';
                $description  = $_POST['description'] ?? '';
                $profilImage  = $_POST['profil_image'] ?? '';

                $this->boardRepository->updateProfil(
                    $introduction,
                    $description,
                    $profilImage
                );

                header("Location: index.php?page=board");
                exit;
            }

            if (isset($_POST['addCompetence'])) {
                $name  = $_POST['competence_name'] ?? '';
                $level = $_POST['competence_level'] ?? '';

                $this->boardRepository->addCompetence($name, $level);

                header("Location: index.php?page=board");
                exit;
            }

        }

        if (isset($_GET['deleteCompetence'])) {
            $this->boardRepository->deleteCompetence((int)$_GET['deleteCompetence']);
            header("Location: index.php?page=board");
            exit;
        }

        if (isset($_GET['deleteProject'])) {
            $this->boardRepository->deleteProjet((int)$_GET['deleteProject']);
            header("Location: index.php?page=board");
            exit;
        }

        if (isset($_GET['readMessage'])) {
            $this->messageRepository->markAsRead((int)$_GET['readMessage']);
            header("Location: index.php?page=board");
            exit;
        }

        if (isset($_GET['deleteMessage'])) {
            $this->messageRepository->delete((int)$_GET['deleteMessage']);
            header("Location: index.php?page=board");
            exit;
        }

        if (isset($_GET['deleteExperience'])) {
            $expRepo = new ExperienceRepository();
            $expRepo->deleteExperience((int)$_GET['deleteExperience']);
            header("Location: index.php?page=board");
            exit;
        }

        $profil      = $this->boardRepository->getProfil();
        $projects    = $this->boardRepository->getProjet();
        $competences = $this->boardRepository->getCompetences();
        $messages    = $this->messageRepository->getAll();

        // charger les experiences via ExperienceRepository
        $experienceRepo = new ExperienceRepository();
        $experiences = $experienceRepo->getExperience();

        $template = "board/board";
        require_once "views/layout.phtml";
    }
}