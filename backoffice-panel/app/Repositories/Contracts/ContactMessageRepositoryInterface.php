<?php

namespace App\Repositories\Contracts;

use App\Models\ContactMessage;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

interface ContactMessageRepositoryInterface
{
    public function getAll(): Collection;
    public function getPaginated(int $perPage = 15): LengthAwarePaginator;
    public function findById(int $id): ?ContactMessage;
    public function create(array $data): ContactMessage;
    public function update(int $id, array $data): bool;
    public function delete(int $id): bool;
    public function updateStatus(int $id, string $status): bool;
}
