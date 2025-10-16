<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Contact Messages') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                <table class="min-w-full border border-gray-300 dark:border-gray-700 text-sm">
                    <thead>
                    <tr class="bg-gray-100 dark:bg-gray-700">
                        <th class="p-3 border">No</th>
                        <th class="p-3 border">Nama</th>
                        <th class="p-3 border">Email</th>
                        <th class="p-3 border">Subjek</th>
                        <th class="p-3 border">Status</th>
                        <th class="p-3 border text-center">Aksi</th>
                    </tr>
                    </thead>
                    <tbody>
{{--                    @forelse($contacts as $key => $contact)--}}
{{--                        <tr class="border-b hover:bg-gray-50 dark:hover:bg-gray-700">--}}
{{--                            <td class="p-3 border">{{ $key + 1 }}</td>--}}
{{--                            <td class="p-3 border">{{ $contact->name }}</td>--}}
{{--                            <td class="p-3 border">{{ $contact->email }}</td>--}}
{{--                            <td class="p-3 border">{{ $contact->subject ?? '-' }}</td>--}}
{{--                            <td class="p-3 border capitalize">{{ $contact->status }}</td>--}}
{{--                            <td class="p-3 border text-center">--}}
{{--                                <button onclick="openViewModal({{ $contact }})" class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1 rounded">View</button>--}}
{{--                                <button onclick="openEditModal({{ $contact }})" class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded mx-1">Edit</button>--}}
{{--                                <form action="{{ route('contacts.destroy', $contact->id) }}" method="POST" class="inline">--}}
{{--                                    @csrf--}}
{{--                                    @method('DELETE')--}}
{{--                                    <button type="submit" onclick="return confirm('Yakin hapus data ini?')" class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded">Delete</button>--}}
{{--                                </form>--}}
{{--                            </td>--}}
{{--                        </tr>--}}
{{--                    @empty--}}
{{--                        <tr>--}}
{{--                            <td colspan="6" class="text-center p-4">Belum ada pesan.</td>--}}
{{--                        </tr>--}}
{{--                    @endforelse--}}
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal View -->
    <div id="viewModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg w-1/2 p-6">
            <h3 class="text-xl font-semibold mb-4 text-gray-800 dark:text-gray-100">Detail Pesan</h3>
            <div id="viewContent" class="text-gray-700 dark:text-gray-300"></div>
            <div class="mt-4 text-right">
                <button onclick="closeViewModal()" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded">Tutup</button>
            </div>
        </div>
    </div>

    <!-- Modal Edit -->
    <div id="editModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg w-1/2 p-6">
            <h3 class="text-xl font-semibold mb-4 text-gray-800 dark:text-gray-100">Edit Pesan</h3>
            <form id="editForm" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-4">
                    <label class="block text-gray-700 dark:text-gray-300 mb-1">Status</label>
                    <select name="status" id="editStatus" class="w-full border rounded p-2 dark:bg-gray-700 dark:text-gray-100">
                        <option value="unread">Unread</option>
                        <option value="read">Read</option>
                        <option value="replied">Replied</option>
                    </select>
                </div>
                <div class="text-right">
                    <button type="button" onclick="closeEditModal()" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded">Batal</button>
                    <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openViewModal(contact) {
            document.getElementById('viewModal').classList.remove('hidden');
            document.getElementById('viewContent').innerHTML = `
                <p><strong>Nama:</strong> ${contact.name}</p>
                <p><strong>Email:</strong> ${contact.email}</p>
                <p><strong>Subjek:</strong> ${contact.subject ?? '-'}</p>
                <p><strong>Pesan:</strong></p>
                <p class="whitespace-pre-line">${contact.message}</p>
                <p><strong>Status:</strong> ${contact.status}</p>
            `;
        }

        function closeViewModal() {
            document.getElementById('viewModal').classList.add('hidden');
        }

        function openEditModal(contact) {
            document.getElementById('editModal').classList.remove('hidden');
            document.getElementById('editStatus').value = contact.status;
            document.getElementById('editForm').action = `/contacts/${contact.id}`;
        }

        function closeEditModal() {
            document.getElementById('editModal').classList.add('hidden');
        }
    </script>
</x-app-layout>
