<?php

namespace repositories;

require_once "services/database.php";
require_once "models/Projet.php";

use models\Projet;

class ChangeRepository {

    private $pdo;

    public function __construct() {
        $this->pdo = getConnexion();
    }

    public function getProjetById(int $id): ?Projet {
        $query = $this->pdo->prepare(
            'SELECT * FROM projet WHERE id = :id'
        );
        $query->bindParam(':id', $id, \PDO::PARAM_INT);
        $query->execute();

        $data = $query->fetch(\PDO::FETCH_ASSOC);

        if (!$data) {
            return null;
        }

        return new Projet(
            $data['id'],
            $data['titre'],
            $data['description'],
            $data['short_description'],
            $data['image']
        );
    }

    public function updateProjet(
        int $id,
        string $titre,
        string $description,
        string $image,
        string $short_description
    ): bool {
        $query = $this->pdo->prepare(
            'UPDATE projet 
             SET titre = ?, description = ?, image = ?, short_description = ? 
             WHERE id = ?'
        );

        $query->execute([
            $titre,
            $description,
            $image,
            $short_description,
            $id
        ]);

        return $query->rowCount() > 0;
    }
}