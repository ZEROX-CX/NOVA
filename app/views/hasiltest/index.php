<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= $data['judul'] ?></title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-50 min-h-screen flex">
  <!-- Container Utama di Tengah -->
  <div class="m-auto bg-white shadow-md rounded-lg p-8 w-full max-w-4xl">

    <h1 class="text-2xl font-bold text-blue-700 mb-8 text-center">
      Hasil Pre-Test & Post-Test
    </h1>

    <!-- ========================== -->
    <!-- BAGIAN NILAI DALAM 2 KOLOM -->
    <!-- ========================== -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

      <!-- Kolom Pre-Test -->
      <div class="bg-blue-50 p-6 rounded-lg shadow">
        <h2 class="text-xl font-semibold text-blue-700 mb-3 text-center">Pre-Test</h2>

        <?php if (!empty($data['pre'])) : ?>
          <p class="text-lg">Benar: <strong><?= $data['pre']['benar'] ?></strong> dari <?= $data['pre']['jumlah'] ?> soal</p>
          <p class="text-lg">Nilai: <strong><?= $data['pre']['nilai'] ?></strong></p>
        <?php else : ?>
          <p class="text-gray-500 text-center">Belum mengerjakan pre-test</p>
        <?php endif; ?>

        <a 
          href="<?= BASEURL ?>/pretest/<?= $data['id_pertemuan'] ?>" 
          class="block mt-4 px-4 py-2 bg-blue-600 text-white rounded text-center hover:bg-blue-700 transition"
        >
          Ulangi Pre-Test
        </a>
      </div>

      <!-- Kolom Post-Test -->
      <div class="bg-green-50 p-6 rounded-lg shadow">
        <h2 class="text-xl font-semibold text-green-700 mb-3 text-center">Post-Test</h2>

        <?php if (!empty($data['post'])) : ?>
          <p class="text-lg">Benar: <strong><?= $data['post']['benar'] ?></strong> dari <?= $data['post']['jumlah'] ?> soal</p>
          <p class="text-lg">Nilai: <strong><?= $data['post']['nilai'] ?></strong></p>
        <?php else : ?>
          <p class="text-gray-500 text-center">Belum mengerjakan post-test</p>
        <?php endif; ?>

        <a 
          href="<?= BASEURL ?>/posttest/<?= $data['id_pertemuan'] ?>" 
          class="block mt-4 px-4 py-2 bg-green-600 text-white rounded text-center hover:bg-green-700 transition"
        >
          Ulangi Post-Test
        </a>
      </div>

    </div>

    <!-- Tombol kembali -->
    <div class="text-center mt-8">
      <a 
        href="<?= BASEURL ?>/pertemuan_content/<?= $data['id_mapel'] ?>/<?= $data['id_pertemuan'] ?>" 
        class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400 transition"
      >
        Kembali
      </a>
    </div>

  </div>
</body>
</html>
