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
        $profil = $this->boardRepository->getProfil();
        $projects = $this->boardRepository->getProjet();
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $introduction = $_POST['introduction'] ?? '';
            $description = $_POST['description'] ?? '';
            $profilImage = $_POST['profil_image'] ?? '';
            $this->boardRepository->updateProfil($introduction, $description, $profilImage);

            $profil = $this->boardRepository->getProfil();

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

    if (isset($_GET['deleteProject'])) {
        $this->boardRepository->deleteProjet((int)$_GET['deleteProject']);
        header("Location: index.php?page=board");
        exit;
    }

    $messages = $this->messageRepository->getAll();

    $template = "board/board";
        require_once "views/layout.phtml";
    }
}