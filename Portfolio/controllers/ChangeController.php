<?php
namespace controllers;

require_once "repositories/ChangeRepository.php";
require_once "AbstractController.php";

use repositories\ChangeRepository;

class ChangeController extends AbstractController {

    private $changeRepository;

    public function __construct() {
        $this->changeRepository = new ChangeRepository();
    }

    public function change() {
        $this->requireLogin();

        if (isset($_GET['id'])) {
            $id = intval($_GET['id']);
            $projet = $this->changeRepository->getProjetById($id);

            if (!$projet) {
                $error = "Projet introuvable.";
            }

            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $titre = $_POST['titre'];
                $description = $_POST['description'];
                $image = $_POST['image'];
                $short_description = $_POST['short_description'];

                $result = $this->changeRepository->UpdateProjet(
                    $id,
                    $titre,
                    $description,
                    $image,
                    $short_description
                );

                if ($result) {
                    header("Location: index.php?page=board");
                    exit;
                } else {
                    $error = "Impossible de modifier le projet.";
                }
            }

            $template = "change/change";
            require_once "views/layout.phtml";
        } else {
            header("Location: index.php?page=board");
            exit;
        }
    }
}