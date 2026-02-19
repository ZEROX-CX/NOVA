<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= $data['judul'] ?></title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-50 min-h-screen flex items-center justify-center">
  <div class="bg-white shadow-md rounded-lg p-8 text-center w-full max-w-md">
    <h1 class="text-2xl font-bold text-purple-700 mb-6">Hasil Pre-Test</h1>
    <p class="text-lg mb-2">Jawaban benar: <strong><?= $data['benar'] ?></strong> dari <?= $data['jumlah'] ?> soal</p>
    <p class="text-lg mb-6">Nilai akhir: <strong><?= $data['nilai'] ?></strong></p>

    <a href="<?= BASEURL ?>/pretest/<?= $data['id_pertemuan'] ?>" class="px-4 py-2 bg-purple-600 text-white rounded hover:bg-purple-700 transition">
      Ulangi
    </a>
  </div>
</body>
</html>