<?php

namespace repositories;

require_once "services/database.php";
require_once "repositories/AbstractRepository.php";

class BoardRepository extends AbstractRepository  {

    public function getProfil(): array {
    $query = $this->pdo->prepare('SELECT * FROM profil WHERE id = 1');
    $query->execute();
    return $query->fetch(\PDO::FETCH_ASSOC);
}

    public function getProjet(): array {
        $query = $this->pdo->prepare('SELECT * FROM projet');
        $query->execute();
        return $query->fetchAll(\PDO::FETCH_ASSOC);
    }

public function updateProfil(string $introduction, string $description): bool {
    $query = $this->pdo->prepare('UPDATE profil SET introduction = ?, description = ? WHERE id = 1');
    return $query->execute([$introduction, $description]);
}


public function deleteProjet($id) {
    $sql = "DELETE FROM projet WHERE id = :id";
    $stmt = $this->pdo->prepare($sql);
    $stmt->bindParam(':id', $id, \PDO::PARAM_INT);
    $stmt->execute();
}
}