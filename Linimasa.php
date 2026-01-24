<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Lini Masa</title>

  <script src="https://cdn.tailwindcss.com"></script>

  <script>
    tailwind.config = {
      theme: {
        extend: {
          colors: {
            primary: '#7a00ff',
          },
          borderRadius: {
            xl: '14px',
          }
        }
      }
    }
  </script>
</head>

<body class="bg-white p-4 font-sans">

<div class="absolute top-1/2 hidden md:block">
  <a href="#"
     id="liniMasa"
     class="transition-all duration-150 hover:w-[155px]
            text-white rounded-r-lg bg-purple-600
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
            text-white rounded-r-lg bg-purple-600
            w-[55px] h-[40px]
            flex items-center justify-center">
    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="white" id="kalenderIkon" class="bi bi-calendar-range-fill" viewBox="0 0 16 16">
          <path d="M4 .5a.5.5 0 0 0-1 0V1H2a2 2 0 0 0-2 2v1h16V3a2 2 0 0 0-2-2h-1V.5a.5.5 0 0 0-1 0V1H4zM16 7V5H0v5h5a1 1 0 1 1 0 2H0v2a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V9h-6a1 1 0 1 1 0-2z"/>
        </svg>
  </a>
</div>
  <div class="max-w-[900px] mx-auto">

    <div class="bg-primary text-white text-center py-3 rounded-xl font-semibold text-base mb-4">
      Lini Masa
    </div>

      <form action="<?= BASEURL ?>/linimasa" method="POST" class="flex flex-col md:flex-row items-center gap-2 mb-6">
        <div class="flex items-center border border-primary rounded-lg px-3 py-1 bg-white w-[900px]">
          <input id="searchInput" type="text" name="search" class="flex-1 outline-none text-gray-700" placeholder="Cari aktivitas ..." />
          <button type="submit" name="cari" class="flex text-gray-600 ml-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400 mt-[3px] mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 1110.5 3a7.5 7.5 0 016.15 13.65z" />
            </svg>
            Cari
          </button>
        </div>
      </form>

    <div class="grid grid-cols-1 gap-4">

      <div class="border-2 border-primary rounded-xl overflow-hidden flex flex-col">
        <div class="bg-primary text-white text-center py-2 font-semibold text-sm">
          Tugas
        </div>

      <?php if(!empty($cek)): ?>
        <?php foreach ($cek as $t): ?>
          <div class="p-3">
            
            <div class="flex gap-3 border-2 border-primary rounded-[15px] p-3 hover:bg-purple-50 transition">
              
              <span class="w-3 h-3 bg-primary rounded-full mt-1 flex-shrink-0"></span>
              
              <!-- Teks -->
              <div>
                <div class="">
                   <a href="" class="font-semibold"><?= $t['judul_tugas'] ?></a>
                   <p class="text-sm"> Deadline Tugas: <?= $t['deadline'] ?></p>
                </div>
              </div>
          
            </div>
          
          </div>
        <?php endforeach; ?>
      <?php else: ?>
        <p class="font-semibold text-sm text-center mt-2">Tidak ada aktivitas tugas</p>
      <?php endif; ?>
      </div>



    </div>
  </div>

  <script>
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
