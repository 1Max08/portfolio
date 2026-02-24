<?php
namespace controllers;

require_once "repositories/BoardRepository.php";
require_once "repositories/MessageRepository.php";
require_once "AbstractController.php";

use repositories\BoardRepository;
use repositories\MessageRepository;

class BoardController extends AbstractController {

    private $boardRepository;

    public function logoutUser() {
        $this->logout();
    }

    public function __construct() {
        $this->boardRepository = new BoardRepository();
    }

    public function board() {
        $this->requireLogin();

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

        $profil = $this->boardRepository->getProfil();
        $projet = $this->boardRepository->getProjet();
        $messages = $messageRepo->getAll();

        $template = "board/board";
        require_once "views/layout.phtml";
    }

    public function getProfil(): array {
        return $this->boardRepository->getProfil();
    }
}