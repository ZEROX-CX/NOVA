<?php
 $mapel = $data['mapel'];
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Dashboard Data Siswa</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 font-sans">

  <div class="flex">
    <!-- Sidebar -->
<aside class="w-64 bg-white shadow rounded-lg p-4 mr-6">
      <nav class="space-y-3">
        <a href="<?= BASEURL ?>/dashboard/index" class="block px-3 py-2 rounded-md hover:bg-indigo-100 hover:text-indigo-700 font-medium duration-300 transition">
          Siswa
        </a>
        <a href="<?= BASEURL ?>/dashboard/mapel" class="block px-3 py-2 font-medium bg-indigo-100 rounded-md text-indigo-700 ">
          Mapel
        </a>
      </nav>
    </aside>

        <!-- Daftar mapel -->
        <!-- <div class="space-y-1">
          <a href="#" class="block px-3 py-2 font-medium hover:bg-indigo-100 hover:rounded-md hover:text-indigo-700 duration-300 transition">
            Pertemuan
          </a>
        </div> -->
      </nav>
    </aside>
    
    <!-- Konten utama -->
    <div class="flex-1 p-6">
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <?php if (!empty($data['mapel'])): ?>
          <?php foreach ($data['mapel'] as $row): ?>
            <div class="border border-gray-300 rounded-xl p-4 bg-white shadow-sm hover:shadow-md transition">
              <div class="flex items-start justify-between mb-3">
                <div class="flex items-start gap-3">
                  <div class="bg-purple-500 w-10 h-10 rounded-lg flex items-center justify-center text-white flex-shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                    </svg>
                  </div>
                  <div>
                    <h1 class="font-semibold text-gray-800 text-lg"><?= htmlspecialchars($row["nama_mapel"] ?? '') ?></h1> 
                  </div>
                </div>
              </div>

              <div class="flex justify-between items-center mt-4">
                <a href="<?= BASEURL ?>/dashboard/mapel/<?= $row['id_mapel'] ?>" 
                   class="bg-blue-500 text-white py-1 px-3 rounded-lg hover:bg-blue-600 transition text-sm font-medium">
                  Lihat Materi
                </a>
              </div>
            </div>
          <?php endforeach; ?>
        <?php endif; ?>
      </div>
    </div>
  </div>
</body>
</html>