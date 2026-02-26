<?php
/**
 * controllers/AboutController.php
 *
 * Contrôleur de la page "About" (à propos). Ce contrôleur :
 * - récupère les données à afficher (profil, projets, compétences, expériences)
 * - gère le formulaire de contact (validation minimale, enregistrement et flash)
 * - prépare la vue `about/about` via la variable `$template`.
 */
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

class AboutController
{
    /** @var AboutRepository */
    private AboutRepository $aboutRepository;

    /**
     * Constructeur : démarre la session si nécessaire et crée le repository
     * qui servira à récupérer les données du profil et des projets.
     */
    public function __construct()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $this->aboutRepository = new AboutRepository();
    }

    /**
     * Méthode exécutée pour afficher la page About.
     * récupère :
     *  - `$profil` via AboutRepository::getProfil()
     *  - `$projet` via AboutRepository::getProjet()
     *  - `$competences` via CompetenceRepository::getAll()
     *  - `$experiences` via ExperienceRepository::getExperience()
     *
     * Elle gère aussi l'envoi du formulaire de contact : validation basique,
     * enregistrement via ContactRepository et flash message en session.
     */
    public function about(): void
    {
        // Chargement des données pour la vue
        $profil = $this->aboutRepository->getProfil();
        $projet = $this->aboutRepository->getProjet();

        // Compétences
        $competenceRepo = new CompetenceRepository();
        $competences = $competenceRepo->getAll();

        // Expériences
        $experienceRepo = new ExperienceRepository();
        $experiences = $experienceRepo->getExperience();

        // Traitement du formulaire de contact (si soumis)
        if (isset($_POST['contact_submit'])) {
            // Récupération et nettoyage minimal des champs
            $name = trim($_POST['contact_name']);
            $email = trim($_POST['contact_email']);
            $subject = trim($_POST['contact_subject']);
            $message = trim($_POST['contact_message']);

            // Validation basique : champs requis
            if ($name && $email && $message) {
                $contactRepo = new ContactRepository();
                // Sauvegarde du message en base
                $contactRepo->saveMessage($name, $email, $subject, $message);

                // Flash message de succès puis redirection (Post/Redirect/Get)
                $_SESSION['flash'] = [
                    'type' => 'success',
                    'message' => 'Message envoyé avec succès.'
                ];
                header("Location: index.php?page=about");
                exit;
            } else {
                // Flash d'erreur si les champs requis ne sont pas fournis
                $_SESSION['flash'] = [
                    'type' => 'error',
                    'message' => 'Veuillez remplir tous les champs obligatoires.'
                ];
            }
        }

        // Indiquer la vue à charger dans le layout
        $template = "about/about";
        require_once "views/layout.phtml";
    }
}