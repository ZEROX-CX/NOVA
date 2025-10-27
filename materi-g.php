<?php
include 'navbar-guru.html';
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
        <a class="text-lg text-gray-600" href="10-pplg-b.php">< kembali</a>
        <h2 class="text-2xl font-bold text-purple-700 mb-6">Tambahkan Materi</h2>
        <form class="max-w-xl mx-auto bg-white border border-purple-300 rounded-lg shadow-md p-6 space-y-6">
          <!-- Toolbar -->
          <div class="flex flex-wrap gap-2">
            <button type="button" onclick="document.execCommand('bold')" class="px-4 py-2 bg-white text-purple-700 border border-purple-600 rounded hover:bg-purple-50 focus:outline-none focus:ring-2 focus:ring-purple-500">B</button>
            <button type="button" onclick="document.execCommand('italic')" class="px-4 py-2 bg-white text-purple-700 border border-purple-600 rounded hover:bg-purple-50 focus:outline-none focus:ring-2 focus:ring-purple-500"><em>I</em></button>
            <button type="button" onclick="document.execCommand('underline')" class="px-4 py-2 bg-white text-purple-700 border border-purple-600 rounded hover:bg-purple-50 focus:outline-none focus:ring-2 focus:ring-purple-500"><u>U</u></button>
            <button type="button" onclick="document.execCommand('insertUnorderedList')" class="px-4 py-2 bg-white text-purple-700 border border-purple-600 rounded hover:bg-purple-50 focus:outline-none focus:ring-2 focus:ring-purple-500">• List</button>
            <button type="button" onclick="document.execCommand('createLink', false, prompt('Masukkan URL:'))" class="px-4 py-2 bg-white text-purple-700 border border-purple-600 rounded hover:bg-purple-50 focus:outline-none focus:ring-2 focus:ring-purple-500">🔗 Link</button>
          </div>
        
          <!-- Editor -->
          <div class="bg-white border border-purple-300 rounded-lg p-4 min-h-[200px] shadow-md" contenteditable="true">
          </div>
        
          <!-- Upload File -->
          <div>
            <label class="block mb-4">
              <span class="text-gray-800 font-medium">Upload File</span>
              <input type="file" class="mt-2 block w-full text-sm text-gray-700 file:mr-4 file:py-2 file:px-4
                file:rounded-lg file:border-0
                file:bg-purple-600 file:text-white
                hover:file:bg-purple-700" />
            </label>
          </div>
        
          <!-- Submit -->
          <button type="submit" class="w-full px-6 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition">
            Simpan
          </button>
        </form>       
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
</html>

<?php
include 'footer.html';
?>
