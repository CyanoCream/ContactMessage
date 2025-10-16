<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dasboard Contact Messages') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                <!-- Alert Notification -->
                <div id="alertBox" class="hidden mb-4 p-4 rounded-md text-white font-medium"></div>

                <!-- Tambah Tombol Create di sini -->
                <div class="mb-4 flex justify-between items-center">
                    <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200">List Message</h3>
                    <a href="{{ route('contacts.create') }}"
                       class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md transition duration-200">
                        + Add New Message
                    </a>
                </div>

                <table class="min-w-full border border-gray-300 dark:border-gray-700 text-sm">
                    <thead>
                    <tr class="bg-gray-100 dark:bg-gray-700">
                        <th class="p-3 border dark:text-gray-200">No</th>
                        <th class="p-3 border dark:text-gray-200">Namae</th>
                        <th class="p-3 border dark:text-gray-200">Email</th>
                        <th class="p-3 border dark:text-gray-200">Subject</th>
                        <th class="p-3 border dark:text-gray-200">Status</th>
                        <th class="p-3 border text-center dark:text-gray-200">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($contacts as $key => $contact)
                        <tr class="border-b hover:bg-gray-50 dark:hover:bg-gray-700">
                            <td class="p-3 border dark:text-gray-200">{{ ($contacts->currentPage() - 1) * $contacts->perPage() + $key + 1 }}</td>
                            <td class="p-3 border dark:text-gray-200">{{ $contact->name }}</td>
                            <td class="p-3 border dark:text-gray-200">{{ $contact->email }}</td>
                            <td class="p-3 border dark:text-gray-200">{{ $contact->subject ?? '-' }}</td>
                            <td class="p-3 border capitalize">
                                <span class="px-2 py-1 rounded-full text-xs
                                    {{ $contact->status == 'unread' ? 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200' : '' }}
                                    {{ $contact->status == 'read' ? 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200' : '' }}
                                    ">
                                    {{ $contact->status }}
                                </span>
                            </td>
                            <td class="p-3 border text-center">
                                <button onclick="openViewModal({{ $contact->id }})" class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1 rounded">View</button>
                                <button onclick="openEditModal({{ $contact->id }}, '{{ $contact->status }}')" class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded mx-1">Edit</button>
                                <button onclick="deleteMessage({{ $contact->id }})" class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded">Delete</button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center p-4">
                                <div class="text-gray-500 dark:text-gray-400">
                                    <svg class="mx-auto h-12 w-12 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                                    </svg>
                                    Belum ada pesan.
                                    <a href="{{ route('contacts.create') }}" class="text-blue-600 hover:text-blue-700 underline block mt-2">
                                        Tulis pesan pertama Anda
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>

                @if($contacts->hasPages())
                    <div class="mt-4">
                        {{ $contacts->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Modal View -->
    <div id="viewModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg w-1/2 p-6 max-h-[90vh] overflow-y-auto">
            <h3 class="text-xl font-semibold mb-4 text-gray-800 dark:text-gray-100">Detail Pesan</h3>
            <div id="viewContent" class="text-gray-700 dark:text-gray-300"></div>
            <div class="mt-4 text-right">
                <button onclick="closeViewModal()" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded">Close</button>
            </div>
        </div>
    </div>

    <!-- Modal Edit -->
    <div id="editModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg w-1/2 p-6">
            <h3 class="text-xl font-semibold mb-4 text-gray-800 dark:text-gray-100">Edit Status Message</h3>
            <form id="editForm">
                @csrf
                <div class="mb-4">
                    <label class="block text-gray-700 dark:text-gray-300 mb-1">Status</label>
                    <select name="status" id="editStatus" class="w-full border rounded p-2 dark:bg-gray-700 dark:text-gray-100">
                        <option value="unread">Unread</option>
                        <option value="read">Read</option>
                    </select>
                </div>
                <div class="text-right">
                    <button type="button" onclick="closeEditModal()" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded">Batal</button>
                    <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Delete Confirmation -->
    <div id="deleteModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg w-[400px] p-6 text-center">
            <svg class="mx-auto h-12 w-12 text-red-600 dark:text-red-400 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M12 8v4m0 4h.01M21 12A9 9 0 113 12a9 9 0 0118 0z"/>
            </svg>
            <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-2">Delete Confirmation</h3>
            <p class="text-gray-600 dark:text-gray-300 mb-5">Are you sure you want to delete this message?</p>
            <div class="flex justify-center space-x-3">
                <button onclick="closeDeleteModal()" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded">
                    Cancel
                </button>
                <button id="confirmDeleteBtn" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded">
                    Yes, Delete
                </button>
            </div>
        </div>
    </div>
    <script>
        let currentContactId = null;
        let contactIdToDelete = null;

        async function openViewModal(contactId) {
            try {
                const response = await fetch(`/contact-messages/${contactId}`);
                const result = await response.json();

                if (result.success) {
                    const contact = result.data;
                    document.getElementById('viewModal').classList.remove('hidden');
                    document.getElementById('viewContent').innerHTML = `
                        <div class="space-y-3">
                            <p><strong>Name:</strong> ${contact.name}</p>
                            <p><strong>Email:</strong> ${contact.email}</p>
                            <p><strong>Subject:</strong> ${contact.subject ?? '-'}</p>
                            <p><strong>Status:</strong> <span class="capitalize ${getStatusColor(contact.status)}">${contact.status}</span></p>
                            <p><strong>Sent at:</strong> ${new Date(contact.created_at).toLocaleString()}</p>
                            <div class="border-t pt-3 mt-3">
                                <strong class="block mb-2">Message:</strong>
                                <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded whitespace-pre-line">${contact.message}</div>
                            </div>
                        </div>
                    `;
                } else {
                    alert('Failed to load message data.');
                }
            } catch (error) {
                console.error('Error:', error);
                alert('An error occurred while loading message data.');
            }
        }

        function getStatusColor(status) {
            const colors = {
                'unread': 'text-red-600 dark:text-red-400',
                'read': 'text-blue-600 dark:text-blue-400',
            };
            return colors[status] || 'text-gray-600 dark:text-gray-400';
        }

        function closeViewModal() {
            document.getElementById('viewModal').classList.add('hidden');
        }

        function openEditModal(contactId, currentStatus) {
            currentContactId = contactId;
            document.getElementById('editModal').classList.remove('hidden');
            document.getElementById('editStatus').value = currentStatus;
        }

        function closeEditModal() {
            document.getElementById('editModal').classList.add('hidden');
            currentContactId = null;
        }

        // 🔥 Open delete modal
        function deleteMessage(contactId) {
            contactIdToDelete = contactId;
            document.getElementById('deleteModal').classList.remove('hidden');
        }

        // Close delete modal
        function closeDeleteModal() {
            document.getElementById('deleteModal').classList.add('hidden');
            contactIdToDelete = null;
        }

        // Confirm delete
        document.getElementById('confirmDeleteBtn').addEventListener('click', async function() {
            if (!contactIdToDelete) return;

            try {
                const response = await fetch(`/contact-messages/${contactIdToDelete}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json'
                    }
                });

                const result = await response.json();

                if (result.success) {
                    closeDeleteModal();
                    showAlert('Message deleted successfully.', 'success');
                    setTimeout(() => location.reload(), 1500);
                } else {
                    alert('Failed to delete message.');
                }
            } catch (error) {
                console.error('Error:', error);
                alert('An error occurred while deleting the message.');
            }
        });

        // Handle edit form submission
        document.getElementById('editForm').addEventListener('submit', async function(e) {
            e.preventDefault();

            if (!currentContactId) return;

            const formData = new FormData(this);
            const status = formData.get('status');

            try {
                const response = await fetch(`/contact-messages/${currentContactId}/status`, {
                    method: 'PUT',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({ status })
                });

                const result = await response.json();

                if (result.success) {
                    alert('Status updated successfully.');
                    closeEditModal();
                    location.reload();
                } else {
                    alert('Failed to update status.');
                }
            } catch (error) {
                console.error('Error:', error);
                alert('An error occurred while updating status.');
            }
        });
        function showAlert(message, type = 'success') {
            const alertBox = document.getElementById('alertBox');

            // Warna hijau utk success, merah utk error
            const colors = {
                success: 'bg-green-500 dark:bg-green-600',
                error: 'bg-red-500 dark:bg-red-600'
            };

            alertBox.textContent = message;
            alertBox.className = `mb-4 p-4 rounded-md text-white font-medium ${colors[type]}`;
            alertBox.classList.remove('hidden');

            // Auto hide setelah 5 detik
            setTimeout(() => {
                alertBox.classList.add('hidden');
            }, 5000);
        }

    </script>
</x-app-layout>
