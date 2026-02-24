<?php

namespace controllers;

require "repositories/AboutRepository.php";

use repositories\AboutRepository;

class AboutController {
    private $aboutRepository;

    public function __construct() {
        session_start();
        $this->aboutRepository = new AboutRepository();
    }

    public function about() {
        $profil = $this->aboutRepository->getProfil();
        $projet = $this->aboutRepository->getProjet();

        if (isset($_POST['contact_submit'])) {

            $name = trim($_POST['contact_name']);
            $email = trim($_POST['contact_email']);
            $subject = trim($_POST['contact_subject']);
            $message = trim($_POST['contact_message']);

            if ($name && $email && $message) {
                $contactRepo = new \repositories\ContactRepository();
                $contactRepo->saveMessage($name, $email, $subject, $message);

                $_SESSION['flash'] = [
                    'type' => 'success',
                    'message' => 'Message envoyé avec succès.'
                ];

                header("Location: index.php?page=about");
                exit;
            } else {
                $_SESSION['flash'] = [
                    'type' => 'error',
                    'message' => 'Veuillez remplir tous les champs obligatoires.'
                ];
            }
        }

        $template = "about/about";
        require_once "views/layout.phtml";
    }
}