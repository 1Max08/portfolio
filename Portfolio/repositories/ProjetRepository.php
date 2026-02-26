<?php

namespace repositories;

require_once "services/database.php";
require_once "models/Projet.php";

use models\Projet;

class ProjetRepository {
    private \PDO $pdo;

    public function __construct() {
        $this->pdo = getConnexion();
    }

    public function getProjetById(int $id): ?Projet {
        $query = $this->pdo->prepare('SELECT * FROM projet WHERE id = :id');
        $query->bindParam(':id', $id, \PDO::PARAM_INT);
        $query->execute();

        $data = $query->fetch(\PDO::FETCH_ASSOC);

        if (!$data) {
            return null;
        }

        return new Projet(
            (int)$data['id'],
            $data['titre'] ?? '',
            $data['description'] ?? '',
            $data['short_description'] ?? '',
            $data['image'] ?? ''
        );
    }

    public function getProjet(): array {
        $query = $this->pdo->prepare('SELECT * FROM projet');
        $query->execute();

        $rows = $query->fetchAll(\PDO::FETCH_ASSOC);

        $projects = [];
        foreach ($rows as $row) {
            $projects[] = new Projet(
                (int)$row['id'],
                $row['titre'] ?? '',
                $row['description'] ?? '',
                $row['short_description'] ?? '',
                $row['image'] ?? ''
            );
        }

        return $projects;
    }
}