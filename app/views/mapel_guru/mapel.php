<?php
$materi = $data['materi'];
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
    <div class="flex pt-4 container mx-auto max-w-7xl">

        <!-- BOX MATA PELAJARAN -->
        <aside class="w-64 bg-white shadow-md rounded-lg overflow-hidden mr-6 h-full">
            <h2 class="px-4 py-3 text-lg font-semibold text-gray-700 border-b">Mapel ></h2>
            <nav class="p-2 space-y-1">
                <a href="#" class="block px-3 py-2 rounded-lg bg-indigo-100 text-indigo-700 font-medium">Bahasa Indonesia</a>
                <a href="#" class="block px-3 py-2 text-gray-700 hover:bg-gray-50">Pertemuan 1</a>
                <a href="#" class="block px-3 py-2 text-gray-700 hover:bg-gray-50">Pertemuan 2</a>
                <a href="#" class="block px-3 py-2 text-gray-700 hover:bg-gray-50">Pertemuan 3</a>
                <div class="h-px bg-gray-200 my-2"></div>
                <a href="#" class="block px-3 py-2 text-gray-700 hover:bg-gray-50">Bahasa Inggris</a>
                <a href="#" class="block px-3 py-2 text-gray-700 hover:bg-gray-50">IPAS</a>
                <a href="#" class="block px-3 py-2 text-gray-700 hover:bg-gray-50">Matematika</a>
                <a href="#" class="block px-3 py-2 text-gray-700 hover:bg-gray-50">PAI</a>
                <a href="#" class="block px-3 py-2 text-gray-700 hover:bg-gray-50">PP</a>
                <a href="#" class="block px-3 py-2 text-gray-700 hover:bg-gray-50">Sejarah</a>
                <a href="#" class="block px-3 py-2 text-gray-700 hover:bg-gray-50">Seni Budaya</a>
            </nav>
        </aside>

        <main class="flex-1 flex">

            <!-- BOX ISI MATA PELAJARAN -->
            <div class="flex-1 bg-white shadow-md rounded-lg p-6 mr-6">
                <p class="text-sm text-gray-500 mb-2">Mapel > Bahasa Indonesia > Pertemuan 1</p>
                
                <h1 class="text-xl font-bold text-gray-800 flex items-center mb-6">
                    <svg class="w-6 h-6 mr-2 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m-9 9h6m-6 4h6m-3-11v6"></path></svg>
                    Mata Pelajaran - Bahasa Indonesia
                </h1>

                <div class="border-b border-gray-200 mb-6">
                    <nav class="flex -mb-px space-x-4">
                        <a href="#" class="px-4 py-2 text-sm font-medium border-b-2 border-indigo-600 text-indigo-600">Pertemuan 1</a>
                        <a href="#" class="px-4 py-2 text-sm font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300 border-b-2 border-transparent">Pertemuan 2</a>
                        <a href="#" class="px-4 py-2 text-sm font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300 border-b-2 border-transparent">Pertemuan 3</a>
                    </nav>
                </div>

                <div class="bg-purple-pattern h-20 rounded-lg mb-6 shadow-inner"></div>

                <h2 class="text-lg font-bold text-gray-800 mb-4">Pertemuan 1</h2>

                <div class="space-y-4">
                    <!-- Daftar box -->
                    <div class="flex items-center p-4 bg-white shadow-sm rounded-lg border border-gray-200 cursor-pointer hover:bg-gray-50">
                        <div class="p-3 mr-4 rounded-full bg-lime-400 text-white">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <span class="font-medium text-gray-700">Daftar Hadir</span>
                    </div>

                    <div class="flex items-center p-4 bg-white shadow-sm rounded-lg border border-gray-200 cursor-pointer hover:bg-gray-50">
                        <div class="p-3 mr-4 rounded-full bg-orange-400 text-white">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        </div>
                        <span class="font-medium text-gray-700">Pre-Test</span>
                    </div>

                    <div class="flex items-center p-4 bg-white shadow-sm rounded-lg border border-gray-200 cursor-pointer hover:bg-gray-50">
                        <div class="p-3 mr-4 rounded-full bg-pink-500 text-white">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                        </div>
                        <span class="font-medium text-gray-700">Materi</span>
                    </div>

                    <div class="flex items-center p-4 bg-white shadow-sm rounded-lg border border-gray-200 cursor-pointer hover:bg-gray-50">
                        <div class="p-3 mr-4 rounded-full bg-emerald-500 text-white">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                        </div>
                        <span class="font-medium text-gray-700">Tugas</span>
                    </div>

                    <div class="flex items-center p-4 bg-white shadow-sm rounded-lg border border-gray-200 cursor-pointer hover:bg-gray-50">
                        <div class="p-3 mr-4 rounded-full bg-blue-500 text-white">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                        </div>
                        <span class="font-medium text-gray-700">Refleksi</span>
                    </div>
                </div>
            </div>

            <!-- BOX NOTIFIKASI -->
            <aside class="w-72 border-l px-4 py-6 bg-white shadow-md rounded-lg mr-6">
                <h2 class="text-lg font-semibold mb-4">Notifikasi</h2>

                <div class="mb-6">
                    <p class="text-sm text-gray-500 mb-1">tanggal notifikasi</p>
                    <ul class="space-y-1">
                        <li class="text-blue-600 ml-4 font-semibold">unread notification <span class="text-red-500 ml-1">•</span></li>
                        <li class="text-gray-700 ml-4">notification</li>
                    </ul>
                </div>

                <div>
                    <p class="text-sm text-gray-500 mb-1">tanggal notifikasi</p>
                    <ul class="space-y-1">
                        <li class="text-gray-700 ml-4">notification</li>
                        <li class="text-gray-700 ml-4">notification</li>
                        <li class="text-gray-700 ml-4">notification</li>
                    </ul>
                </div>
            </aside>

        </main>
    </div>
</body>
</html>
