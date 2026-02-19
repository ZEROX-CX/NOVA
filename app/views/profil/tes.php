<?php
    if(isset($_POST['logout'])) {
        session_unset();
        session_destroy();
        header("location:" . BASEURL . "/login_guru");
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body class="bg-[#fffde8] flex justify-center items-start min-h-screen font-sans text-gray-800">

  <div class="w-[1100px] h-auto mt-10 flex flex-col justify-between">

    <!-- Bagian utama -->
    <div class="flex justify-between">

      <!-- Kiri: Profil Pengguna -->
      <div class="w-[430px] bg-gray-100 rounded-lg p-6 shadow">
        <!-- Header Profil -->
        <div class="flex items-center mb-6">
          <!-- Foto Profil -->
          <div class="relative">
            <div class="w-20 h-20 bg-gray-300 rounded-full flex items-center justify-center overflow-hidden group cursor-pointer">
              <svg xmlns="http://www.w3.org/2000/svg" class="w-10 h-10 text-gray-500 group-hover:opacity-0 transition" viewBox="0 0 24 24" fill="currentColor">
                <path d="M12 12c2.7 0 5-2.3 5-5s-2.3-5-5-5-5 2.3-5 5 2.3 5 5 5zm0 2c-3.3 0-10 1.7-10 5v3h20v-3c0-3.3-6.7-5-10-5z"/>
              </svg>
              <div class="absolute inset-0 bg-black bg-opacity-40 text-white text-sm flex items-center justify-center opacity-0 group-hover:opacity-100 transition">
                Ganti Foto
              </div>
            </div>
          </div>

          <div class="ml-4">
            <h2 class="text-xl font-semibold"><?= $_SESSION['namaSiswa'] ?></h2>
            <p class="text-blue-700 font-medium"><?= $data['kelas']['kelas'] ?></p>
            <p class="text-sm text-gray-600 mt-1">Status: <span class="font-semibold text-green-700">Murid</span></p>
            <p class="text-sm text-gray-600">Jenis Kelamin: <span class="font-semibold">Perempuan</span></p>
          </div>
        </div>

        <!-- Detail Pengguna -->
        <div class="text-sm">
          <p class="font-semibold mb-1">Detail Pengguna</p>

          <p class="font-semibold">Alamat surel</p>
          <a href="#" class="text-blue-600">ratnadewi2025@gmail.com</a>

          <div class="flex justify-between mt-4">
            <div>
              <p class="font-semibold">Negara</p>
              <p>Indonesia</p>
            </div>
            <div>
              <p class="font-semibold">Zona waktu</p>
              <p>Asia/Makassar</p>
            </div>
          </div>
        </div>

        <!-- Achievement -->
        <div class="mt-6 space-y-2">
          <p class="font-semibold text-sm mb-1">Pencapaian</p>

          <div class="bg-white border border-gray-200 rounded-md px-3 py-2 flex items-center justify-between">
            <div class="flex items-center gap-2">
              <span class="text-yellow-400 text-lg">⭐</span>
              <span>Juara Kelas</span>
            </div>
            <span class="text-gray-500">⌄</span>
          </div>

          <div class="bg-white border border-gray-200 rounded-md px-3 py-2 flex items-center justify-between">
            <div class="flex items-center gap-2">
              <span class="text-yellow-400 text-lg">⭐</span>
              <span>Aktif di Forum</span>
            </div>
            <span class="text-gray-500">⌄</span>
          </div>
        </div>
      </div>

      <!-- Kanan: Detail Kursus -->
      <div class="w-[540px] bg-gray-100 rounded-lg p-6 shadow">
        <h2 class="text-lg font-semibold text-blue-800 mb-3">Detail Kursus</h2>
        <p class="text-gray-700 font-medium mb-3">Profil Kursus</p>

        <div class="grid grid-cols-3 gap-x-10 gap-y-2 text-blue-800 text-sm font-medium">
          <a href="#">Matematika</a>
          <a href="#">Biologi</a>
          <a href="#">Seni Budaya</a>
          <a href="#">IPA</a>
          <a href="#">B. Indonesia</a>
          <a href="#">PAI</a>
          <a href="#">IPS</a>
          <a href="#">Informatika</a>
          <a href="#">Sejarah</a>
          <a href="#">Fisika</a>
          <a href="#">B. Inggris</a>
          <a href="#">Ekonomi</a>
        </div>

        <!-- Riwayat Kursus -->
        <div class="mt-6">
          <h3 class="text-blue-800 font-semibold mb-2">Riwayat Kursus</h3>
          <div class="bg-white rounded-md border border-gray-200 divide-y text-sm">
            <div class="px-4 py-2 flex justify-between">
              <span>Seni Tari Tradisional</span>
              <span class="text-green-600 font-medium">Selesai</span>
            </div>
            <div class="px-4 py-2 flex justify-between">
              <span>Informatika Dasar</span>
              <span class="text-yellow-600 font-medium">Sedang Berlangsung</span>
            </div>
            <div class="px-4 py-2 flex justify-between">
              <span>PAI - Akhlak Mulia</span>
              <span class="text-green-600 font-medium">Selesai</span>
            </div>
            <div class="px-4 py-2 flex justify-between">
              <span>Bahasa Inggris</span>
              <span class="text-gray-600 font-medium">Belum Mulai</span>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Log out -->
    <div class="text-right mt-4">
      <a href="#" class="text-blue-700 font-medium hover:underline">Log out</a>
    </div>

        <form action="" method="POST" class="text-right mt-4">
      <button name="logout" type="submit" href="#" class="text-blue-700 font-medium">Log out</button>
    </form>

    <!-- Garis bawah halus -->
    <div class="border-t border-gray-300 mt-2"></div>
  </div>

 <?php
    if(isset($_POST['logout'])) {
        session_unset();
        session_destroy();
        header("location:" . BASEURL . "/login_guru");
    }
?>
</body>
</html>