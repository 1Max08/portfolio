<?php
namespace repositories;

require_once "services/database.php";
require_once "models/Experience.php";

use models\Experience;

class ExperienceRepository {
    private \PDO $pdo;

    public function __construct() {
        $this->pdo = getConnexion();
    }

    public function getExperienceById(int $id): ?Experience {
        $query = $this->pdo->prepare('SELECT * FROM experience WHERE id = :id');
        $query->bindParam(':id', $id, \PDO::PARAM_INT);
        $query->execute();

        $data = $query->fetch(\PDO::FETCH_ASSOC);
        if (!$data) return null;

        return new Experience(
            (int)$data['id'],
            $data['title'] ?? '',
            $data['description'] ?? '',
            $data['short_description'] ?? '',
            $data['image'] ?? ''
        );
    }

    public function getExperience(): array {
        $query = $this->pdo->prepare('SELECT * FROM experience ORDER BY id ASC');
        $query->execute();
        $rows = $query->fetchAll(\PDO::FETCH_ASSOC);

        $items = [];
        foreach ($rows as $row) {
            $items[] = new Experience(
                (int)$row['id'],
                $row['title'] ?? '',
                $row['description'] ?? '',
                $row['short_description'] ?? '',
                $row['image'] ?? ''
            );
        }

        return $items;
    }

    public function createExperience(Experience $exp): bool {
        $stmt = $this->pdo->prepare('INSERT INTO experience (title, description, image, short_description) VALUES (?, ?, ?, ?)');
        $stmt->execute([
            $exp->title,
            $exp->description,
            $exp->image,
            $exp->short_description
        ]);
        return $stmt->rowCount() > 0;
    }

    public function updateExperience(int $id, string $title, string $description, string $image, string $short_description): bool {
        $stmt = $this->pdo->prepare('UPDATE experience SET title = ?, description = ?, image = ?, short_description = ? WHERE id = ?');
        $stmt->execute([$title, $description, $image, $short_description, $id]);
        return $stmt->rowCount() > 0;
    }

    public function deleteExperience(int $id): bool {
        $stmt = $this->pdo->prepare('DELETE FROM experience WHERE id = ?');
        return $stmt->execute([$id]);
    }
}
