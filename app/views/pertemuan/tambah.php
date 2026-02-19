<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Tambah Pertemuan</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-50 min-h-screen py-10">
  <main class="max-w-3xl mx-auto bg-white p-6 rounded-lg shadow-md">
    <h1 class="text-2xl font-semibold text-purple-700 mb-6">Tambahkan Pertemuan</h1>

    <!-- FLASH MESSAGE -->
    <!-- FORM UTAMA -->
    <form method="POST" action="<?= BASEURL ?>/pertemuan/tambah" enctype="multipart/form-data">
      <input type="hidden" name="id_mapel" value="<?= htmlspecialchars($id_materi ?? '') ?>">

      <div class="mb-4">
        <label class="block font-medium mb-1">Judul Pertemuan</label>
        <input type="text" name="judul_pertemuan" class="w-full border border-gray-300 rounded-lg p-2">
      </div>

      <!-- Bagian Tambah Sesi -->
      <div class="mb-4">
        <label class="block font-medium mb-1">Tanggal Sesi Absen</label>
        <input type="date" name="tanggal_sesi" class="w-full border border-gray-300 rounded-lg p-2">
      </div>

      <!-- Bagian Pre-test -->
      <div class="mb-6">
        <label class="block font-medium mb-1">Pre Test</label>
        
        <!-- Input untuk jumlah soal -->
        <div class="mb-4">
          <label class="block text-sm font-medium mb-1">Jumlah Soal</label>
          <input type="number" id="jumlah_soal" class="py-1 px-2 rounded-md border-2 w-full" min="0" max="20" placeholder="Masukkan jumlah soal (0-20)">
          <button type="button" id="tombol_buat_soal" class="mt-2 px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-600 transition">
            Buat Form Soal
          </button>
        </div>
        
        <!-- Container untuk soal-soal -->
        <div id="container_soal" class="space-y-4 mt-4">
          <!-- Soal akan ditambahkan di sini secara dinamis -->
        </div>
      </div>

      <!-- Bagian Post-test -->
      <div class="mb-6 mt-10">
        <label class="block font-medium mb-1">Post Tes</label>

        <!-- Input untuk jumlah soal -->
        <div class="mb-4">
          <label class="block text-sm font-medium mb-1">Jumlah Soal Post-Test</label>
          <input type="number" id="jumlah_soal_post" class="py-1 px-2 rounded-md border-2 w-full" min="0" max="20" placeholder="Masukkan jumlah soal (0-20)">
          <button type="button" id="tombol_buat_post" class="mt-2 px-4 py-2 bg-blue-600 text-white rounded hover:bg-green-700 transition">
            Buat Form Soal Post-Test
          </button>
        </div>

        <!-- Container Post Test -->
        <div id="container_post" class="space-y-4 mt-4"></div>
      </div>

      <!-- Bagian Refleksi -->
        <div class="mb-6 mt-10">
        <label class="block font-medium mb-1">Refleksi</label>

        <!-- Input untuk jumlah soal -->
        <div class="mb-4">
          <label class="block text-sm font-medium mb-1">Jumlah Soal Refleksi</label>
          <input type="number" id="jumlah_soal_refleksi" class="py-1 px-2 rounded-md border-2 w-full" min="0" max="20" placeholder="Masukkan jumlah soal (0-20)">
          <button type="button" id="tombol_buat_refleksi" class="mt-2 px-4 py-2 bg-blue-600 text-white rounded hover:bg-green-700 transition">
            Buat Form Soal Refleksi
          </button>
        </div>

        <!-- Container Post Test -->
        <div id="container_ref" class="space-y-4 mt-4"></div>
      </div>

    <!-- Bagian Materi -->
    <div class="mb-6">
        <label for="materi" class="block font-medium mb-1">Materi</label>
        <textarea name="materi" id="materi" class="py-2 px-4 w-full rounded-md border-2" placeholder="Isi materi"></textarea>
        
        <!-- Tambahkan field untuk link YouTube -->
        <label class="block mt-2">Link YouTube (Opsional)</label>
        <input type="text" name="link_youtube" class="w-full border border-gray-300 rounded-md p-2" placeholder="https://www.youtube.com/watch?v=...">
        
        <label class="block mt-2">File Materi (Opsional)</label>
        <input type="file" name="materi_file" class="w-full border border-gray-300 rounded-md p-2">
    </div>

      <!-- Bagian Tugas dengan Deadline -->
      <div class="mb-6">
        <label for="tugas" class="block font-medium mb-1">Tugas</label>
        <textarea name="tugas" id="tugas" class="py-2 px-4 w-full rounded-md border-2" placeholder="Deskripsi tugas"></textarea>
        <label class="block mt-2">File Tugas (Opsional)</label>
        <input type="file" name="tugas_file" class="w-full border border-gray-300 rounded-lg p-2">
        
        <!-- Tambahkan field deadline -->
        <div class="mt-4 grid grid-cols-2 gap-4">
          <div>
            <label class="block font-medium mb-1">Deadline Tugas</label>
            <input type="datetime-local" name="deadline" class="w-full border border-gray-300 rounded-lg p-2">
          </div>
          <div>
            <label class="block font-medium mb-1">Izinkan Pengumpulan Terlambat</label>
            <select name="allow_late" class="w-full border border-gray-300 rounded-lg p-2">
              <option value="0">Tidak</option>
              <option value="1">Ya</option>
            </select>
          </div>
        </div>
      </div>

      <!-- Tombol Simpan -->
      <div class="flex justify-end space-x-3">
        <a href="<?= BASEURL ?>/pertemuan/<?= htmlspecialchars($id_materi ?? '') ?>" class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400 transition">Batal</a>
        <button type="submit" class="px-4 py-2 bg-purple-600 text-white rounded hover:bg-purple-700 transition">Simpan</button>
      </div>
    </form>
  </main>

  <script>
    document.getElementById('tombol_buat_soal').addEventListener('click', function() {
      const jumlahSoal = parseInt(document.getElementById('jumlah_soal').value);
      const container = document.getElementById('container_soal');
      
      // Kosongkan container terlebih dahulu
      container.innerHTML = '';
      
      if (jumlahSoal > 0 && jumlahSoal <= 100) {
        for (let i = 1; i <= jumlahSoal; i++) {
          const soalDiv = document.createElement('div');
          soalDiv.className = 'border border-gray-300 rounded-lg p-4 bg-gray-50';
          
          soalDiv.innerHTML = `
            <h3 class="font-medium mb-2">Soal ${i}</h3>
            <div class="mb-3">
              <label class="block text-sm font-medium mb-1">Pertanyaan</label>
              <textarea name="pre_pertanyaan_${i}" class="py-2 px-4 w-full rounded-md border-2" placeholder="Pertanyaan"></textarea>
            </div>
            
            <div class="space-y-2 text-sm text-gray-700">
              <input type="text" class="py-1 px-2 rounded-md border-2 w-full" name="pre_a_${i}" placeholder="Pilihan A" require>
              <input type="text" class="py-1 px-2 rounded-md border-2 w-full" name="pre_b_${i}" placeholder="Pilihan B" require>
              <input type="text" class="py-1 px-2 rounded-md border-2 w-full" name="pre_c_${i}" placeholder="Pilihan C" require>
              <input type="text" class="py-1 px-2 rounded-md border-2 w-full" name="pre_d_${i}" placeholder="Pilihan D" require >
              
              <select name="pre_jawaban_benar_${i}" class="w-full border rounded-md p-2">
                <option value="" disabled selected>Pilih Jawaban Benar</option>
                <option value="A">A</option>
                <option value="B">B</option>
                <option value="C">C</option>
                <option value="D">D</option>
              </select>
            </div>
          `;
          
          container.appendChild(soalDiv);
        }
      } else {
        alert('Masukkan jumlah soal antara 1 hingga 100');
      }
    });
  </script>
  <script>
    // SCRIPT POST TEST
    document.getElementById('tombol_buat_post').addEventListener('click', function() {
      const jumlahSoal = parseInt(document.getElementById('jumlah_soal_post').value);
      const container = document.getElementById('container_post');

      container.innerHTML = '';

      if (jumlahSoal > 0 && jumlahSoal <= 100) {
        for (let i = 1; i <= jumlahSoal; i++) {
          
          const div = document.createElement('div');
          div.className = 'border border-gray-300 rounded-lg p-4 bg-gray-50';

          div.innerHTML = `
            <h3 class="font-medium mb-2">Post-Test Soal ${i}</h3>

            <div class="mb-3">
              <label class="block text-sm font-medium mb-1">Pertanyaan</label>
              <textarea name="post_pertanyaan_${i}" class="py-2 px-4 w-full rounded-md border-2" placeholder="Pertanyaan"></textarea>
            </div>

            <div class="space-y-2 text-sm text-gray-700">
              <input type="text" name="post_a_${i}" class="py-1 px-2 rounded-md border-2 w-full" placeholder="Pilihan A">
              <input type="text" name="post_b_${i}" class="py-1 px-2 rounded-md border-2 w-full" placeholder="Pilihan B">
              <input type="text" name="post_c_${i}" class="py-1 px-2 rounded-md border-2 w-full" placeholder="Pilihan C">
              <input type="text" name="post_d_${i}" class="py-1 px-2 rounded-md border-2 w-full" placeholder="Pilihan D">

              <select name="post_jawaban_benar_${i}" class="w-full border rounded-md p-2">
                <option value="" disabled selected>Pilih Jawaban Benar</option>
                <option value="A">A</option>
                <option value="B">B</option>
                <option value="C">C</option>
                <option value="D">D</option>
              </select>
            </div>
          `;

          container.appendChild(div);
        }

      } else {
        alert('Masukkan jumlah soal antara 1 hingga 100');
      }
    });
  </script>
    <script>
    // SCRIPT REFLEKSI
    document.getElementById('tombol_buat_refleksi').addEventListener('click', function() {
      const jumlahSoal = parseInt(document.getElementById('jumlah_soal_refleksi').value);
      const container = document.getElementById('container_ref');

      container.innerHTML = '';

      if (jumlahSoal > 0 && jumlahSoal <= 100) {
        for (let i = 1; i <= jumlahSoal; i++) {
          
          const div = document.createElement('div');
          div.className = 'border border-gray-300 rounded-lg p-4 bg-gray-50';

          div.innerHTML = `
            <h3 class="font-medium mb-2">Soal Refleksi ${i}</h3>

            <div class="mb-3">
              <label class="block text-sm font-medium mb-1">Pertanyaan</label>
              <textarea name="refleksi_pertanyaan_${i}" class="py-2 px-4 w-full rounded-md border-2" placeholder="Pertanyaan"></textarea>
            </div>
          `;

          container.appendChild(div);
        }

      } else {
        alert('Masukkan jumlah soal antara 1 hingga 100');
      }
    });
  </script>
</body>
</html>