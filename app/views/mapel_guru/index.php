<?php
$error_message = "";
$materi_message = "";
$mapel = $data['mapel'];
$mapel_guru = $data['mapel_guru'];
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Mapelku Guru</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-white min-h-screen font-sans text-gray-800">
  <main class="max-w-7xl mx-auto px-4 py-10 flex flex-col md:flex-row gap-6">
    <!-- Bagian Mapel -->
    <section class="flex-1">
      <h2 class="text-2xl font-bold text-gray-800 mb-6">Mata Pelajaran</h2>

      <!-- Search & Sort -->
      <form action="<?= BASEURL ?>/mapel_guru" method="POST" class="flex flex-col md:flex-row items-center gap-2 mb-6">
        <div class="flex items-center border border-gray-300 rounded-lg px-3 py-1 bg-white w-full md:w-1/3">
          <input id="searchInput" type="text" name="search" class="flex-1 outline-none text-gray-700" placeholder="Cari judul mapel ..." />
          <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 1110.5 3a7.5 7.5 0 016.15 13.65z" />
          </svg>
          <button type="submit" name="cari" class="text-gray-600 ml-2">Cari</button>
        </div>
      </form>

      <!-- Grid Mapel -->
      <div id="mapelContainer" 
     class="grid gap-4 justify-start"
     style="grid-template-columns: repeat(auto-fill, minmax(260px, 1fr));">

        <?php
          // Tentukan data yang akan digunakan langsung di sini
          // dan ingat tipe sumber agar link dapat dibuat kondisional
          $data_source = [];
          $sourceType = 'mapel_guru'; // default
          if (isset($_SESSION['role']) && $_SESSION['role'] == 'siswa') {
            $data = $mapel ?? [];
            $sourceType = 'mapel';
          } else {
            $data = $mapel_guru ?? [];
            $sourceType = 'mapel_guru';
          }
        ?>
        <?php if (!empty($data)): ?>
          <?php foreach ($data as $row): ?>
            <div class="border border-gray-300 rounded-xl gap-x-10 p-4 bg-white flex flex-col shadow-sm hover:shadow-md transition w-[260px]">
              <div class="flex items-start justify-between mb-3">
                <div class="flex items-start gap-3">
                  <div class="bg-purple-400 w-10 h-10 rounded-lg flex items-center justify-center text-white font-bold text-lg flex-shrink-0">📘</div>
                  <div>
                    <h1 class="font-semibold text-gray-800"><?= htmlspecialchars($row["nama_mapel"] ?? '') ?></h1> 
                  </div>
                </div>
              </div>
              <?php
                // Buat link berbeda berdasarkan sumber data
                if ($sourceType === 'mapel') {
                    // Untuk siswa: buka halaman pertemuan mapel
                    $href = BASEURL . '/pertemuan/' . ($row['id_mapel'] ?? '');
                } else {
                    // Untuk guru/daftar mapel_guru: arahkan ke dashboard
                    $href = BASEURL . '/dashboard/mapel/' . ($row['id_mapel']);
                }
              ?>
              <a href="<?= $href ?>" 
                 class="lihat-materi-link btn btn-primary mt-auto text-center bg-blue-500 text-white py-1 px-3 rounded-lg hover:bg-blue-600 transition"
                 data-id="<?= htmlspecialchars($row['id_mapel'] ?? '') ?>">
                 Lihat Materi
              </a>
            </div>
          <?php endforeach; ?>
        <?php else: ?>
          <p class="text-gray-500 col-span-full">Belum ada materi.</p>
        <?php endif; ?>
      </div>
    </section>
  </main>

  <script>
    const editModal = document.getElementById("editModal");
    const cancelEdit = document.getElementById("cancelEdit");
    const editId = document.getElementById("edit-id");
    const editMapel = document.getElementById("edit-mapel-select");
    const editJudul = document.getElementById("edit-judul");

    document.querySelectorAll(".editBtn").forEach(btn => {
      btn.addEventListener("click", () => {
        editId.value = btn.dataset.id;
        editMapel.value = btn.dataset.mapel;
        editJudul.value = btn.dataset.judul;
        editModal.classList.remove("hidden");
      });
    });

    saveEdit.addEventListener("click", () => {
    const id = document.getElementById("edit-id").value;
    document.getElementById("editModal").action = "<?= BASEURL ?>/mapel_guru/edit/" + id;
    document.getElementById("editModal").submit();
});

    cancelEdit.addEventListener("click", () => editModal.classList.add("hidden"));

    const deleteModal = document.getElementById("deleteModal");
    const cancelDelete = document.getElementById("cancelDelete");
    const deleteId = document.getElementById("delete-id");
    const deleteJudul = document.getElementById("delete-judul");
    const id = document.getElementById("delete-id").value;

    document.querySelectorAll(".deleteBtn").forEach(btn => {
    btn.addEventListener("click", () => {
      const id = btn.dataset.id; // ambil id dari tombol yg diklik
      deleteId.value = id;
      deleteJudul.textContent = btn.dataset.judul;

      deleteModal.action = "<?= BASEURL ?>/mapel_guru/deleteMateri/" + id;
      deleteModal.classList.remove("hidden");
    });
  });


    cancelDelete.addEventListener("click", () => deleteModal.classList.add("hidden"));

    const addCard = document.getElementById("addCard");
    const addModal = document.getElementById("addModal");
    const closeAddModal = document.getElementById("closeAddModal");
    addCard?.addEventListener("click", () => addModal.classList.remove("hidden"));
    closeAddModal?.addEventListener("click", () => addModal.classList.add("hidden"));
  </script>
</body>
</html>
