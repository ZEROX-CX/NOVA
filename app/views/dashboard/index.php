<?php
$siswa = $data['siswa'];
$kelas_selected = $data['kelas'] ?? '';
$search_query = $data['search'] ?? '';
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Dashboard Data Siswa</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <style>
    /* Responsive styles */
    @media (max-width: 768px) {
      .sidebar {
        position: fixed;
        left: -100%;
        top: 0;
        height: 100vh;
        z-index: 50;
        transition: left 0.3s ease-in-out;
        width: 250px;
      }
      
      .sidebar.active {
        left: 0;
      }
      
      .overlay {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: rgba(0, 0, 0, 0.5);
        z-index: 40;
      }
      
      .overlay.active {
        display: block;
      }
    }
    
    /* Perbaikan table responsive */
    @media (max-width: 640px) {
      table {
        font-size: 0.875rem;
      }
      
      th, td {
        padding: 0.5rem 0.25rem;
      }
    }
  </style>
</head>
<body class="bg-gray-100 font-sans">

  <!-- Overlay untuk mobile -->
  <div class="overlay" id="overlay" onclick="toggleSidebar()"></div>

  <!-- Tombol hamburger untuk mobile -->
  <button 
    onclick="toggleSidebar()" 
    class="fixed top-4 left-4 z-50 md:hidden bg-indigo-600 text-white p-3 rounded-lg shadow-lg hover:bg-indigo-700"
    id="hamburger"
  >
    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
    </svg>
  </button>

  <div class="flex">
    <!-- Sidebar -->
    <aside class="sidebar bg-white shadow-lg md:shadow rounded-none md:rounded-lg p-4 md:mr-6 md:w-64 md:static">
      <div class="flex justify-between items-center mb-4 md:mb-0">
        <h2 class="text-lg font-bold md:hidden">Menu</h2>
        <!-- Tombol close untuk mobile -->
        <button 
          onclick="toggleSidebar()" 
          class="md:hidden p-2 hover:bg-gray-100 rounded"
        >
          <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
          </svg>
        </button>
      </div>
      
      <nav class="space-y-3">
        <!-- Menu Siswa -->
        <a href="#" class="block px-3 py-2 rounded-md bg-indigo-100 text-indigo-700 font-medium">
          Siswa
        </a>

        <!-- Menu Mapel -->
        <a href="<?= BASEURL ?>/mapel_guru" class="block px-3 py-2 font-medium hover:bg-indigo-100 hover:rounded-md hover:text-indigo-700 duration-300 transition">
          Mapel
        </a>
      </nav>
    </aside>

    <!-- Konten utama -->
    <div class="flex-1 w-full md:max-w-5xl md:mx-auto mt-2 md:mt-10 p-4 md:p-6 bg-white rounded-lg shadow-lg">
      <h1 class="mb-6 md:mb-10 text-xl md:text-2xl font-bold mt-14 md:mt-0">Daftar Siswa</h1>
      
      <!-- Form pencarian - responsive -->
      <form action="<?= BASEURL ?>/dashboard" method="get" class="mb-6 space-y-3">
        <!-- Input Cari Siswa -->
        <div class="w-full">
          <label for="cari" class="block text-sm font-medium mb-1 text-gray-700">Cari Siswa</label>
          <input 
            type="text" 
            id="cari"
            name="cari" 
            placeholder="Cari siswa berdasarkan nama..." 
            class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
          />
        </div>
        
        <!-- Dropdown Pilih Kelas -->
        <div class="w-full">
          <label for="kelas" class="block text-sm font-medium mb-1 text-gray-700">Pilih Kelas</label>
          <select 
            name="kelas" 
            id="kelas" 
            class="w-full bg-white border border-gray-300 text-gray-700 py-2.5 px-4 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
          >
            <option value="">Semua Kelas</option>
            <option value="9A" <?php echo (isset($_GET['kelas']) && $_GET['kelas'] == '9A') ? 'selected' : ''; ?>>9A</option>
            <option value="9B" <?php echo (isset($_GET['kelas']) && $_GET['kelas'] == '9B') ? 'selected' : ''; ?>>9B</option>
            <option value="9C" <?php echo (isset($_GET['kelas']) && $_GET['kelas'] == '9C') ? 'selected' : ''; ?>>9C</option>
          </select>
        </div>
        
        <!-- Tombol Aksi -->
        <div class="flex gap-2 w-full">
          <button 
            type="submit" 
            class="flex-1 bg-green-500 text-white py-2.5 px-4 rounded-lg hover:bg-green-600 transition font-medium"
          >
            Cari
          </button>
          <a 
            href="<?= BASEURL ?>/dashboard" 
            class="flex-1 bg-gray-500 text-white py-2.5 px-4 rounded-lg hover:bg-gray-600 transition text-center font-medium"
          >
            Reset
          </a>
        </div>
      </form>
      
      <!-- Table wrapper - responsive -->
      <div class="overflow-x-auto -mx-4 md:mx-0 rounded-lg border border-gray-200">
        <table class="min-w-full bg-white">
          <thead>
            <tr class="bg-purple-600 text-white">
              <th class="py-3 px-3 md:px-4 text-left text-sm md:text-base font-semibold">Nama</th>
              <th class="py-3 px-3 md:px-4 text-left text-sm md:text-base font-semibold">Usia</th>
              <th class="py-3 px-3 md:px-4 text-left text-sm md:text-base font-semibold">Kelas</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-gray-200">
          <?php if (!empty($data['siswa']) && is_array($data['siswa'])): ?>
            <?php foreach ($data['siswa'] as $row): ?>
            <tr class="hover:bg-gray-50 transition">
              <td class="py-3 px-3 md:px-4 text-sm md:text-base"><?php echo htmlspecialchars($row["nama_siswa"] ?? '-'); ?></td>
              <td class="py-3 px-3 md:px-4 text-sm md:text-base"><?php echo htmlspecialchars($row["usia"] ?? '-'); ?></td>
              <td class="py-3 px-3 md:px-4 text-sm md:text-base"><?php echo htmlspecialchars($row["kelas"] ?? '-'); ?></td>
            </tr>
            <?php endforeach; ?>
          <?php else: ?>
            <tr>
              <td class="py-4 px-3 md:px-4 text-sm md:text-base text-center text-gray-500" colspan="4">
                Tidak ada data siswa.
              </td>
            </tr>
          <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <script>
    function toggleSidebar() {
      const sidebar = document.querySelector('.sidebar');
      const overlay = document.getElementById('overlay');
      sidebar.classList.toggle('active');
      overlay.classList.toggle('active');
    }
    
    // Close sidebar ketika klik menu di mobile
    document.querySelectorAll('.sidebar a').forEach(link => {
      link.addEventListener('click', function() {
        if (window.innerWidth < 768) {
          toggleSidebar();
        }
      });
    });
  </script>
</body>
</html>