<?php
namespace repositories;

require_once "services/database.php";
require_once "models/Project.php";
require_once "models/Profil.php";

use models\Project;
use models\Profil;

class AboutRepository {

    private \PDO $pdo;

    public function __construct() {
        $this->pdo = getConnexion();
    }

    // Retourne un objet Profil
    public function getProfil(): ?Profil {
        $query = $this->pdo->prepare('SELECT * FROM profil WHERE id = 1');
        $query->execute();
        $data = $query->fetch(\PDO::FETCH_ASSOC);

        if (!$data) return null;

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