<?php
namespace repositories;

require_once "services/database.php";
require_once "models/Projet.php";
require_once "models/Profil.php";

use models\Projet;
use models\Profil;

class AboutRepository {

    private \PDO $pdo;

    public function __construct() {
        $this->pdo = getConnexion();
    }

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