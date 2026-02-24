<?php
namespace models;

class Message {
    public int $id;
    public string $name;
    public string $email;
    public ?string $subject;
    public string $message;
    public string $createdAt;
    public bool $isRead;

    public function __construct(
        int $id,
        string $name,
        string $email,
        ?string $subject,
        string $message,
        string $createdAt,
        bool $isRead
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->email = $email;
        $this->subject = $subject;
        $this->message = $message;
        $this->createdAt = $createdAt;
        $this->isRead = $isRead;
    }
}