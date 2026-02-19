<?php
$id_materi = $data['id_materi'] ?? ($_GET['id'] ?? null);
$materi = $data['materi'] ?? null;
$id_materi = $data['id_materi'] ?? null;
$judul_materi = $materi['judul'] ?? 'Judul Materi';
$tugas = $data['tugas'];
$pertemuan = $data['pertemuan'];
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Halaman Materi - Platform E-learning</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 font-sans text-gray-800">

  <!-- 🔹 Container utama -->
  <div class="flex min-h-screen">
    <!-- 🔸 Konten Utama -->
    <main class="flex-1 p-10">
      <!-- Section Materi -->
      <section class="bg-white p-8 rounded-lg shadow">
        <h2 class="text-2xl font-semibold text-gray-800 mb-6">
          <p class="font-medium text-gray-700">
            Tugas 
            <p>
              </h2>        
              <!-- Teks Materi -->
              <div class="mb-8">
                <div class="space-y-4 text-gray-700 leading-relaxed">
                  <p>
                    <?= $tugas['judul_tugas'] ?? ''; ?>
                  </p>
                </div>
              </div>
              
              <div class="border-t border-gray-200 pt-6">
                <h3 class="text-xl font-semibold mb-3">File Tugas</h3>
                <p class="text-gray-700">
                  <?php if (!empty($tugas['file_tugas'])): ?>
                    Download 
                    <a href="<?= BASEURL ?>/uploads/<?= $tugas['file_tugas'] ?>" 
                    class="text-blue-600 hover:underline font-medium"
                    download>
                    <?= htmlspecialchars(basename($tugas['file_tugas'])) ?>
                  </a>
                  <?php else: ?>
                    <span class="text-gray-500 italic">Tidak ada file terlampir.</span>
                    <?php endif; ?>
                  </p>
                </div>
        <div class="mt-10 border-gray-200 pt-6">
          <div class="mb-5">
            <a href="<?= BASEURL ?>/tugas/edit/<?= $data['id_mapel'] ?>/<?= $data['id_pertemuan'] ?>" class="text-center block w-[200px] py-2 px-1 rounded-md bg-green-500 text-white font-semibold">
                Edit Tugas
            </a>
          </div>
          <a href="<?= BASEURL ?>/pengumpulan/list/<?= $pertemuan['id_pertemuan'] ?>" class="text-center block w-[200px] py-2 px-1 rounded-md bg-blue-600 text-white font-semibold">Lihat Tugas Siswa</a>
        </div>
      </section>
    </main>
  </div>
</body>
</html>