<?php
    include '../service/database.php';

    $register_message = "";

    if(isset($_SESSION["is_login"])) {
        header("location: " . BASEURL . "/beranda");
    }

    if(isset($_POST['register'])) {
        $username = $_POST['nama_siswa'];
        $password = $_POST['password'];
        $hash_password = hash("sha256", $password);

        // Cek apakah username atau email sudah terdaftar
        $check_sql = "SELECT * FROM siswa WHERE nama_siswa='$username'";
        $check_result = $db->query($check_sql);

        if($check_result->num_rows > 0) {
            $register_message = "Username sudah digunakan";
        } else {
            // Insert data siswa baru ke database
            $insert_sql = "INSERT INTO siswa (nama_siswa, password) VALUES ('$username', '$hash_password')";
            
            if($db->query($insert_sql)) {
                // Ambil ID siswa yang baru didaftarkan
                $siswa_id = $db->insert_id;
                
                // Set session untuk login otomatis setelah registrasi
                $_SESSION["id_siswa"] = $siswa_id;
                $_SESSION["namaSiswa"] = $username;
                $_SESSION["is_login"] = true;
                $_SESSION["role"] = "siswa";
                
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
  <title>Register Siswa</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <style>
    #activeLine {
      position: absolute;
      bottom: 0;
      left: 0;
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
      <a href="#" id="tabSiswa"
         class="w-1/2 text-center py-3 font-semibold text-blue-600">Siswa</a>
      <a href="register_guru" id="tabGuru"
         class="w-1/2 text-center py-3 font-semibold text-gray-500 hover:text-blue-600 transition-colors">Guru</a>
      <div id="activeLine"></div>
    </div>

    <!-- Form -->
    <div class="p-8">
      <h2 class="text-2xl font-bold text-gray-700 mb-6 text-left">Register Siswa</h2>
      
      <?php if(!empty($register_message)): ?>
        <div class="mb-4 p-3 bg-red-100 text-red-700 rounded-lg">
          <?php echo $register_message; ?>
        </div>
      <?php endif; ?>

      <form action="" method="POST" class="space-y-5">
        <div>
          <input type="text" name="nama_siswa" placeholder="Username" required
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

    // Saat halaman dimuat, posisi garis di kiri (Siswa)
    window.addEventListener('load', () => {
      line.style.left = '0';
    });

    // Saat klik "Guru", garis geser dulu baru pindah halaman
    document.getElementById('tabGuru').addEventListener('click', (e) => {
      e.preventDefault();
      line.style.left = '50%';
      setTimeout(() => {
        window.location.href = 'register_guru';
      }, 300);
    });
  </script>
</body>
</html>