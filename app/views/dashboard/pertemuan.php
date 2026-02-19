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

    <div class="flex pt-4 container mx-auto max-w-7xl">

        <!-- KONTEN UTAMA -->
        <main class="flex-1 flex">

            <div class="flex-1 bg-white shadow-md rounded-lg p-6 mr-6">
                <p class="text-sm text-gray-500 mb-2">
                    Mapel > <?= htmlspecialchars($mapel['nama_mapel']) ?> > Pertemuan
                </p>

                <h1 class="text-xl font-bold text-gray-800 flex items-center mb-6">
                    <svg class="w-6 h-6 mr-2 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                              d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m-9 9h6m-6 4h6m-3-11v6"/>
                    </svg>
                    Daftar Pertemuan - <?= htmlspecialchars($mapel['nama_mapel']); ?>
                </h1>

                <div class="border-b border-gray-200 mb-6 flex items-center justify-between">
                    <h2 class="text-lg font-semibold text-gray-800">Pertemuan</h2>
                    <button onclick="window.location.href='<?= BASEURL ?>/pertemuan/tambah/<?= $mapel['id_mapel'] ?>'" 
                        class="flex items-center px-3 py-1.5 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg shadow transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                        Tambah
                    </button>
                </div>

                <!-- 🔹 DAFTAR PERTEMUAN -->
<div class="mt-6">
    <div class="bg-purple-pattern h-20 rounded-lg mt-5 mb-5 shadow-inner"></div>
    <h2 class="text-lg font-semibold text-gray-800 mb-4">Daftar Pertemuan</h2>
    
        <?php if (!empty($pertemuan)): ?>
            <?php foreach ($pertemuan as $p): ?>
                <div class="p-4 border rounded-lg mb-3 bg-gray-50 hover:bg-gray-100 transition">
                    <a href="<?= BASEURL ?>/dashboard/pertemuan_content/<?= $mapel['id_mapel'] ?>/<?= htmlspecialchars($p['id_pertemuan']) ?>" class="font-semibold text-indigo-700"><?= htmlspecialchars($p['judul_pertemuan']) ?></a>
                    <p class="text-sm text-gray-500"><?= htmlspecialchars($p['tanggal']) ?></p>
                    <p class="text-gray-700 mt-1"><?= htmlspecialchars($p['deskripsi'] ?? '') ?></p>
                    <div class="mt-3 flex flex-wrap gap-2">
                        <form action="<?= BASEURL ?>/pertemuan/hapus/<?= htmlspecialchars($p['id_pertemuan']) ?>" method="post" onsubmit="return confirm('Yakin ingin menghapus pertemuan ini beserta semua data terkait?');">
                            <button type="submit" class="px-3 py-1.5 bg-red-600 hover:bg-red-700 text-white text-sm font-medium rounded-lg">Hapus Pertemuan</button>
                        </form>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p class="text-gray-500 italic">Belum ada pertemuan untuk materi ini.</p>
        <?php endif; ?>

                <!-- Dekorasi bawah -->
                
            </div>
        </main>
    </div>
</body>
</html>
