<?php
namespace models;

class Competence
{
    public int $id;
    public string $name;
    public string $level;

    public function __construct(int $id, string $name, string $level)
    {
        $this->id = $id;
        $this->name = $name;
        $this->level = $level;
    }
}