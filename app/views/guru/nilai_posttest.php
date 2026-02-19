<!DOCTYPE html>
<html lang="id">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Mapelku Guru - Nilai Posttest</title>
    <script src="https://cdn.tailwindcss.com"></script>
  </head>

  <body class="bg-white min-h-screen font-sans text-gray-800">
    <!-- Konten Utama -->
    <main class="max-w-7xl mx-auto px-4 py-10 flex flex-col justify-center md:flex-row gap-6">
      <!-- Bagian Nilai Posttest -->
      
      <section class="flex-1 ">
        <div class="bg-[#7a00ff] flex w-[130px] h-[35px] items-center justify-center rounded mb-4">
          <a href="<?= BASEURL ?>/guru/posttest/<?= $data['id_mapel']?>/<?= $data['id_pertemuan'] ?>" class="text-lg text-white inline-block">&lt; kembali</a>
        </div>
        <h2 class="text-2xl font-bold text-black mb-6">Nilai Posttest</h2>
            
        <!-- Tabel Nilai -->
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
            <?php if (!empty($data['siswa'])): ?>
            <?php foreach ($data['siswa'] as $row): ?>
            <tr class="hover:bg-gray-100">
              <td class="py-3 px-4"><?= htmlspecialchars($row['nama_siswa'] ?? 'Unknown') ?></td>
              <td class="py-3 px-4 text-center"><?= htmlspecialchars($row['nilai'] ?? '') ?></td>
              <td class="py-3 px-4 text-center"><?= htmlspecialchars($row['tanggal'] ?? '') ?></td>
            </tr>
            <?php endforeach; ?>
          <?php else: ?>
            <tr>
              <td class="py-3 px-4 text-center" colspan="3">Tidak ada data nilai posttest untuk pertemuan ini</td>
            </tr>
          <?php endif; ?>
            </tbody>
          </table>
        </div>
        
        <!-- Tombol Navigasi -->
        <div class="flex mt-5">
          <a href="<?= BASEURL ?>/dashboard/pertemuan_content/<?= $data['id_mapel'] ?>/<?= $data['id_pertemuan'] ?>" class="px-4 py-2 bg-[#7a00ff] text-white rounded hover:bg-[#6700D8] transition">Kembali ke Pertemuan</a>
        </div>
      </section>
    </main>
  </body>
</html>