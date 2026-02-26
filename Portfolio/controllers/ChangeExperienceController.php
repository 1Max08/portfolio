<?php
namespace controllers;

require_once "repositories/ExperienceRepository.php";
require_once "AbstractController.php";

use repositories\ExperienceRepository;

class ChangeExperienceController extends AbstractController {
    private ExperienceRepository $repo;

    public function __construct() {
        $this->repo = new ExperienceRepository();
        $this->startSession();
        $this->requireLogin();
    }

    public function changeExperience(): void {
        $template = "changeExperience/changeExperience";
        $error = null;

        if (!isset($_GET['id'])) {
            header("Location: index.php?page=board");
            exit;
        }

        $id = (int)$_GET['id'];
        $experience = $this->repo->getExperienceById($id);

        if (!$experience) {
            $error = "Experience introuvable.";
            require_once "views/layout.phtml";
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $title = $_POST['title'] ?? '';
            $description = $_POST['description'] ?? '';
            $image = $_POST['image'] ?? '';
            $short_description = $_POST['short_description'] ?? '';

            $success = $this->repo->updateExperience($id, $title, $description, $image, $short_description);

            if ($success) {
                header("Location: index.php?page=board");
                exit;
            } else {
                $error = "Impossible de modifier l'expérience.";
            }
        }

        require_once "views/layout.phtml";
    }

}
