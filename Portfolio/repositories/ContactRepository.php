<?php

namespace repositories;

require_once "services/database.php";
require_once "models/ContactMessage.php";

use models\ContactMessage;
use PDO;

class ContactRepository {

    private PDO $pdo;

    public function __construct() {
        $this->pdo = getConnexion();
    }

    /**
     * Enregistre un nouveau message de contact
     */
    public function saveMessage(ContactMessage $message): bool {
        $query = $this->pdo->prepare(
            "INSERT INTO contact_message (name, email, subject, message)
             VALUES (:name, :email, :subject, :message)"
        );

        return $query->execute([
            'name' => $message->getName(),
            'email' => $message->getEmail(),
            'subject' => $message->getSubject(),
            'message' => $message->getMessage()
        ]);
    }
}