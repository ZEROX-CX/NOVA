<?php
    if (session_status() === PHP_SESSION_NONE) {
      session_start();
    }
    include '../service/database.php';

    $login_message = "";

    if(isset($_SESSION["is_login"])) {
        header("location: " . BASEURL . "/beranda");
        exit();
    }

    if(isset($_POST['kirim']))  {
        // Ambil data dari form
        $namaSiswa = $_POST['namaSiswa'];
        $password = $_POST['password'];
        $hash_password = hash("sha256", $password);

        // --- PERBAIKAN KEAMANAN: Gunakan Prepared Statements ---
        $stmt = $db->prepare("SELECT * FROM siswa WHERE nama_siswa = ? AND password = ?");
        
        // 'ss' berarti kita mengikat dua string (string, string)
        $stmt->bind_param("ss", $namaSiswa, $hash_password);
        $stmt->execute();
        $result = $stmt->get_result();

        if($result->num_rows > 0) {
            $data = $result->fetch_assoc();

            $_SESSION["id_siswa"] = $data["id_siswa"];
            $_SESSION["namaSiswa"] = $data["nama_siswa"];
            $_SESSION["is_login"] = true;
            $_SESSION["role"] = "siswa";
            $_SESSION["foto"] = $data["foto_profil"];
            $_SESSION['jenisKelamin'] = $data['jeniskelamin'];
            
            header("location:/beranda");
        } else {
            $login_message = "akun tidak ditemukan";
        }
        $stmt->close(); // Tutup statement
        $db->close();
    }
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login Siswa</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <style>
    #activeLine {
      position: absolute;
      bottom: 0;
      left: 0;
      width: 50%;
      height: 3px;
      background-color: #7a00ff;
      transition: all 0.3s ease;
    }

    /* HILANGKAN WARNA KUNING SAAT TAP / KLIK */
    input, button, a {
      outline: none !important;
      -webkit-tap-highlight-color: transparent;
    }

    input:focus {
      outline: none;
      box-shadow: none;
    }
  </style>
</head>

<body class="relative overflow-hidden min-h-screen flex items-center justify-center px-4
bg-gradient-to-br from-[#7a00ff] via-[#8f2bff] to-[#5b00c7]">

  <!-- ORNAMEN -->
  <div class="absolute top-12 left-10 w-32 h-32 border-4 border-white/30 rounded-lg rotate-12"></div>
  <div class="absolute bottom-20 right-14 w-40 h-40 border-4 border-white/20 rounded-full"></div>
  <div class="absolute top-1/2 right-1/4 w-24 h-24 bg-white/20 rounded-md rotate-6"></div>

  <!-- CARD -->
  <div class="relative w-full max-w-md bg-white rounded-2xl shadow-2xl overflow-hidden z-10">

    <!-- LOGO -->
    <div class="flex justify-center pt-6">
      <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 69 69" fill="none">
        <path d="M33.6931 28.3165C37.9674 31.9086 44.3404 31.3503 47.9268 27.0692L63.9972 7.88599C51.9238 26.7444 53.5913 51.8737 69 69L36.7195 41.8692C32.4455 38.2771 26.0731 38.8352 22.4865 43.1158L6.02469 62.7651C18.6488 43.3806 16.6404 17.2319 0 0L33.6931 28.3165Z" fill="url(#paint0_linear_1247_287)"></path>
        <defs>
          <linearGradient id="paint0_linear_1247_287" x1="0" y1="34.5" x2="69" y2="34.5" gradientUnits="userSpaceOnUse">
            <stop stop-color="#7a00ff"></stop>
            <stop offset="1" stop-color="#F2DE9B"></stop>
          </linearGradient>
        </defs>
      </svg>
    </div>

    <!-- TAB -->
    <div class="relative flex bg-gray-100 mt-4">
      <a href="#" id="tabSiswa" class="w-1/2 text-center py-3 font-semibold text-purple-700">Siswa</a>
      <a href="#" id="tabGuru" class="w-1/2 text-center py-3 font-semibold text-gray-500">Guru</a>
      <div id="activeLine"></div>
    </div>

    <div class="p-6 sm:p-8">
      <h2 class="text-xl sm:text-2xl font-bold text-gray-700 mb-6 text-center">
        Log In Siswa
      </h2>

      <form action="" method="POST" class="space-y-5">
        <input type="text" name="namaSiswa" placeholder="Nama" required
          class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-purple-500">

        <!-- PASSWORD -->
        <div class="relative">
          <input id="password"
            type="password" name="password"
            placeholder="Password"
            minlength="8"
            required
            class="w-full px-4 py-2 pr-12 border rounded-lg focus:ring-2 focus:ring-purple-500">

          <button type="button"
            onclick="togglePassword('password', this)"
            class="absolute inset-y-0 right-3 flex items-center text-purple-600">

            <!-- EYE OPEN -->
            <svg class="eye-open w-5 h-5" fill="none" stroke="currentColor" stroke-width="2"
              viewBox="0 0 24 24">
              <path d="M1 12s4-7 11-7 11 7 11 7-4 7-11 7-11-7-11-7z"/>
              <circle cx="12" cy="12" r="3"/>
            </svg>

            <!-- EYE CLOSE -->
            <svg class="eye-close w-5 h-5 hidden" fill="none" stroke="currentColor" stroke-width="2"
              viewBox="0 0 24 24">
              <path d="M17.94 17.94A10.94 10.94 0 0112 19
                       c-7 0-11-7-11-7a21.77 21.77 0 015.06-5.94"/>
              <path d="M1 1l22 22"/>
              <path d="M9.9 4.24A10.94 10.94 0 0112 5
                       c7 0 11 7 11 7a21.77 21.77 0 01-3.17 4.32"/>
            </svg>

          </button>
        </div>

        <p class="text-xs text-gray-500">
          Minimal 8 karakter (huruf, angka, simbol)
        </p>

        <p class="text-sm text-red-500"><?= $login_message ?></p>


        <button type="submit" name="kirim"
          class="w-full bg-purple-600 text-white font-semibold py-2 rounded-lg
                 hover:bg-purple-700 transition">
          Log In
        </button>
      </form>
    </div>
  </div>

  <script>
      function togglePassword(id, btn) {
    const input = document.getElementById(id);
    const openEye = btn.querySelector(".eye-open");
    const closeEye = btn.querySelector(".eye-close");

    if (input.type === "password") {
      input.type = "text";
      openEye.classList.add("hidden");
      closeEye.classList.remove("hidden");
    } else {
      input.type = "password";
      openEye.classList.remove("hidden");
      closeEye.classList.add("hidden");
    }
  }
    const tabGuru = document.getElementById('tabGuru');
    const line = document.getElementById('activeLine');

    tabGuru.addEventListener('click', (e) => {
      e.preventDefault();
      line.style.left = '50%';
      setTimeout(() => {
        window.location.href = 'login_guru';
      }, 300);
    });
  </script>
</body>
</html>
