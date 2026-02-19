<?php
$error_message = "";
$materi_message = "";
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Mapelku Guru</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://cdn.tiny.cloud/1/2yy1wa14ecmlmis1l9is7xx2hdbpermod4de9q4pyq21b72y/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
  <script>
    tinymce.init({
      selector: '#mytextarea',
      height: 200,
      elementpath: false,
      forced_root_block: ''
    });
  </script>
</head>

<body class="bg-white min-h-screen font-sans text-gray-800">
  <main class="max-w-7xl mx-auto px-4 py-10 flex flex-col md:flex-row gap-6">
    <!-- Bagian Mapel -->
    <section class="flex-1">
      <h2 class="text-2xl font-bold text-gray-800 mb-6">Mata Pelajaran - Kelas VII</h2>

      <!-- Search & Sort -->
      <form action="<?= BASEURL ?>/mapelku" method="POST" class="flex flex-col md:flex-row items-center gap-2 mb-6">
        <div class="flex items-center border border-gray-300 rounded-lg px-3 py-1 bg-white w-full md:w-1/3">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 1110.5 3a7.5 7.5 0 016.15 13.65z" />
          </svg>
          <input id="searchInput" type="text" name="search" class="flex-1 outline-none text-gray-700" placeholder="Cari judul materi..." />
          <button type="submit" name="cari" class="text-gray-600 ml-2">Cari</button>
        </div>
      </form>

      <!-- Grid Mapel -->
      <div id="mapelContainer" class="grid sm:grid-cols-2 lg:grid-cols-3 gap-4">
        <?php if (!empty($data['materi'])): ?>
          <?php foreach ($data['materi'] as $row): ?>
            <?php
              $id_materi = $row["id_materi"];
              $materi_message = isset($_SESSION["viewed"][$id_materi]) ? "sudah dilihat" : "belum dilihat"; 
            ?>
            <div class="border border-gray-300 rounded-xl p-4 bg-white flex flex-col shadow-sm hover:shadow-md transition">
              <div class="flex items-start justify-between mb-3">
                <div class="flex items-start gap-3">
                  <div class="bg-purple-400 w-10 h-10 rounded-lg flex items-center justify-center text-white font-bold text-lg flex-shrink-0">📘</div>
                  <div>
                    <!-- <h1 class="font-semibold text-gray-800"><?= htmlspecialchars($row["judul"] ?? '') ?></h1>  -->
                    <p class="text-sm text-gray-600 capitalize">Mapel: <?= htmlspecialchars($row["mapel"] ?? '') ?></p>
                    <p class="text-xs text-gray-500 italic"><?= $materi_message ?></p>
                    <p>Guru: <span class="text-[#0000FF]">kasim</span></p>
                  </div>
                </div>

                <?php if ($_SESSION['role'] === "guru"): ?>
                  <div class="flex gap-2 flex-shrink-0">
                    <button class="text-sm text-blue-600 hover:underline editBtn"
                      data-id="<?= $row['id_materi'] ?>"
                      data-mapel="<?= htmlspecialchars($row['mapel'] ?? '') ?>"
                      data-judul="<?= htmlspecialchars($row['judul'] ?? '') ?>">
                      Edit
                    </button>
                    <button class="text-sm text-red-600 hover:underline deleteBtn"
                      data-id="<?= $row['id_materi'] ?>"
                      data-judul="<?= htmlspecialchars($row['judul']) ?>">
                      Hapus
                    </button>
                  </div>
                <?php endif; ?>
              </div>

              <a href="<?= BASEURL ?>/mapel/<?= $id_materi ?>" 
                 class="lihat-materi-link btn btn-primary mt-auto text-center bg-blue-500 text-white py-1 px-3 rounded-lg hover:bg-blue-600 transition"
                 data-id="<?= $id_materi ?>">
                 Lihat Mapel
              </a>
            </div>
          <?php endforeach; ?>
        <?php else: ?>
          <p class="text-gray-500 col-span-full">Belum ada materi.</p>
        <?php endif; ?>

        <?php if ($_SESSION['role'] === "guru"): ?>
          <div id="addCard" class="flex items-center justify-center border border-dashed border-gray-300 rounded-xl text-gray-400 text-4xl bg-white cursor-pointer hover:bg-gray-50 transition">
            +
          </div>
        <?php endif; ?>
      </div>
    </section>

    <!-- Sidebar Notifikasi -->
    <aside class="w-72 border-l px-4 py-6 bg-white hidden md:block">
      <h3 class="font-semibold mb-3">Notifikasi</h3>
      <p class="text-gray-500 text-sm">Tidak ada notifikasi baru.</p>
    </aside>
  </main>

  <!-- Modal Edit -->
  <form method="POST" id="editModal" class="hidden fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50">
    <div class="bg-white rounded-xl p-6 w-96 shadow-lg">
      <h3 class="text-lg font-semibold mb-4">Edit Materi</h3>
      <input type="hidden" name="id_materi" id="edit-id">
      <select id="edit-mapel-select" class="w-full border border-gray-300 rounded-lg px-3 py-2 mb-3" name="mapel" required>
        <option value="" selected disabled>Pilih Mapel</option>
        <option value="Matematika">Matematika</option>
        <option value="Ipa">IPA</option>
        <option value="Agama">Agama</option>
        <option value="Bahasa Indonesia">Bahasa Indonesia</option>
      </select>
      <label class="block text-sm mb-1">Edit Judul</label>
      <textarea name="judul_materi" id="edit-judul" class="w-full border border-gray-300 rounded-lg px-3 py-2 mb-4" required></textarea>
      <div class="flex justify-end gap-2">
        <button type="button" id="cancelEdit" class="px-3 py-1 rounded-lg bg-gray-200 text-gray-700">Batal</button>
        <button type="button" id="saveEdit" class="px-3 py-1 rounded-lg bg-blue-600 text-white">Simpan</button>
      </div>
    </div>
  </form>

  <!-- Modal Hapus -->
  <form method="POST" id="deleteModal" action="" class="hidden fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50">
    <div class="bg-white rounded-xl p-6 w-96 shadow-lg">
      <h3 class="text-lg font-semibold mb-4 text-red-600">Konfirmasi Hapus</h3>
      <input type="hidden" name="id_materi" id="delete-id">
      <p class="mb-6">Apakah Anda yakin ingin menghapus materi "<span id="delete-judul" class="font-bold"></span>"?</p>
      <div class="flex justify-end gap-2">
        <button type="button" id="cancelDelete" class="px-4 py-2 rounded-lg bg-gray-200 text-gray-700 hover:bg-gray-300 transition">Batal</button>
        <button type="submit" class="px-4 py-2 rounded-lg bg-red-600 text-white hover:bg-red-700 transition">Hapus</button>
      </div>
    </div>
  </form>

  <!-- Modal Tambah -->
  <form method="POST" action="<?= BASEURL ?>/mapel_guru/tambah" id="addModal" class="hidden fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50">
    <div class="bg-white rounded-xl p-6 w-[1000px] shadow-lg relative">
      <button type="button" id="closeAddModal" class="absolute top-3 right-3 text-gray-500 hover:text-gray-700 text-xl font-bold">&times;</button>
      <h3 class="text-lg font-semibold mb-4">Tambah Materi Baru</h3>
      <select class="w-full border border-gray-300 rounded-lg px-3 py-2 mb-3" name="mapel" required>
        <option value="" selected disabled>Pilih Mapel</option>
        <option value="Matematika">Matematika</option>
        <option value="Ipa">IPA</option>
        <option value="Agama">Agama</option>
        <option value="Bahasa Indonesia">Bahasa Indonesia</option>
      </select>
      <label class="block text-sm mb-1">Judul Materi</label>
      <textarea id="mytextarea" name="judul_materi" class="w-full border border-gray-300 rounded-lg"></textarea>
      <div class="flex justify-end mt-4">
        <button type="submit" class="px-4 py-2 rounded-lg bg-green-600 text-white hover:bg-green-700 transition">Tambah</button>
      </div>
    </div>
  </form>

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
      deleteModal.action = "<?= BASEURL ?>/mapelku/deleteMateri/" + id;
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