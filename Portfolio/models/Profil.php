<?php
namespace models;

class Profil {
    public int $id;
    public string $introduction;
    public string $description;

    public function __construct(int $id, string $introduction, string $description) {
        $this->id = $id;
        $this->introduction = $introduction;
        $this->description = $description;
    }
}