<?php
namespace repositories;

require_once "services/database.php";
require_once "models/Competence.php";

use models\Competence;

class CompetenceRepository {
    private \PDO $pdo;

    public function __construct() {
        $this->pdo = getConnexion();
    }

    public function getAll(): array {
        $stmt = $this->pdo->query("SELECT * FROM competence ORDER BY id ASC");
        $rows = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        $competences = [];
        foreach ($rows as $row) {
            $competences[] = new Competence(
                (int)$row['id'],
                $row['name'] ?? '',
                $row['level'] ?? ''
            );
        }
        return $competences;
    }

    public function add(string $name, string $level): bool {
        $stmt = $this->pdo->prepare("INSERT INTO competence (name, level) VALUES (?, ?)");
        return $stmt->execute([$name, $level]);
    }

    public function delete(int $id): bool {
        $stmt = $this->pdo->prepare("DELETE FROM competence WHERE id = ?");
        return $stmt->execute([$id]);
    }
}