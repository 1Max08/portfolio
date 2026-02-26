<?php
namespace models;

class Experience
{
    public ?int $id;
    public string $title;
    public string $description;
    public string $short_description;
    public string $image;

    public function __construct(?int $id, string $title, string $description, string $short_description, string $image)
    {
        $this->id = $id;
        $this->title = $title;
        $this->description = $description;
        $this->short_description = $short_description;
        $this->image = $image;
    }
}
