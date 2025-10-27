<?php
include 'navbar.html';
echo '
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

        <a class="text-lg text-gray-600" href="kelas.php">< kembali</a>
        <div class="bg-white rounded-lg shadow-md p-6 border border-gray-200">
        
          <!-- Banner -->
          <div class="bg-purple-600 text-white rounded-md p-4 mb-6 flex items-center justify-between">
            <div class="text-lg font-medium">Pre-Test</div>
            <div class="flex space-x-2">
              <div class="w-3 h-3 bg-white rounded-full opacity-30"></div>
              <div class="w-3 h-3 bg-white rounded-full opacity-30"></div>
              <div class="w-3 h-3 bg-white rounded-full opacity-30"></div>
            </div>
          </div>
        
          <!-- Soal Pilihan Ganda -->
          <form class="space-y-6">

            <div class="bg-gray-50 border border-gray-300 rounded-md p-4">
              <p class="text-sm font-medium text-gray-800 mb-3">1. Soal</p>
              <div class="space-y-2 text-sm text-gray-700">
                <label class="flex items-center space-x-2">
                  <input type="radio" name="soal1" value="a" class="text-purple-600 focus:ring-purple-500">
                  <span>Section</span>
                </label>
                <label class="flex items-center space-x-2">
                  <input type="radio" name="soal1" value="a" class="text-purple-600 focus:ring-purple-500">
                  <span>Section</span>
                </label>
                <label class="flex items-center space-x-2">
                  <input type="radio" name="soal1" value="a" class="text-purple-600 focus:ring-purple-500">
                  <span>Section</span>
                </label>
                <label class="flex items-center space-x-2">
                  <input type="radio" name="soal1" value="a" class="text-purple-600 focus:ring-purple-500">
                  <span>Section</span>
                </label>
              </div>
            </div>

            <div class="bg-gray-50 border border-gray-300 rounded-md p-4">
              <p class="text-sm font-medium text-gray-800 mb-3">2. Soal</p>
              <div class="space-y-2 text-sm text-gray-700">
                <label class="flex items-center space-x-2">
                  <input type="radio" name="soal1" value="a" class="text-purple-600 focus:ring-purple-500">
                  <span>Section</span>
                </label>
                <label class="flex items-center space-x-2">
                  <input type="radio" name="soal1" value="a" class="text-purple-600 focus:ring-purple-500">
                  <span>Section</span>
                </label>
                <label class="flex items-center space-x-2">
                  <input type="radio" name="soal1" value="a" class="text-purple-600 focus:ring-purple-500">
                  <span>Section</span>
                </label>
                <label class="flex items-center space-x-2">
                  <input type="radio" name="soal1" value="a" class="text-purple-600 focus:ring-purple-500">
                  <span>Section</span>
                </label>
              </div>
            </div>
        
            <!-- Tombol Kirim -->
            <div class="flex justify-end">
              <button type="submit" class="px-4 py-2 bg-purple-600 text-white text-sm font-medium rounded hover:bg-purple-700 transition">
                Kirim
              </button>
            </div>
          </form>
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
include 'footer.html'
?>
