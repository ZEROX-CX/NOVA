
<!DOCTYPE html>
<html lang="id">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Mapelku Guru</title>
    <script src="https://cdn.tailwindcss.com"></script>
  </head>

  <body class="bg-white min-h-screen font-sans text-gray-800">
    <!-- Konten Utama -->
    <main class="max-w-7xl mx-auto px-4 py-10">
      <section class="flex-1">
        <a class="text-lg text-gray-600 ml-[10em]" href="<?= BASEURL ?>/dashboard/pertemuan_content/<?= $data['id_mapel'] ?>/<?= $data['id_pertemuan'] ?>">< kembali</a>
        <h2 class="text-2xl font-bold text-black ml-[7.5em] mb-6">Kehadiran Siswa - Pertemuan 1</h2>
            
        <!-- Tanggal Sesi Absen -->
        <div class="max-w-4xl mx-auto bg-white border border-purple-300 rounded-lg shadow-md p-4 mb-4">
          <div class="flex items-center justify-between">
            <div class="flex items-center gap-2">
              <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-black" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
              </svg>
              <span class="font-medium text-black">Tanggal Sesi Absen:</span>
              <span id="tanggalSesi" class="text-gray-700">2023-11-15</span>
            </div>
            <button id="editTanggalBtn" class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1 rounded-md text-sm flex items-center gap-1">
              <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
              </svg>
              Edit Tanggal
            </button>
          </div>
        </div>
        
        <!-- Form Edit Tanggal (Hidden by default) -->
        <div id="formEditTanggal" class="max-w-4xl mx-auto bg-white border border-purple-300 rounded-lg shadow-md p-4 mb-4 hidden">
          <div class="flex items-center gap-2">
            <label for="tanggalInput" class="font-medium text-black">Ubah Tanggal:</label>
            <input type="date" id="tanggalInput" class="border border-gray-300 rounded-md px-3 py-1 focus:outline-none focus:ring-2 focus:ring-purple-600">
            <button id="simpanTanggalBtn" class="bg-blue-600 hover:bg-green-700 text-white px-3 py-1 rounded-md text-sm">Simpan</button>
            <button id="batalTanggalBtn" class="bg-gray-400 hover:bg-gray-500 text-white px-3 py-1 rounded-md text-sm">Batal</button>
          </div>
        </div>
            
        <!-- Tabel Kehadiran -->
        <div class="max-w-4xl mx-auto bg-white border border-purple-300 rounded-lg shadow-md p-6">
          <table class="w-full table-auto border-collapse">
            <thead>
              <tr class="bg-blue-100 text-black">
                <th class="border px-4 py-2 text-left">Nama Siswa</th>
                <th class="border px-4 py-2 text-center">Status Kehadiran</th>
                <th class="border px-4 py-2 text-center">Keterangan</th>
              </tr>
            </thead>
            <tbody>
            <?php if (!empty($siswa)): ?>
            <?php foreach ($siswa as $row): ?>
            <tr class="hover:bg-gray-100">
              <td class="py-3 px-4"><?= htmlspecialchars($row["nama_siswa"] ?? '') ?></td>
              <td class="py-3 px-4"><?= htmlspecialchars($row["status"] ?? '') ?></td>
              <td class="py-3 px-4"><?= htmlspecialchars($row["keterangan"] ?? '') ?></td>
            </tr>
            <?php endforeach; ?>
          <?php else: ?>
            <tr>
              <td class="py-3 px-4 text-center" colspan="3">Tidak ada data siswa yang absen saat ini</td>
            </tr>
          <?php endif; ?>
            </tbody>
          </table>
        </div>
        
      </section>
    </main>

    <!-- SCRIPT -->
    <script>
      const editTanggalBtn = document.getElementById("editTanggalBtn");
      const formEditTanggal = document.getElementById("formEditTanggal");
      const simpanTanggalBtn = document.getElementById("simpanTanggalBtn");
      const batalTanggalBtn = document.getElementById("batalTanggalBtn");
      const tanggalInput = document.getElementById("tanggalInput");
      const tanggalSesi = document.getElementById("tanggalSesi");

      // Gunakan ID pertemuan dari data PHP
      const idPertemuan = <?= $id_pertemuan ?? 1 ?>; 

      // Menampilkan form edit tanggal
      editTanggalBtn.addEventListener("click", () => {
        formEditTanggal.classList.remove("hidden");
        tanggalInput.value = tanggalSesi.textContent;
      });

      // Menyembunyikan form edit tanggal
      batalTanggalBtn.addEventListener("click", () => {
        formEditTanggal.classList.add("hidden");
      });

      // Menyimpan perubahan tanggal
      simpanTanggalBtn.addEventListener("click", () => {
        const newTanggal = tanggalInput.value;
        
        if (!newTanggal) {
          alert("Tanggal tidak boleh kosong");
          return;
        }

        // Kirim data ke server menggunakan fetch API
        fetch(`<?= BASEURL ?>/absen/editTanggal/${idPertemuan}`, {
          method: 'POST',
          headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
          },
          body: `tanggal=${newTanggal}`
        })
        .then(response => response.json())
        .then(data => {
          // TAMPILKAN DEBUG INFO DI CONSOLE BROWSER
          if (data.debug) {
            console.log("--- DEBUG INFO ---");
            console.log(data.debug);
            console.log("-------------------");
          }

          if (data.success) {
            // Update tampilan tanggal
            tanggalSesi.textContent = newTanggal;
            formEditTanggal.classList.add("hidden");
            showNotification("Tanggal berhasil diperbarui", "success");
          } else {
            // Tampilkan notifikasi error dengan pesan dari server
            showNotification(data.message || "Gagal memperbarui tanggal", "error");
          }
        })
        .catch(error => {
          console.error('Error:', error);
          showNotification("Terjadi kesalahan saat memperbarui tanggal", "error");
        });
      });

      // Fungsi untuk menampilkan notifikasi
      function showNotification(message, type) {
        const notification = document.createElement("div");
        notification.className = `fixed top-4 right-4 px-4 py-3 rounded-md text-white z-50 ${
          type === "success" ? "bg-green-500" : "bg-red-500"
        }`;
        notification.textContent = message;
        
        document.body.appendChild(notification);
        
        setTimeout(() => {
          notification.remove();
        }, 3000);
      }
    </script>
  </body>
</html>