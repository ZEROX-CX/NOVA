<?php
    include 'service/database.php';
    session_start();

    $login_message = "";

    if(isset($_SESSION["is_login"])) {
        header("location: /belajar/dashboard.php");
    }

    if(isset($_POST['kirim']))  {
        $namaSiswa = $_POST['namaSiswa'];
        $password = $_POST['password'];
        $hash_password = hash("sha256", $password);

        $sql = "SELECT * FROM siswa WHERE nama_siswa='$namaSiswa' AND password='$hash_password'";
        $result = $db->query($sql);

        if($result->num_rows > 0) {
            $data = $result->fetch_assoc();
            $_SESSION["id_siswa"] = $data["id_siswa"];
            $_SESSION["namaSiswa"] = $data["nama_siswa"];
            $_SESSION["is_login"] = true;
            header("location: dashboard.php");
        }else {
            $login_message = "akun tidak ditemukan";
        }
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
      background-color: #2563eb;
      transition: all 0.3s ease;
    }
  </style>
</head>
<body class="bg-gradient-to-br from-blue-50 to-blue-100 flex items-center justify-center min-h-screen">

  <div class="w-full max-w-md bg-white rounded-2xl shadow-xl overflow-hidden">
    <!-- Tab Pilihan -->
    <div class="relative flex bg-gray-100">
      <a href="#" id="tabSiswa"
         class="w-1/2 text-center py-3 font-semibold text-blue-600">Siswa</a>
      <a href="#" id="tabGuru"
         class="w-1/2 text-center py-3 font-semibold text-gray-500">Guru</a>
      <div id="activeLine"></div>
    </div>

    <!-- Form -->
    <div class="p-8">
      <h2 class="text-2xl font-bold text-gray-700 mb-6 text-left">Log In Siswa</h2>

      <form action="login_siswa.php" method="POST" class="space-y-5">
        <div>
          <input type="text" name="namaSiswa" placeholder="Nama" required
                 class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-400 outline-none">
        </div>
        <div>
          <input type="password" name="password" placeholder="Password" required
                 class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-400 outline-none">
                 <p><?= $login_message ?></p>
        </div>

        <div class="flex justify-between items-center text-sm">
          <a href="#" class="text-blue-600 hover:underline">Lupa Password?</a>
        </div>

        <div class="flex justify-end">
          <button name="kirim" type="submit" class="bg-blue-600 text-white font-semibold px-6 py-2 rounded-lg hover:bg-blue-700 transition">
            Log In
          </button>
        </div>
      </form>
    </div>
  </div>

  <script>
    const tabGuru = document.getElementById('tabGuru');
    const line = document.getElementById('activeLine');

    tabGuru.addEventListener('click', (e) => {
      e.preventDefault();
      line.style.left = '50%';
      setTimeout(() => {
        window.location.href = 'login_guru.php';
      }, 300);
    });
  </script>
</body>
</html>