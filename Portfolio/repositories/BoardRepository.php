<?php
namespace repositories;

require_once "services/database.php";
require_once "repositories/AbstractRepository.php";
require_once "models/Profil.php";
require_once "models/Projet.php";

use models\Profil;
use models\Projet;

class BoardRepository extends AbstractRepository {

    public function getProfil(): Profil {
        $query = $this->pdo->prepare('SELECT * FROM profil WHERE id = 1');
        $query->execute();
        $data = $query->fetch(\PDO::FETCH_ASSOC);

        return new Profil(
            (int)$data['id'],
            $data['introduction'] ?? '',
            $data['description'] ?? '',
            $data['profil_image'] ?? ''
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
    
    public function updateProfil(string $introduction, string $description, string $profil_image): bool {
        $query = $this->pdo->prepare(
            'UPDATE profil SET introduction = ?, description = ?, profil_image = ? WHERE id = 1'
    );

    return $query->execute([$introduction, $description, $profil_image]);
    }

    public function deleteProjet(int $id): void {
        $sql = "DELETE FROM projet WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':id', $id, \PDO::PARAM_INT);
        $stmt->execute();
    }

    public function getCompetences(): array {
        $stmt = $this->pdo->query("SELECT * FROM competence ORDER BY id ASC");
        return $stmt->fetchAll(\PDO::FETCH_OBJ);
    }

    public function getCompetenceById(int $id) {
        $stmt = $this->pdo->prepare("SELECT * FROM competence WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(\PDO::FETCH_OBJ);
    }

    public function addCompetence(string $name, string $level): bool {
        $stmt = $this->pdo->prepare("INSERT INTO competence (name, level) VALUES (?, ?)");
        return $stmt->execute([$name, $level]);
    }

    public function deleteCompetence(int $id): bool {
        $stmt = $this->pdo->prepare("DELETE FROM competence WHERE id = ?");
        return $stmt->execute([$id]);
    }
}