<?php

namespace App\DTOs;

class ContactMessageDTO
{
    public function __construct(
        public ?int $id,
        public string $name,
        public string $email,
        public ?string $subject,
        public string $message,
        public string $status = 'unread',
        public ?string $created_at = null,
        public ?string $updated_at = null
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            id: $data['id'] ?? null,
            name: $data['name'],
            email: $data['email'],
            subject: $data['subject'] ?? null,
            message: $data['message'],
            status: $data['status'] ?? 'unread',
            created_at: $data['created_at'] ?? null,
            updated_at: $data['updated_at'] ?? null
        );
    }

    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'email' => $this->email,
            'subject' => $this->subject,
            'message' => $this->message,
            'status' => $this->status,
        ];
    }
}
