<?php
namespace repositories;

require_once "services/database.php";
require_once "repositories/AbstractRepository.php";
require_once "models/Profil.php";
require_once "models/Project.php";

use models\Profil;
use models\Project;

class BoardRepository extends AbstractRepository {

    public function getProfil(): Profil {
        $query = $this->pdo->prepare('SELECT * FROM profil WHERE id = 1');
        $query->execute();
        $data = $query->fetch(\PDO::FETCH_ASSOC);

        return new Profil(
            (int)$data['id'],
            $data['introduction'] ?? '',
            $data['description'] ?? ''
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

    public function updateProfil(string $introduction, string $description): bool {
        $query = $this->pdo->prepare('UPDATE profil SET introduction = ?, description = ? WHERE id = 1');
        return $query->execute([$introduction, $description]);
    }

    public function deleteProjet(int $id): void {
        $sql = "DELETE FROM projet WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':id', $id, \PDO::PARAM_INT);
        $stmt->execute();
    }
}