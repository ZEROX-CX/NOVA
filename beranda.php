<!DOCTYPE html>
<html lang="id">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Mapelku Guru</title>
    <script src="https://cdn.tailwindcss.com"></script>
  </head>

  <body class="bg-white min-h-screen font-sans text-gray-800">
    <?php
      if (session_status() === PHP_SESSION_NONE) {
        session_start();
      }
      $displayName = '';
      if (!empty($_SESSION['namaSiswa'])) {
        $displayName = $_SESSION['namaSiswa'];
      } elseif (!empty($_SESSION['namaGuru'])) {
        $displayName = $_SESSION['namaGuru'];
      } else {
        // fallback: try common session structures or show generic label
        $displayName = $_SESSION['user']['nama'] ?? ($_SESSION['nama'] ?? 'Pengguna');
      }
    ?>

    <div class="absolute top-1/2">
      <a href="<?= BASEURL ?>/liniMasa" id="liniMasa" class="transition-all duration-150 ease-in-out hover:w-[155px] text-white rounded-r-lg bg-purple-600 w-[55px] h-[40px] flex items-center justify-center -mb-[120px]">
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
      <!-- Tombol Kalender -->
      <a href="" id="kalender" class="transition-all duration-150 ease-in-out hover:w-[155px] text-white rounded-r-lg bg-purple-600 w-[55px] h-[40px] flex items-center justify-center">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="white" id="kalenderIkon" class="bi bi-calendar-range-fill" viewBox="0 0 16 16">
          <path d="M4 .5a.5.5 0 0 0-1 0V1H2a2 2 0 0 0-2 2v1h16V3a2 2 0 0 0-2-2h-1V.5a.5.5 0 0 0-1 0V1H4zM16 7V5H0v5h5a1 1 0 1 1 0 2H0v2a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V9h-6a1 1 0 1 1 0-2z"/>
        </svg>
      </a>
    </div>
    <!-- Konten Utama -->
    <main class="max-w-7xl mx-auto px-4 py-10 flex flex-col md:flex-row gap-6">
      <!-- Bagian Mapel -->
      <section class="flex-1">
       <div class="flex">
         <main class="flex-1 px-12 py-8">
           <h1 class="text-xl font-semibold mb-6 ml-[20em]">Selamat Datang, <?= htmlspecialchars($displayName) ?></h1>
     
           <section> 
              <div class="max-w-xl mx-auto bg-white p-4 rounded shadow">
                <div class="flex justify-between items-center mb-4">
                  <button id="prev" class="px-2 py-1 bg-purple-600 text-white rounded">Prev</button>
                  <h2 id="monthYear" class="text-lg font-bold"></h2>
                  <button id="next" class="px-2 py-1 bg-purple-600 text-white rounded">Next</button>
                </div>
                <div class="grid grid-cols-7 gap-2 text-center font-bold">
                  <div>Sun</div><div>Mon</div><div>Tue</div><div>Wed</div><div>Thu</div><div>Fri</div><div>Sat</div>
                </div>
                <div id="calendar" class="grid grid-cols-7 gap-2 mt-2"></div>
              </div>
            </section>
          </main>
        </div>
        
      </section>
    </main>
    
<!-- SCRIPT -->
<script>
  document.addEventListener('DOMContentLoaded', function() {
    
    // ==========================================
    // 1. ISI DATA DARI PHP KE JAVASCRIPT
    // ==========================================
// ==========================================
// 1. ISI DATA DARI PHP KE JAVASCRIPT
// ==========================================
const activities = [
  <?php 
  if (!empty($data['absen']) && is_array($data['absen'])) {
      foreach ($data['absen'] as $absen) {
          $judul = !empty($absen['judul_absen']) ? htmlspecialchars($absen['judul_absen']) : 'Sesi Absen';
          $id_mapel = isset($absen['id_mapel']) ? $absen['id_mapel'] : null;
          $id_pertemuan = $absen['id_pertemuan'];
          $namaAktivitas = $judul;
          
          echo "{ date: '" . $absen['tanggal'] . "', name: '" . $namaAktivitas . "', id_mapel: '" . $id_mapel . "', id_pertemuan: '" . $id_pertemuan . "' },";
      }
  }
  ?>
];

// ...existing code...

    // ==========================================
    // 2. FUNGSI UNTUK KALENDER
    // ==========================================
    const calendar = document.getElementById("calendar");
    const monthYear = document.getElementById("monthYear");
    let currentDate = new Date();

    function renderCalendar(date) {
      calendar.innerHTML = "";
      const year = date.getFullYear();
      const month = date.getMonth();
      const firstDay = new Date(year, month, 1).getDay();
      const daysInMonth = new Date(year, month + 1, 0).getDate();
    
      monthYear.textContent = date.toLocaleString("id-ID", { month: "long", year: "numeric" });
    
      // Tambahkan sel kosong sebelum hari pertama bulan
      for (let i = 0; i < firstDay; i++) {
        calendar.innerHTML += `<div></div>`;
      }
    
      // Loop untuk setiap hari dalam bulan
      for (let day = 1; day <= daysInMonth; day++) {
        const dateStr = `${year}-${String(month + 1).padStart(2, '0')}-${String(day).padStart(2, '0')}`;
        const isToday = day === new Date().getDate() && month === new Date().getMonth() && year === new Date().getFullYear();
        
        // Cari aktivitas untuk hari ini
        const dayActivity = activities.find(activity => activity.date === dateStr);
        
        // Siapkan kelas dan konten untuk sel
        let cellClasses = 'border rounded p-2 w-[70px] h-20 text-xs flex flex-col justify-start items-center transition-all';
        let cellContent = '';

        if (isToday) {
          cellClasses += ' bg-blue-500 text-white font-bold';
        }
        
        if (dayActivity) {
          if (!isToday) {
            cellClasses += ' bg-green-100 hover:bg-green-200';
          }
          cellContent = `
            <div class="font-semibold">${day}</div>
            <div class="text-center text-gray-700 leading-tight mt-1">
              <a href="<?= BASEURL ?>/pertemuan_content/${dayActivity.id_mapel}/${dayActivity.id_pertemuan}" class=""overflow-hidden text-ellipsis block w-full" id="absenModal" title="${dayActivity.name}">${dayActivity.name}</a>
            </div>
          `;
        } else {
          cellContent = `<div class="${isToday ? '' : 'text-gray-700'}">${day}</div>`;
        }
      
        calendar.innerHTML += `<div class="${cellClasses}">${cellContent}</div>`;
      }
    }

    // Pastikan elemen ada sebelum menambahkan event listener
    const prevButton = document.getElementById("prev");
    const nextButton = document.getElementById("next");

    if (prevButton) {
        prevButton.addEventListener("click", () => {
            currentDate.setMonth(currentDate.getMonth() - 1);
            renderCalendar(currentDate);
        });
    }

    if (nextButton) {
        nextButton.addEventListener("click", () => {
            currentDate.setMonth(currentDate.getMonth() + 1);
            renderCalendar(currentDate);
        });
    }
    
    // Render kalender pertama kali
    renderCalendar(currentDate);

  });
</script>

<!-- Animasi tombol -->
    <script>
      const kalender = document.getElementById("kalender")
      const kalenderIkon = document.getElementById("kalenderIkon")
      const liniMasa = document.getElementById("liniMasa")
      const liniMasaIkon = document.getElementById("LiniMasaIkon")

      kalender.addEventListener("mouseenter", extendKalender);
      kalender.addEventListener("mouseleave", reduceKalender);
      liniMasa.addEventListener("mouseenter", extendLiniMasa);
      liniMasa.addEventListener("mouseleave", reduceLiniMasa);
      function extendKalender() {
        const textSpan = document.createElement('span');
        textSpan.textContent = ' Kalender';
        kalender.appendChild(textSpan);
        kalenderIkon.classList.add("mr-2")
      }

      function reduceKalender() {
        const textSpan = kalender.querySelector('span');
        if (textSpan) {
          kalender.removeChild(textSpan);
        }
        kalenderIkon.classList.remove("mr-2");
      }

      function extendLiniMasa() {
        const textSpan = document.createElement('span');
        textSpan.textContent = ' Lini Masa';
        liniMasa.appendChild(textSpan);
        liniMasaIkon.classList.add("mr-2");
      }

      function reduceLiniMasa() {
        const textSpan = liniMasa.querySelector('span');
        if (textSpan) {
          liniMasa.removeChild(textSpan);
        }
        liniMasaIkon.classList.remove("mr-2");
      }
    </script>
  </body>
</html>
