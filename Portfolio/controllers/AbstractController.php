<?php
namespace controllers;

abstract class AbstractController {

    protected function startSession() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    protected function requireLogin() {
        $this->startSession();
        if (!isset($_SESSION['user'])) {
            header("Location: index.php?page=about");
            exit;
        }
    }
    
        protected function logout() {
        $this->startSession();
        $_SESSION = [];
        session_unset();
        session_destroy();
        setcookie(session_name(), '', time() - 3600);
        header("Location: index.php?page=login");
        exit;
    }
}