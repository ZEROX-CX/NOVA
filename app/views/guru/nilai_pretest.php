<!DOCTYPE html>
<html lang="id">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Mapelku Guru</title>
    <script src="https://cdn.tailwindcss.com"></script>
  </head>

  <body class="bg-white min-h-screen font-sans text-gray-800">
    <!-- Menu Hamburger (Mobile) -->
    <div id="menuPanel"
      class="fixed top-0 left-0 h-full w-64 bg-white shadow-lg transform -translate-x-full transition-transform duration-300 z-50">
      <div class="flex justify-between items-center p-4 border-b">
        <img src="logo.png" alt="Logo" class="w-10 h-10 object-contain" />
        <button id="closeMenu" class="text-gray-600 text-2xl">&times;</button>
      </div>
      <nav class="flex flex-col p-4 space-y-4 text-gray-700 font-medium">
        <a href="#" class="hover:text-blue-600" id="">Beranda</a>
        <a href="#" class="hover:text-blue-600">Mapel ku</a>
      </nav>
    </div>

    <!-- Konten Utama -->
    <main class="max-w-7xl mx-auto px-4 py-10 flex flex-col md:flex-row gap-6">
      <!-- Bagian Mapel -->
      <section class="flex-1">

        <a class="text-lg text-gray-600" href="<?= BASEURL ?>/guru/pretest/<?= $data['id_mapel'] ?>/<?= $data['id_pertemuan'] ?>">< kembali</a>
        <h2 class="text-2xl font-bold text-black mb-6">Nilai Pretest - Pertemuan</h2>
            
        <!-- Tabel Kehadiran -->
        <div class="ml-0.5 max-w-4xl mx-auto bg-white border border-blue-300 rounded-lg shadow-md p-6">
          <table class="w-full table-auto border-collapse">
            <thead>
              <tr class="bg-blue-100 text-black">
                <th class="border px-4 py-2 text-left">Nama Siswa</th>
                <th class="border px-4 py-2 text-center">Nilai</th>
                <th class="border px-4 py-2 text-center">Tanggal</th>
              </tr>
            </thead>
            <tbody>
            <?php if (!empty($siswa)): ?>
            <?php foreach ($siswa as $row): ?>
            <tr class="hover:bg-gray-100">
              <td class="py-3 px-4"><?= htmlspecialchars($row['nama_siswa'] ?? 'Unknown') ?></td>
              <td class="py-3 px-4 text-center"><?= htmlspecialchars($row['nilai'] ?? '') ?></td>
              <td class="py-3 px-4 text-center"><?= htmlspecialchars($row['tanggal'] ?? '') ?></td>
            </tr>
            <?php endforeach; ?>
          <?php else: ?>
            <tr>
              <td class="py-3 px-4 text-center" colspan="3">Tidak ada data nilai pretest untuk pertemuan ini</td>
            </tr>
          <?php endif; ?>
            </tbody>
          </table>
        </div>
              <div class="flex mt-5">
                <a href="<?= BASEURL ?>/guru/materi/<?= $id_pertemuan ?>" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition">Lanjut ke Materi</a>
              </div>
      </section>
    </main>

    <!-- SCRIPT -->
    <script>
      // Menu Hamburger (mobile)
      const menuBtn = document.getElementById("menuBtn");
      const menuPanel = document.getElementById("menuPanel");
      const closeMenu = document.getElementById("closeMenu");

      menuBtn.addEventListener("click", () => {
        menuPanel.classList.remove("-translate-x-full");
      });
      closeMenu.addEventListener("click", () => {
        menuPanel.classList.add("-translate-x-full");
      });
    </script>
  </body>
</html>