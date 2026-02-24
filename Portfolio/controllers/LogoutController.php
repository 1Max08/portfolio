<?php
namespace controllers;

require_once "AbstractController.php";

class LogoutController extends AbstractController {

    public function logout() {
        $this->startSession();
        $_SESSION = [];
        session_unset();
        session_destroy();
        setcookie(session_name(), '', time() - 3600);

        header("Location: index.php?page=about");
        exit;
    }
}