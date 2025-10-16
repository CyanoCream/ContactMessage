<?php

namespace App\Http\Controllers;

use App\DTOs\ContactMessageDTO;
use App\UseCases\Contracts\ContactMessageUseCaseInterface;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;
use Illuminate\Validation\ValidationException;
use Exception;
use Illuminate\Support\Facades\Log;

class ContactMessageController extends Controller
{
    public function __construct(
        private ContactMessageUseCaseInterface $contactMessageUseCase
    ) {}

    public function index(): View
    {
        try {
            $contacts = $this->contactMessageUseCase->getPaginatedMessages();
            return view('contact-messages.index', compact('contacts'));
        } catch (Exception $e) {
            Log::error('ContactController@index: ' . $e->getMessage());
            return view('contact-messages.index')->with('error', 'Gagal memuat data pesan.');
        }
    }

    public function create(): View
    {
        return view('contact-messages.create');
    }

    public function store(Request $request): JsonResponse
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:100',
                'email' => 'required|email|max:150',
                'subject' => 'nullable|string|max:150',
                'message' => 'required|string'
            ]);

            $dto = ContactMessageDTO::fromArray($validated);
            $contactMessage = $this->contactMessageUseCase->createMessage($dto);

            return response()->json([
                'success' => true,
                'message' => 'Pesan berhasil dikirim!',
                'data' => $contactMessage
            ], 201);

        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Data tidak valid.',
                'errors' => $e->errors()
            ], 422);

        } catch (Exception $e) {
            Log::error('ContactController@store: ' . $e->getMessage(), [
                'request' => $request->all()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Gagal mengirim pesan. Silakan coba lagi.'
            ], 500);
        }
    }

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
            Log::error("ContactController@show ID {$id}: " . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat mengambil data pesan.'
            ], 500);
        }
    }

    public function updateStatus(Request $request, int $id): JsonResponse
    {
        try {
            $validated = $request->validate([
                'status' => 'required|in:unread,read,replied'
            ]);

            $success = $this->contactMessageUseCase->updateMessageStatus($id, $validated['status']);

            if (!$success) {
                return response()->json([
                    'success' => false,
                    'message' => 'Pesan tidak ditemukan.'
                ], 404);
            }

            return response()->json([
                'success' => true,
                'message' => 'Status berhasil diupdate.'
            ]);

        } catch (Exception $e) {
            Log::error("ContactController@updateStatus ID {$id}: " . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Gagal mengupdate status pesan.'
            ], 500);
        }
    }

    public function destroy(int $id): JsonResponse
    {
        try {
            $success = $this->contactMessageUseCase->deleteMessage($id);

            if (!$success) {
                return response()->json([
                    'success' => false,
                    'message' => 'Pesan tidak ditemukan.'
                ], 404);
            }

            return response()->json([
                'success' => true,
                'message' => 'Pesan berhasil dihapus.'
            ]);

        } catch (Exception $e) {
            Log::error("ContactController@destroy ID {$id}: " . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus pesan.'
            ], 500);
        }
    }
}
