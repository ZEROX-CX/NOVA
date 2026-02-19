<?php
 $questions = $data['questions'] ?? [];
 $id_pertemuan = $data['id_pertemuan'];
// Asumsi: guru login jika session 'id_guru' ada
 $isGuru = isset($_SESSION['id_guru']);
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= $data['judul'] ?></title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-white min-h-screen font-sans text-gray-800">
  <main class="max-w-5xl mx-auto px-4 py-10">
    <div class="bg-[#7a00ff] flex w-[130px] h-[35px] items-center justify-center rounded mb-4">
      <a href="<?= BASEURL ?>/dashboard/pertemuan_content/<?= $data['id_mapel'] ?>/<?= $id_pertemuan ?>" class="text-lg text-white inline-block">&lt; kembali</a>
    </div>

    <div class="bg-white rounded-lg shadow-md p-6 border border-gray-200">

      <div class="bg-[#7a00ff] text-white rounded-md p-4 mb-6 flex items-center justify-between">
        <div class="text-lg font-medium">Pre-Test</div>
        
        <!-- Tombol Tambah Soal (Hanya untuk Guru) -->
        <?php if ($isGuru): ?>
          <a href="<?= BASEURL ?>/pretest/create/<?= $data['id_mapel'] ?>/<?= $id_pertemuan ?>" class="bg-[#7a00ff] hover:bg-[#6700D8] text-white font-bold py-2 px-4 rounded text-sm transition duration-300">
            + Tambah Soal Baru
          </a>
        <?php endif; ?>
      </div>

      <?php if (!empty($questions)): ?>
        <form method="post" action="<?= BASEURL ?>/pretest/submit" class="space-y-6">
          <input type="hidden" name="id_pertemuan" value="<?= $id_pertemuan ?>">
          
          <?php $no = 1; foreach ($questions as $row): ?>
            <div class="bg-gray-50 border border-gray-300 rounded-md p-4 relative">
              <!-- Tombol Aksi (Hanya untuk Guru) -->
              <?php if ($isGuru): ?>
                <div class="absolute top-2 right-2 space-x-2">
                  <a href="<?= BASEURL ?>/pretest/edit/<?= $row['id_pretest'] ?>" class="bg-[#7a00ff] hover:bg-[#6700D8] text-white text-xs font-bold py-1 px-2 rounded transition duration-300">
                    Edit
                  </a>
                  <a href="<?= BASEURL ?>/pretest/delete/<?= $row['id_pretest'] ?>" onclick="return confirm('Apakah Anda yakin ingin menghapus soal ini?');" class="bg-red-500 hover:bg-red-600 text-white text-xs font-bold py-1 px-2 rounded transition duration-300">
                    Hapus
                  </a>
                </div>
              <?php endif; ?>

              <p class="font-medium mb-3 pr-32"><?= $no ?>. <?= htmlspecialchars($row['pertanyaan']) ?></p>
              
              <?php foreach (['A','B','C','D'] as $opt): 
                $opsi_text = htmlspecialchars($row['opsi_'.strtolower($opt)]);
                ?>
                <label class="flex items-center space-x-2 mb-1">
                  <input type="radio" name="soal_<?= $row['id_pretest'] ?>" value="<?= $opt ?>">
                  <span><?= $opt ?>. <?= $opsi_text ?></span>
                </label>
                <?php endforeach; ?>
            </div>
            <?php $no++; endforeach; ?>
            
            <!-- Tombol di bawah, hanya untuk siswa -->
        </form>
      <?php else: ?>
          <p class="text-gray-600">Belum ada soal.</p>
      <?php endif; ?>

      <!-- Link di bawah, hanya untuk guru -->
      <?php if ($isGuru): ?>
        <div class="flex justify-end mt-6 space-x-2">
          <a href="<?= BASEURL ?>/guru/nilai_pretest/<?= $data['id_mapel'] ?>/<?= $data['id_pertemuan'] ?>" class="px-4 py-2 bg-[#7a00ff] text-white rounded hover:bg-[#6700D8] transition">Lihat Nilai Siswa</a>
          <a href="<?= BASEURL ?>/guru/materi/<?= $data['id_mapel'] ?>/<?= $data['id_pertemuan'] ?>" class="px-4 py-2 bg-[#7a00ff] text-white rounded hover:bg-[#6700D8] transition">
            Lanjut ke Materi
          </a>
        </div>
      <?php endif; ?>
    </div>
  </main>
</body>
</html>