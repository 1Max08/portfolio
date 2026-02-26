<?php
namespace repositories;

require_once "services/database.php";
require_once "models/Competence.php";

use models\Competence;

class ChangeCompetenceRepository {
    private \PDO $pdo;

    public function __construct() {
        $this->pdo = getConnexion();
    }

    public function getCompetenceById(int $id): Competence|bool {
        $stmt = $this->pdo->prepare("SELECT * FROM competence WHERE id = ?");
        $stmt->execute([$id]);
        $row = $stmt->fetch(\PDO::FETCH_ASSOC);

        return $row ? new Competence((int)$row['id'], $row['name'], $row['level']) : false;
    }

    public function updateCompetence(int $id, string $name, string $level): bool {
        $stmt = $this->pdo->prepare("UPDATE competence SET name = ?, level = ? WHERE id = ?");
        return $stmt->execute([$name, $level, $id]);
    }
}