<?php
$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$segments = explode('/', trim($path, '/'));
$last = end($segments);

// jika URL berakhir dengan "index", anggap folder sebelumnya sebagai route aktif
if ($last === 'index' && count($segments) > 1) {
    $current = $segments[count($segments) - 2];
} elseif ($last === '' || $last === null) {
    // default jika root/public diakses langsung
    $current = 'beranda';
} else {
    $current = $last;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Beranda Siswa</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-[#FFFFEE] font-sans">

  <!-- Navbar -->
  <nav class="bg-white shadow-md flex items-center justify-between px-6 py-4">
    <div class="flex items-center space-x-5 ">
      <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox=" 0 0 69 69" fill="none">
        <path d="M33.6931 28.3165C37.9674 31.9086 44.3404 31.3503 47.9268 27.0692L63.9972 7.88599C51.9238 26.7444 53.5913 51.8737 69 69L36.7195 41.8692C32.4455 38.2771 26.0731 38.8352 22.4865 43.1158L6.02469 62.7651C18.6488 43.3806 16.6404 17.2319 0 0L33.6931 28.3165Z" fill="url(#paint0_linear_1247_287)"></path>
        <defs>
          <linearGradient id="paint0_linear_1247_287" x1="0" y1="34.5" x2="69" y2="34.5" gradientUnits="userSpaceOnUse">
            <stop stop-color="#7f7fff"></stop>
            <stop offset="1" stop-color="#F2DE9B"></stop>
          </linearGradient>
        </defs>
      </svg> 
      <ul class="flex space-x-6 text-[#00007F] font-medium">
        <li class="<?= ($current === 'beranda') ? 'border-b-2 border-[#00007F]' : '' ?> cursor-pointer"><a href="<?= BASEURL?>/beranda">Beranda</a></li>
        <li class="<?= ($current === 'mapel_guru') ? 'border-b-2 border-[#00007F]' : '' ?> hover:text-[#3F3D56] cursor-pointer"><a href="<?= BASEURL ?>/mapel_guru">Mapel ku</a></li>
        <div id="activeLine"></div>
      </ul>
    </div>
    <div class="flex items-center">
        <a href="<?= BASEURL?>/profil">
            <img src="../Generic avatar.png" alt="profile" class="rounded-full
             w-6 h-6">
        </a>
    </div>
  </nav>
</body>
</html>



<!DOCTYPE html>
<html lang="id">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Navbar Mapelku Guru</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
      /* Garis aktif animasi kanan-kiri */
      #activeLine {
        position: absolute;
        bottom: -16px; /* jarak dari teks */
        height: 3px;
        background-color: #2563eb;
        transition: left 0.4s ease, width 0.4s ease;
      }

      /* Animasi slide lembut pada menu hamburger */
      #menuPanel {
        transition: transform 0.4s ease, opacity 0.4s ease;
        opacity: 0;
      }

      #menuPanel.active {
        transform: translateX(0);
        opacity: 1;
      }
    </style>
  </head>

  <body class="bg-white font-sans text-gray-800">
    <!-- Navbar -->
    <header class="flex justify-between items-center bg-white px-6 py-3 shadow-md relative">
      <!-- Tombol Hamburger -->
      <button id="menuBtn" class="md:hidden text-gray-700">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
        </svg>
      </button>

      <!-- Menu Desktop -->
      <div class="hidden md:flex items-center gap-6">
        <img src="logo.png" alt="Logo" class="w-10 h-10 object-contain" />
        <nav class="relative pb-2"> <!-- Tambah sedikit padding bawah agar garis tidak terpotong -->
          <ul class="flex gap-6 text-gray-700 font-medium relative">
            <li><a href="#" class="nav-link text-blue-600">Beranda</a></li>
            <li><a href="#" class="nav-link">Mapel ku</a></li>
          </ul>
          <div id="activeLine"></div>
        </nav>
      </div>

      <!-- Tombol Log Out -->
      <button class="text-blue-700 font-semibold hover:underline">Log Out</button>
    </header>

    <!-- Menu Hamburger (Mobile) -->
    <div
      id="menuPanel"
      class="fixed top-0 left-0 h-full w-64 bg-white shadow-lg transform -translate-x-full transition-transform duration-300 z-50"
    >
      <div class="flex justify-between items-center p-4 border-b">
        <img src="logo.png" alt="Logo" class="w-10 h-10 object-contain" />
        <button id="closeMenu" class="text-gray-600 text-2xl">&times;</button>
      </div>
      <nav class="flex flex-col p-4 space-y-4 text-gray-700 font-medium">
        <a href="#" class="hover:text-blue-600">Beranda</a>
        <a href="#" class="hover:text-blue-600">Mapel ku</a>
      </nav>
    </div>

    <!-- SCRIPT -->
    <script>
      // Hamburger menu
      const menuBtn = document.getElementById("menuBtn");
      const menuPanel = document.getElementById("menuPanel");
      const closeMenu = document.getElementById("closeMenu");

      menuBtn.addEventListener("click", () => {
        menuPanel.classList.add("active");
        menuPanel.classList.remove("-translate-x-full");
      });

      closeMenu.addEventListener("click", () => {
        menuPanel.classList.remove("active");
        menuPanel.classList.add("-translate-x-full");
      });

      // Garis aktif animasi (desktop)
      const links = document.querySelectorAll(".nav-link");
      const line = document.getElementById("activeLine");
      const nav = document.querySelector("nav");


      function moveLine(link) {
        if (!nav || !link || !line) return;
        const navRect = nav.getBoundingClientRect();
        const linkRect = link.getBoundingClientRect();
        const left = linkRect.left - navRect.left;
        const width = linkRect.width;
        line.style.left = left + "px";
        line.style.width = width + "px";
      }
      // Posisi awal
      window.addEventListener("load", () => {
        const active = document.querySelector(".nav-link.text-blue-600");
        if (active) {
          // beri sedikit delay agar layout selesai dan hitungan boundingClientRect akurat
          setTimeout(() => moveLine(active), 20);
        } else {
          // sembunyikan garis jika tidak ada active
          line.style.width = "0";
        }
      });
      // Klik menu
      links.forEach((link) => {
        link.addEventListener("click", (e) => {
          e.preventDefault();
          links.forEach((l) => l.classList.remove("text-blue-600"));
          link.classList.add("text-blue-600");
          moveLine(link);
        });
      });

      function moveLine(link) {
        const navRect = nav.getBoundingClientRect();
        const linkRect = link.getBoundingClientRect();
        const left = linkRect.left - navRect.left;
        const width = linkRect.width;
        line.style.left = left + "px";
        line.style.width = width + "px";
      }
    </script>
  </body>
</html>

<!-- <?php
// $BASE = defined('BASEURL') ? rtrim(BASEURL, '/') : '/belajar/public';

// // deteksi route saat ini
// $path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
// $segments = explode('/', trim($path, '/'));
// $last = end($segments);
// $current = ($last === '' || $last === 'public') ? 'beranda' : $last;
?>
<header class="flex justify-between items-center bg-white px-6 py-3 shadow-md relative">
  <!-- Tombol Hamburger
  <button id="menuBtn" class="md:hidden text-gray-700">
    <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
    </svg>
  </button> -->

  <!-- Menu Desktop
  <div class="hidden md:flex items-center gap-6">
    <img src="<?= $BASE ?>/img/logo.png" alt="Logo" class="w-10 h-10 object-contain" />
    <nav class="relative pb-2">
      <ul class="flex gap-6 text-gray-700 font-medium relative">
        <li><a href="<?= $BASE ?>/beranda" data-page="beranda" class="nav-link <?= ($current === 'beranda') ? 'text-blue-600' : '' ?>">Beranda</a></li>
        <li><a href="<?= $BASE ?>/mapel_guru" data-page="mapel_guru" class="nav-link <?= ($current === 'mapel_guru') ? 'text-blue-600' : '' ?>">Mapel ku</a></li>
      </ul>
      <div id="activeLine"></div>
    </nav>
  </div> -->

  <!-- Tombol Logout
  <button class="text-blue-700 font-semibold hover:underline">Log Out</button>
</header> -->

<!-- Menu Hamburger -->
<!-- <div id="menuPanel" class="fixed top-0 left-0 h-full w-64 bg-white shadow-lg transform -translate-x-full transition-transform duration-300 z-50">
  <div class="flex justify-between items-center p-4 border-b">
    <img src="<?= $BASE ?>/img/logo.png" alt="Logo" class="w-10 h-10 object-contain" />
    <button id="closeMenu" class="text-gray-600 text-2xl">&times;</button>
  </div>
  <nav class="flex flex-col p-4 space-y-4 text-gray-700 font-medium">
    <a href="<?= $BASE ?>/beranda" data-page="beranda" class="nav-link">Beranda</a>
    <a href="<?= $BASE ?>/mapel_guru" data-page="mapel_guru" class="nav-link">Mapel ku</a>
  </nav>
</div> -->

<style>
  /* #activeLine {
    position: absolute;
    bottom: -14px;
    height: 3px;
    background-color: #2563eb;
    border-radius: 2px;
    transition: left 0.35s cubic-bezier(.2,.9,.2,1), width 0.35s cubic-bezier(.2,.9,.2,1);
  }

  main {
    max-width: 900px;
    margin: 40px auto;
    padding: 20px;
    background: white;
    border-radius: 12px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    opacity: 0;
    transform: translateY(15px);
    transition: all 0.4s ease;
  }

  main.visible {
    opacity: 1;
    transform: translateY(0);
  } */
</style>

<script>
  // const menuBtn = document.getElementById("menuBtn");
  // const menuPanel = document.getElementById("menuPanel");
  // const closeMenu = document.getElementById("closeMenu");
  // const links = document.querySelectorAll(".nav-link");
  // const line = document.getElementById("activeLine");
  // const nav = document.querySelector("nav");
  // const main = document.querySelector("main");

  // // Hamburger
  // menuBtn && menuBtn.addEventListener("click", () => {
  //   menuPanel.classList.add("active");
  //   menuPanel.classList.remove("-translate-x-full");
  // });
  // closeMenu && closeMenu.addEventListener("click", () => {
  //   menuPanel.classList.remove("active");
  //   menuPanel.classList.add("-translate-x-full");
  // });

  // function moveLine(link) {
  //   if (!nav || !line || !link) return;
  //   const navRect = nav.getBoundingClientRect();
  //   const linkRect = link.getBoundingClientRect();
  //   line.style.left = (linkRect.left - navRect.left) + "px";
  //   line.style.width = linkRect.width + "px";
  // }

  // async function loadPage(page, push = true) {
  //   main.classList.remove("visible");
  //   await new Promise(r => setTimeout(r, 150));

  //   try {
  //     const res = await fetch(`<?= $BASE ?>/${page}`);
  //     const text = await res.text();
  //     // ambil isi dari <main> di view yang dikembalikan
  //     const match = text.match(/<main[^>]*>([\s\S]*?)<\/main>/i);
  //     main.innerHTML = match ? match[1] : text;
  //     setTimeout(() => main.classList.add("visible"), 50);
  //     if (push) history.pushState({ page }, "", "<?= $BASE ?>/" + page);
  //   } catch (err) {
  //     main.innerHTML = "<p class='text-red-600'>Gagal memuat halaman.</p>";
  //   }
  // }

  // // Klik link
  // links.forEach(link => {
  //   link.addEventListener("click", e => {
  //     const page = link.dataset.page;
  //     if (!page) return;
  //     e.preventDefault();
  //     links.forEach(l => l.classList.remove("text-blue-600"));
  //     link.classList.add("text-blue-600");
  //     moveLine(link);
  //     loadPage(page);
  //   });
  // });

  // window.addEventListener("popstate", e => {
  //   const page = e.state?.page || "beranda";
  //   const active = [...links].find(l => l.dataset.page === page);
  //   if (active) {
  //     links.forEach(l => l.classList.remove("text-blue-600"));
  //     active.classList.add("text-blue-600");
  //     moveLine(active);
  //   }
  //   loadPage(page, false);
  // });

  // window.addEventListener("load", () => {
  //   const current = location.pathname.split("/").pop() || "beranda";
  //   const active = [...links].find(l => l.dataset.page === current);
  //   if (active) moveLine(active);
  //   loadPage(current, false);
  // });

  // window.addEventListener("resize", () => {
  //   const active = document.querySelector(".nav-link.text-blue-600");
  //   if (active) moveLine(active);
  // });
</script> -->
