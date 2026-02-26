<?php
namespace controllers;

require_once "repositories/ChangeCompetenceRepository.php";
require_once "AbstractController.php";

use repositories\ChangeCompetenceRepository;

class ChangeCompetenceController extends AbstractController {
    private ChangeCompetenceRepository $repo;

    public function __construct() {
        $this->repo = new ChangeCompetenceRepository();
        $this->startSession();
        $this->requireLogin();
    }

    public function changeCompetence(): void {
        $competence = null;
        $error = null;

        $id = (int)($_GET['id'] ?? 0);
        if (!$id || !($competence = $this->repo->getCompetenceById($id))) {
            $error = "Compétence introuvable.";
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'] ?? '';
            $level = $_POST['level'] ?? '';

            if ($this->repo->updateCompetence($id, $name, $level)) {
                header("Location: index.php?page=board");
                exit;
            } else {
                $error = "Impossible de modifier la compétence.";
            }
        }

        $template = "changeCompetence/changeCompetence";
        require_once "views/layout.phtml";
    }

}