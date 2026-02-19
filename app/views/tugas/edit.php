<?php
 $tugas = $data['tugas']; // Ambil data dari controller
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Edit Tugas</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-10">
  <div class="max-w-2xl mx-auto bg-white p-8 rounded-lg shadow-md">
    <h2 class="text-2xl font-bold mb-6">Edit Tugas</h2>
    <form action="<?= BASEURL ?>/tugas/update" method="post" enctype="multipart/form-data">
        <input type="hidden" name="id_tugas" value="<?= $data['tugas']['id_tugas'] ?>">
        <input type="hidden" name="id_mapel" value="<?= $data['id_mapel'] ?>">
        <input type="hidden" name="id_pertemuan" value="<?= $data['tugas']['id_pertemuan'] ?>">
        <input type="hidden" name="file_lama" value="<?= htmlspecialchars($data['tugas']['file_tugas']) ?>">
        
        <div class="mb-4">
            <label for="judul_tugas" class="block text-gray-700 text-sm font-bold mb-2">Judul Tugas</label>
            <input type="text" id="judul_tugas" name="judul_tugas" value="<?= htmlspecialchars($data['tugas']['judul_tugas']) ?>" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
        </div>

        <div class="mb-4">
            <label for="deadline" class="block text-gray-700 text-sm font-bold mb-2">Deadline (Opsional)</label>
            <input type="datetime-local" id="deadline" name="deadline" value="<?= $data['tugas']['deadline_formatted'] ?? '' ?>" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
        </div>

        <div class="mb-4">
            <label>
                <input type="checkbox" name="allow_late" value="1" <?= ($data['tugas']['allow_late']) ? 'checked' : '' ?> class="mr-2">
                Izinkan pengumpulan terlambat
            </label>
        </div>

        <div class="mb-6">
            <label for="file_tugas" class="block text-gray-700 text-sm font-bold mb-2">File Tugas (Opsional)</label>
            <?php if (!empty($data['tugas']['file_tugas'])): ?>
                <p class="text-sm text-gray-600 mb-2">File saat ini: <strong><?= htmlspecialchars($data['tugas']['file_tugas']) ?></strong></p>
            <?php endif; ?>
            <input type="file" id="file_tugas" name="file_tugas" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            <p class="text-xs text-gray-500 mt-1">Pilih file baru untuk mengganti. Kosongkan jika tidak ingin mengubah file.</p>
        </div>

        <div class="flex items-center justify-between">
            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                Simpan Perubahan
            </button>
            <a href="<?= BASEURL ?>/tugas/index/<?= $data['tugas']['id_pertemuan'] ?>" class="inline-block align-baseline font-bold text-sm text-gray-500 hover:text-gray-800">
                Batal
            </a>
        </div>
    </form>
</div>
</body>
</html>