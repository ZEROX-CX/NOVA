<?php
    if (session_status() === PHP_SESSION_NONE) {
      session_start();
    }
    include '../service/database.php';
    $register_message = "";

    // Jika sudah login, redirect ke halaman beranda
    if(isset($_SESSION["is_login"])) {
        header("location: " . BASEURL . "/beranda");
    }

    // Proses registrasi guru
    if(isset($_POST['register'])) {
        $username = $_POST['nama_guru'];
        $password = $_POST['password'];
        $hash_password = hash("sha256", $password);

        // Cek apakah username atau email sudah terdaftar
        $check_sql = "SELECT * FROM guru WHERE nama_guru='$username'";
        $check_result = $db->query($check_sql);

        if($check_result->num_rows > 0) {
            $register_message = "Username sudah digunakan";
        } else {
            // Insert data guru baru ke database
            $insert_sql = "INSERT INTO guru (nama_guru, password) VALUES ('$username', '$hash_password')";
            
            if($db->query($insert_sql)) {
                // Ambil ID guru yang baru didaftarkan
                $guru_id = $db->insert_id;
                
                // Set session untuk login otomatis setelah registrasi
                $_SESSION["id_guru"] = $guru_id;
              // gunakan username yang baru didaftarkan
              $_SESSION["namaGuru"] = $username;
                $_SESSION["is_login"] = true;
                $_SESSION["role"] = "guru";
                
                // Redirect ke halaman beranda
                header("location: " . BASEURL . "/beranda");
            } else {
                $register_message = "Registrasi gagal: " . $db->error;
            }
        }
        $db->close();
    }
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Register Guru</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <style>
    #activeLine {
      position: absolute;
      bottom: 0;
      left: 50%;
      width: 50%;
      height: 3px;
      background-color: #2563eb;
      transition: left 0.4s ease-in-out;
    }
  </style>
</head>
<body class="bg-gradient-to-br from-blue-50 to-blue-100 flex items-center justify-center min-h-screen">

  <div class="w-full max-w-md bg-white rounded-2xl shadow-xl overflow-hidden">
    <!-- Tab Pilihan -->
    <div class="relative flex bg-gray-100">
      <a href="register_siswa" id="tabSiswa"
         class="w-1/2 text-center py-3 font-semibold text-gray-500 hover:text-blue-600 transition-colors">Siswa</a>
      <a href="#" id="tabGuru"
         class="w-1/2 text-center py-3 font-semibold text-blue-600">Guru</a>
      <div id="activeLine"></div>
    </div>

    <!-- Form -->
    <div class="p-8">
      <h2 class="text-2xl font-bold text-gray-700 mb-6 text-left">Register Guru</h2>
      
      <?php if(!empty($register_message)): ?>
        <div class="mb-4 p-3 bg-red-100 text-red-700 rounded-lg">
          <?php echo $register_message; ?>
        </div>
      <?php endif; ?>

      <form action="" method="POST" class="space-y-5">
        <div>
          <input type="text" name="nama_guru" placeholder="Username" required
                 class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-400 outline-none">
        </div>
        <div>
          <input type="password" name="password" placeholder="Password" required minlength="8"
                 class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-400 outline-none">
        </div>

        <div class="flex justify-end">
          <button type="submit" name="register"
                  class="bg-blue-600 text-white font-semibold px-6 py-2 rounded-lg hover:bg-blue-700 transition">
            Register
          </button>
        </div>
      </form>
    </div>
  </div>

  <script>
    const line = document.getElementById('activeLine');

    // Saat halaman dimuat, garis di kanan (Guru)
    window.addEventListener('load', () => {
      line.style.left = '50%';
    });

    // Saat klik "Siswa", garis geser dulu baru pindah halaman
    document.getElementById('tabSiswa').addEventListener('click', (e) => {
      e.preventDefault();
      line.style.left = '0';
      setTimeout(() => {
        window.location.href = 'register_siswa';
      }, 300);
    });
  </script>
</body>
</html>