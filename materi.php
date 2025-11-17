<?php
include 'navbar.html';
?>
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
        <!-- Judul -->
        <h2 class="text-2xl font-bold text-gray-800 mb-6">Mapel Ku</h2>

        <!-- Search & Sort -->
        <div class="flex flex-col md:flex-row md:items-center gap-3 mb-6">
          <div class="flex items-center border border-gray-300 rounded-lg px-3 py-1 bg-white w-full md:w-1/3">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400 mr-2" fill="none"
              viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 1110.5 3a7.5 7.5 0 016.15 13.65z" />
            </svg>
            <input id="searchInput" type="text" placeholder="Cari"
              class="w-full outline-none text-gray-700" />
          </div>
          <select id="sortSelect"
            class="border border-gray-300 rounded-lg px-3 py-2 bg-white text-gray-700 w-full md:w-auto">
            <option value="a-z">Urutkan A-Z</option>
            <option value="z-a">Urutkan Z-A</option>
          </select>
        </div>

        <!-- Grid Mapel -->
        <div id="mapelContainer" class="grid sm:grid-cols-2 lg:grid-cols-3 gap-4">
          <!-- Card Mapel -->
          <a href="sejarah.php">
            <div class="border border-gray-300 rounded-xl p-4 bg-white flex flex-col shadow-sm hover:shadow-md transition">
              <div class="flex items-center justify-between mb-3">
                <div class="flex items-center gap-3">
                  <div class="bg-purple-400 w-10 h-10 rounded-lg flex items-center justify-center text-white font-bold text-lg">📘</div>
                  <div>
                    <p class="font-semibold text-gray-800">Sejarah</p>
                    <p class="text-sm text-gray-800">Guru: nama-guru</p>
                  </div>
                </div>
              </div>
            </div>
          </a>

          <a href="matematika.php">
            <div class="border border-gray-300 rounded-xl p-4 bg-white flex flex-col shadow-sm hover:shadow-md transition">
              <div class="flex items-center justify-between mb-3">
                <div class="flex items-center gap-3">
                  <div class="bg-green-400 w-10 h-10 rounded-lg flex items-center justify-center text-white font-bold text-lg">📗</div>
                  <div>
                    <p class="font-semibold text-gray-800">Matematika</p>
                    <p class="text-sm text-gray-800">Guru: nama-guru</p>
                  </div>
                </div>
              </div>
            </div>
          </a>

          <a href="b-indo.php">
            <div class="border border-gray-300 rounded-xl p-4 bg-white flex flex-col shadow-sm hover:shadow-md transition">
              <div class="flex items-center justify-between mb-3">
                <div class="flex items-center gap-3">
                  <div class="bg-orange-400 w-10 h-10 rounded-lg flex items-center justify-center text-white font-bold text-lg">📘</div>
                  <div>
                    <p class="font-semibold text-gray-800">Bahasa Indonesia</p>
                    <p class="text-gray-800 text-sm">Guru: nama-guru</p>
                  </div>
                </div>
              </div>
            </div>
          </a>
        </div>
      </section>

      <!-- Notifikasi Desktop -->
      <aside class="hidden md:block w-72 bg-white border border-gray-300 rounded-xl p-4 shadow-sm">
        <h3 class="font-semibold mb-3 flex items-center gap-2">
          <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none"
            viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M15 19l-7-7 7-7" />
          </svg>
          Notifikasi
        </h3>
        <ul class="space-y-2 text-sm">
          <li class="text-blue-600 font-medium">🔹 Unread Notification</li>
          <li>• Notification</li>
          <li>• Notification</li>
          <li>• Notification</li>
        </ul>
      </aside>
    </main>

    <!-- Tombol Buka Notifikasi (Mobile) -->
    <button id="notifBtn"
      class="fixed bottom-6 right-6 md:hidden bg-gray-200 border-2 border-blue-500 text-black rounded-full w-12 h-12 flex items-center justify-center shadow-md">
      <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none"
        viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
          d="M15 19l-7-7 7-7" />
      </svg>
    </button>

    <!-- Panel Notifikasi (Mobile) -->
    <div id="notifPanel"
      class="fixed top-0 right-0 h-full w-64 bg-white shadow-lg border-l border-gray-200 transform translate-x-full transition-transform duration-300 md:hidden z-50">
      <div class="flex justify-between items-center p-4 border-b">
        <h3 class="font-semibold">Notifikasi</h3>
        <button id="closeNotif" class="text-gray-600 text-2xl">&times;</button>
      </div>
      <ul class="p-4 space-y-2 text-sm">
        <li class="text-blue-600 font-medium">🔹 Unread Notification</li>
        <li>• Notification</li>
        <li>• Notification</li>
        <li>• Notification</li>
      </ul>
    </div>

    <!-- SCRIPT -->
    <script>
      // Notifikasi (mobile)
      const notifBtn = document.getElementById("notifBtn");
      const notifPanel = document.getElementById("notifPanel");
      const closeNotif = document.getElementById("closeNotif");

      notifBtn.addEventListener("click", () => {
        notifPanel.classList.toggle("translate-x-full");
      });
      closeNotif.addEventListener("click", () => {
        notifPanel.classList.add("translate-x-full");
      });

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
</html>';
<?php
include 'footer.html';
?>

