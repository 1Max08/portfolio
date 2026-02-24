<?php

namespace controllers;

use models\User;
require_once "AbstractController.php";
require_once "models/User.php";

class LogoutController extends AbstractController {

    public function logout(): void {
        if (!isset($_SESSION)) session_start();
        
        if (isset($_SESSION['user']) && $_SESSION['user'] instanceof User) {
            $_SESSION = [];
            session_unset();
            session_destroy();
            setcookie(session_name(), '', time() - 3600);
        }

        header("Location: index.php?page=about");
        exit;
    }
}