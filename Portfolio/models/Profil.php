<?php
namespace models;

class Profil {
    public int $id;
    public string $introduction;
    public string $description;
    public string $profil_image;

    public function __construct(int $id, string $introduction, string $description, string $profil_image) {
        $this->id = $id;
        $this->introduction = $introduction;
        $this->description = $description;
        $this->profil_image = $profil_image;
    }
}