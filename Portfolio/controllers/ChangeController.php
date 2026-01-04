<?php

namespace controllers;

require_once "repositories/ChangeRepository.php";

use repositories\ChangeRepository;

class ChangeController {

    private $changeRepository;

    public function __construct() {
        $this->changeRepository = new ChangeRepository();
    }

    public function change() {
        if (isset($_GET['id'])) {
            $id = intval($_GET['id']);

            $projet = $this->changeRepository->getProjetById($id);



            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $titre = $_POST['titre'];
                $description = $_POST['description'];
                $image = $_POST['image'];
                $short_description = $_POST['short_description'];

                $result = $this->changeRepository->UpdateProjet($id, $titre, $description, $image, $short_description);
            }

            $template = "change/change";
            require_once "views/layout.phtml";
        } 
    }
}