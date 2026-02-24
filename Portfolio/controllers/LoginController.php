<?php

namespace controllers;

require_once "repositories/LoginRepository.php";

use repositories\LoginRepository;
use models\User;

class LoginController {
    private LoginRepository $loginRepository;

    public function __construct() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $this->loginRepository = new LoginRepository();
    }

    public function login(): void {
        $template = "login/login";
        require_once "views/layout.phtml";

        if (!empty($_POST['email']) && !empty($_POST['password'])) {
            $email = trim($_POST['email']);
            $password = $_POST['password'];

            $user = $this->loginRepository->getUserByEmail($email);

            if ($user instanceof User && password_verify($password, $user->getPassword())) {
                $_SESSION['user'] = $user;
                header("Location: index.php?page=board");
                exit();
            } else {
                header("Location: index.php?page=login");
                exit();
            }
        }
    }
}