<!-- Tempatkan kode ini di bagian atas view, misalnya setelah tag <body> -->
<?php
// Bagian ini masih berguna jika ada pesan dari proses lain (bukan dari AJAX)
if (isset($_SESSION['message'])) {
    $message = $_SESSION['message'];
    $type = $_SESSION['message_type'] ?? 'info'; // Default ke 'info' jika tipe tidak ada

    // Tentukan kelas CSS berdasarkan tipe pesan (sesuaikan dengan framework CSS Anda)
    $alertClass = '';
    $icon = '';
    switch ($type) {
        case 'success':
            $alertClass = 'bg-green-50 border-l-4 border-green-500 text-green-700';
            $icon = '<svg class="w-5 h-5 text-green-600" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>';
            break;
        case 'error':
            $alertClass = 'bg-red-50 border-l-4 border-red-500 text-red-700';
            $icon = '<svg class="w-5 h-5 text-red-600" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path></svg>';
            break;
        case 'warning':
            $alertClass = 'bg-yellow-50 border-l-4 border-yellow-500 text-yellow-700';
            $icon = '<svg class="w-5 h-5 text-yellow-600" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>';
            break;
        default: // info
            $alertClass = 'bg-blue-50 border-l-4 border-blue-500 text-blue-700';
            $icon = '<svg class="w-5 h-5 text-blue-600" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path></svg>';
            break;
    }

    echo '<div class="p-4 mb-4 rounded ' . $alertClass . ' flex items-start gap-3" role="alert">';
    echo $icon;
    echo '<div><p class="font-semibold">' . htmlspecialchars($message) . '</p></div>';
    echo '</div>';

    // Hapus pesan dari session setelah ditampilkan agar tidak muncul lagi
    unset($_SESSION['message']);
    unset($_SESSION['message_type']);

}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Pengumpulan Tugas - <?= htmlspecialchars($tugas['judul_tugas'] ?? 'Judul Tugas') ?></title>
  <script src="https://cdn.tailwindcss.com"></script>
  <style>
    .upload-zone {
      transition: all 0.3s ease;
      border-style: dashed;
    }
    .upload-zone.dragover {
      background-color: #ede9fe;
      border-color: #7c3aed;
      transform: scale(1.02);
    }
    .file-preview {
      animation: slideIn 0.3s ease;
    }
    @keyframes slideIn {
      from { opacity: 0; transform: translateY(-10px); }
      to { opacity: 1; transform: translateY(0); }
    }
  </style>
</head>
<body class="bg-gradient-to-br from-slate-50 to-slate-100 min-h-screen flex items-center justify-center">

  <!-- Container utama agar konten di tengah -->
  <div class="w-full max-w-3xl mx-auto my-12 px-4">
    <!-- Upload Section -->
    <div class="bg-white rounded-xl shadow-md border border-gray-100 p-6">
      <!-- PERUBAHAN: Judul dinamis berdasarkan kondisi -->
      <h2 class="text-xl font-bold text-gray-900 mb-6 flex items-center gap-2">
        <?php if ($pengumpulan): ?>
            <svg class="w-6 h-6 text-orange-600" fill="currentColor" viewBox="0 0 20 20"><path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"></path></svg>
              File Jawaban
        <?php else: ?>
            <svg class="w-6 h-6 text-blue-600" fill="currentColor" viewBox="0 0 20 20"><path d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z"></path></svg>
            Upload File Jawaban
        <?php endif; ?>
      </h2>

      <!-- Tampilkan informasi deadline -->
<?php
    $deadline_value = $tugas['deadline'] ?? null;
    $deadline_is_set = !empty($deadline_value);

    // Tentukan kelas notifikasi dan ikon berdasarkan apakah deadline ada
    $notification_class = $deadline_is_set ? 'bg-yellow-50 border-l-4 border-yellow-400' : 'bg-blue-50 border-l-4 border-blue-400';
    $icon_color = $deadline_is_set ? 'text-yellow-400' : 'text-blue-400';
    $deadline_text = $deadline_is_set ? date('d F Y H:i', strtotime($deadline_value)) : 'Tidak ada deadline';
?>
<div class="<?= $notification_class ?> p-4 mb-6">
  <div class="flex">
    <div class="flex-shrink-0">
      <!-- Ikon yang sama bisa digunakan, warna berubah sesuai kelas -->
      <svg class="h-5 w-5 <?= $icon_color ?>" viewBox="0 0 20 20" fill="currentColor">
        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
      </svg>
    </div>
    <div class="ml-3">
      <p class="text-sm <?= $deadline_is_set ? 'text-yellow-700' : 'text-blue-700' ?>">
        <strong>Deadline Tugas:</strong> <?= $deadline_text ?>
      </p>
    </div>
  </div>
</div>

      <!-- PERUBAHAN: Tampilkan pesan dari session jika ada -->
      <?php if (!empty($submission_message)): ?>
        <div class="bg-green-50 border-l-4 border-green-500 p-4 mb-6">
          <div class="flex">
            <div class="flex-shrink-0">
              <svg class="h-5 w-5 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
              </svg>
            </div>
            <div class="ml-3">
              <p class="text-sm text-green-700">
                <?= $submission_message ?>
              </p>
            </div>
          </div>
        </div>
      <?php endif; ?>

      <!-- PERUBAHAN: Tambahkan pemeriksaan deadline dan allow_late -->
      <?php
      // Ambil data deadline dan allow_late dari tugas
      $deadline = !empty($tugas['deadline']) ? new DateTime($tugas['deadline']) : null;
      $waktu_sekarang = new DateTime();
      $deadline_passed = false;
      $allow_late = isset($tugas['allow_late']) ? $tugas['allow_late'] : 0;
      
      // Cek apakah deadline sudah lewat
      if ($deadline && $waktu_sekarang > $deadline) {
          $deadline_passed = true;
      }
      ?>

      <!-- Tampilkan pesan jika deadline sudah lewat -->
      <?php if ($deadline_passed): ?>
        <?php if ($allow_late == 1): ?>
          <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 mb-6">
            <div class="flex">
              <div class="flex-shrink-0">
                <svg class="h-5 w-5 text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
                  <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                </svg>
              </div>
              <div class="ml-3">
                <p class="text-sm text-yellow-700">
                  <strong>Perhatian!</strong> Deadline untuk tugas ini telah lewat, tetapi pengumpulan terlambat diizinkan.
                </p>
              </div>
            </div>
          </div>
        <?php else: ?>
          <div class="bg-red-50 border-l-4 border-red-400 p-4 mb-6">
            <div class="flex">
              <div class="flex-shrink-0">
                <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                  <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                </svg>
              </div>
              <div class="ml-3">
                <p class="text-sm text-red-700">
                  <strong>Perhatian!</strong> Deadline untuk tugas ini telah lewat dan pengumpulan terlambat tidak diizinkan.
                </p>
              </div>
            </div>
          </div>
        <?php endif; ?>
      <?php endif; ?>

      <!-- KONDISI 1: BELUM PERNAH KUMPUL -->
      <?php if (empty($pengumpulan)): ?>
        <?php if (!$deadline_passed || $allow_late == 1): ?>
          <form id="uploadForm" class="space-y-4" method="post" action="<?= BASEURL ?>/pengumpulan/kumpul">
            <input type="hidden" name="id_tugas" value="<?= htmlspecialchars($id_tugas) ?>">
            <div id="uploadZone" class="upload-zone border-2 border-blue-300 bg-blue-50 rounded-lg p-8 text-center cursor-pointer hover:bg-blue-100 transition">
              <div class="space-y-3">
                <svg class="w-12 h-12 text-blue-600 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                </svg>
                <p class="text-lg font-semibold text-gray-900">Drag & drop file Anda di sini</p>
                <p class="text-sm text-gray-600">atau klik untuk memilih file</p>
                <p class="text-xs text-gray-500 mt-2">Format: PDF, DOC, DOCX, TXT, ZIP, RAR | Max: 10 MB</p>
              </div>
              <input type="file" id="fileInput" name="file_jawaban" class="hidden" accept=".pdf,.doc,.docx,.txt,.zip,.rar" required>
            </div>
            <div id="filePreview" class="hidden file-preview">
              <div class="bg-gray-50 rounded-lg p-4 flex items-center justify-between">
                <div class="flex items-center gap-3">
                  <div class="w-10 h-10 bg-blue-100 rounded flex items-center justify-center">
                    <svg class="w-6 h-6 text-blue-600" fill="currentColor" viewBox="0 0 20 20"><path d="M8 16.5a1 1 0 11-2 0 1 1 0 012 0zM15 7a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                  </div>
                  <div>
                    <p id="fileName" class="font-semibold text-gray-900"></p>
                    <p id="fileSize" class="text-xs text-gray-500"></p>
                  </div>
                </div>
                <button type="button" id="removeFile" class="text-red-600 hover:text-red-700 transition">
                  <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                </button>
              </div>
            </div>
            <div id="alertContainer"></div>
            <button type="submit" id="submitBtn" class="w-full bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-bold py-3 px-4 rounded-lg transition transform hover:scale-105 flex items-center justify-center gap-2">
              <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M2 9.5A1.5 1.5 0 013.5 8H4v4H3.5A1.5 1.5 0 012 9.5z"></path><path d="M6 4a2 2 0 012-2h4a1 1 0 100 2H8v14h4a1 1 0 100-2H8V4h4a2 2 0 012 2v12a2 2 0 01-2 2H8a2 2 0 01-2-2V4z"></path></svg>
              Kumpulkan Tugas
            </button>
          </form>
        <?php else: ?>
          <div class="bg-gray-50 rounded-lg p-4 mb-6">
            <div class="flex">
              <div class="flex-shrink-0">
                <svg class="h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                  <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                </svg>
              </div>
              <div class="ml-3">
                <p class="text-sm text-gray-700">
                  <strong>Pengumpulan ditutup.</strong> Deadline telah lewat dan pengumpulan terlambat tidak diizinkan.
                </p>
              </div>
            </div>
          </div>
        <?php endif; ?>


      <!-- KONDISI 3: SUDAH KUMPUL DAN TIDAK BOLEH EDIT (VIEW ONLY) -->
      <?php else: ?>
        <div class="bg-gray-50 rounded-lg p-4 mb-6">
          <h3 class="font-semibold text-gray-800 mb-2">Detail Pengumpulan Anda:</h3>
          <p class="text-sm text-gray-600"><strong>Dikumpulkan pada:</strong> <?= date('d F Y H:i', strtotime($pengumpulan['tanggal_kumpul'])) ?></p>
          <p class="text-sm text-gray-600"><strong>Status:</strong> 
            <?php 
                $status = 'Tepat Waktu'; 
                if($pengumpulan['is_late'] == 1) { $status = 'Telat'; }
                echo $status;
            ?>
          </p>
          <?php if (!empty($pengumpulan['file_jawaban'])): ?>
            <p class="text-sm text-gray-600 mt-2">
              <strong>File:</strong> 
              <a href="<?= BASEURL ?>/public/uploads/tugas/<?= htmlspecialchars($pengumpulan['file_jawaban']) ?>" target="_blank" download class="text-blue-600 hover:underline ml-1">
                Lihat File
              </a>
            </p>
          <?php endif; ?>
        </div>
        <div class="text-center">
           <a href="<?= BASEURL ?>/tugas/<?= $data['pertemuan']['id_pertemuan'] ?>" class="inline-block bg-gray-600 text-white font-bold py-2 px-6 rounded-lg hover:bg-gray-700 transition">
             Kembali ke Tugas
           </a>
        </div>
      <?php endif; ?>

    </div>
  </div>

  <!-- JavaScript yang sudah diperbaiki -->
   <script>
    const uploadZone = document.getElementById('uploadZone');
    const fileInput = document.getElementById('fileInput');
    const filePreview = document.getElementById('filePreview');
    const fileName = document.getElementById('fileName');
    const fileSize = document.getElementById('fileSize');
    const removeFileBtn = document.getElementById('removeFile');
    const uploadForm = document.getElementById('uploadForm');
    const submitBtn = document.getElementById('submitBtn');
    const alertContainer = document.getElementById('alertContainer');

    // Click to upload
    if (uploadZone) {
      uploadZone.addEventListener('click', () => fileInput.click());

      // Drag and drop
      uploadZone.addEventListener('dragover', (e) => {
        e.preventDefault();
        uploadZone.classList.add('dragover');
      });

      uploadZone.addEventListener('dragleave', () => {
        uploadZone.classList.remove('dragover');
      });

      uploadZone.addEventListener('drop', (e) => {
        e.preventDefault();
        uploadZone.classList.remove('dragover');
        const files = e.dataTransfer.files;
        if (files.length > 0) {
          fileInput.files = files;
          handleFileSelect();
        }
      });
    }

    // File input change
    if (fileInput) {
      fileInput.addEventListener('change', handleFileSelect);
    }

    function handleFileSelect() {
      if (fileInput.files.length > 0) {
        const file = fileInput.files[0];
        fileName.textContent = file.name;
        fileSize.textContent = (file.size / 1024 / 1024).toFixed(2) + ' MB';
        filePreview.classList.remove('hidden');
      }
    }

    // Remove file
    if (removeFileBtn) {
      removeFileBtn.addEventListener('click', () => {
        fileInput.value = '';
        filePreview.classList.add('hidden');
      });
    }

    // Form submit
    if (uploadForm) {
      uploadForm.addEventListener('submit', async (e) => {
        e.preventDefault();

        if (!fileInput.files.length) {
          showAlert('Pilih file terlebih dahulu', 'error');
          return;
        }

        const formData = new FormData(uploadForm);
        submitBtn.disabled = true;
        submitBtn.innerHTML = 'Mengupload...';

        try {
          const response = await fetch('<?= BASEURL ?>/pengumpulan/kumpul', {
            method: 'POST',
            credentials: 'same-origin',
            body: formData
          });

          // Cek jika response adalah JSON
          const contentType = response.headers.get('content-type');
          if (!contentType || !contentType.includes('application/json')) {
            throw new Error('Server mengembalikan respons yang tidak valid.');
          }

          const result = await response.json();

          if (result.success) {
            if(result.redirect) {
              // Refresh halaman untuk menampilkan pesan terbaru
              window.location.href = window.location.href;
            } else {
              showAlert(result.message, 'success');
            }
          } else {
            showAlert(result.error || 'Terjadi kesalahan', 'error');
          }
        } catch (error) {
          console.error('Error:', error);
          showAlert('Error: ' + error.message, 'error');
        } finally {
          submitBtn.disabled = false;
          submitBtn.innerHTML = 'Kumpulkan Tugas'; // Atau 'Perbarui Tugas', bisa disesuaikan
        }
      });
    }

    function showAlert(message, type) {
      const alertClass = type === 'success' 
        ? 'bg-green-50 border-l-4 border-green-500 text-green-700'
        : 'bg-red-50 border-l-4 border-red-500 text-red-700';
      
      alertContainer.innerHTML = `
        <div class="${alertClass} p-4 rounded">
          <p class="font-semibold">${message}</p>
        </div>
      `;
    }
  </script>
</body>
</html>