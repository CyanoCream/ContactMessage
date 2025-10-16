<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\DTOs\ContactMessageDTO;
use App\UseCases\Contracts\ContactMessageUseCaseInterface;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class ContactMessageApiController extends Controller
{
    public function __construct(
        private ContactMessageUseCaseInterface $contactMessageUseCase
    ) {}

    /**
     * Mengirim pesan kontak baru dari frontend
     */
    public function store(Request $request): JsonResponse
    {
        DB::beginTransaction();

        try {
            $validated = $request->validate([
                'name' => 'required|string|max:100',
                'email' => 'required|email|max:150',
                'subject' => 'nullable|string|max:150',
                'message' => 'required|string'
            ]);

            $dto = ContactMessageDTO::fromArray($validated);
            $contactMessage = $this->contactMessageUseCase->createMessage($dto);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Pesan berhasil dikirim!',
                'data' => [
                    'id' => $contactMessage->id,
                    'name' => $contactMessage->name,
                    'email' => $contactMessage->email,
                    'subject' => $contactMessage->subject,
                    'status' => $contactMessage->status,
                    'created_at' => $contactMessage->created_at
                ]
            ], 201);

        } catch (ValidationException $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'Data tidak valid.',
                'errors' => $e->errors()
            ], 422);

        } catch (Exception $e) {
            DB::rollBack();

            Log::error('ContactMessageApiController@store: ' . $e->getMessage(), [
                'request' => $request->all(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat mengirim pesan. Silakan coba lagi.'
            ], 500);
        }
    }

    /**
     * Mendapatkan detail pesan
     */
    public function show(int $id): JsonResponse
    {
        try {
            $contact = $this->contactMessageUseCase->getMessageById($id);

            if (!$contact) {
                return response()->json([
                    'success' => false,
                    'message' => 'Pesan tidak ditemukan.'
                ], 404);
            }

            return response()->json([
                'success' => true,
                'data' => $contact
            ]);

        } catch (Exception $e) {
            Log::error("ContactMessageApiController@show ID {$id}: " . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat mengambil data pesan.'
            ], 500);
        }
    }
}
