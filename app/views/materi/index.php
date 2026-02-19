<!DOCTYPE html>
<html lang="id">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Mapelku Guru - Materi</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
      /* Tambahan CSS untuk PDF viewer */
      #pdfViewer {
        max-height: 600px;
        overflow-y: auto;
        border: 1px solid #e5e7eb;
        border-radius: 8px;
        background-color: #f9fafb;
      }
      
      .pdf-page {
        margin: 10px auto;
        display: block;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
      }
      
      .loading-spinner {
        display: flex;
        justify-content: center;
        align-items: center;
        height: 200px;
      }
      
      .loading-spinner::after {
        content: "";
        width: 40px;
        height: 40px;
        border: 4px solid #e5e7eb;
        border-top: 4px solid #9333ea;
        border-radius: 50%;
        animation: spin 1s linear infinite;
      }
      
      @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
      }
    </style>
  </head>

  <body class="bg-gray-100 min-h-screen font-sans text-gray-800">
    <!-- Konten Utama -->
    <main class="max-w-7xl mx-auto px-4 py-10 flex justify-center gap-6">

      
<section class="flex-1 max-w-3xl">

        <!-- Konten Sidebar bisa ditambahkan di sini -->
      </aside>

      <!-- Bagian Mapel -->
      <section class="flex-1">
        
      <div class="bg-[#7a00ff] flex w-[130px] h-[35px] items-center justify-center rounded mb-4">
        <a class="text-lg text-white inline-block" href="<?= BASEURL ?>/pretest/<?= $data['id_mapel'] ?>/<?= $data['id_pertemuan'] ?>">< Kembali</a>
      </div>

        <div class="bg-white rounded-lg shadow-md p-6 border border-gray-200 mt-4">

          <!-- Banner -->
          <div class="bg-[#7a00ff] text-white rounded-md p-4 mb-6 flex items-center justify-between">
            <div class="text-lg font-medium">Judul Pertemuan: <span class=""><?= htmlspecialchars($pertemuan['judul_pertemuan'] ?? 'Judul Pertemuan') ?></span></div>
          </div>
        
          <!-- Konten Materi -->
          <div class="bg-gray-50 border border-gray-300 rounded-md p-5 mb-6">
            <h3 class="text-md font-semibold text-gray-800 mb-3">Isi Materi</h3>
            <div class="text-sm text-gray-700 leading-relaxed space-y-4">
              <!-- PERBAIKAN: Cek apakah $data['materi'] ada dan isinya valid -->
              <?php if (!empty($data['materi']) && isset($data['materi']['isi_materi'])): ?>
                <p><?= nl2br(htmlspecialchars($data['materi']['isi_materi'])) ?></p>
              <?php else: ?>
                <p class="text-gray-500 italic">Materi untuk pertemuan ini belum tersedia.</p>
              <?php endif; ?>
            </div>
          </div>

          <!-- BAGIAN VIDEO YOUTUBE -->
          <?php if (!empty($data['materi']) && !empty($data['materi']['link_youtube'])): ?>
              <div class="bg-gray-50 border border-gray-300 rounded-md p-5 mb-6">
                  <h3 class="text-md font-semibold text-gray-800 mb-3">Video Pembelajaran</h3>
                  <div class="video-container">
                      <?php 
                      // Extract YouTube video ID from URL
                      $youtube_url = $data['materi']['link_youtube'];
                      $video_id = '';
                      
                      // Check if it's a full URL or just the video ID
                      if (preg_match('/youtube\.com\/watch\?v=([^\&\?\/]+)/', $youtube_url, $id)) {
                          $video_id = $id[1];
                      } else if (preg_match('/youtu\.be\/([^\&\?\/]+)/', $youtube_url, $id)) {
                          $video_id = $id[1];
                      } else if (preg_match('/youtube\.com\/embed\/([^\&\?\/]+)/', $youtube_url, $id)) {
                          $video_id = $id[1];
                      } else {
                          // If it's just the video ID
                          $video_id = $youtube_url;
                      }
                      
                      // Generate embed URL
                      $embed_url = 'https://www.youtube.com/embed/' . $video_id;
                      ?>
                      <div class="aspect-w-16 aspect-h-9">
                          <iframe src="<?= $embed_url ?>" 
                                  frameborder="0" 
                                  allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                                  allowfullscreen
                                  class="w-full h-64 md:h-96 rounded-lg">
                          </iframe>
                      </div>
                  </div>
              </div>
          <?php endif; ?>
          <!-- BAGIAN PDF VIEWER -->
          <?php if (!empty($data['materi']) && !empty($data['materi']['file_materi'])): ?>
            <?php $id_tugas = (int)$data['materi']['id']; ?>
            
            <!-- Tombol untuk membuka PDF -->
            <div class="flex flex-col sm:flex-row gap-3 mb-4">
              <button id="viewPdfBtn" class="px-5 py-2.5 bg-[#7a00ff] text-white rounded-lg hover:bg-[#6700D8] transition font-medium">
                Lihat Materi PDF
              </button>
            </div>
                        
            <div id="pdfViewerWrapper" class="hidden mb-6">
              <div class="flex justify-between items-center mb-3">
                <h3 class="text-md font-semibold text-gray-800">Viewer PDF</h3>
                <button id="closePdfBtn" class="text-gray-500 hover:text-gray-700">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                  </svg>
                </button>
              </div>
              <div id="pdfViewer" class="loading-spinner"></div>
            </div>
          <?php endif; ?>

          <!-- NAVIGASI (PREV & NEXT) -->
          <div class="flex justify-between items-center mt-8">
            <!-- Tombol Previous -->
            <a href="<?= BASEURL ?>/pretest/<?= $data['pertemuan']['id_pertemuan'] ?>" class="px-5 py-2.5 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition font-medium">
              ← Sebelumnya
            </a>
            
            <!-- Tombol Next untuk membuka Modal -->
            <button id="nextBtn" class="px-5 py-2.5 bg-[#7a00ff] text-white rounded-lg hover:bg-[#6700D8] transition font-medium">
              Selanjutnya →
            </button>
          </div>

        </div>
        
      </section>
    </main>

    <!-- Modal Konfirmasi ke Posttest -->
    <div id="nextModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
      <div class="bg-white rounded-lg shadow-xl p-6 max-w-md w-full mx-4 transform transition-all">
        <h2 class="text-xl font-bold text-gray-800 mb-4">Lanjut ke Posttest?</h2>
        <p class="text-gray-600 mb-6">Anda akan melanjutkan ke tahap posttest. Pastikan Anda sudah memahami semua materi sebelumnya.</p>
        <div class="flex gap-4 justify-end">
          <button id="cancelBtn" type="button" class="px-4 py-2 bg-gray-300 text-gray-800 rounded-lg hover:bg-gray-400 transition font-medium">
            Batal
          </button>
          <!-- Link ke halaman posttest -->
          <a href="<?= BASEURL ?>/posttest/<?= $data['id_mapel'] ?>/<?= htmlspecialchars($pertemuan['id_pertemuan'])?>" class="px-4 py-2 bg-[#7a00ff] text-white rounded-lg hover:bg-[#6700D8] transition inline-block font-medium">
            Ya, Lanjut
          </a>
        </div>
      </div>
    </div>

    <!-- JavaScript -->
    <script>
      // --- Modal Handler ---
      const nextBtn = document.getElementById('nextBtn');
      const nextModal = document.getElementById('nextModal');
      const cancelBtn = document.getElementById('cancelBtn');
      
      nextBtn.addEventListener('click', function() {
        nextModal.classList.remove('hidden');
      });

      cancelBtn.addEventListener('click', function() {
        nextModal.classList.add('hidden');
      });

      nextModal.addEventListener('click', function(e) {
        if (e.target === nextModal) {
          nextModal.classList.add('hidden');
        }
      });
      
      // --- PDF Viewer Handler ---
      const viewPdfBtn = document.getElementById('viewPdfBtn');
      const closePdfBtn = document.getElementById('closePdfBtn');
      const pdfViewerWrapper = document.getElementById('pdfViewerWrapper');
      
      if (viewPdfBtn) {
        viewPdfBtn.addEventListener('click', function() {
          pdfViewerWrapper.classList.remove('hidden');
          // Scroll ke PDF viewer
          pdfViewerWrapper.scrollIntoView({ behavior: 'smooth' });
        });
      }
      
      if (closePdfBtn) {
        closePdfBtn.addEventListener('click', function() {
          pdfViewerWrapper.classList.add('hidden');
        });
      }
    </script>

    <!-- PDF.js Script -->
    <script src="https://unpkg.com/pdfjs-dist@3.6.172/build/pdf.min.js"></script>
    <script>
      pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://unpkg.com/pdfjs-dist@3.6.172/build/pdf.worker.min.js';
    
      (function(){
        const idTugas = <?= isset($id_tugas) ? $id_tugas : 'null' ?>;
        if (!idTugas) return;
    
        const pdfUrl = "<?= BASEURL ?>/materi/streamPdf/" + idTugas;
        const pdfContainer = document.getElementById('pdfViewer');
        const pdfWrapper = document.getElementById('pdfViewerWrapper');
        const statusText = document.getElementById('statusText');
        const downloadBtn = document.getElementById('downloadBtn');
    
        function enableDownload() {
          downloadBtn.classList.remove('bg-gray-200','opacity-60','pointer-events-none');
          downloadBtn.classList.add('bg-purple-600','text-white', 'hover:bg-purple-700');
          downloadBtn.href = "<?= BASEURL ?>/materi/download/" + idTugas;
          downloadBtn.textContent = "Download";
          downloadBtn.removeAttribute('role');
          // Hapus event listener sebelumnya jika ada untuk mencegah duplikasi
          downloadBtn.replaceWith(downloadBtn.cloneNode(true));
        }
    
        // Tambahkan event listener untuk tombol view PDF
        const viewPdfBtn = document.getElementById('viewPdfBtn');
        if (viewPdfBtn) {
          viewPdfBtn.addEventListener('click', function() {
            // Jika PDF sudah dimuat, tidak perlu memuat ulang
            if (pdfContainer.querySelector('canvas')) {
              return;
            }
            
            // Tampilkan loading spinner
            pdfContainer.innerHTML = '';
            pdfContainer.classList.add('loading-spinner');
            
            fetch(pdfUrl)
              .then(function(res){
                if (!res.ok) throw new Error("Gagal mengambil file PDF");
                return res.arrayBuffer();
              })
              .then(function(data){
                return pdfjsLib.getDocument({data: data}).promise;
              })
              .then(function(pdf){
                const total = pdf.numPages;
                let lastCanvas = null;
                pdfContainer.classList.remove('loading-spinner');
                
                for (let p = 1; p <= total; p++) {
                  pdf.getPage(p).then(function(page){
                    const viewport = page.getViewport({ scale: 1.4 });
                    const canvas = document.createElement('canvas');
                    canvas.className = 'pdf-page';
                    canvas.width = Math.floor(viewport.width);
                    canvas.height = Math.floor(viewport.height);
                    canvas.setAttribute('data-page-number', page.pageNumber);
                    pdfContainer.appendChild(canvas);
                    const renderContext = {
                      canvasContext: canvas.getContext('2d'),
                      viewport: viewport
                    };
                    page.render(renderContext).promise.then(function(){
                      if (page.pageNumber === total) {
                        lastCanvas = canvas;
                        observeLastCanvas(lastCanvas);
                      }
                    });
                  });
                }
              })
              .catch(function(err){
                console.error("PDF loading error:", err);
                statusText.textContent = "";
                pdfContainer.innerHTML = '<p class="text-center text-red-500 p-4">Gagal memuat file PDF. Silakan coba lagi.</p>';
              });
          });
        }
    
        function observeLastCanvas(canvasEl) {
          if (!canvasEl) return;
          const options = {
            root: pdfWrapper,
            threshold: 0.9
          };
          const obs = new IntersectionObserver(function(entries){
            entries.forEach(function(entry){
              if (entry.isIntersecting && entry.intersectionRatio >= 0.9) {
                markRead();
                obs.disconnect();
              }
            });
          }, options);
          obs.observe(canvasEl);
        }
    
        let markReadSent = false;
        function markRead() {
          if (markReadSent) return;
          markReadSent = true;
          fetch("<?= BASEURL ?>/materi/mark_read", {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ id_tugas: idTugas })
          }).then(function(res){
              if (!res.ok) throw new Error("Network response was not ok");
              return res.json();
          }).then(function(resp){
            if (resp.status && resp.status === 'ok') {
              statusText.textContent = "Status: Sudah dibaca — download tersedia.";
              enableDownload();
            } else {
              statusText.textContent = "Status: Gagal menandai selesai.";
              console.warn("Server response:", resp);
            }
          }).catch(function(err){
            console.error("Mark read error:", err);
            statusText.textContent = "Status: Gagal menandai selesai (kesalahan jaringan).";
          });
        }
    
      })();
    </script>
  </body>
</html>