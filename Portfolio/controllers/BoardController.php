<?php
namespace controllers;

require_once "repositories/BoardRepository.php";
require_once "repositories/MessageRepository.php";
require_once "AbstractController.php";

use repositories\BoardRepository;
use repositories\MessageRepository;

class BoardController extends AbstractController {
    private BoardRepository $boardRepository;

    public function __construct() {
        $this->boardRepository = new BoardRepository();
        $this->startSession();
        $this->requireLogin();
    }

    public function board(): void {
        $profil = $this->boardRepository->getProfil();
        $projects = $this->boardRepository->getProjet();

        $messageRepo = new MessageRepository();

        if (isset($_GET['readMessage'])) {
            $messageRepo->markAsRead((int)$_GET['readMessage']);
            header("Location: index.php?page=board");
            exit;
        }

        if (isset($_GET['deleteMessage'])) {
            $messageRepo->delete((int)$_GET['deleteMessage']);
            header("Location: index.php?page=board");
            exit;
        }

        if (isset($_GET['deleteProject'])) {
            $this->boardRepository->deleteProjet((int)$_GET['deleteProject']);
            header("Location: index.php?page=board");
            exit;
        }

        $messages = $messageRepo->getAll();
        $template = "board/board";
        require_once "views/layout.phtml";
    }
}