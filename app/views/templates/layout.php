<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="https://cdn.tailwindcss.com"></script>
  <title><?= $data['title'] ?? 'Mapelku Guru' ?></title>
</head>
<body class="bg-gray-50 font-sans">
  <?php require 'navbar.php'; ?>
  <main class="visible">
    <?php require $view; // isi halaman dari controller ?>
  </main>
</body>
</html>
