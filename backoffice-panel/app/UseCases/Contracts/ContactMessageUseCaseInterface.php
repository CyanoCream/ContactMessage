<?php

namespace App\UseCases\Contracts;

use App\DTOs\ContactMessageDTO;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

interface ContactMessageUseCaseInterface
{
    public function getAllMessages(): Collection;
    public function getPaginatedMessages(int $perPage = 15): LengthAwarePaginator;
    public function getMessageById(int $id): ?ContactMessageDTO;
    public function createMessage(ContactMessageDTO $data): ContactMessageDTO;
    public function updateMessageStatus(int $id, string $status): bool;
    public function deleteMessage(int $id): bool;
}
