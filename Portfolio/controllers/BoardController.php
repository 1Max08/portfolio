<?php

namespace controllers;

require "repositories/BoardRepository.php";
require "repositories/MessageRepository.php";

use repositories\BoardRepository;
use repositories\MessageRepository;

class BoardController {
    private $boardRepository;

    public function __construct() {
        session_start();
        $this->boardRepository = new BoardRepository();
    }
    
public function getProfil(): array {
    return $this->boardRepository->getProfil();
}
  
    
public function board() {
    if (!isset($_SESSION['user'])) {
        header("Location: index.php?page=login");
        exit;
    }

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
}