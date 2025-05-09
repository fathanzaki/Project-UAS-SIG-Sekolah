<!-- resources/views/modal-create.blade.php -->
<div class="grid grid-cols-2 gap-4">
    <div>
        <label for="nama" class="block text-sm font-medium text-gray-700">Nama</label>
        <input type="text" id="nama" name="nama" class="w-full px-4 py-2 mt-1 border border-gray-300 rounded-md" required>
    </div>

    <div>
        <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
        <input type="email" id="email" name="email" class="w-full px-4 py-2 mt-1 border border-gray-300 rounded-md" required>
    </div>

    <div>
        <label for="telepon" class="block text-sm font-medium text-gray-700">Telepon</label>
        <input type="text" id="telepon" name="telepon" class="w-full px-4 py-2 mt-1 border border-gray-300 rounded-md" required>
    </div>

    <div>
        <label for="jenis_sekolah" class="block text-sm font-medium text-gray-700">Jenis Sekolah</label>
        <select id="jenis_sekolah" name="jenis_sekolah" class="w-full px-4 py-2 mt-1 border border-gray-300 rounded-md" required>
            <option value="SMA">SMA</option>
            <option value="SMK">SMK</option>
        </select>
    </div>

    <div>
        <label for="status_sekolah" class="block text-sm font-medium text-gray-700">Status Sekolah</label>
        <input type="text" id="status_sekolah" name="status_sekolah" class="w-full px-4 py-2 mt-1 border border-gray-300 rounded-md" required>
    </div>

    <div>
        <label for="akreditasi" class="block text-sm font-medium text-gray-700">Akreditasi</label>
        <input type="text" id="akreditasi" name="akreditasi" class="w-full px-4 py-2 mt-1 border border-gray-300 rounded-md">
    </div>

    <div>
        <label for="website" class="block text-sm font-medium text-gray-700">Website</label>
        <input type="url" id="website" name="website" class="w-full px-4 py-2 mt-1 border border-gray-300 rounded-md">
    </div>

    <div>
        <label for="latitude" class="block text-sm font-medium text-gray-700">Latitude</label>
        <input type="text" id="latitude" name="latitude" class="w-full px-4 py-2 mt-1 border border-gray-300 rounded-md" required>
    </div>

    <div>
        <label for="longitude" class="block text-sm font-medium text-gray-700">Longitude</label>
        <input type="text" id="longitude" name="longitude" class="w-full px-4 py-2 mt-1 border border-gray-300 rounded-md" required>
    </div>
</div>
