<?php
namespace repositories;

require_once "services/database.php";
require_once "models/Projet.php";

use models\Projet;

class CreateRepository {

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

    public function createProjet(Projet $project): bool {
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