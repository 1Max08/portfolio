<?php
namespace controllers;

require_once "repositories/CompetenceRepository.php";
require_once "AbstractController.php";

use repositories\CompetenceRepository;

class CompetenceController extends AbstractController {
    private CompetenceRepository $competenceRepository;

    public function __construct() {
        $this->competenceRepository = new CompetenceRepository();
        $this->startSession();
        $this->requireLogin();
    }

    public function list(): void {
        $competences = $this->competenceRepository->getAll();
        $template = "competence/list";
        require_once "views/layout.phtml";
    }

    public function add(): void {
        $error = null;
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'] ?? '';
            $level = $_POST['level'] ?? '';

            if (!$this->competenceRepository->add($name, $level)) {
                $error = "Impossible d'ajouter la compétence.";
            } else {
                header("Location: index.php?page=competences");
                exit;
            }
        }

        $template = "competence/add";
        require_once "views/layout.phtml";
    }

    public function delete(int $id): void {
        $this->competenceRepository->delete($id);
        header("Location: index.php?page=competences");
        exit;
    }
}