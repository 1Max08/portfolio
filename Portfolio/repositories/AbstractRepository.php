<?php

namespace repositories;

require_once "services/database.php";

abstract class AbstractRepository {
    protected \PDO $pdo;

    public function __construct() {
        $this->pdo = getConnexion();
    }

    abstract public function getProjet(): array;
}