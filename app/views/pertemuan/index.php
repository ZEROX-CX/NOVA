<?php
$pertemuan = $data['pertemuan'];
$mapel = $data['mapel'];
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($judul) ?></title>
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        .bg-purple-pattern {
            background-color: #6B46C1;
            background-image: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" width="100" height="100" viewBox="0 0 100 100"><circle cx="50" cy="50" r="15" fill="%23805AD5" opacity="0.8"/><circle cx="10" cy="10" r="8" fill="%23B794F4" opacity="0.6"/><circle cx="90" cy="10" r="10" fill="%23D6BCFA" opacity="0.7"/><circle cx="10" cy="90" r="10" fill="%23D6BCFA" opacity="0.7"/><circle cx="90" cy="90" r="8" fill="%23B794F4" opacity="0.6"/></svg>');
            background-size: 20px 20px;
        }
    </style>
</head>

<body class="bg-gray-100 min-h-screen">

<div class="container mx-auto max-w-7xl px-3 md:px-0 pt-4">
  <div class="flex flex-col md:flex-row">

    <!-- KONTEN UTAMA -->
    <main class="flex-1">

      <div class="bg-white shadow-md rounded-lg p-4 md:p-6">

        <!-- Judul -->
        <h1 class="text-lg md:text-xl font-bold text-gray-800 flex items-center mb-6">
          <svg class="w-6 h-6 mr-2 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
              d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m-9 9h6m-6 4h6m-3-11v6"/>
          </svg>
          Daftar Pertemuan - <?= htmlspecialchars($mapel['nama_mapel']); ?>
        </h1>

        <!-- DAFTAR PERTEMUAN -->
        <div class="mt-6">

          <div class="bg-purple-pattern h-16 md:h-20 rounded-lg mb-5 shadow-inner"></div>

          <h2 class="text-base md:text-lg font-semibold text-gray-800 mb-4">
            Daftar Pertemuan
          </h2>

          <?php if (!empty($pertemuan)): ?>
            <?php foreach ($pertemuan as $p): ?>
              <div class="p-4 border rounded-lg mb-3 bg-gray-50 hover:bg-gray-100 transition">
                <a href="<?= BASEURL ?>/pertemuan_content/<?= htmlspecialchars($mapel['id_mapel']) ?>/<?= htmlspecialchars($p['id_pertemuan']) ?>"
                   class="font-semibold text-indigo-700 block">
                  <?= htmlspecialchars($p['judul_pertemuan']) ?>
                </a>
                <p class="text-sm text-gray-500"><?= htmlspecialchars($p['tanggal']) ?></p>
                <p class="text-gray-700 mt-1 text-sm md:text-base">
                  <?= htmlspecialchars($p['deskripsi'] ?? '') ?>
                </p>
              </div>
            <?php endforeach; ?>
          <?php else: ?>
            <p class="text-gray-500 italic">Belum ada pertemuan untuk materi ini.</p>
          <?php endif; ?>

        </div>

      </div>
    </main>

  </div>
</div>

</body>
</html>