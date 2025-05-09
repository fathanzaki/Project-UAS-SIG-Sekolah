<x-app-layout>

    <div class="py-8 px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if (session('message'))
                <div class="bg-green-500 text-white p-4 rounded mb-4">
                    {{ session('message') }}
                </div>
            @endif

            <!-- Tombol Tambah -->
            <div class="flex justify-start mb-4">
                <button onclick="openModal('tambahModal')"
                    class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                    + Tambah Sekolah
                </button>
            </div>
            <!-- Tabel -->
            <table class="min-w-full table-auto divide-y divide-gray-600 mt-6 border text-xs text-white">
                <thead class="bg-gray-800">
                    <tr>
                        <th class="px-5 py-5 text-center font-medium">Nama</th>
                        <th class="px-2 py-2 text-center font-medium">Telepon</th>
                        <th class="px-2 py-2 text-center font-medium">Email</th>
                        <th class="px-2 py-2 text-center font-medium">Jenis</th>
                        <th class="px-2 py-2 text-center font-medium">Status</th>
                        <th class="px-2 py-2 text-center font-medium">Akreditasi</th>
                        <th class="px-2 py-2 text-center font-medium">Website</th>
                        <th class="px-2 py-2 text-center font-medium">Longitude</th>
                        <th class="px-2 py-2 text-center font-medium">Latitude</th>
                        <th class="px-2 py-2 text-center font-medium">Aksi</th>
                    </tr>
                </thead>
                <tbody id="sekolahTable" class="bg-gray-900 divide-y divide-gray-700">
                    <!-- Diisi dari JavaScript -->
                </tbody>
            </table>            


            <!-- Modal Tambah -->
            <div id="tambahModal"
                class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center">
                <div class="bg-white p-6 rounded shadow-lg w-1/2">
                    <h2 class="text-xl font-bold mb-4">Tambah Sekolah</h2>
                    <form method="POST" action="{{ route('sekolah.store') }}">
                        @csrf
                        @include('modal-create')
                        <div class="mt-4 flex justify-end space-x-2">
                            <button type="button" onclick="closeModal('tambahModal')"
                                class="bg-gray-500 text-white px-4 py-2 rounded">Batal</button>
                            <button class="bg-blue-600 text-white px-4 py-2 rounded">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Modal Edit -->
            <div id="editModal"
                class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center">
                <div class="bg-white p-6 rounded shadow-lg w-1/2">
                    <h2 class="text-xl font-bold mb-4">Edit Sekolah</h2>
                    <form method="POST" id="editForm">
                        @csrf @method('PUT')
                        @include('modal-edit')
                        <div class="mt-4 flex justify-end space-x-2">
                            <button type="button" onclick="closeModal('editModal')"
                                class="bg-gray-500 text-white px-4 py-2 rounded">Batal</button>
                            <button class="bg-yellow-600 text-white px-4 py-2 rounded">Update</button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>

    <!-- Script Section -->
    <script>
        function openModal(id) {
            document.getElementById(id).classList.remove('hidden');
        }
        function closeModal(id) {
            document.getElementById(id).classList.add('hidden');
        }

        function openEditModal(data) {
            const form = document.getElementById('editForm');
            form.action = `/sekolah/${data.id}`;
            form.querySelector('[name=nama]').value = data.nama;
            form.querySelector('[name=email]').value = data.email;
            form.querySelector('[name=telepon]').value = data.telepon;
            form.querySelector('[name=jenis_sekolah]').value = data.jenis_sekolah;
            form.querySelector('[name=status_sekolah]').value = data.status_sekolah;
            form.querySelector('[name=akreditasi]').value = data.akreditasi;
            form.querySelector('[name=website]').value = data.website;
            form.querySelector('[name=latitude]').value = data.latitude;
            form.querySelector('[name=longitude]').value = data.longitude;
            openModal('editModal');
        }

        async function loadDataSekolah() {
            try {
                const response = await fetch('/api/sekolah');
                const json = await response.json();
                const data = json.data;

                const tableBody = document.getElementById('sekolahTable');
                tableBody.innerHTML = '';

                data.forEach((item) => {
                    const row = document.createElement('tr');
                    row.innerHTML = `
            <td class="px-6 py-4 border text-white">${item.nama}</td>
            <td class="px-6 py-4 border text-white">${item.telepon}</td>
            <td class="px-6 py-4 border text-white">${item.email}</td>
            <td class="px-6 py-4 border text-white">${item.jenis_sekolah}</td>
            <td class="px-6 py-4 border text-white">${item.status_sekolah}</td>
            <td class="px-6 py-4 border text-white">${item.akreditasi}</td>
            <td class="px-6 py-4 border text-white">${item.website}</td>
            <td class="px-6 py-4 border text-white">${item.longitude}</td>
            <td class="px-6 py-4 border text-white">${item.latitude}</td>
            <td class="px-6 py-4 border flex gap-2">
                <button onclick='openEditModal(${JSON.stringify(item)})' class="bg-yellow-500 text-white px-3 py-1 rounded">Edit</button>
                <button onclick='deleteSekolah(${item.id})' class="bg-red-600 text-white px-3 py-1 rounded">Hapus</button>
            </td>
            `;

                    tableBody.appendChild(row);
                });
            } catch (error) {
                console.error("Gagal load data sekolah:", error);
            }
        }

        async function deleteSekolah(id) {
            if (!confirm('Yakin ingin menghapus?')) return;
            try {
                await fetch(`/api/sekolah/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                });
                loadDataSekolah();
            } catch (error) {
                console.error("Gagal hapus:", error);
            }
        }

        document.addEventListener('DOMContentLoaded', loadDataSekolah);
    </script>
</x-app-layout>