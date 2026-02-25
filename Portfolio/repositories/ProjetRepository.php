<?php

namespace repositories;

require_once "services/database.php";
require_once "models/Project.php";

use models\Project;

class ProjetRepository {
    private \PDO $pdo;

    public function __construct() {
        $this->pdo = getConnexion();
    }

    public function getProjetById(int $id): ?Project {
        $query = $this->pdo->prepare('SELECT * FROM projet WHERE id = :id');
        $query->bindParam(':id', $id, \PDO::PARAM_INT);
        $query->execute();

        $data = $query->fetch(\PDO::FETCH_ASSOC);

        if (!$data) {
            return null;
        }

        return new Project(
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
            $projects[] = new Project(
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