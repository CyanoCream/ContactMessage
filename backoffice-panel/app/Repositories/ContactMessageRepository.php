<?php

namespace App\Repositories;

use App\Models\ContactMessage;
use App\Repositories\Contracts\ContactMessageRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Exception;

class ContactMessageRepository implements ContactMessageRepositoryInterface
{
    public function __construct(
        private ContactMessage $model
    ) {}

    public function getAll(): Collection
    {
        try {
            return $this->model->latest()->get();
        } catch (Exception $e) {
            Log::error('Failed to get all contact messages: ' . $e->getMessage());
            throw new Exception('Failed to get all contact.');
        }
    }

    public function getPaginated(int $perPage = 15): LengthAwarePaginator
    {
        try {
            return $this->model->latest()->paginate($perPage);
        } catch (Exception $e) {
            Log::error('Failed to get paginated contact messages: ' . $e->getMessage());
            throw new Exception('Failed to get paginated contact.');
        }
    }

    public function findById(int $id): ?ContactMessage
    {
        try {
            return $this->model->find($id);
        } catch (Exception $e) {
            Log::error("Failed to find contact message with ID {$id}: " . $e->getMessage());
            throw new Exception('Failed to find contact message.');
        }
    }

    public function create(array $data): ContactMessage
    {
        try {
            return DB::transaction(function () use ($data) {
                return $this->model->create($data);
            });
        } catch (Exception $e) {
            Log::error('Failed to create contact message: ' . $e->getMessage(), ['data' => $data]);
            throw new Exception('Failed to create contact message.');
        }
    }

    public function update(int $id, array $data): bool
    {
        try {
            return DB::transaction(function () use ($id, $data) {
                $contact = $this->findById($id);

                if (!$contact) {
                    return false;
                }

                return $contact->update($data);
            });
        } catch (Exception $e) {
            Log::error("Failed to update contact message with ID {$id}: " . $e->getMessage(), ['data' => $data]);
            throw new Exception('Failed to update contact message.');
        }
    }

    public function delete(int $id): bool
    {
        try {
            return DB::transaction(function () use ($id) {
                $contact = $this->findById($id);

                if (!$contact) {
                    return false;
                }

                return $contact->delete();
            });
        } catch (Exception $e) {
            Log::error("Failed to delete contact message with ID {$id}: " . $e->getMessage());
            throw new Exception('Failed to delete contact message.');
        }
    }

    public function updateStatus(int $id, string $status): bool
    {
        try {
            return DB::transaction(function () use ($id, $status) {
                return $this->update($id, ['status' => $status]);
            });
        } catch (Exception $e) {
            Log::error("Failed to update status for contact message with ID {$id}: " . $e->getMessage());
            throw new Exception('Failed to update status for contact message.');
        }
    }
}
