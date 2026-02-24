<?php
namespace controllers;

require_once "repositories/BoardRepository.php";
require_once "repositories/MessageRepository.php";
require_once "AbstractController.php";

use repositories\BoardRepository;
use repositories\MessageRepository;

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
        // Récupération du profil
        $profil = $this->boardRepository->getProfil();

        // Récupération des projets sous forme de model Project
        $projects = $this->boardRepository->getProjet();

        // Gestion des actions sur les messages
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

        // Gestion suppression projet
        if (isset($_GET['deleteProject'])) {
            $this->boardRepository->deleteProjet((int)$_GET['deleteProject']);
            header("Location: index.php?page=board");
            exit;
        }

        // Récupération des messages sous forme de model Message
        $messages = $this->messageRepository->getAll();

        // Chargement du template
        $template = "board/board";
        require_once "views/layout.phtml";
    }
}