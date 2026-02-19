<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Pre-Test</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-white min-h-screen font-sans text-gray-800">
  <main class="max-w-5xl mx-auto px-4 py-10">
    <a class="text-lg text-gray-600 mb-4 inline-block" href="10-pplg-b.php">&lt; kembali</a>

    <div class="bg-white rounded-lg shadow-md p-6 border border-gray-200">
      <div class="bg-blue-600 text-white rounded-md p-4 mb-6 flex items-center justify-between">
        <div class="text-lg font-medium">Pre-Test</div>

        <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'guru'): ?>
          <div class="relative inline-block text-left">
            <button id="dropdownBtnTop" class="p-2 rounded-full hover:bg-purple-700 focus:outline-none" type="button" aria-expanded="false" aria-haspopup="true">
              <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" fill="currentColor" viewBox="0 0 16 16">
                <path d="M3 9.5a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3m5 0a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3m5 0a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3"/>
              </svg>
            </button>
            <div id="dropdownMenuTop" class="hidden absolute right-0 mt-2 w-48 bg-white border border-gray-200 rounded-lg shadow-lg z-10">
              <a href="/pretest/add" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Tambah Pertanyaan</a>
            </div>
          </div>
        <?php endif; ?>
      </div>

      <?php if (empty($questions)): ?>
        <p class="text-gray-600">Belum ada soal.</p>
      <?php else: ?>
        <form method="post" action="/pretest/submit" class="space-y-6">
          <?php $no = 1; foreach ($questions as $row): 
            $qid = (int)$row['id'];
            $question = htmlspecialchars($row['pertanyaan']);
          ?>
            <div class="bg-gray-50 border border-gray-300 rounded-md p-4 relative">
              <div class="flex items-start justify-between mb-3">
                <p class="font-medium"><?= $no ?>. <?= $question ?></p>

                <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'guru'): ?>
                  <div class="relative inline-block text-left">
                    <button type="button" class="dropdown-btn p-2 rounded-full hover:bg-gray-100" data-id="<?= $qid ?>" aria-expanded="false">
                      <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500" viewBox="0 0 20 20" fill="currentColor">
                        <path d="M6 10a2 2 0 11-4 0 2 2 0 014 0zM12 10a2 2 0 11-4 0 2 2 0 014 0zM18 10a2 2 0 11-4 0 2 2 0 014 0z" />
                      </svg>
                    </button>

                    <div class="dropdown-menu hidden absolute right-0 mt-2 w-40 bg-white rounded-lg shadow-lg border border-gray-200 z-10" data-id="<?= $qid ?>">
                      <a href="/pretest/edit/<?= $qid ?>" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">✏️ Edit</a>
                      <a href="/pretest/delete/<?= $qid ?>" onclick="return confirm('Yakin ingin menghapus pertanyaan ini?')" class="block px-4 py-2 text-red-600 hover:bg-gray-100">🗑️ Hapus</a>
                    </div>
                  </div>
                <?php endif; ?>
              </div>

              <?php foreach (['A','B','C','D'] as $opt):
                $optText = htmlspecialchars($row['opsi_' . strtolower($opt)]);
              ?>
                <label class="flex items-center space-x-2 mb-1">
                  <input type="radio" name="soal_<?= $qid ?>" value="<?= $opt ?>" required>
                  <span><?= $opt ?>. <?= $optText ?></span>
                </label>
              <?php endforeach; ?>
            </div>
          <?php $no++; endforeach; ?>

          <div class="flex justify-end">
            <button type="submit" class="px-4 py-2 bg-purple-600 text-white rounded hover:bg-purple-700 transition">Kirim Jawaban</button>
          </div>
        </form>
      <?php endif; ?>
    </div>
  </main>

  <script>
    // Toggle header dropdown
    const dropdownBtnTop = document.getElementById('dropdownBtnTop');
    const dropdownMenuTop = document.getElementById('dropdownMenuTop');
    if (dropdownBtnTop) {
      dropdownBtnTop.addEventListener('click', (e) => {
        e.stopPropagation();
        dropdownMenuTop.classList.toggle('hidden');
      });
    }

    // Toggle per-question dropdowns (delegation by data-id)
    document.querySelectorAll('.dropdown-btn').forEach(btn => {
      btn.addEventListener('click', (e) => {
        e.stopPropagation();
        const id = btn.getAttribute('data-id');
        const menu = document.querySelector('.dropdown-menu[data-id="' + id + '"]');
        if (menu) menu.classList.toggle('hidden');
      });
    });

    // Close all dropdowns when clicking outside
    window.addEventListener('click', () => {
      document.querySelectorAll('.dropdown-menu').forEach(m => m.classList.add('hidden'));
      if (dropdownMenuTop) dropdownMenuTop.classList.add('hidden');
    });
  </script>
</body>
</html>