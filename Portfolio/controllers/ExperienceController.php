<?php
namespace controllers;

require_once "repositories/ExperienceRepository.php";
require_once "models/Experience.php";
require_once "AbstractController.php";

use repositories\ExperienceRepository;
use models\Experience;

class ExperienceController extends AbstractController {

    private ExperienceRepository $experienceRepository;

    public function __construct() {
        $this->experienceRepository = new ExperienceRepository();
    }

    public function experience(): void {
        $error = null;
        $experience = null;

        if (isset($_GET['id'])) {
            $id = intval($_GET['id']);
            $experience = $this->experienceRepository->getExperienceById($id);

            if (!$experience) {
                $error = "Experience introuvable.";
            }
        } else {
            $error = "Aucune experience sélectionnée.";
        }

        $template = "experience/experience";
        require_once "views/layout.phtml";
    }
}
