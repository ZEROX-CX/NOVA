<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Mapelku Guru</title>
  <script src="https://cdn.tailwindcss.com"></script>

  <script>
    tailwind.config = {
      theme: {
        extend: {
          colors: {
            primary: '#7a00ff',
          }
        }
      }
    }
  </script>

  <style>
    /* Responsive styles */
    @media (max-width: 768px) {
      .sidebar {
        position: fixed;
        left: -100%;
        top: 0;
        height: 100vh;
        z-index: 50;
        transition: left 0.3s ease-in-out;
        width: 250px;
      }
      
      .sidebar.active {
        left: 0;
      }
      
      .overlay {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: rgba(0, 0, 0, 0.5);
        z-index: 40;
      }
      
      .overlay.active {
        display: block;
      }
    }
  </style>
</head>

<body class="bg-white min-h-screen font-sans text-gray-800">

<?php
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}

$displayName = $_SESSION['namaSiswa']
  ?? $_SESSION['namaGuru']
  ?? ($_SESSION['user']['nama'] ?? 'Pengguna');
?>

<!-- ================= MOBILE HAMBURGER ================= -->
<button 
  onclick="toggleSidebar()" 
  class="fixed top-15 left-4 z-50 lg:hidden"
  id="hamburger"
>
☰
</button>

<!-- ================= OVERLAY UNTUK MOBILE ================= -->
<div class="overlay" id="overlay" onclick="toggleSidebar()"></div>

<!-- ================= DESKTOP SIDEBAR (ORIGINAL) ================= -->
<div class="absolute top-1/2 hidden md:block">
  <a href="<?= BASEURL ?>/liniMasa"
     id="liniMasa"
     class="transition-all duration-150 hover:w-[155px]
            text-white rounded-r-lg bg-primary
            w-[55px] h-[40px]
            flex items-center justify-center -mb-[120px]">
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 850.389 850.391" width="48" height="48" fill="white" id="LiniMasaIkon"> <path d="M146.219,329.418c-40.467,0-73.501,33.435-73.501,74.417c0,40.965,33.035,74.4,73.501,74.4
          c35.83,0,66.069-26.368,72.105-61.216h140.039c6.501,34.848,36.277,61.216,72.105,61.216
          c36.278,0,66.054-26.368,72.572-61.216h140.021c6.535,34.848,36.295,61.216,72.122,61.216
          c40.483,0,73.502-33.435,73.502-74.4c0-40.966-33.019-74.417-73.502-74.417
          c-35.827,0-65.587,26.368-72.122,61.232H503.04c-6.519-34.847-36.294-61.232-72.572-61.232
          c-35.828,0-66.07,26.368-72.105,61.232H218.323
          C212.274,355.787,182.031,329.418,146.219,329.418z
          M146.219,356.269c26.517,0,47.45,21.198,47.45,47.567
          c0,26.368-20.933,48.032-47.45,48.032 f
          c-26.052,0-46.984-21.664-46.984-48.032
          C99.234,377.466,120.167,356.269,146.219,356.269z
          M430.468,356.269c26.503,0,47.435,21.198,47.435,47.567
          c0,26.368-20.932,48.032-47.435,48.032
          c-26.052,0-46.982-21.664-46.982-48.032
          C383.486,377.466,404.399,356.269,430.468,356.269z
          M715.168,356.269c26.516,0,47.449,21.198,47.449,47.567
          c0,26.368-20.934,48.014-47.449,48.014
          c-26.053,0-46.985-21.663-46.985-48.031
          C668.183,377.449,689.115,356.269,715.168,356.269z"/>
        </svg>
  </a>

  <a href="<?= BASEURL ?>/beranda"
     id="kalender"
     class="transition-all duration-150 hover:w-[155px]
            text-white rounded-r-lg bg-primary
            w-[55px] h-[40px]
            flex items-center justify-center">
    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="white" id="kalenderIkon" class="bi bi-calendar-range-fill" viewBox="0 0 16 16">
          <path d="M4 .5a.5.5 0 0 0-1 0V1H2a2 2 0 0 0-2 2v1h16V3a2 2 0 0 0-2-2h-1V.5a.5.5 0 0 0-1 0V1H4zM16 7V5H0v5h5a1 1 0 1 1 0 2H0v2a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V9h-6a1 1 0 1 1 0-2z"/>
        </svg>
  </a>
</div>

<!-- ================= MOBILE SIDEBAR ================= -->
<aside class="sidebar md:hidden bg-white shadow-lg p-4">
  <div class="flex justify-between items-center mb-4">
    <h2 class="text-lg font-bold">Menu</h2>
    <button 
      onclick="toggleSidebar()" 
      class="p-2 hover:bg-gray-100 rounded"
    >
      <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
      </svg>
    </button>
  </div>
  
  <nav class="space-y-3">
    <a href="<?= BASEURL ?>/liniMasa" class="block px-3 py-2 font-medium hover:bg-primary hover:rounded-md hover:text-white duration-300 transition">
      Lini Masa
    </a>
    <a href="<?= BASEURL ?>/beranda" class="block px-3 py-2 rounded-md bg-primary text-white font-medium">
      Kalender
    </a>
  </nav>
</aside>

<!-- ================= MAIN CONTENT ================= -->
<div class="flex flex-1">
  <main class="flex-1 w-full max-w-7xl mx-auto px-4 py-6">
  </h1>

  <!-- ================= CALENDAR ================= -->
  <section class="max-w-xl mx-auto bg-white p-4 rounded shadow">
    <div class="flex justify-between items-center mb-4">
      <button id="prev" class="px-3 py-1 bg-purple-600 text-white rounded">Prev</button>
      <h2 id="monthYear" class="text-lg font-bold"></h2>
      <button id="next" class="px-3 py-1 bg-purple-600 text-white rounded">Next</button>
    </div>

    <div class="grid grid-cols-7 text-center font-bold text-sm mb-2">
      <div>Sun</div><div>Mon</div><div>Tue</div><div>Wed</div>
      <div>Thu</div><div>Fri</div><div>Sat</div>
    </div>

    <div id="calendar" class="grid grid-cols-7 gap-1 sm:gap-2"></div>
  </section>

  </main>
</div>

<!-- ================= CALENDAR SCRIPT ================= -->
<script>
document.addEventListener('DOMContentLoaded', () => {

  const activities = [
    <?php
    if (!empty($data['absen'])) {
      foreach ($data['absen'] as $a) {
        echo "{
          date: '{$a['tanggal']}',
          name: '".htmlspecialchars($a['judul_absen'] ?? 'Sesi Absen')."',
          id_mapel: '{$a['id_mapel']}',
          id_pertemuan: '{$a['id_pertemuan']}'
        },";
      }
    }
    ?>
  ];

  const calendar = document.getElementById("calendar");
  const monthYear = document.getElementById("monthYear");
  let currentDate = new Date();

  function renderCalendar(date) {
    calendar.innerHTML = "";
    const year = date.getFullYear();
    const month = date.getMonth();
    const firstDay = new Date(year, month, 1).getDay();
    const daysInMonth = new Date(year, month + 1, 0).getDate();

    monthYear.textContent = date.toLocaleString("id-ID", {
      month: "long",
      year: "numeric"
    });

    for (let i = 0; i < firstDay; i++) calendar.innerHTML += `<div></div>`;

    for (let day = 1; day <= daysInMonth; day++) {
      const dateStr = `${year}-${String(month + 1).padStart(2,'0')}-${String(day).padStart(2,'0')}`;
      const isToday = new Date().toDateString() === new Date(year,month,day).toDateString();
      const act = activities.find(a => a.date === dateStr);

      calendar.innerHTML += `
        <div class="border rounded p-1 h-16 sm:h-20
                    text-xs sm:text-sm flex flex-col items-center
                    ${isToday ? 'bg-blue-500 text-white font-bold' : ''}
                    ${act && !isToday ? 'bg-green-100' : ''}">
          <div>${day}</div>
          ${act ? `
            <a href="<?= BASEURL ?>/pertemuan_content/${act.id_mapel}/${act.id_pertemuan}"
               class="text-[10px] sm:text-xs text-center mt-1">
              ${act.name}
            </a>` : ''}
        </div>
      `;
    }
  }

  document.getElementById("prev").onclick = () => {
    currentDate.setMonth(currentDate.getMonth() - 1);
    renderCalendar(currentDate);
  };

  document.getElementById("next").onclick = () => {
    currentDate.setMonth(currentDate.getMonth() + 1);
    renderCalendar(currentDate);
  };

  renderCalendar(currentDate);
});
</script>

<!-- ================= SIDEBAR SCRIPTS ================= -->
<script>
  function toggleSidebar() {
    const sidebar = document.querySelector('.sidebar');
    const overlay = document.getElementById('overlay');
    sidebar.classList.toggle('active');
    overlay.classList.toggle('active');
  }
  
  // Close sidebar ketika klik menu di mobile
  document.querySelectorAll('.sidebar a').forEach(link => {
    link.addEventListener('click', function() {
      if (window.innerWidth < 768) {
        toggleSidebar();
      }
    });
  });

   function hoverText(el, text, icon) {
  el.addEventListener("mouseenter", () => {
    const span = document.createElement("span");
    span.textContent = " " + text;
    el.appendChild(span);
    icon.classList.add("mr-2");
  });

  el.addEventListener("mouseleave", () => {
    const span = el.querySelector("span");
    if (span) span.remove();
    icon.classList.remove("mr-2");
  });
}

hoverText(
  document.getElementById("kalender"),
  "Kalender",
  document.getElementById("kalenderIkon")
);

hoverText(
  document.getElementById("liniMasa"),
  "Lini Masa",
  document.getElementById("LiniMasaIkon")
);
</script>

</body>
</html>
