<?php
$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$segments = array_values(array_filter(explode('/', trim($path, '/'))));
$segments = array_map('strtolower', $segments);

// default
$current = 'beranda';

// jika ada segmen yang spesifik, gunakan itu (lebih robust)
if (in_array('mapel_guru', $segments, true)) {
    $current = 'mapel_guru';
} elseif (in_array('beranda', $segments, true)) {
    $current = 'beranda';
} elseif (in_array('profil', $segments, true)) {
    $current = 'profil';
} elseif (in_array('dashobard', $segments, true)) {
  $current = 'dashboard';
} elseif (!empty($segments)) {
    $current = end($segments);
}

// Cek role dari session (session sudah dimulai di app/init.php)
// Support kedua struktur: $_SESSION['user']['role'] atau $_SESSION['role']
$userRole = 'siswa'; // Default

if (isset($_SESSION['user']['role'])) {
    $userRole = $_SESSION['user']['role'];
} elseif (isset($_SESSION['role'])) {
    $userRole = $_SESSION['role'];
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title><?= $judul ?></title>
  <script src="https://cdn.tailwindcss.com"></script>
  <style>
    .bt{
      display: inline-block;           /* pastikan padding dan border-bottom bekerja */
      border-bottom: 4px solid transparent;
      transition: border-bottom-color .25s;
    }
    .bt:hover{
      border-bottom-color: rgba(0,0,127,0.24);
    }
    .active {

      border-bottom-color: #00007f;
    }
  </style>
</head>
<body class="bg-[#FFFFFF] font-sans">

  <!-- Navbar: tambahkan py-4 agar tinggi konsisten -->
  <nav class="bg-white border-b-2 flex items-center justify-between px-6 py-[1px]">
    <div class="flex items-center space-x-5 ">
      <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 69 69" fill="none">
        <path d="M33.6931 28.3165C37.9674 31.9086 44.3404 31.3503 47.9268 27.0692L63.9972 7.88599C51.9238 26.7444 53.5913 51.8737 69 69L36.7195 41.8692C32.4455 38.2771 26.0731 38.8352 22.4865 43.1158L6.02469 62.7651C18.6488 43.3806 16.6404 17.2319 0 0L33.6931 28.3165Z" fill="url(#paint0_linear_1247_287)"></path>
        <defs>
          <linearGradient id="paint0_linear_1247_287" x1="0" y1="34.5" x2="69" y2="34.5" gradientUnits="userSpaceOnUse">
            <stop stop-color="#7a00ff"></stop>
            <stop offset="1" stop-color="#F2DE9B"></stop>
          </linearGradient>
        </defs>
      </svg>
      <ul class="flex text-[#00007F] font-medium">
        <li>
          <a href="<?= BASEURL ?>/beranda"
             class="px-8 py-2 cursor-pointer bt <?= ($current === 'beranda') ? 'active' : '' ?>">Beranda</a>
        </li>
        <li>
          <a href="<?= BASEURL ?>/mapel_guru"
             class="px-8 py-2 cursor-pointer bt <?= ($current === 'mapel_guru') ? 'active' : '' ?>">Mapelku</a>
        </li>
        <?php if ($userRole === "guru"): ?>
        <li>
          <a href="<?= BASEURL ?>/dashboard"
             class="px-8 py-2 cursor-pointer bt <?= ($current === 'dashboard') ? 'active' : '' ?>">Dashboard</a>
        </li>
        <?php endif; ?>
      </ul>
    </div>
    <div class="flex items-center">
        <a href="<?= BASEURL ?>/profil">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#7f7fff" class="bi bi-person-circle" viewBox="0 0 16 16">
  <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0"/>
  <path fill-rule="evenodd" d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8m8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1"/>
</svg>
        </a>
    </div>
  </nav>

</body>
<script>
  document.querySelectorAll('.bt').forEach(item => {
    item.addEventListener('click', () => {
      document.querySelectorAll('.bt').forEach(el => el.classList.remove('active'));
      item.classList.add('active');
    });
  });
</script>
</html>