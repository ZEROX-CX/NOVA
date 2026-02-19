<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mapelku Guru - Jawaban Refleksi</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-white min-h-screen font-sans text-gray-800">
    <!-- Konten Utama -->
    <main class="max-w-7xl mx-auto px-4 py-10 flex flex-col md:flex-row gap-6">
        <!-- Bagian Jawaban Refleksi -->
        <section class="flex-1">
            <h2 class="text-2xl font-bold text-purple-700 mb-6">Jawaban Refleksi</h2>
            
            <!-- Informasi Pertemuan -->
            <div class="mb-4 p-4 bg-purple-50 rounded-lg">
                <h3 class="font-semibold text-purple-700"><?= htmlspecialchars($data['pertemuan']['judul_pertemuan']) ?></h3>
                <p class="text-sm text-gray-600"><?= date('d/m/Y', strtotime($data['pertemuan']['tanggal'])) ?></p>
            </div>
            
            <!-- Tabel Jawaban -->
            <div class="ml-0.5 max-w-4xl mx-auto bg-white border border-purple-300 rounded-lg shadow-md p-6">
                <?php if (!empty($data['jawaban'])): ?>
                    <?php 
                    // Kelompokkan jawaban per siswa
                    $jawaban_per_siswa = [];
                    foreach ($data['jawaban'] as $j) {
                        $jawaban_per_siswa[$j['id_siswa']]['nama'] = $j['nama_siswa'];
                        $jawaban_per_siswa[$j['id_siswa']]['jawaban'][] = $j;
                    }
                    ?>
                    
                    <?php foreach ($jawaban_per_siswa as $id_siswa => $data_siswa): ?>
                    <div class="mb-8 p-4 bg-gray-50 rounded-lg">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4"><?= htmlspecialchars($data_siswa['nama']) ?></h3>
                        
                        <?php foreach ($data_siswa['jawaban'] as $j): ?>
                        <div class="mb-4 p-3 bg-white rounded border">
                            <h4 class="font-medium text-gray-700 mb-2"><?= htmlspecialchars($j['pertanyaan']) ?></h4>
                            <p class="text-gray-600 mb-2"><?= htmlspecialchars($j['jawaban']) ?></p>
                            <p class="text-sm text-gray-500">Dikirim pada: <?= date('d/m/Y H:i', strtotime($j['tanggal'])) ?></p>
                        </div>
                        <?php endforeach; ?>
                    </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4 mb-6">
                        <p>Belum ada siswa yang mengirimkan jawaban refleksi.</p>
                    </div>
                <?php endif; ?>
            </div>
            
            <!-- Tombol Navigasi -->
            <div class="flex mt-5 gap-2">
                <a href="<?= BASEURL ?>/guru/refleksi/<?= $data['id_mapel'] ?>/<?= $data['pertemuan']['id_pertemuan'] ?>" class="px-4 py-2 bg-purple-600 text-white rounded hover:bg-purple-700 transition">Kembali ke Refleksi</a>
            </div>
        </section>
    </main>
</body>
</html>