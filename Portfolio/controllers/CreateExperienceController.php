<?php
namespace controllers;

require_once "repositories/ExperienceRepository.php";
require_once "AbstractController.php";
require_once "models/Experience.php";

use repositories\ExperienceRepository;
use models\Experience;

class CreateExperienceController extends AbstractController {
    private ExperienceRepository $repo;

    public function __construct() {
        $this->repo = new ExperienceRepository();
        $this->startSession();
        $this->requireLogin();
    }

    public function createExperience(): void {
        $template = "createExperience/createExperience";
        $error = null;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $experience = new Experience(
                null,
                $_POST['title'] ?? '',
                $_POST['description'] ?? '',
                $_POST['short_description'] ?? '',
                $_POST['image'] ?? ''
            );

            $success = $this->repo->createExperience($experience);

            if ($success) {
                header("Location: index.php?page=board");
                exit;
            } else {
                $error = "Impossible de créer l'expérience.";
            }
        }

        require_once "views/layout.phtml";
    }
}
