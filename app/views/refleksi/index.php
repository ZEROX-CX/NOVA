<?php
 $refleksi = $data['refleksi'];
 $pertemuan = $data['pertemuan'];
 $mapel = $data['mapel'];
 $jawaban_siswa = $data['jawaban_siswa'] ?? [];
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Refleksi Pembelajaran</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 min-h-screen">

<div class="container mx-auto max-w-7xl px-3 md:px-0 pt-4">
  <div class="flex flex-col md:flex-row">

    <!-- Sidebar (Desktop Only) -->
    <aside class="hidden md:block w-64 bg-white shadow-md rounded-lg overflow-hidden mr-6 h-full">
      <!-- isi sidebar jika diperlukan -->
    </aside>

    <!-- Main Content -->
    <main class="flex-1 bg-white shadow-md rounded-lg p-4 md:p-6">

      <!-- Tombol Kembali -->
      <a class="inline-block mb-4 text-base md:text-lg text-gray-600 hover:text-purple-600 transition"
         href="<?= BASEURL ?>/pertemuan_content/<?= $data['id_mapel'] ?>/<?= $data['id_pertemuan'] ?>">
        ← Kembali
      </a>

      <h1 class="text-xl md:text-2xl font-bold text-gray-800 mb-6">
        Refleksi Pembelajaran
      </h1>

      <!-- Notifikasi jika sudah mengisi -->
      <?php if (!empty($jawaban_siswa)): ?>
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded">
          <p class="text-sm md:text-base">
            Anda sudah mengirimkan jawaban refleksi. Anda dapat memperbarui jawaban jika diperlukan.
          </p>
        </div>
      <?php endif; ?>

      <!-- Form Refleksi -->
      <form action="<?= BASEURL ?>/refleksi/submit" method="POST" class="space-y-6">
        <input type="hidden" name="id_mapel" value="<?= $mapel['id_mapel'] ?>">
        <input type="hidden" name="id_pertemuan" value="<?= $pertemuan['id_pertemuan'] ?>">

        <?php foreach ($refleksi as $r): ?>
          <div>
            <label class="block text-gray-700 font-medium mb-2 text-sm md:text-base">
              <?= htmlspecialchars($r['pertanyaan']) ?>
            </label>

            <textarea 
              name="jawaban[<?= $r['id_refleksi'] ?>]"
              rows="4"
              class="w-full border border-gray-300 rounded-lg p-3 text-sm md:text-base
                     focus:outline-none focus:ring-2 focus:ring-indigo-400"
            ><?php
              foreach ($jawaban_siswa as $js) {
                if ($js['id_refleksi'] == $r['id_refleksi']) {
                  echo htmlspecialchars($js['jawaban']);
                  break;
                }
              }
            ?></textarea>
          </div>
        <?php endforeach; ?>

        <!-- Tombol Submit -->
        <div class="pt-2">
          <button type="submit"
            class="w-full md:w-auto bg-indigo-600 text-white font-semibold
                   px-6 py-3 rounded-lg hover:bg-indigo-700 transition">
            Kirim Refleksi
          </button>
        </div>

      </form>
    </main>

  </div>
</div>

</body>
</html>