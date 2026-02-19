<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $data['judul'] ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 min-h-screen font-sans text-gray-800">
    <main class="max-w-4xl mx-auto px-4 py-10">
        <a href="<?= BASEURL ?>/materi/index/<?= $data['materi']['id_pertemuan'] ?>" class="text-lg text-gray-600 mb-4 inline-block">&lt; Kembali</a>

<div class="bg-white rounded-lg shadow-md p-6 border border-gray-200">
    <h2 class="text-2xl font-bold mb-6">Edit Materi</h2>
    
    <form action="<?= BASEURL ?>/materi/update" method="post" enctype="multipart/form-data">
        <!-- Hidden fields -->
        <input type="hidden" name="id_materi" value="<?= $data['materi']['id'] ?>">
        <input type="hidden" name="id_pertemuan" value="<?= $data['materi']['id_pertemuan'] ?>">
        <!-- Hidden field untuk nama file lama, agar bisa dihapus jika diganti -->
        <input type="hidden" name="file_lama" value="<?= htmlspecialchars($data['materi']['file_materi']) ?>">

        <!-- Isi Materi -->
        <div class="mb-6">
            <label for="isi_materi" class="block text-gray-700 text-sm font-bold mb-2">Isi Materi</label>
            <textarea id="isi_materi" name="isi_materi" rows="10" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required><?= htmlspecialchars($data['materi']['isi_materi']) ?></textarea>
        </div>

        <!-- Link YouTube -->
        <div class="mb-6">
            <label for="link_youtube" class="block text-gray-700 text-sm font-bold mb-2">Link YouTube (Opsional)</label>
            <input type="text" id="link_youtube" name="link_youtube" value="<?= htmlspecialchars($data['materi']['link_youtube']) ?>" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="https://www.youtube.com/watch?v=...">
        </div>

        <!-- File Materi PDF -->
        <div class="mb-6">
            <label for="file_materi" class="block text-gray-700 text-sm font-bold mb-2">File Materi (PDF)</label>
            <?php if (!empty($data['materi']['file_materi'])): ?>
                <p class="text-sm text-gray-600 mb-2">File saat ini: <strong><?= htmlspecialchars($data['materi']['file_materi']) ?></strong></p>
            <?php endif; ?>
            <input type="file" id="file_materi" name="file_materi" accept=".pdf" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            <p class="text-xs text-gray-500 mt-1">Pilih file baru untuk mengganti. Kosongkan jika tidak ingin mengubah file.</p>
        </div>

        <!-- Tombol Aksi -->
        <div class="flex items-center justify-between">
            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                Simpan Perubahan
            </button>
            <a href="<?= BASEURL ?>/materi/index/<?= $data['materi']['id_pertemuan'] ?>" class="inline-block align-baseline font-bold text-sm text-gray-500 hover:text-gray-800">
                Batal
            </a>
        </div>
    </form>
</div>
    </main>
</body>
</html>