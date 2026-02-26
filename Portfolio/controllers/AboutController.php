<?php
namespace controllers;

require_once "repositories/AboutRepository.php";
require_once "repositories/ContactRepository.php";
require_once "repositories/CompetenceRepository.php";
require_once "repositories/ExperienceRepository.php";
require_once "models/Projet.php";
require_once "models/Profil.php";

use repositories\AboutRepository;
use repositories\ContactRepository;
use repositories\CompetenceRepository;
use repositories\ExperienceRepository;
use models\Projet;
use models\Profil;

class AboutController {
    private AboutRepository $aboutRepository;

    public function __construct() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $this->aboutRepository = new AboutRepository();
    }

    public function about(): void {
        $profil = $this->aboutRepository->getProfil();
        $projet = $this->aboutRepository->getProjet();
        $competenceRepo = new CompetenceRepository();
        $competences = $competenceRepo->getAll();
        // charger les experiences pour la page about
        $experienceRepo = new ExperienceRepository();
        $experiences = $experienceRepo->getExperience();

        if (isset($_POST['contact_submit'])) {
            $name = trim($_POST['contact_name']);
            $email = trim($_POST['contact_email']);
            $subject = trim($_POST['contact_subject']);
            $message = trim($_POST['contact_message']);

            if ($name && $email && $message) {
                $contactRepo = new ContactRepository();
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