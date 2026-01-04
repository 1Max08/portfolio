<?php

namespace repositories;

require_once "services/database.php";

class ChangeRepository {

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

    public function UpdateProjet($id, $titre, $description, $image, $short_description) {
        $query = $this->pdo->prepare('UPDATE projet SET titre = ?, description = ?, image = ?, short_description = ? WHERE id = ?');
        $query->execute([$titre, $description, $image, $short_description, $id]);
        return $query->rowCount() > 0;
    }
}