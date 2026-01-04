<?php

namespace repositories;

require_once "services/database.php";

class ContactRepository {
    private \PDO $pdo;

    public function __construct() {
        $this->pdo = getConnexion();
    }

    public function saveMessage(
        string $name,
        string $email,
        ?string $subject,
        string $message
    ): bool {
        $query = $this->pdo->prepare(
            "INSERT INTO contact_message (name, email, subject, message)
             VALUES (:name, :email, :subject, :message)"
        );

        return $query->execute([
            'name' => $name,
            'email' => $email,
            'subject' => $subject,
            'message' => $message
        ]);
    }
}
