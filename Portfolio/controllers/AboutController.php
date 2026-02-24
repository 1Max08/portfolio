<?php
namespace controllers;

require "repositories/AboutRepository.php";
require "models/Project.php";
require "models/Profil.php";

use repositories\AboutRepository;
use models\Project;
use models\Profil;

class AboutController {
    private AboutRepository $aboutRepository;

    public function __construct() {
        session_start();
        $this->aboutRepository = new AboutRepository();
    }

    public function about() {
        $profilData = $this->aboutRepository->getProfil();
        $profil = new Profil(
            $profilData['id'] ?? 0,
            $profilData['introduction'] ?? '',
            $profilData['description'] ?? ''
        );

        $projectsData = $this->aboutRepository->getProjet();
        $projet = [];
        foreach ($projectsData as $p) {
            $projet[] = new Project(
                $p['id'],
                $p['titre'],
                $p['description'] ?? '',
                $p['short_description'] ?? '',
                $p['image'] ?? ''
            );
        }

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