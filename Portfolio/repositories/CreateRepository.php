<?php
namespace repositories;

require_once "services/database.php";
require_once "models/Project.php";

use models\Project;

class CreateRepository {

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

    public function createProjet(Project $project): bool {
        $query = $this->pdo->prepare(
            'INSERT INTO projet (titre, description, image, short_description) VALUES (?, ?, ?, ?)'
        );

        $query->execute([
            $project->title,
            $project->description,
            $project->image,
            $project->short_description
        ]);

        return $query->rowCount() > 0;
    }
}