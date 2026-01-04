<?php

namespace controllers;

require "repositories/LoginRepository.php";

use repositories\LoginRepository;

class LoginController {
        private $loginRepository;

    public function __construct() {
        session_start();
        $this->loginRepository = new LoginRepository();
    }
    
    public function login(){
                $template = "login/login";
        require_once "views/layout.phtml";
        
    if (!empty($_POST['email']) && !empty($_POST['password'])) {
                $email = $_POST['email'];
        $password = $_POST['password'];

        $user = $this->loginRepository->getUserByEmail($email);
                if ($user && password_verify($password, $user["password"])) {
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