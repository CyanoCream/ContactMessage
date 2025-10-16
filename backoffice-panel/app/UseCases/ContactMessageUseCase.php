<?php

namespace App\UseCases;

use App\DTOs\ContactMessageDTO;
use App\Models\ContactMessage;
use App\Repositories\Contracts\ContactMessageRepositoryInterface;
use App\UseCases\Contracts\ContactMessageUseCaseInterface;
use Exception;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Log;

class ContactMessageUseCase implements ContactMessageUseCaseInterface
{
    public function __construct(
        private ContactMessageRepositoryInterface $repository
    ) {}

    public function getAllMessages(): Collection
    {
        try {
            return $this->repository->getAll();
        } catch (Exception $e) {
            Log::error('UseCase: Failed to get all messages - ' . $e->getMessage());
            throw $e;
        }
    }

    public function getPaginatedMessages(int $perPage = 15): LengthAwarePaginator
    {
        try {
            if ($perPage < 1 || $perPage > 100) {
                throw new ValidationException("Per page must be between 1 and 100");
            }

            return $this->repository->getPaginated($perPage);
        } catch (Exception $e) {
            Log::error('UseCase: Failed to get paginated messages - ' . $e->getMessage());
            throw $e;
        }
    }

    public function getMessageById(int $id): ?ContactMessageDTO
    {
        try {
            if ($id <= 0) {
                throw new ValidationException("Invalid message ID");
            }

            $contact = $this->repository->findById($id);

            if (!$contact) {
                return null;
            }

            return $this->mapToDTO($contact);
        } catch (Exception $e) {
            Log::error("UseCase: Failed to get message with ID {$id} - " . $e->getMessage());
            throw $e;
        }
    }

    public function createMessage(ContactMessageDTO $data): ContactMessageDTO
    {
        try {
            $this->validateContactMessageData($data->toArray());

            $contact = $this->repository->create($data->toArray());

            return $this->mapToDTO($contact);
        } catch (Exception $e) {
            Log::error('UseCase: Failed to create message - ' . $e->getMessage(), [
                'data' => $data->toArray()
            ]);
            throw $e;
        }
    }

    public function updateMessageStatus(int $id, string $status): bool
    {
        try {
            if ($id <= 0) {
                throw new ValidationException("Invalid message ID");
            }

            $validStatuses = ['unread', 'read', 'replied'];
            if (!in_array($status, $validStatuses)) {
                throw new ValidationException("Invalid status value");
            }

            return $this->repository->updateStatus($id, $status);
        } catch (Exception $e) {
            Log::error("UseCase: Failed to update status for message ID {$id} - " . $e->getMessage());
            throw $e;
        }
    }

    public function deleteMessage(int $id): bool
    {
        try {
            if ($id <= 0) {
                throw new ValidationException("Invalid message ID");
            }

            return $this->repository->delete($id);
        } catch (Exception $e) {
            Log::error("UseCase: Failed to delete message with ID {$id} - " . $e->getMessage());
            throw $e;
        }
    }

    private function mapToDTO(ContactMessage $contact): ContactMessageDTO
    {
        return new ContactMessageDTO(
            id: $contact->id,
            name: $contact->name,
            email: $contact->email,
            subject: $contact->subject,
            message: $contact->message,
            status: $contact->status,
            created_at: $contact->created_at?->toDateTimeString(),
            updated_at: $contact->updated_at?->toDateTimeString()
        );
    }

    private function validateContactMessageData(array $data): void
    {
        $required = ['name', 'email', 'message'];
        foreach ($required as $field) {
            if (empty($data[$field])) {
                throw new ValidationException("Field {$field} is required");
            }
        }

        if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            throw new ValidationException("Invalid email format");
        }
    }
}
