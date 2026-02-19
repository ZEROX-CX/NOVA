<?php
 $questions = $data['questions'] ?? [];
 $id_pertemuan = $data['id_pertemuan'];
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= $data['judul'] ?></title>
  <script src="https://cdn.tailwindcss.com"></script>
  <style>
    /* Mencegah seleksi teks */
    body {
      -webkit-user-select: none;
      -moz-user-select: none;
      -ms-user-select: none;
      user-select: none;
    }
    
    /* Mencegah klik kanan */
    body {
      -webkit-touch-callout: none;
      -webkit-user-select: none;
      -khtml-user-select: none;
      -moz-user-select: none;
      -ms-user-select: none;
      user-select: none;
    }
  </style>
</head>

<body class="bg-white min-h-screen font-sans text-gray-800">
  <main class="max-w-5xl mx-auto px-4 py-10">
    <div class="bg-[#7a00ff] flex w-[130px] h-[35px] items-center justify-center rounded mb-4">
    <a href="<?= BASEURL ?>/pertemuan_content/<?= $data['id_mapel'] ?>/<?= $id_pertemuan ?>" class="text-lg text-white inline-block" onclick="return confirm('Anda yakin ingin kembali? Pre-test Anda belum disimpan.');">&lt; kembali</a>
    </div>

    <div class="bg-white rounded-lg shadow-md p-6 border border-gray-200">

      <div class="bg-[#7a00ff] text-white rounded-md p-4 mb-6 flex items-center justify-between">
        <div class="text-lg font-medium">Pre-Test</div>
      </div>

      <?php if (!empty($questions)): ?>
        <form method="post" action="<?= BASEURL ?>/pretest/submit" class="space-y-6" id="pretestForm">
          <input type="hidden" name="id_pertemuan" value="<?= $id_pertemuan ?>">
          <input type="hidden" name="tab_switch_count" id="tab_switch_count" value="0">
          <input type="hidden" name="test_duration" id="test_duration" value="0">
          <input type="hidden" name="id_mapel" value="<?= $data['id_mapel'] ?>">
          
          <?php $no = 1; foreach ($questions as $row): ?>
            <div class="bg-gray-50 border border-gray-300 rounded-md p-4">
              <p class="font-medium mb-3"><?= $no ?>. <?= htmlspecialchars($row['pertanyaan']) ?></p>
              
              <?php foreach (['A','B','C','D'] as $opt): 
                $opsi_text = htmlspecialchars($row['opsi_'.strtolower($opt)]);
                ?>
                <label class="flex items-center space-x-2 mb-1">
                  <input type="radio" name="soal_<?= $row['id_pretest'] ?>" value="<?= $opt ?>" required>
                  <span><?= $opt ?>. <?= $opsi_text ?></span>
                </label>
                <?php endforeach; ?>
              </div>
              <?php $no++; endforeach; ?>
              
              <div class="flex justify-end">
                <button type="submit" class="px-4 py-2 bg-[#7a00ff] text-white rounded hover:bg-[#6700D8] transition">
                  Kirim Jawaban
                </button>
              </div>
            </form>
            <?php else: ?>
              <p class="text-gray-600">Belum ada soal.</p>
              <div class="flex mt-10">
                <a href="<?= BASEURL ?>/materi/<?= $data['id_mapel'] ?>/<?= $data['id_pertemuan'] ?>" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition">Lanjut ke Materi</a>
              </div>
      <?php endif; ?>
    </div>
  </main>

  <script>
        // Mencegah klik kanan
    document.addEventListener('contextmenu', function(e) {
      if (isOnTestPage) {
        e.preventDefault();
        alert("Klik kanan dinonaktifkan selama pre-test.");
        return false;
      }
    });
    
    // Mencegah keyboard shortcuts untuk pindah tab
    document.addEventListener('keydown', function(e) {
      if (isOnTestPage) {
        // Ctrl+Tab, Ctrl+PageUp, Ctrl+PageDown, Alt+Tab
        if ((e.ctrlKey && e.keyCode === 9) || 
            (e.ctrlKey && (e.keyCode === 33 || e.keyCode === 34)) || 
            (e.altKey && e.keyCode === 9)) {
          e.preventDefault();
          alert("Pintasan keyboard untuk berpindah tab dinonaktifkan selama pre-test.");
          return false;
        }
      }
    });
  </script>
</body>
</html>