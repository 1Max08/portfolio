<?php

namespace repositories;

require_once "services/database.php";
require_once "repositories/AbstractRepository.php";

class AboutRepository extends AbstractRepository {

    public function getProfil(): array|bool {
        $pdo = getConnexion();

        $query = $pdo->prepare('SELECT description, introduction FROM profil WHERE id = 1');
        $query->execute();

        $result = $query->fetch(\PDO::FETCH_ASSOC);

        return $result;
    }

    public function getProjet(): array {
        $query = $this->pdo->prepare('SELECT * FROM projet');
        $query->execute();
        return $query->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getCategories(): array {
        $query = $this->pdo->prepare('SELECT * FROM category WHERE id');
        $query->execute();
        return $query->fetchAll(\PDO::FETCH_ASSOC);
    }

}