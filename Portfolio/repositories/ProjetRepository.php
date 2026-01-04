<?php

namespace repositories;

require_once "services/database.php";

class ProjetRepository {
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

    public function getProjet(): array {
        $query = $this->pdo->prepare('SELECT * FROM projet');
        $query->execute();
        return $query->fetchAll(\PDO::FETCH_ASSOC);
    }
}