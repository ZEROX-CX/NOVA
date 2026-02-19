<?php
$pertemuan = $data['pertemuan'];
$materi = $data['materi'];
$sesi_absen = $data['sesi_absen'];
$pretest = $data['pretest'];
$tugas = $data['tugas'];
$refleksi = $data['refleksi'];
$mapel = $data['mapel'];

if (isset($_SESSION['toast'])) {
  $toastType = $_SESSION['toast']['type'];
  $toastMessage = $_SESSION['toast']['message'];

  // HAPUS setelah ditampilkan (supaya tidak muncul saat refresh)
  unset($_SESSION['toast']);
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mata Pelajaran - Bahasa Indonesia</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* Gaya tambahan untuk menyesuaikan warna ungu pada gambar */
        .bg-purple-pattern {
            background-color: #6B46C1; /* Warna dasar ungu */
            background-image: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" width="100" height="100" viewBox="0 0 100 100"><circle cx="50" cy="50" r="15" fill="%23805AD5" opacity="0.8"/><circle cx="10" cy="10" r="8" fill="%23B794F4" opacity="0.6"/><circle cx="90" cy="10" r="10" fill="%23D6BCFA" opacity="0.7"/><circle cx="10" cy="90" r="10" fill="%23D6BCFA" opacity="0.7"/><circle cx="90" cy="90" r="8" fill="%23B794F4" opacity="0.6"/></svg>');
            background-size: 20px 20px;
        }
    </style>
</head>
<body class="bg-gray-100 min-h-screen">

    <div class="flex flex-col lg:flex-row pt-4 container mx-auto max-w-7xl items-center lg:items-stretch px-3">
    <?php if (!empty($toastMessage)) : ?>
        <div id="toast"
            class="fixed text-white top-5 right-5 px-4 py-3 rounded shadow transform translate-x-full opacity-0 transition-all duration-500 ease-out
                    <?= $toastType === 'success' ? 'bg-green-500' : 'bg-red-500' ?>
                    text-white z-50">
            <?= $toastMessage ?>
        </div>

        <script>
            const toast = document.getElementById('toast');

            setTimeout(() => {
                toast.classList.remove('translate-x-full', 'opacity-0');
                toast.classList.add('translate-x-0', 'opacity-100');
            }, 100);
            
            setTimeout(() => {
                toast.classList.add("translate-x-full", "opacity-0");
            }, 3000);

            setTimeout(() => {
                toast.remove();
            }, 3500);
        </script>
    <?php endif; ?>
        <main class="w-full flex justify-center">
            <div class="flex-1 bg-white shadow-md rounded-lg p-6">
                <h1 class="text-xl font-bold text-gray-800 flex items-center mb-6">
                    <svg class="w-6 h-6 mr-2 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m-9 9h6m-6 4h6m-3-11v6"></path></svg>
                    Mata Pelajaran - <?= $mapel['nama_mapel'] ?>
                </h1>

                <div class="border-b border-gray-200 mb-6">
                    <nav class="flex -mb-px space-x-4">
                        <a href="#" class="px-4 pya-2 text-sm font-medium border-b-2 border-indigo-600 text-indigo-600"><?= $pertemuan['judul_pertemuan'] ?></a>
                    </nav>
                </div>

                <div class="bg-purple-pattern h-20 rounded-lg mb-6 shadow-inner">
                    </div>
        
                

                <div class="space-y-4">
                    <!-- ABSEN -->
                    <?php if (!empty($sesi_absen)): ?>
                    <div class="flex items-center p-4 bg-white shadow-sm rounded-lg border border-gray-200 cursor-pointer hover:bg-gray-50">
                        <div class="p-3 mr-4 rounded-full bg-lime-400 text-white">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <a href="<?= BASEURL ?>/absen/<?= $mapel['id_mapel'] ?>/<?= htmlspecialchars($pertemuan['id_pertemuan']) ?>" class="font-medium text-gray-700">Daftar Hadir</a>
                        <div class="flex-grow"></div>
                    </div>
                    <?php endif; ?>

                    <!-- MATERI -->
                    <?php if (!empty($materi)): ?>
                        <?php if($data['sudah_absen']): ?>
                    <div class="flex items-center p-4 bg-white shadow-sm rounded-lg border border-gray-200 cursor-pointer hover:bg-gray-50">
                        <div class="p-3 mr-4 rounded-full bg-pink-500 text-white">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                        </div>
                        <a href="<?= BASEURL ?>/pretest/<?= $mapel['id_mapel'] ?>/<?= htmlspecialchars($pertemuan['id_pertemuan']) ?>" class="font-medium text-gray-700">Materi</a>
                        <div class="flex-grow"></div>
                    </div>
                        <?php endif; ?>
                    <?php endif; ?>

                    <!-- TUGAS -->
                    <?php if (!empty($tugas)): ?>
                        <?php if($data['sudah_absen']): ?>
                            <div class="flex items-center p-4 bg-white shadow-sm rounded-lg border border-gray-200 cursor-pointer hover:bg-gray-50">
                                <div class="p-3 mr-4 rounded-full bg-emerald-500 text-white">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                                </div>
                                <a href="<?=  BASEURL ?>/tugas/<?= $mapel['id_mapel'] ?>/<?= htmlspecialchars($pertemuan['id_pertemuan']) ?>" class="font-medium text-gray-700">Tugas</a>
                                <div class="flex-grow"></div>
                            </div>
                        <?php endif; ?>
                    <?php endif; ?>
                    
                    <?php if (!empty($refleksi)): ?>
                        <?php if($data['sudah_absen']): ?>
                            <div class="flex items-center p-4 bg-white shadow-sm rounded-lg border border-gray-200 cursor-pointer hover:bg-gray-50">
                                <div class="p-3 mr-4 rounded-full bg-blue-500 text-white">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                                </div>
                                <a href="<?= BASEURL ?>/refleksi/<?= $mapel['id_mapel'] ?>/<?= htmlspecialchars($pertemuan['id_pertemuan']) ?>" class="font-medium text-gray-700">Refleksi</a>
                                <div class="flex-grow"></div>
                            </div>
                        <?php endif; ?>
                    <?php endif; ?>
                    
                    <div class="flex items-center p-4 bg-white shadow-sm rounded-lg border border-gray-200 cursor-pointer hover:bg-gray-50">
                        <div class="p-3 mr-4 rounded-full bg-blue-500 text-white">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                        </div>
                        <a href="<?= BASEURL ?>/dragdrop/<?= htmlspecialchars($pertemuan['id_pertemuan']) ?>" class="font-medium text-gray-700">Game</a>
                        <div class="flex-grow"></div>
                    </div>
                </div>
                
            </div>
        </main>
    </div>
</body>
</html>