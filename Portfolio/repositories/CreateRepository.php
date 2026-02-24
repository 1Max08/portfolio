<?php

namespace repositories;

require_once "services/database.php";

class CreateRepository {

    private $pdo;

    public function __construct() {
        $this->pdo = getConnexion();
    }

    public function getProjetById($id) {
        $query = $this->pdo->prepare('SELECT * FROM projet WHERE id = :id');
        $query->bindParam(':id', $id, \PDO::PARAM_INT);
        $query->execute();
        return $query->fetch(\PDO::FETCH_ASSOC);
    }

    public function createProjet($titre, $description, $image, $short_description) {
        $query = $this->pdo->prepare('INSERT INTO projet (titre, description, image, short_description) VALUES (?, ?, ?, ?)');
        $query->execute([$titre, $description, $image, $short_description]);

        return $query->rowCount() > 0;
    }
}