<?php

namespace repositories;

require_once "services/database.php";

class MessageRepository {
    private \PDO $pdo;

    public function __construct() {
        $this->pdo = getConnexion();
    }

    public function getAll(): array {
        $query = $this->pdo->query(
            "SELECT * FROM contact_message ORDER BY created_at DESC"
        );
        return $query->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function markAsRead(int $id): void {
        $query = $this->pdo->prepare(
            "UPDATE contact_message SET is_read = 1 WHERE id = :id"
        );
        $query->execute(['id' => $id]);
    }

    public function delete(int $id): void {
        $query = $this->pdo->prepare(
            "DELETE FROM contact_message WHERE id = :id"
        );
        $query->execute(['id' => $id]);
    }
}
